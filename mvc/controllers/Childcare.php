<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Childcare extends Admin_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model("childcare_m");
		$this->load->model('usertype_m');
		$this->load->model('systemadmin_m');
		$this->load->model('student_m');
		$this->load->model('parents_m');
		$this->load->model('teacher_m');
		$this->load->model('user_m');
		$language = $this->session->userdata('lang');
		$this->lang->load('childcare', $language);
	}

	protected function rules() {
		$rules = array(
			array(
				'field' => 'classesID',
				'label' => $this->lang->line("classesID"),
				'rules' => 'trim|numeric|max_length[11]|xss_clean|callback_unique_classes'
			),
			array(
				'field' => 'userID',
				'label' => $this->lang->line("userID"),
				'rules' => 'trim|numeric|required|xss_clean|callback_unique_userID'
			),

			array(
				'field' => 'receiver_name',
				'label' => $this->lang->line("receiver_name"),
				'rules' => 'trim|required|xss_clean|max_length[60]'
			),

            array(
				'field' => 'drop_date',
				'label' => $this->lang->line("drop_date"),
				'rules' => 'trim|required|xss_clean|max_length[60]'
			),
            array(
				'field' => 'receive_date',
				'label' => $this->lang->line("receive_date"),
				'rules' => 'trim|xss_clean|max_length[60]'
			),
            array(
				'field' => 'drop_time',
				'label' => $this->lang->line("add_drop_time"),
				'rules' => 'trim|required|xss_clean|max_length[60]'
			),
            array(
				'field' => 'receive_time',
				'label' => $this->lang->line("add_receive_time"),
				'rules' => 'trim|xss_clean|max_length[60]'
			),
			array(
				'field' => 'phone',
				'label' => $this->lang->line("phone"),
				'rules' => 'trim|required|max_length[25]|min_length[5]|xss_clean'
			),
            array(
				'field' => 'comment',
				'label' => $this->lang->line("comment"),
				'rules' => 'trim|max_length[40]|xss_clean'
			)
            
		);
		return $rules;
	}

	public function index() {
        $this->data['headerassets'] = array(
            'css' => array(
                'assets/timepicker/timepicker.css',
                'assets/datepicker/datepicker.css',
                'assets/select2/css/select2.css',
                'assets/select2/css/select2-bootstrap.css'
            ),
            'js' => array(
                'assets/datepicker/datepicker.js',
                'assets/select2/select2.js',
                'assets/timepicker/timepicker.js'
            )
        );

        

        $this->data['drop_receive'] = $this->childcare_m->get_join_childcare_all();
        $this->data['parents'] = $this->parents_m->get_parents();
        $this->data['classes'] = $this->classes_m->get_classes();

        if($this->input->post('classesID')) {
        	$this->data['students'] = $this->student_m->get_order_by_student(array('schoolyearID' => $this->data['siteinfos']->school_year, 'classesID' => $this->input->post('classesID')));
        } else {
        	$this->data['students'] = array();
        }

		if ($_POST) {
			$rules = $this->rules();
			$array = array();
            $this->form_validation->set_rules($rules);
            if ($this->form_validation->run() == FALSE) {
                $this->data["subview"] = "childcare/index";
                $this->load->view('_layout_main', $this->data);
            } else {
                for($i=0; $i<count($rules); $i++) {
                    $array[$rules[$i]['field']] = $this->input->post($rules[$i]['field']);
                }
                
                if($this->input->post('userID')) {
                	$student = $this->student_m->get_single_student(array('studentID' => $this->input->post('userID')));
                	if(count($student)) {
                		$data['parentID'] = $student->parentID;
                	} else {
                		$data['parentID'] = 0;
                	}
                }

                $data["classesID"] = $array['classesID'];
                $data["userID"] = $array['userID'];
                
                $data["receiver_name"] = $array['receiver_name'];
                $data["phone"] = $array['phone'];
                $data["dropped_at"] = date("Y-m-d H:i:s", strtotime($array['drop_date']." ". $array['drop_time']));
                
                $data["received_at"] = date("Y-m-d H:i:s", strtotime($array['receive_date']." ". $array['receive_time']));
                $data["usertypeID"] = 3;
                $data["schoolyearID"] = $this->data['siteinfos']->school_year;
                $data["comment"] = $array['comment'];

                $this->childcare_m->insert_childcare($data);
                redirect(base_url('childcare/index'));
            }
	    } else {
			$this->data["subview"] = "childcare/index";
			$this->load->view('_layout_main', $this->data);
		}

	}

	function all_student() {
		$classesID = $this->input->post('classes');
		if((int)$classesID) {
			$this->data['users'] = array();
            $this->data['users'] = $this->student_m->get_order_by_student(array('classesID' => $classesID));
            echo "<option value='0'>", $this->lang->line("select_student"),"</option>";
            if(count($this->data['users'])) {
                foreach ($this->data['users'] as $value) {
                    echo "<option value=\"$value->studentID\">",$value->name,"</option>";
                }
            }
		}
	}

	public function delete() {
		$id = htmlentities(escapeString($this->uri->segment(3)));
		if((int)$id) {
			$this->childcare_m->delete_childcare($id);
			$this->session->set_flashdata('success', $this->lang->line('menu_success'));
			redirect(base_url("childcare/index"));
		} else {
			redirect(base_url("childcare/index"));
		}
	}

	function unique_classes() {
		if($this->input->post('classesID') == 0) {
			$this->form_validation->set_message("unique_classes", "The %s field is required");
	     	return FALSE;
		}
		return TRUE;
	}

	function unique_userID() {
		if($this->input->post('userID') == 0) {
			$this->form_validation->set_message("unique_userID", "The %s field is required");
	     	return FALSE;
		}
		return TRUE;
	}

}

/* End of file childcare.php */
/* Location: .//var/www/html/schoolv2/mvc/controllers/childcare.php */
