<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Childcare_m extends MY_Model {

	protected $_table_name = 'childcare';
	protected $_primary_key = 'childcareID';
	protected $_primary_filter = 'intval';
	protected $_order_by = "childcareID desc";

	function __construct() {
		parent::__construct();
	}

	function get_childcare($array=NULL, $signal=FALSE) {
		$query = parent::get($array, $signal);
		return $query;
	}

	function get_join_childcare_all($id=null) {
        $this->db->select('*');
        $this->db->from('childcare');
        $this->db->join('classes', 'classes.ClassesID = childcare.classesID', 'LEFT');
        $this->db->join('student', 'student.studentID = childcare.userID', 'LEFT');
        if ((int)$id) {
            $this->db->where("childcare.childcareID", $id);
        }
        $this->db->where('childcare.schoolyearID', $this->session->userdata('defaultschoolyearID'));

        $query = $this->db->get();
        return $query->result();
	}

	function get_order_by_childcare($array=NULL) {
		$query = parent::get_order_by($array);
		return $query;
	}

	function insert_childcare($array) {
		$id = parent::insert($array);
		return $id;
	}

	function update_childcare($data, $id = NULL) {
		parent::update($data, $id);
		return $id;
	}

	public function delete_childcare($id){
		parent::delete($id);
	}
}

/* End of file childcare_m.php */
/* Location: .//D/xampp/htdocs/school/mvc/models/childcare_m.php */
