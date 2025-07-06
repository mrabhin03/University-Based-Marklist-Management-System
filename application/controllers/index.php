<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class index extends CI_Controller {

	
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
	
}
