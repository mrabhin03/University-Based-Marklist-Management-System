<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Result extends CI_Controller {

	public function index(){
		$this->load->helper('url');
		$this->load->view('Degree_Type');
	}

	public function getStudentResult($prn,$ExamID){
		if($prn && $ExamID){
			$details['PRN']=$prn;
			$details['Exam']=$this->db->where('ExamID',$ExamID)->get('exams')->row();
			$query = $this->db->join('examattender','examattender.PRN=students.PRN')->join('examcenter','examcenter.ExamCenterID=examattender.ExamCenterID')->join('program','program.ProgramID=students.ProgramID')->where('students.PRN', $prn)->where('ExamID', $ExamID)->get('students');
			$results = $query->result();
			$details['Student'] = isset($results[0]) ? $results[0] : null;
			$att=$this->db->where('PRN',$prn)->where('ExamID',$ExamID)->get('examattender');
        	if ($att->num_rows() > 0) {
				$details['AttDetails']=$att->row();
				$this->db->select('IFNULL(marks.INTS,0) AS INTS,IFNULL(marks.EXT,0) AS EXT,IFNULL(marks.MarkID,0)AS MarkID, course.*');
				$this->db->from('course');
				$this->db->join('marks', 'marks.CourseCode = course.CourseCode AND marks.AttID="'.$details['AttDetails']->AttID.'"', 'left');
				$this->db->where('course.ProgramID',$details['Exam']->ProgramID);
				$this->db->where('course.Semester',$details['Exam']->Semester);
				$query = $this->db->get();
			$details['result'] = $query->result();
			}

			return $details;
		}
	}
	
	public function PG($subpage = '')
	{
		if ($subpage === 'Rank') {
			$rankData = $this->Rank("PG");
			return;
		}
		$this->load->helper('url');
		$this->load->helper('form');
		$this->load->database();

		$prn=$this->input->post('PRN');
		$ExamID=$this->input->post('Exam');
		$details=$this->getStudentResult($prn,$ExamID);

		$this->db->select('*');
		$this->db->from('exams');
		$this->db->join('program', 'exams.ProgramID = program.ProgramID');
		$this->db->where('Type', 'PG');
		$details['semester']=$this->db->get()->result();
		$this->load->view('result',$details);
	}

	public function UG($subpage = '')
	{
		if ($subpage === 'Rank') {
			$rankData = $this->Rank("UG");
			return;
		}
		$this->load->helper('url');
		$this->load->helper('form');
		$this->load->database();

		$prn=$this->input->post('PRN');
		$ExamID=$this->input->post('Exam');
		$details=$this->getStudentResult($prn,$ExamID);

		$this->db->select('*');
		$this->db->from('exams');
		$this->db->join('program', 'exams.ProgramID = program.ProgramID');
		$this->db->where('Type', 'UG');
		$details['semester']=$this->db->get()->result();
		$this->load->view('result',$details);
	}

	public function Rank($RankType){
		$this->load->helper('url');
		$this->load->helper('form');
		$this->load->database();

		$PostExamID=$this->input->get('ExamID');
		if($PostExamID){
			$ExamID=$PostExamID;
		}else{
			$this->db->select('MAX(ExamID) as LatestExam');
            $this->db->from('exams')->join("program","program.ProgramID=exams.ProgramID")->where("program.Type",$RankType);
            $query = $this->db->get();
            $result = $query->row();
            $ExamID=$result->LatestExam;
		}
		$query = $this->db
			->select('exams.*, program.*')
			->from('exams')
			->join('program', 'program.ProgramID = exams.ProgramID', 'inner')
			->where('exams.ExamID', $ExamID)
			->get();

		if ($query->num_rows()==0){
			$this->load->view('Errors');
			return;
		}

		$data['Exam'] = $query->row();

		
		$data['Type']=$data['Exam']->Type;
		
		if ($data['Exam']->Type=="PG"){
			$this->db->select("students.*, (SUM(((marks.INTS*0.25)+(marks.EXT*0.75))*course.Credit)/SUM(course.Credit)) AS TotalGPA,(IF((MIN(marks.EXT)<2 || MIN((marks.INTS*0.25)+(marks.EXT*0.75))<2),0,1)) AS Pass");
			$this->db->from("students");
			$this->db->join("examattender", "examattender.PRN = students.PRN");
			$this->db->join("marks", "marks.AttID = examattender.AttID");
			$this->db->join("course", "course.CourseCode=marks.CourseCode");
			$this->db->where('examattender.ExamID',$ExamID);
			$this->db->group_by("students.PRN");
			$this->db->order_by("TotalGPA", "DESC");
			$query = $this->db->get();
			$data['results'] = $query->result();
		}else{
			$this->db->select("
				students.*,
				(
					SUM(
						(
							CASE 
								WHEN (marks.INTS + marks.EXT) >= 95 THEN 10.0
								WHEN (marks.INTS + marks.EXT) >= 85 THEN 9.0
								WHEN (marks.INTS + marks.EXT) >= 75 THEN 8.0
								WHEN (marks.INTS + marks.EXT) >= 65 THEN 7.0
								WHEN (marks.INTS + marks.EXT) >= 55 THEN 6.0
								WHEN (marks.INTS + marks.EXT) >= 45 THEN 5.0
								WHEN (marks.INTS + marks.EXT) >= 35 THEN 4.0
								ELSE 0.0
							END
						) * course.Credit
					) / NULLIF(SUM(course.Credit), 0)
				) AS TotalGPA,
				
				(
					IF(
						((MIN(marks.EXT) >= 24 OR MIN(marks.INTS + marks.EXT) >= 36) or (marks.INTS>=20)),
						1,
						0
					)
				) AS Pass
			", false);

			$this->db->from("students");
			$this->db->join("examattender", "examattender.PRN = students.PRN");
			$this->db->join("marks", "marks.AttID = examattender.AttID");
			$this->db->join("course", "course.CourseCode = marks.CourseCode");
			$this->db->where("examattender.ExamID", $ExamID);
			$this->db->group_by("students.PRN");
			$this->db->order_by("TotalGPA", "DESC");

			$query = $this->db->get();
			$data['results'] = $query->result();

		}
		$data['semester']=$this->db->from('exams')->join("program","program.ProgramID=exams.ProgramID")->where("program.Type",$RankType)->get()->result();
		$this->load->view('Rank',$data);
		// return $data;
	}
	
}
