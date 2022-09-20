<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pages_m extends MY_Model {

    protected $_table_name = 'pages';
    protected $_primary_key = 'pagesID';
    protected $_primary_filter = 'intval';
    protected $_order_by = "pagesID asc";

    function __construct() {
        parent::__construct();
    }

    function get_pages($array=NULL, $signal=FALSE) {
        $query = parent::get($array, $signal);
        return $query;
    }

    function get_single_pages($array) {
        $query = parent::get_single($array);
        return $query;
    }

    function get_order_by_pages($array=NULL) {
        $query = parent::get_order_by($array);
        return $query;
    }

    function insert_pages($array) {
        $id = parent::insert($array);
        return $id;
    }

    function update_pages($data, $id = NULL) {
        parent::update($data, $id);
        return $id;
    }

    public function delete_pages($id){
        parent::delete($id);
    }

    public function get_one() {
        $query = $this->db->get($this->_table_name);
        $query = $this->db->join('fmenu_relation', 'fmenu_relation.menu_pagesID = pages.pagesID', 'FULL');
        $query = $this->db->order_by('pages.pagesID asc'); 
        $query = $this->db->get_where($this->_table_name, array('status' => 1));
        $ret = $query->row();
        return $ret;
    }
}
