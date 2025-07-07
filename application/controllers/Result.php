<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Result extends CI_Controller {

	
	public function index()
	{
		$this->load->helper('url');
		$this->load->helper('form');
		$this->load->database();

		$prn=$this->input->post('PRN');
		$ExamID=$this->input->post('Exam');
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


		}

		$details['semester']=$this->db->get('exams')->result();
		// print_r($details['semester']);
		$this->load->view('result',$details);
	}
	public function Rank(){
		$this->load->helper('url');
		$this->load->helper('form');
		$this->load->database();

		$PostExamID=$this->input->get('ExamID');
		if($PostExamID){
			$ExamID=$PostExamID;
		}else{
			$this->db->select('MAX(ExamID) as LatestExam');
            $this->db->from('exams');
            $query = $this->db->get();
            $result = $query->row();
            $ExamID=$result->LatestExam;
		}
		$data['Exam']=$this->db->where('ExamID',$ExamID)->get('exams')->row();

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
		$data['semester']=$this->db->get('exams')->result();
		$this->load->view('Rank',$data);
	}
	
}
