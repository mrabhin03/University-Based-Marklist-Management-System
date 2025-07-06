<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class admin extends CI_Controller {

	public function loader(){
        $this->load->helper(array('url', 'form'));
        $this->load->library('session');
        $this->load->database();
    }
	public function index()
	{
        $this->loader();
        if ($this->session->userdata('user_name')) {
            redirect('admin/home');
            return;
        }
        
		if ($this->input->post('Username') && $this->input->post('Password')) {
            $Username = $this->input->post('Username');
            $password = $this->input->post('Password');

            $this->db->where('Username', $Username);
            $this->db->where('Password', $password); 
            $query = $this->db->get('theadmin');

            if ($query->num_rows() === 1) {
                $user = $query->row();

                $this->session->set_userdata('user_name', $Username);

                redirect('admin/home');
            } else {
                $data['error'] = "Invalid Username or password";
                $this->load->view('login', $data);
            }
        } else {
            $this->load->view('login');
        }
	}
    public function logout() {
        $this->loader();
        $this->session->sess_destroy();
        redirect('admin');
    }
    public function home() {
        $this->loader();
        if (!$this->session->userdata('user_name')) {
            redirect('admin');
        }
        $data['program']=$this->db->get('program')->result();

        $this->load->view('home',$data);
    }



    public function ProgramManage(){
        $this->loader();
        if (!$this->session->userdata('user_name')) {
            redirect('admin');
        }
        $program=$this->input->get('program');
        if($program){
            $data['Mode']=1;
            $data['program']=$this->db->where('ProgramID',$program)->get('program')->row();
        }else{
            $data['Mode']=0;
        }

        $this->load->view('ManageProgram',$data);
    }


    public function ChangeValueProgram(){
        $this->loader();
        if (!$this->session->userdata('user_name')) {
            redirect('admin');
        }
        $ProgramName=$this->input->post('ProgramName');
        $TotalSemesters=$this->input->post('TotalSemesters');
        $ProgramID=$this->input->post('ProgramID');
        $Mode=$this->input->post('Mode');
        if($Mode==0){
            $data = array(
                'ProgramName'      => $ProgramName,
                'TotalSemesters'   => $TotalSemesters,
            );
            $inserted = $this->db->insert('program', $data);
            redirect('admin');
        }elseif($Mode==1){
            $data = array(
                'ProgramName'      => $ProgramName,
                'TotalSemesters'   => $TotalSemesters,
            );
            $this->db->where('ProgramID',$ProgramID);
            $update = $this->db->update('program', $data);
            redirect('admin');
        }else{
            $courseD=$this->db->where('ProgramID', $ProgramID)->get('course')->result();
            foreach($courseD as $course){
                $this->db->where('CourseCode', $course->CourseCode);
                $this->db->delete('marks');

                $this->db->where('CourseCode', $course->CourseCode);
                $this->db->delete('course');
            }
            $examsD=$this->db->where('ProgramID', $ProgramID)->get('exams')->result();
            foreach($examsD as $exam){
                $this->db->where('ExamID', $exam->ExamID);
                $this->db->delete('examattender');

                $this->db->where('ExamID', $exam->ExamID);
                $this->db->delete('exams');
            }

            $this->db->where('ProgramID', $ProgramID);
            $this->db->delete('students');

            $this->db->where('ProgramID', $ProgramID);
            $this->db->delete('program');
        }
        
    }


    public function ExamCenter() {
        $this->loader();
        if (!$this->session->userdata('user_name')) {
            redirect('admin');
        }
        $data['examcenter']=$this->db->order_by('Status','ASC')->get('examcenter')->result();

        $this->load->view('ExamCenter',$data);
    }

    public function CenterManage(){
        $this->loader();
        if (!$this->session->userdata('user_name')) {
            redirect('admin');
        }
        $Center=$this->input->get('Center');
        if($Center){
            $data['Mode']=1;
            $data['Center']=$this->db->where('ExamCenterID ',$Center)->get('examcenter')->row();
        }else{
            $data['Mode']=0;
        }

        $this->load->view('ManageCenter',$data);
    }

    public function ChangeValueCenter(){
        $this->loader();
        if (!$this->session->userdata('user_name')) {
            redirect('admin');
        }

        $ExamCenterID=$this->input->post('ExamCenterID');
        $ExamCenter=$this->input->post('ExamCenter');
        $Mode=$this->input->post('Mode');
        if($Mode==0){
            $data = array(
                'ExamCenter' => $ExamCenter,
            );
            $inserted = $this->db->insert('examcenter', $data);
            redirect('admin/ExamCenter');
        }elseif($Mode==1){
            $data = array(
                'ExamCenter' => $ExamCenter,
            );
            $this->db->where('ExamCenterID',$ExamCenterID);
            $update = $this->db->update('examcenter', $data);
            redirect('admin/ExamCenter');
        }else if($Mode==2){
            $this->db->where('ExamCenterID',$ExamCenterID);
            $query = $this->db->get('examattender');
            if ($query->num_rows() > 0) {
                $this->db->where('ExamCenterID',$ExamCenterID);
                $update = $this->db->update('examcenter', array('Status'=>1));
                echo "0";
            }else{
                $this->db->where('ExamCenterID',$ExamCenterID);
                $this->db->delete('examcenter');
            }
            
        }else{
            $this->db->where('ExamCenterID',$ExamCenterID);
            $update = $this->db->update('examcenter', array('Status'=>0));
        }
        
    }


    public function AcademicYear(){
        $this->loader();
        if (!$this->session->userdata('user_name')) {
            redirect('admin');
        }
        $data['program']=$program=$this->input->get('program');
        $this->db->distinct();
        $this->db->select('AcademicYear');
        $this->db->from('students');
        $this->db->where('ProgramID', $program);
        $this->db->order_by('AcademicYear', 'ASC');
        $query = $this->db->get();
        $result = $query->result();

        $data['AcademicYears']=$result;
        $this->load->view('AcademicYear',$data);
    }

    public function students() {
        $this->loader();
        if (!$this->session->userdata('user_name')) {
            redirect('admin');
        }
        $data['program']=$program=$this->input->get('program');
        $data['AcademicYear']=$AcademicYear=$this->input->get('AcademicYear');
        $data['students']=$this->db->where('ProgramID',$program)->where('AcademicYear',$AcademicYear)->get('students')->result();
        $this->load->view('Students',$data);
    }

    public function studentdetails() {
        $this->loader();
        if (!$this->session->userdata('user_name')) {
            redirect('admin');
        }
        $details['AcademicYear']=$AcademicYear=$this->input->get('AcademicYear');
        $details['program']=$this->input->get('program');
        $PRN=$this->input->get('PRN');
        $details['PRN']=$PRN;
        $ExamID=$postExamID=$this->input->get('Exam');
        if($postExamID){
            $ExamID=$postExamID;
        }else{
            $this->db->select('MAX(ExamID) as LatestExam');
            $this->db->from('exams');
            $this->db->where('ProgramID', $details['program']);
            $query = $this->db->get();
            $result = $query->row();
            $ExamID=$result->LatestExam;
        }

        $details['Exam']=$this->db->where('ExamID',$ExamID)->get('exams')->row();
        $details['semester']=$this->db->where('ProgramID',$details['program'])->get('exams')->result();
        $details['Centers']=$this->db->where('Status!=',1)->get('examcenter')->result();


        $query = $this->db->join('program','program.ProgramID=students.ProgramID')->where('PRN', $PRN)->get('students');
		$results = $query->result();
		$details['Student'] = isset($results[0]) ? $results[0] : null;

        $att=$this->db->where('PRN',$PRN)->where('ExamID',$ExamID)->get('examattender');
        if ($att->num_rows() > 0) {
            $details['AttDetails']=$att->row();
            $this->db->select('IFNULL(marks.INTS,0) AS INTS,IFNULL(marks.EXT,0) AS EXT,IFNULL(marks.MarkID,0)AS MarkID, course.*');
			$this->db->from('course');
			$this->db->join('marks', 'marks.CourseCode = course.CourseCode AND marks.AttID="'.$details['AttDetails']->AttID.'"', 'left');
            $this->db->where('course.ProgramID',$details['program']);
            $this->db->where('course.Semester',$details['Exam']->Semester);
            $query = $this->db->get();
            $details['result'] = $query->result();
        }
        
        

        $this->load->view('Studentdetails',$details);
    }


    public function createAtts(){
        $this->loader();
        if (!$this->session->userdata('user_name')) {
            redirect('admin');
        }
        $AttID=$this->input->post('attID');
        $PRN=$this->input->post('PRN');
        $ExamID=$this->input->post('ExamID');
        $ExamCenterID=$this->input->post('ExamCenter');
        $programID=$this->input->post('programID');
        $AcademicYear=$this->input->post('AcademicYear');
        if($AttID==0){
            $data = array(
                'PRN'           => $PRN,
                'ExamID'        => $ExamID,
                'ExamCenterID'  => $ExamCenterID,
            );
            $inserted = $this->db->insert('examattender', $data);
        }else{
            $data = array(
                'ExamCenterID' => $ExamCenterID
            );
            $this->db->where('AttID',$AttID);
            $update = $this->db->update('examattender', $data);
        }
        redirect('admin/studentdetails?PRN='.$PRN.'&program='.$programID.'&Exam='.$ExamID.'&AcademicYear='.$AcademicYear);
    }


    public function studentManage(){
        $this->loader();
        if (!$this->session->userdata('user_name')) {
            redirect('admin');
        }
        $program=$this->input->get('program');
        $data['AcademicYear']=$AcademicYear=$this->input->get('AcademicYear');
        $data['program']=$this->db->where('ProgramID',$program)->get('program')->row();
        $data['PRNs']=$this->db->select('PRN')->get('students')->result();
        $PRN=$this->input->get('PRN');
        if($PRN){
            $data['Mode']=1;
            $data['Studentdetails']=$this->db->where('PRN',$PRN)->get('students')->row();
        }else{
            $data['Mode']=0;
        }

        $this->load->view('ManageStudent',$data);
    }


    public function ChangeValueStudents(){
        $this->loader();
        $ProgramID=$this->input->post('ProgramID');
        $Mode=$this->input->post('Mode');
        $PRN=$this->input->post('PRN');
        $Name=$this->input->post('StudentName');
        $AcademicYear=$this->input->post('AcademicYear');
        if($Mode==0){
            $data = array(
                'PRN'           => $PRN,
                'Name'          => $Name,
                'ProgramID'     => $ProgramID,
                'AcademicYear'  => $AcademicYear,
            );
            $inserted = $this->db->insert('students', $data);
            if ($inserted) {
                redirect('admin/students?program='.$ProgramID."&AcademicYear=".$AcademicYear);
            } else {
                echo "Failed to insert students.";
            }
        }else if($Mode==1){
            $data = array(
                'Name' => $Name
            );
            $this->db->where('PRN', $PRN);
            $updated = $this->db->update('students', $data);

            if ($updated) {
                redirect('admin/students?program='.$ProgramID."&AcademicYear=".$AcademicYear);
            } else {
                echo "Failed to update students.";
            }
        }elseif($Mode==2){

            $AttD=$this->db->where('PRN', $PRN)->get('examattender')->result();
            foreach($AttD as $Att){
                $this->db->where('AttID ', $Att->AttID );
                $this->db->delete('marks');

                $this->db->where('AttID ', $Att->AttID);
                $this->db->delete('examattender');
            }

            $this->db->where('PRN', $PRN);            
            $this->db->delete('students');
        }
        
    }



    public function courses() {
        $this->loader();
        if (!$this->session->userdata('user_name')) {
            redirect('admin');
        }
        $program=$this->input->get('program');
        $data['semester']=$semester=$this->input->get('semester');
        $data['program']=$program;
        $data['course']=$this->db->where('ProgramID',$program)->where('Semester',$semester)->order_by('CourseCode', 'ASC')->get('course')->result();
        $this->load->view('courses',$data);
    }



    public function Semester() {
        $this->loader();
        if (!$this->session->userdata('user_name')) {
            redirect('admin');
        }
        $program=$this->input->get('program');
        $data['program']=$program;
        $this->db->distinct();
        $this->db->select('Semester');
        $this->db->from('course');
        $this->db->where('ProgramID', $program);
        $this->db->order_by('Semester', 'ASC');

        $query = $this->db->get();
        $result = $query->result();
        $data['Semesters']=$result;
        $this->load->view('Semester',$data);
    }


    public function ManageCourse(){
        $this->loader();
        if (!$this->session->userdata('user_name')) {
            redirect('admin');
        }
        $CourseCode=$this->input->get('CourseCode');
        $program=$this->input->get('program');
        $data['semester']=$this->input->get('semester');
        $data['program']=$this->db->where('ProgramID',$program)->get('program')->row();
        $data['CourseCodes']=$this->db->select('CourseCode')->get('course')->result();
        if($CourseCode){
            $data['Mode']=1;
            $data['CourseDetails']=$this->db->where('CourseCode',$CourseCode)->get('course')->row();
        }else{
            $data['Mode']=0;
        }
        $this->load->view('ManageCourse',$data);
    }

    public function ChangeValue(){
        $this->loader();
        $ProgramID=$this->input->post('ProgramID');
        $Mode=$this->input->post('Mode');
        $CourseCode=$this->input->post('CourseCode');
        $CourseName=$this->input->post('CourseName');
        $Credits=$this->input->post('Credits');
        $CourseType=$this->input->post('CourseType');
        $SemesterNo=$this->input->post('SemesterNo');
        if($Mode==0){
            $data = array(
                'CourseCode'  => $CourseCode,
                'CourseName'  => $CourseName,
                'Credit'     => $Credits,
                'CourseType'  => $CourseType,
                'ProgramID'   => $ProgramID,
                'Semester'    => $SemesterNo
            );
            $inserted = $this->db->insert('course', $data);
            if ($inserted) {
                redirect('admin/courses?program='.$ProgramID."&semester=".$SemesterNo);
            } else {
                echo "Failed to insert course.";
            }
        }elseif($Mode==1){
            $data = array(
                'CourseName' => $CourseName,
                'Credit'    =>  $Credits,
                'CourseType' => $CourseType,
                'ProgramID'  => $ProgramID,
                'Semester'   => $SemesterNo
            );
            $this->db->where('CourseCode', $CourseCode);
            $updated = $this->db->update('course', $data);

            if ($updated) {
                redirect('admin/courses?program='.$ProgramID."&semester=".$SemesterNo);
            } else {
                echo "Failed to update course.";
            }
        }else{
            $this->db->where('CourseCode', $CourseCode);
            $this->db->delete('marks');
            $this->db->where('CourseCode', $CourseCode);
            $this->db->delete('course');
        }
        
    }

    public function SaveMarks(){
        $this->loader();
        $CourseCode=$this->input->post('CourseCode');
        $AttID=$this->input->post('AttID');
        $MarkID=$this->input->post('MarkID');
        $INTS=$this->input->post('INTS');
        $EXT=$this->input->post('EXT');

        $this->db->where('CourseCode', $CourseCode);
        $this->db->where('AttID', $AttID);
        $query = $this->db->get('marks');

        if ($query->num_rows() > 0) {
           $MarkID=$query->row()->MarkID;
        }


        if($MarkID==0){
            $data = array(
                'CourseCode'    => $CourseCode,
                'AttID'         => $AttID,
                'INTS'          => $INTS,
                'EXT'           => $EXT
            );
            $inserted = $this->db->insert('marks', $data);
            if ($inserted) {
                echo "Okay";
            } else {
                echo "Failed to insert marks.";
            }
        }else{
            $data = array(
                'INTS'  => $INTS,
                'EXT'   => $EXT
            );
            $this->db->where('MarkID', $MarkID);
            $updated = $this->db->update('marks', $data);

            if ($updated) {
                echo "Okay";
            } else {
                echo "Failed to update marks.";
            }
        }
    }

    public function exams(){
        $this->loader();
        if (!$this->session->userdata('user_name')) {
            redirect('admin');
        }
        $program=$this->input->get('program');
        $data['program']=$program;
        $data['exams']=$this->db->where('ProgramID',$program)->get('exams')->result();
        $this->load->view('exams',$data);
    }

    public function ManageExam(){
        $this->loader();
        if (!$this->session->userdata('user_name')) {
            redirect('admin');
        }
        $ExamID=$this->input->get('ExamID');
        $program=$this->input->get('program');
        $data['program']=$this->db->where('ProgramID',$program)->get('program')->row();
        if($ExamID){
            $data['Mode']=1;
            $data['ExamsDetails']=$this->db->where('ExamID',$ExamID)->get('exams')->row();
        }else{
            $data['Mode']=0;
        }
        $this->load->view('ManageExam',$data);
    }

    public function ChangeValueExam(){
        $this->loader();
        $ProgramID=$this->input->post('ProgramID');
        $Mode=$this->input->post('Mode');
        $ExamID=$this->input->post('ExamID');
        $ExamName=$this->input->post('ExamName');
        $AcademicYear=$this->input->post('AcademicYear');
        $Semester=$this->input->post('SemesterNo');
        if($Mode==0){
            $data = array(
                'ExamName'      => $ExamName,
                'ProgramID'     => $ProgramID,
                'AcademicYear'  => $AcademicYear,
                'Semester'      => $Semester
            );
            $inserted = $this->db->insert('exams', $data);
            if ($inserted) {
                redirect('admin/exams?program='.$ProgramID);
            } else {
                echo "Failed to insert exams.";
            }
        }else if($Mode==1){
            $data = array(
                'ExamName' => $ExamName,
            );
            $this->db->where('ExamID', $ExamID);
            $updated = $this->db->update('exams', $data);

            if ($updated) {
                redirect('admin/exams?program='.$ProgramID);
            } else {
                echo "Failed to update exams.";
            }
        }elseif($Mode==2){

            $AttD=$this->db->where('ExamID', $ExamID)->get('examattender')->result();
            foreach($AttD as $Att){
                $this->db->where('AttID ', $Att->AttID );
                $this->db->delete('marks');

                $this->db->where('AttID ', $Att->AttID);
                $this->db->delete('examattender');
            }
            
            $this->db->where('ExamID', $ExamID);
            $this->db->delete('exams');
        }
        
    }

}
