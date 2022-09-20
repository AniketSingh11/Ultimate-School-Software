<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Frontend_setting extends Admin_Controller {
    
    function __construct() {
        parent::__construct();
        $this->load->model("frontend_setting_m");
        $this->load->helper('frontenddata');
        $language = $this->session->userdata('lang');
        $this->lang->load('frontend_setting', $language);
    }

    protected function rules() {
        $rules = array(
            array(
                'field' => 'facebook',
                'label' => $this->lang->line("frontend_setting_facebook"),
                'rules' => 'trim|xss_clean|max_length[255]'
            ),
            array(
                'field' => 'twitter',
                'label' => $this->lang->line("frontend_setting_twitter"),
                'rules' => 'trim|xss_clean|max_length[255]'
            ),
            array(
                'field' => 'linkedin',
                'label' => $this->lang->line("frontend_setting_linkedin"),
                'rules' => 'trim|xss_clean|max_length[255]'
            ),
            array(
                'field' => 'youtube',
                'label' => $this->lang->line("frontend_setting_youtube"),
                'rules' => 'trim|xss_clean|max_length[255]'
            ),
            array(
                'field' => 'google',
                'label' => $this->lang->line("frontend_setting_google"),
                'rules' => 'trim|xss_clean|max_length[255]'
            )
        );
        return $rules;
    }

    public function index() {
        $this->data['frontend_setting'] = $this->frontend_setting_m->get_frontend_setting();

        if($this->data['frontend_setting']) {
            if($_POST) {
                $rules = $this->rules();
                $this->form_validation->set_rules($rules);
                if ($this->form_validation->run() == FALSE) {
                    $this->data["subview"] = "frontend_setting/index";
                    $this->load->view('_layout_main', $this->data);
                } else {
                    $array = array(
                        'facebook' => $this->input->post('facebook'),
                        'twitter' => $this->input->post('twitter'),
                        'linkedin' => $this->input->post('linkedin'),
                        'youtube' => $this->input->post('youtube'),
                        'google' => $this->input->post('google'),
                    );

                    $this->frontend_setting_m->insertorupdate($array);
                    $this->session->set_flashdata('success', $this->lang->line('menu_success'));

                    frontendData::get_frontend_delete();
                    frontendData::get_frontend();
                    redirect(base_url("frontend_setting/index"));
                }
            } else {
                $this->data["subview"] = "frontend_setting/index";
                $this->load->view('_layout_main', $this->data);
            }
        } else {
            $this->data["subview"] = "error";
            $this->load->view('_layout_main', $this->data);
        }
    }
}
