<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Example extends Admin_Controller {

	function __construct() {
		parent::__construct();
        $this->load->driver('cache', array('adapter' => 'file'));
        $this->load->library('blade');
        redirect('dashboard/index');
	}

	function index() {
		$this->data["subview"] = "example/index";
        $this->load->view('_layout_main', $this->data);
	}

	function get() {
		$this->data["subview"] = "example/addtextfield";
        $this->load->view('_layout_main', $this->data);
	}
}

/* End of file class.php */
/* Location: .//D/xampp/htdocs/school/mvc/controllers/class.php */