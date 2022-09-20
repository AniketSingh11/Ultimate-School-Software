<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Complain extends Admin_Controller {
    

    function __construct() {
        parent::__construct();
        $this->load->model("complain_m");
        $this->load->model("systemadmin_m");
        $this->load->model("teacher_m");
        $this->load->model("student_m");
        $this->load->model("parents_m");
        $this->load->model("user_m");
        $language = $this->session->userdata('lang');
        $this->lang->load('complain', $language);
    }

    public function index() {
        if(permissionChecker('complain_view')) {
            $this->data['complains'] = $this->complain_m->get_complain_with_usertypeID();
            $this->data["subview"] = "/complain/index";
            $this->load->view('_layout_main', $this->data);
        } else {
            if(permissionChecker('complain_add')) {
                $this->add();
            } else {
                redirect(base_url('exceptionpage/error'));
            }
        }
    }

    protected function rules() {
        $rules = array(
            array(
                'field' => 'title',
                'label' => $this->lang->line("complain_title"),
                'rules' => 'trim|required|xss_clean|max_length[128]'
            ),
            array(
                'field' => 'usertypeID',
                'label' => $this->lang->line("complain_usertypeID"),
                'rules' => 'trim|required|xss_clean'
            ),
            array(
                'field' => 'userID',
                'label' => $this->lang->line("complain_userID"),
                'rules' => 'trim|xss_clean'
            ),
            array(
                'field' => 'description',
                'label' => $this->lang->line("complain_description"),
                'rules' => 'trim|xss_clean|required'
            ),
            array(
                'field' => 'attachment',
                'label' => $this->lang->line("complain_attachment"),
                'rules' => 'trim|max_length[200]|xss_clean|callback_attachUpload'
            )
        );
        return $rules;
    }

    public function attachUpload() {
        $id = htmlentities(escapeString($this->uri->segment(3)));
        $complain = array();
        if((int)$id) {
            $complain = $this->complain_m->get_complain($id);
        }

        $original_file_name = '';
        if($_FILES["attachment"]['name'] !="") {
            $file_name = $_FILES["attachment"]['name'];
            $original_file_name = $file_name;
            $random = rand(1, 10000000000000000);
            $makeRandom = hash('sha512', $random.config_item("encryption_key"));
            $file_name_rename = $makeRandom;
            $explode = explode('.', $file_name);
            if(count($explode) >= 2) {
                $new_file = $file_name_rename.'.'.end($explode);
                $config['upload_path'] = "./uploads/attach";
                $config['allowed_types'] = "gif|jpg|png|docx|pdf";
                $config['file_name'] = $new_file;
                $config['max_size'] = '1024';
                $config['max_width'] = '3000';
                $config['max_height'] = '3000';
                $this->load->library('upload', $config);
                if(!$this->upload->do_upload("attachment")) {
                    $this->form_validation->set_message("attachUpload", $this->upload->display_errors());
                    return FALSE;
                } else {
                    $this->upload_data['file'] =  $this->upload->data();
                    $this->upload_data['file']['original_file_name'] = $original_file_name;
                    return TRUE;
                }
            } else {
                $this->form_validation->set_message("attachUpload", "Invalid file");
                return FALSE;
            }
        } else {
            if(count($complain)) {
                $this->upload_data['file'] = array('file_name' => $complain->attachment);
                $this->upload_data['file']['original_file_name'] = $complain->originalfile;
                return TRUE;
            }
        }
    }

    public function add() {
        $this->data['headerassets'] = array(
            'css' => array(
                'assets/select2/css/select2.css',
                'assets/select2/css/select2-bootstrap.css',
                'assets/editor/jquery-te-1.4.0.css'
            ),
            'js' => array(
                'assets/select2/select2.js',
                'assets/editor/jquery-te-1.4.0.min.js'
            )
        );
        $this->data['usertypes'] = $this->usertype_m->get_usertype();
        $this->data['usertypeID'] = 0;
        

        if($_POST) {
            if($this->input->post('usertypeID')) {
                $this->data['usertypeID'] = $this->input->post('usertypeID');
            } else {
                $this->data['usertypeID'] = 0;
            }

            $rules = $this->rules();
            $this->form_validation->set_rules($rules);
            if ($this->form_validation->run() == FALSE) {
                $this->data['form_validation'] = validation_errors();
                $this->data["subview"] = "complain/add";
                $this->load->view('_layout_main', $this->data);
            } else {
                $array = array(
                    "title" => $this->input->post("title"),
                    "usertypeID" => $this->input->post("usertypeID"),
                    "userID" => $this->input->post("userID"),
                    "description" => $this->input->post("description"),
                );
                $array['attachment'] = $this->upload_data['file']['file_name'];
                $array['originalfile'] = $this->upload_data['file']['original_file_name'];

                $this->complain_m->insert_complain($array);
                $this->session->set_flashdata('success', $this->lang->line('menu_success'));
                redirect(base_url("complain/index"));
            }
        } else {
            $this->data["subview"] = "complain/add";
            $this->load->view('_layout_main', $this->data);
        }
    }

    public function edit() {
        $this->data['headerassets'] = array(
            'css' => array(
                'assets/select2/css/select2.css',
                'assets/select2/css/select2-bootstrap.css',
                'assets/editor/jquery-te-1.4.0.css'
            ),
            'js' => array(
                'assets/select2/select2.js',
                'assets/editor/jquery-te-1.4.0.min.js'
            )
        );
        $id = htmlentities(escapeString($this->uri->segment(3)));
        $this->data['usertypes'] = $this->usertype_m->get_usertype();

        if((int)$id) {
            $this->data['complain'] = $this->complain_m->get_single_complain(array('complainID' => $id));
            if($this->data['complain']) {

                $this->data['userID'] = $this->data['complain']->userID;

                if($this->input->post('usertypeID')) {
                    $usertypeID = $this->input->post('usertypeID');
                    $this->data['usertypeID'] = $this->input->post('usertypeID');
                } else {
                    $usertypeID = $this->data['complain']->usertypeID;
                    $this->data['usertypeID'] = $this->data['complain']->usertypeID;                
                }

                if($usertypeID != 0) {
                    if($usertypeID == 1) {
                        $this->data['users'] = pluck($this->systemadmin_m->get_systemadmin(), 'name', 'systemadminID');
                    } elseif($usertypeID == 2) {
                        $this->data['users'] = pluck($this->teacher_m->get_teacher(), 'name', 'teacherID');
                    } elseif($usertypeID == 3) {
                        $this->data['users'] = pluck($this->student_m->get_order_by_student(array('schoolyearID' => $this->data['siteinfos']->school_year)), 'name', 'studentID');
                    } elseif($usertypeID == 4) {
                        $this->data['users'] = pluck($this->parents_m->get_parents(), 'name', 'parentsID');
                    } else {
                        $this->data['users'] = pluck($this->user_m->get_order_by_user(array('usertypeID' => $usertypeID)), 'name', 'userID');
                    }
                } else {
                    $this->data['users'] = array();
                }


                if($_POST) {
                    $rules = $this->rules();
                    $this->form_validation->set_rules($rules);
                    if ($this->form_validation->run() == FALSE) {
                        $this->data['usertypeID'] = $this->input->post('usertypeID');
                        $this->data['userID'] = $this->input->post('userID');
                        $this->data["subview"] = "complain/edit";
                        $this->load->view('_layout_main', $this->data);
                    } else {
                        $array = array(
                            "title" => $this->input->post("title"),
                            "usertypeID" => $this->input->post("usertypeID"),
                            "userID" => $this->input->post("userID"),
                            "description" => $this->input->post("description"),
                        );

                        $array['attachment'] = $this->upload_data['file']['file_name'];
                        $array['originalfile'] = $this->upload_data['file']['original_file_name'];

                        $this->complain_m->update_complain($array, $id);
                        $this->session->set_flashdata('success', $this->lang->line('menu_success'));
                        redirect(base_url("complain/index"));
                    }
                } else {
                    $this->data["subview"] = "complain/edit";
                    $this->load->view('_layout_main', $this->data);
                }
            } else {
                $this->data["subview"] = "error";
                $this->load->view('_layout_main', $this->data);
            }
        } else {
            $this->data["subview"] = "error";
            $this->load->view('_layout_main', $this->data);
        }
    }

    public function view() {
        $id = htmlentities(escapeString($this->uri->segment(3)));
        if((int)$id) {
            $this->data['complain'] = $this->complain_m->get_single_complain_with_usertypeID(array('complainID' => $id));
            if($this->data['complain']) {
                $this->data['usertype'] = $this->usertype_m->get_usertype($this->data['complain']->usertypeID);
                $usertypeID = $this->data['complain']->usertypeID;
                if($usertypeID != 0) {
                    if($usertypeID == 1) {
                        $this->data['user'] = $this->systemadmin_m->get_single_systemadmin(array('systemadminID' => $this->data['complain']->userID));
                    } elseif($usertypeID == 2) {
                        $this->data['user'] = $this->teacher_m->get_single_teacher(array('teacherID' => $this->data['complain']->userID));
                    } elseif($usertypeID == 3) {
                        $this->data['user'] = $this->student_m->get_single_student(array('studentID' => $this->data['complain']->userID));
                    } elseif($usertypeID == 4) {
                        $this->data['user'] = $this->parents_m->get_single_parents(array('parentsID' => $this->data['complain']->userID));
                    } else {
                        $this->data['user'] = $this->user_m->get_single_user(array('usertypeID' => $usertypeID, 'userID' => $this->data['complain']->userID));
                    }
                } else {
                    $this->data['user'] = "empty";
                }
                $this->data["subview"] = "/complain/view";
                $this->load->view('_layout_main', $this->data);
            } else {
                $this->data["subview"] = "error";
                $this->load->view('_layout_main', $this->data);
            }
        } else {
            $this->data["subview"] = "error";
            $this->load->view('_layout_main', $this->data);
        }
    }

    public function delete() {
        $id = htmlentities(escapeString($this->uri->segment(3)));
        if((int)$id) {
            $this->data['complain'] = $this->complain_m->get_single_complain(array('complainID' => $id));
            if($this->data['complain']) {
                if(config_item('demo') == FALSE) {
                    if($this->data['complain']->attachment) {
                        if(file_exists(FCPATH.'uploads/attach/'.$this->data['complain']->attachment)) {
                            unlink(FCPATH.'uploads/attach/'.$this->data['complain']->attachment);
                        }
                    }
                }

                $this->complain_m->delete_complain($id);
                $this->session->set_flashdata('success', $this->lang->line('menu_success'));
                redirect(base_url("complain/index"));
            } else {
                redirect(base_url("complain/index"));
            }
        } else {
            redirect(base_url("complain/index"));
        }
    }

    function allStudent() {
        $classesID = $this->input->post('classes');
        if( (int)$classesID) {
            $students = $this->student_m->get_order_by_student(array('classesID' => $classesID));

            if(count($students)) {
                echo '<option value="0">'.$this->lang->line('complain_select_users').'</option>';
                foreach ($students as $key => $student) {
                    echo '<option value="'.$student->studentID.'">'.$student->name.'</option>';
                }
            } else {
                echo '<option value="0">'.$this->lang->line('complain_select_users').'</option>';
            }
        } else {
            echo '<option value="0">'.$this->lang->line('complain_select_users').'</option>';
        }
    }

    function all_classes() {
        $userID = $this->input->post('userID');
        $userInfo = $this->student_m->get_student($userID);
        $classes = $this->classes_m->get_classes();
        if(count($classes)) {
            echo "<option value='0'>".$this->lang->line('complain_select_class')."</option>";
            foreach ($classes as $key => $classm) {
                if ($userInfo->classesID==$classm->classesID) {
                    echo "<option value='".$classm->classesID."' selected=\"selected\">".$classm->classes.'</option>';
                } else {
                    echo "<option value='".$classm->classesID."'>".$classm->classes.'</option>';
                }
            }
        } else {
            echo '<option value="0">'.$this->lang->line('complain_select_class').'</option>';
        }
    }

    function all_student() {
        $userID = $this->input->post('userID');
        $userInfo = $this->student_m->get_student($userID);
        $students = $this->student_m->get_order_by_student(array("classesID" => $userInfo->classesID));
        if(count($students)) {
            echo "<option value='0'>".$this->lang->line('complain_select_users')."</option>";
            foreach ($students as $key => $student) {
                if ($userID==$student->studentID) {
                    echo "<option value='".$student->studentID."' selected=\"selected\">".$student->name.'</option>';
                } else {
                    echo "<option value='".$student->studentID."'>".$student->name.'</option>';
                }
            }
        } else {
            echo '<option value="0">'.$this->lang->line('complain_select_users').'</option>';
        }
    }

    function allusers() {
        if($this->input->post('usertypeID') == '0') {
            echo '<option value="0">'.$this->lang->line('complain_select_users').'</option>';
        } else {
            $usertypeID = $this->input->post('usertypeID');

            if($usertypeID == 1) {
                $systemadmins = $this->systemadmin_m->get_systemadmin();
                if(count($systemadmins)) {
                    echo "<option value='0'>".$this->lang->line('complain_select_users')."</option>";
                    foreach ($systemadmins as $key => $systemadmin) {
                        echo "<option value='".$systemadmin->systemadminID."'>".$systemadmin->name.'</option>';
                    }
                } else {
                    echo '<option value="0">'.$this->lang->line('complain_select_users').'</option>';
                }
            } elseif($usertypeID == 2) {
                $teachers = $this->teacher_m->get_teacher();
                if(count($teachers)) {
                    echo "<option value='0'>".$this->lang->line('complain_select_users')."</option>";
                    foreach ($teachers as $key => $teacher) {
                        echo "<option value='".$teacher->teacherID."'>".$teacher->name.'</option>';
                    }
                } else {
                    echo '<option value="0">'.$this->lang->line('complain_select_users').'</option>';
                }
            } elseif($usertypeID == 3) {
                $classes = $this->classes_m->get_classes();
                if(count($classes)) {
                    echo "<option value='0'>".$this->lang->line('complain_select_class')."</option>";
                    foreach ($classes as $key => $classm) {
                        echo "<option value='".$classm->classesID."'>".$classm->classes.'</option>';
                    }
                } else {
                    echo '<option value="0">'.$this->lang->line('complain_select_class').'</option>';
                }
            } elseif($usertypeID == 4) {
                $parents = $this->parents_m->get_parents();
                if(count($parents)) {
                    echo "<option value='0'>".$this->lang->line('complain_select_users')."</option>";
                    foreach ($parents as $key => $parent) {
                        echo "<option value='".$parent->parentsID."'>".$parent->name.'</option>';
                    }
                } else {
                    echo '<option value="0">'.$this->lang->line('complain_select_users').'</option>';
                }
            } else {
                $users = $this->user_m->get_order_by_user(array('usertypeID' => $usertypeID));
                if(count($users)) {
                    echo "<option value='0'>".$this->lang->line('complain_select_users')."</option>";
                    foreach ($users as $key => $user) {
                        echo "<option value='".$user->userID."'>".$user->name.'</option>';
                    }
                } else {
                    echo '<option value="0">'.$this->lang->line('complain_select_users').'</option>';
                }
            }
        }
    }

    public function download() {
        $id = htmlentities(escapeString($this->uri->segment(3)));
        if((int)$id) {
            $complain = $this->complain_m->get_single_complain(array('complainID' => $id));
            $file = realpath('uploads/attach/'.$complain->attachment);
            $originalname = $complain->originalfile;
            if (file_exists($file)) {
                header('Content-Description: File Transfer');
                header('Content-Type: application/octet-stream');
                header('Content-Disposition: attachment; filename="'.basename($originalname).'"');
                header('Expires: 0');
                header('Cache-Control: must-revalidate');
                header('Pragma: public');
                header('Content-Length: ' . filesize($file));
                readfile($file);
                exit;
            } else {
                redirect(base_url('complain/index'));
            }
        } else {
            redirect(base_url('complain/index'));
        }
        
    }
}
