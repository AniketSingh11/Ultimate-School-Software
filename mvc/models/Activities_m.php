<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Activities_m extends MY_Model {

	protected $_table_name = 'activities';
	protected $_primary_key = 'activitiesID';
	protected $_primary_filter = 'intval';
	protected $_order_by = "activitiesID desc";

	function __construct() {
		parent::__construct();
	}

	function get_activities($array=NULL, $signal=FALSE) {
		$query = parent::get($array, $signal);
		return $query;
	}

    function get_activities_data() {

        $this->db->select('*');
        $this->db->from('activities');
        $this->db->join('activitiescategory', 'activities.activitiescategoryID = activitiescategory.activitiescategoryID', 'LEFT');

        $this->db->order_by('activitiesID', 'desc');
        $query = $this->db->get();
        $activities = $query->result();
        foreach ($activities as $key => &$row)
        {
            $row->attachments = $this->get_media_for_activities($row->activitiesID);
            $row->students = $this->get_students_for_activities($row->activitiesID);
            $row->comments = $this->get_comments_for_activities($row->activitiesID);

            if ($row->usertypeID == 1) {
                $table = "systemadmin";
            } elseif($row->usertypeID == 2) {
                $table = "teacher";
            } elseif($row->usertypeID == 3) {
                $table = 'student';
            } elseif($row->usertypeID == 4) {
                $table = 'parents';
            } else {
                $table = 'user';
            }

            $query = $this->db->get_where($table, array($table.'ID' => $row->userID));
            if (count($query->row())) {
                $row = (object) array_merge( (array)$row, array( 'publisher' => $query->row()->name, 'user_image' => $query->row()->photo));
            }
        }

        return $activities;
    }

    function get_media_for_activities($activities_id) {
        $media = $this->db->get_where("activitiesmedia", array("activitiesID" => $activities_id))->result();
        return $media;
    }

    function get_students_for_activities($activities_id) {
        return $this->db->get_where("activitiesstudent", array("activitiesID" => $activities_id))->result();
    }

    function get_comments_for_activities($activities_id) {
        $comments = $this->db->get_where("activitiescomment", array("activitiesID" => $activities_id))->result();
        foreach ($comments as $key => $comment) {
            if ($comment->usertypeID == 1) {
                $table = "systemadmin";
            } elseif($comment->usertypeID == 2) {
                $table = "teacher";
            } elseif($comment->usertypeID == 3) {
                $table = 'student';
            } elseif($comment->usertypeID == 4) {
                $table = 'parents';
            } else {
                $table = 'user';
            }

            $query = $this->db->get_where($table, array($table.'ID' => $comment->userID));
            if (count($query->row())) {
                $comments[$key] = (object) array_merge( (array)$comment, array( 'sender' => $query->row()->name, 'photo' => $query->row()->photo));
            }
        }
        return $comments;
    }

	function get_order_by_activities($array=NULL) {
		$query = parent::get_order_by($array);
		return $query;
	}

	function get_single_activities($array=NULL) {
		$query = parent::get_single($array);
		return $query;
	}

	function insert_activities($array) {
		$id = parent::insert($array);
		return $id;
	}

	function update_activities($data, $id = NULL) {
		parent::update($data, $id);
		return $id;
	}

	public function delete_activities($id){
		parent::delete($id);
        $tables = array('activitiesmedia', 'activitiescomment', 'activitiesstudent');
        $this->db->where($this->_primary_key, $id);
        $this->db->delete($tables);
	}
}

/* End of file activities_m.php */
/* Location: .//D/xampp/htdocs/school/mvc/models/activities_m.php */