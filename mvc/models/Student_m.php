<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once 'Classes_m.php';

class student_m extends MY_Model {

	protected $_table_name = 'student';
	protected $_primary_key = 'student.studentID';
	protected $_primary_filter = 'intval';
	protected $_order_by = "roll asc";

	function __construct() {
		parent::__construct();
	}

	function get_username($table, $data=NULL) {
		$query = $this->db->get_where($table, $data);
		return $query->result();
	}

	function get_single_username($table, $data=NULL) {
		$query = $this->db->get_where($table, $data);
		return $query->row();
	}

	function get_class($id=NULL) {
		$query = $this->db->get_where('classes', array('classesID' => $id));
		return $query->row();
	}

	function get_classes() {
	    $class = new Classes_m;
	    return $class->get_order_by_classes();
	}

	function get_parent($id = NULL) {
		$query = $this->db->get_where('parent', array('studentID' => $id));
		return $query->row();
	}

	function get_parent_info($username = NULL) {
		$query = $this->db->get_where('parent', array('username' => $username));
		return $query->row();
	}

	function get_student($array=NULL, $signal=FALSE) {
		if($this->showTeacherStudent([], $array)) {
	        $this->db->join('studentextend', 'studentextend.studentID = student.studentID', 'LEFT');
			$query = parent::get($array, $signal);
			return $query;
		}
		return [];
	}

	function get_single_student($array) {
		$array = $this->showTeacherStudent([], $array);
        $usertypeID = $this->session->userdata('usertypeID');
		if(count($array) || $usertypeID != 2) {
			$array = $this->makeArrayWithTableName($array);
	        $this->db->join('studentextend', 'studentextend.studentID = student.studentID', 'LEFT');
			$query = parent::get_single($array);
			return $query;
		}
		return []; 
        
	}

	function get_order_by_student($array=[]) {
        $array = $this->showTeacherStudent($array);
        $usertypeID = $this->session->userdata('usertypeID');
        if(count($array) || $usertypeID != 2) {
        	$array = $this->makeArrayWithTableName($array);

        	if(!is_array($array)) {
        		$array = [];
        	}
        	$this->db->join('studentextend', 'studentextend.studentID = student.studentID', 'LEFT');
		    $query = parent::get_order_by($array);
			return $query;	
        } else {
        	return [];
        }
	}

	public function showTeacherStudent($array, $studentID = NULL) {
		$usertypeID = $this->session->userdata('usertypeID');
		if($usertypeID == 2) {
			$teacherID = $this->session->userdata('loginuserID');
			$tquery = $this->db->get_where('classes', array('teacherID' => $teacherID));
			$classes = pluck($tquery->result(), 'classesID');
			if(isset($array['classesID']) && in_array($array['classesID'], $classes)) {
				return $array;
			} elseif(!is_null($studentID) && !is_array($studentID)) {
				$squery = $this->db->get_where('student', array('studentID' => $studentID));
				$getStudent = $squery->row();

				if(count($getStudent) && (in_array($getStudent->classesID, $classes))) {
					return $studentID;
				} else {
					return FALSE; 
				}
			} elseif(is_array($studentID)) {
				$squery = $this->db->get_where('student', $studentID);
				$getStudent = $squery->row();

				if(count($getStudent) && (in_array($getStudent->classesID, $classes))) {
					return $studentID;
				} else {
					return []; 
				}
			} else {
				return [];
			}
		} else {
			if(is_null($studentID)) {
				if(!count($array)) {
					return TRUE;
				}
				return $array;
			} else {
				return $studentID;
			}
		}
	}

	function get_order_by_student_single_max_roll($roll, $classesID) {
		$query = $this->db->query("SELECT MAX(roll) AS maxroll FROM student WHERE roll LIKE '%$roll%' AND classesID= '$classesID'");
		return $query->row();
	}

	function insert_student($array) {
		$id = parent::insert($array);
		return $id;
	}

	function insert_parent($array) {
		$this->db->insert('parent', $array);
		return TRUE;
	}

	function update_student($data, $id = NULL) {
		parent::update($data, $id);
		return $id;
	}

	function update_student_classes($data, $array = NULL) {
		$this->db->set($data);
		$this->db->where($array);
		$this->db->update($this->_table_name);
	}

	function delete_student($id){
		parent::delete($id);
	}

	function delete_parent($id){
		$this->db->delete('parent', array('studentID' => $id));
	}

	function hash($string) {
		return parent::hash($string);
	}

	function profileUpdate($table, $data, $username) {
		$this->db->update($table, $data, "username = '".$username."'");
		return TRUE;
	}

	function profileRelationUpdate($table, $data, $studentID) {
		$this->db->update($table, $data, "srstudentID = '".$studentID."'");
		return TRUE;
	}

	/* Start For Promotion */
	function get_order_by_student_year($classesID) {
		$query = $this->db->query("SELECT * FROM student WHERE year = (SELECT MIN(year) FROM student) AND classesID = $classesID order by roll asc");
		return $query->result();
	}

	function get_order_by_student_single_year($classesID) {
		$query = $this->db->query("SELECT year FROM student WHERE year = (SELECT MIN(year) FROM student) AND classesID = $classesID order by roll asc");
		return $query->row();
	}

	function get_order_by_student_single_max_year($classesID) {
		$query = $this->db->query("SELECT year FROM student WHERE year = (SELECT MAX(year) FROM student) AND classesID = $classesID order by roll asc");
		return $query->row();
	}
	/* End For Promotion */


	/* Start For Report */
	function get_order_by_student_with_section($classesID, $schoolyearID, $sectionID=NULL) {
		$this->db->select('*');
		$this->db->from('student');
		$this->db->join('classes', 'student.classesID = classes.classesID', 'LEFT');
		$this->db->join('section', 'student.sectionID = section.sectionID', 'LEFT');
		$this->db->join('studentextend', 'studentextend.studentID = student.studentID', 'LEFT');
		$this->db->where('student.classesID', $classesID);
		$this->db->where('student.schoolyearID', $schoolyearID);
		if($sectionID != NULL) {
			$this->db->where('student.sectionID', $sectionID);
		}
		$query = $this->db->get();
		return $query->result();
	}

	/* End For Report */




	/* infinite code starts here */
}

/* End of file student_m.php */
/* Location: .//D/xampp/htdocs/school/mvc/models/student_m.php */
