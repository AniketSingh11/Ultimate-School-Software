<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Online_exam_m extends MY_Model {

    protected $_table_name = 'online_exam';
    protected $_primary_key = 'onlineExamID';
    protected $_primary_filter = 'intval';
    protected $_order_by = "onlineExamID asc";

    function __construct() {
        parent::__construct();
    }

    function get_online_exam($array=NULL, $signal=FALSE) {
        $query = parent::get($array, $signal);
        return $query;
    }

    function get_single_online_exam($array) {
        $query = parent::get_single($array);
        return $query;
    }

    function get_order_by_online_exam($array=NULL) {
        $query = parent::get_order_by($array);
        return $query;
    }

    function insert_online_exam($array) {
        $id = parent::insert($array);
        return $id;
    }

    function update_online_exam($data, $id = NULL) {
        parent::update($data, $id);
        return $id;
    }

    public function delete_online_exam($id){
        parent::delete($id);
    }
}
