<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Question_bank extends Admin_Controller {
    
    function __construct() {
        parent::__construct();
        $this->load->model("question_bank_m");
        $this->load->model("question_group_m");
        $this->load->model("question_level_m");
        $this->load->model("question_type_m");
        $this->load->model("question_answer_m");
        $this->load->model("question_option_m");
        $language = $this->session->userdata('lang');
        $this->lang->load('question_bank', $language);
    }

    public function index() {
        $this->data['question_banks'] = $this->question_bank_m->get_order_by_question_bank();
        $this->data['groups'] = pluck($this->question_group_m->get_order_by_question_group(), 'obj', 'questionGroupID');
        $this->data['levels'] = pluck($this->question_level_m->get_order_by_question_level(), 'obj', 'questionLevelID');
        $this->data['types'] = pluck($this->question_type_m->get_order_by_question_type(), 'obj', 'typeNumber');
        $this->data["subview"] = "question/bank/index";
        $this->load->view('_layout_main', $this->data);
    }

    protected function rules($postOption) {
        $rules = array(
            array(
                'field' => 'group',
                'label' => $this->lang->line("question_bank_group"),
                'rules' => 'trim|numeric|required|xss_clean|callback_unique_group'
            ),
            array(
                'field' => 'level',
                'label' => $this->lang->line("question_bank_level"),
                'rules' => 'trim|numeric|required|xss_clean|callback_unique_level'
            ),
            array(
                'field' => 'question',
                'label' => $this->lang->line("question_bank_question"),
                'rules' => 'trim|required|xss_clean'
            ),
            array(
                'field' => 'explanation',
                'label' => $this->lang->line("question_bank_explanation"),
                'rules' => 'trim|xss_clean'
            ),
            array(
                'field' => 'photo',
                'label' => $this->lang->line("question_bank_image"),
                'rules' => 'trim|max_length[200]|xss_clean|callback_photoupload'
            ),
            array(
                'field' => 'hints',
                'label' => $this->lang->line("question_bank_hints"),
                'rules' => 'trim|xss_clean'
            ),
            array(
                'field' => 'mark',
                'label' => $this->lang->line("question_bank_mark"),
                'rules' => 'trim|xss_clean|numeric'
            ),
            array(
                'field' => 'type',
                'label' => $this->lang->line("question_bank_type"),
                'rules' => 'trim|required|xss_clean|callback_unique_type'
            )
        );

        if(count($postOption) > 0) {
            $postOption = count($postOption);
            $ruleForAns = 'trim|xss_clean';

            for($i = 1; $i <= $postOption; $i++) {
                $rules[] = array(
                    'field' => 'option'.$i,
                    'label' => $this->lang->line("question_bank_option").' '.$i,
                    'rules' => 'trim|xss_clean'
                );
                
                if($i = 1) {
                    $ruleForAns = 'trim|xss_clean|callback_unique_answer';
                }

                $rules[] = array(
                    'field' => 'answer'.$i,
                    'label' => 'Answer'. ' '.$i,
                    'rules' => $ruleForAns
                    
                ); 
            }
        }

        return $rules;
    }


    public function photoupload() {
        $id = htmlentities(escapeString($this->uri->segment(3)));
        $question_bank = array();
        if((int)$id) {
            $question_bank = $this->question_bank_m->get_question_bank($id);
        }

        $new_file = "default.png";
        if($_FILES["photo"]['name'] !="") {
            $file_name = $_FILES["photo"]['name'];
            $random = rand(1, 10000000000000000);
            $makeRandom = hash('sha512', $random.$_FILES["photo"]['name'].date('Y-M-d-H:i:s') . config_item("encryption_key"));
            $file_name_rename = $makeRandom;
            $explode = explode('.', $file_name);
            if(count($explode) >= 2) {
                $new_file = $file_name_rename.'.'.end($explode);
                $config['upload_path'] = "./uploads/images";
                $config['allowed_types'] = "gif|jpg|jpeg|png|mpeg|x-mpeg|mp3|x-mp3|mpeg3|x-mpeg3|mpg|x-mpg|x-mpegaudio|mkv|flv|vob|wmv|3gp|mpg|avi|mp4";
                $config['file_name'] = $new_file;
                $config['max_size'] = (1024*20);
                $config['max_width'] = '3000';
                $config['max_height'] = '3000';
                $this->load->library('upload');
                $this->upload->initialize($config);
                if(!$this->upload->do_upload("photo")) {
                    $this->form_validation->set_message("photoupload", $this->upload->display_errors());
                    return FALSE;
                } else {
                    $this->upload_data['file'] =  $this->upload->data();
                    return TRUE;
                }
            } else {
                $this->form_validation->set_message("photoupload", "Invalid file");
                return FALSE;
            }
        } else {
            if(count($question_bank)) {
                $this->upload_data['file'] = array('file_name' => $question_bank->upload);
                return TRUE;
            } else {
                $this->upload_data['file'] = array('file_name' => '');
                return TRUE;
            }
        }
    }


    public function imageUpload($imgArrays) {
        $returnArray = array();
        $error = '';

        if(count($imgArrays)) {
            foreach ($imgArrays as $imgkKey => $imgValue) {
                $new_file = '';
                if($_FILES[$imgValue]['name'] !="") {
                    $file_name = $_FILES[$imgValue]['name'];
                    $random = rand(1, 10000000000000000);
                    $makeRandom = $new_file = hash('sha512', $random. $_FILES[$imgValue]['name'] .date('Y-M-d-H:i:s') . config_item("encryption_key"));
                    $file_name_rename = $makeRandom;
                    $explode = explode('.', $file_name);
                    if(count($explode) >= 2) {
                        $new_file = $file_name_rename.'.'.end($explode);
                        $config['upload_path'] = "./uploads/images";
                        $config['allowed_types'] = "gif|jpg|png";
                        $config['file_name'] = $new_file;
                        $config['max_size'] = (1024*2);
                        $config['max_width'] = '3000';
                        $config['max_height'] = '3000';
                        $this->load->library('upload');
                        $this->upload->initialize($config);
                        if(!$this->upload->do_upload($imgValue)) {
                            preg_match_all('!\d+!', $imgValue, $matches);
                            $returnArray['error'][$this->upload->display_errors()][] = 'image '.$matches[0][0];
                        } else {
                            $returnArray['success'][] = $new_file;
                        }

                    }
                }
            }
        }

        return $returnArray;
    }

    public function add() {
        $this->data['headerassets'] = array(
            'css' => array(
                'assets/datepicker/datepicker.css',
                'assets/editor/jquery-te-1.4.0.css'
            ),
            'js' => array(
                'assets/editor/jquery-te-1.4.0.min.js',
                'assets/datepicker/datepicker.js'
            )
        );
        $usertypeID = $this->session->userdata('usertypeID');
        $loginuserID = $this->session->userdata('loginuserID');

        $this->data['groups']  = $this->question_group_m->get_order_by_question_group();
        $this->data['levels']  = $this->question_level_m->get_order_by_question_level();
        $this->data['types']  = $this->question_type_m->get_order_by_question_type();
        $this->data['options'] = array();
        $this->data['answers'] = array();
        $this->data['typeID'] = 0;
        $this->data['totalOptionID'] = 0;

        if($_POST) {
            $postOption = $this->input->post("option");
            $rules = $this->rules($postOption = 0);
            $this->form_validation->set_rules($rules);
            if ($this->form_validation->run() == FALSE) {
                $this->data['form_validation'] = $this->form_validation->error_array();
                $this->data['typeID'] = $this->input->post("type");
                $this->data['totalOptionID'] = $this->input->post("totalOption");
                $this->data['options'] = $this->input->post("option");
                $this->data['answers'] = $this->input->post("answer");
                $this->data["subview"] = "question/bank/add";
                $this->load->view('_layout_main', $this->data);
            } else {
                $imageUpload = array();
                $question_bank = array(
                    "groupID" => $this->input->post("group"),
                    "levelID" => $this->input->post("level"),
                    "question" => $this->input->post("question"),
                    "explanation" => $this->input->post("explanation"),
                    "hints" => $this->input->post("hints"),
                    "mark" => empty($this->input->post('mark')) ? NULL : $this->input->post('mark'),
                    "typeNumber" => $this->input->post("type"),
                    "totalOption" => $this->input->post("totalOption"),
                    "create_date" => date("Y-m-d H:i:s"),
                    "modify_date" => date("Y-m-d H:i:s"),
                    "create_userID" => $usertypeID,
                    "create_usertypeID" => $loginuserID
                );

                $question_bank['upload'] = $this->upload_data['file']['file_name'];

                $options = $this->input->post("option");
                $answers = $this->input->post("answer");

                $questionInsertID = $this->question_bank_m->insert_question_bank($question_bank);

                if($this->input->post("type") == 1 || $this->input->post("type") == 2) {

                    $imgArray = array();
                    if($this->input->post("totalOption") > 0) {
                        for($imgi=1; $imgi<=$this->input->post("totalOption"); $imgi++) {
                            if($_FILES['image'.$imgi]['name'] !="") {
                                $imgArray[] = 'image'.$imgi;
                            }
                        }
                    }

                    if(count($imgArray)) {
                        $imageUpload = $this->imageUpload($imgArray);
                    }

                    $getQuestionOptions = pluck($this->question_option_m->get_order_by_question_option(['questionID' => $questionInsertID]), 'optionID');

                    if(!count($getQuestionOptions)) {
                        foreach (range(1,10) as $optionID) {
                            $data = [
                                'name' => '',
                                'questionID' => $questionInsertID
                            ];
                            $getQuestionOptions[] = $this->question_option_m->insert_question_option($data);
                        }
                    }

                    $totalOption = $this->input->post("totalOption");
                    foreach ($options as $key => $option) {
                        if($option == '' && !isset($imageUpload['success'][$key])) {
                            $totalOption--;
                            continue;
                        }

                        $data = [
                            'name' => $option,
                            'img' => isset($imageUpload['success'][$key]) ? $imageUpload['success'][$key] : ''
                        ];
                        $this->question_option_m->update_question_option($data, $getQuestionOptions[$key]);
                        if(in_array($key+1, $answers)) {
                            $ansData = [
                                'questionID' => $questionInsertID,
                                'optionID' => $getQuestionOptions[$key],
                                'typeNumber' =>$this->input->post("type")
                            ];
                            $this->question_answer_m->insert_question_answer($ansData);
                        }
                    }

                    if($totalOption != $this->input->post("totalOption")) {
                        $this->question_bank_m->update_question_bank(['totalOption' => $totalOption], $questionInsertID);
                    }
                } elseif ($this->input->post("type") == 3) {
                    $totalOption = $this->input->post("totalOption");
                    foreach ($answers as $answer) {
                        if($answer == '') {
                            $totalOption--;
                            continue;
                        }
                        $ansData = [
                            'questionID' => $questionInsertID,
                            'text' => $answer,
                            'typeNumber' =>$this->input->post("type")
                        ];
                        $this->question_answer_m->insert_question_answer($ansData);

                        if($totalOption != $this->input->post("totalOption")) {
                            $this->question_bank_m->update_question_bank(['totalOption' => $totalOption], $questionInsertID);
                        }
                    }
                }

 
                if(count($imageUpload['error'])) {
                    $errorData = '';
                    foreach ($imageUpload['error'] as $imgErrorKey => $imgErrorValue) {
                        $optionErrors = implode(',', $imgErrorValue);
                        $errorData .= $imgErrorKey .' : '. $optionErrors.'<br/>';
                    }
                    $this->session->set_flashdata('error', $errorData);
                        redirect(base_url("question_bank/edit/$questionInsertID"));
                } else {
                    $this->session->set_flashdata('success', $this->lang->line('menu_success'));
                    redirect(base_url("question_bank/index"));
                }
            }
        } else {
            $this->data["subview"] = "question/bank/add";
            $this->load->view('_layout_main', $this->data);
        }
    }

    public function edit() {
        $this->data['headerassets'] = array(
            'css' => array(
                'assets/datepicker/datepicker.css',
                'assets/editor/jquery-te-1.4.0.css'
            ),
            'js' => array(
                'assets/editor/jquery-te-1.4.0.min.js',
                'assets/datepicker/datepicker.js'
            )
        );
        $questionID = htmlentities(escapeString($this->uri->segment(3)));
        if((int)$questionID) {
            $this->data['question_bank'] = $this->question_bank_m->get_single_question_bank(array('questionBankID' => $questionID));
            if($this->data['question_bank']) {

                // $this->data['form_validation'] = $this->form_validation->error_array();
                $this->data['typeID'] = $this->data['question_bank']->typeNumber;
                $this->data['totalOptionID'] = $this->input->post("totalOption");
                $this->data['dbTotalOptionID'] = pluck($this->question_option_m->get_order_by_question_option(['questionID' => $questionID, 'name !=' => '']), 'name', 'optionID');
                // $this->data['answers'] = $this->input->post("answer");



                $this->data['groups']  = $this->question_group_m->get_order_by_question_group();
                $this->data['levels']  = $this->question_level_m->get_order_by_question_level();
                $this->data['types']  = $this->question_type_m->get_order_by_question_type();
                $this->data['options'] = pluck($this->question_option_m->get_order_by_question_option(['questionID' => $questionID]), 'name', 'optionID');

                // dd($this->data['options']);

                if($this->data['question_bank']->typeNumber == 1 || $this->data['question_bank']->typeNumber == 2) {
                    $this->data['answers'] = pluck($this->question_answer_m->get_order_by_question_answer(['questionID' => $questionID]), 'optionID');
                } elseif ($this->data['question_bank']->typeNumber == 3) {
                    $this->data['answers'] = pluck($this->question_answer_m->get_order_by_question_answer(['questionID' => $questionID]), 'text');
                }


                if($_POST) {
                    $postOption = $this->input->post("option");
                    $rules = $this->rules($postOption = 0);
                    $this->form_validation->set_rules($rules);
                    if ($this->form_validation->run() == FALSE) {
                        $this->data['typeID'] = $this->input->post("type");
                        $this->data['totalOptionID'] = $this->input->post("totalOption");
                        $this->data['postData'] = 1;
                        $this->data['options'] = $this->input->post("option");
                        $this->data['answers'] = $this->input->post("answer");

                        $this->data["subview"] = "question/bank/edit";
                        $this->load->view('_layout_main', $this->data);
                    } else {
//                        dd($this->input->post('answer'));
                        $imageUpload = array();
                        $question_bank = array(
                            "groupID" => $this->input->post("group"),
                            "levelID" => $this->input->post("level"),
                            "question" => $this->input->post("question"),
                            "explanation" => $this->input->post("explanation"),
                            "hints" => $this->input->post("hints"),
                            "mark" => empty($this->input->post('mark')) ? NULL : $this->input->post('mark'),
                            "typeNumber" => $this->input->post("type"),
                            "totalOption" => $this->input->post("totalOption"),
                            "modify_date" => date("Y-m-d H:i:s")
                        );

                        $question_bank['upload'] = $this->upload_data['file']['file_name'];

                        $options = $this->input->post("option");
                        $answers = $this->input->post("answer");

                        if($this->input->post("type") == 1 || $this->input->post("type") == 2) {

                            $imgArray = array();
                            if($this->input->post("totalOption") > 0) {
                                for($imgi=1; $imgi<=$this->input->post("totalOption"); $imgi++) {
                                    if($_FILES['image'.$imgi]['name'] !="") {
                                        $imgArray[] = 'image'.$imgi;
                                    }
                                }
                            }

                            if(count($imgArray)) {
                                $imageUpload = $this->imageUpload($imgArray);
                            }

                            $getQuestionOptions = pluck($this->question_option_m->get_order_by_question_option(['questionID' => $questionID]), 'optionID');
                            $getQuestionAnswers = pluck($this->question_answer_m->get_order_by_question_answer(['questionID' => $questionID]), 'optionID', 'answerID');

                            $totalOption = $this->input->post("totalOption");
                            $corrcetAnswer = [];
                            foreach ($options as $key => $option) {
                                if($option == '') {
                                    $totalOption--;
                                    continue;
                                }

                                $data = [
                                    'name' => $option,
                                ];

                                if(isset($imageUpload['success'][$key])) {
                                    $data['img'] = isset($imageUpload['success'][$key]) ? $imageUpload['success'][$key] : '';
                                }

                                $this->question_option_m->update_question_option($data, $getQuestionOptions[$key]);
                                if(in_array($key+1, $answers)) {
                                    $corrcetAnswer [] = $getQuestionOptions[$key];
                                }
                            }

                            if($totalOption != $this->input->post("totalOption")) {
                                $question_bank['totalOption'] = $totalOption;
                            }
                            $this->question_bank_m->update_question_bank($question_bank, $questionID);

                            $i = 0;
                            foreach ($getQuestionAnswers as $answerID => $optionID) {
                                if(isset($corrcetAnswer[$i])) {
                                    $this->question_answer_m->update_question_answer(['optionID' => $corrcetAnswer[$i]], $answerID);
                                } else {
                                    $this->question_answer_m->delete_question_answer($answerID);
                                }
                                $i++;
                            }
                            $countOfCorrectAnswer = count($corrcetAnswer);
                            for($j = $i; $j < $countOfCorrectAnswer; $j++) {
                                $ansData = [
                                    'questionID' => $questionID,
                                    'optionID' => $getQuestionOptions[$j],
                                    'typeNumber' => $this->input->post("type")
                                ];
                                $this->question_answer_m->insert_question_answer($ansData);
                            }
                        } elseif ($this->input->post("type") == 3) {
                            $getQuestionAnswers = pluck($this->question_answer_m->get_order_by_question_answer(['questionID' => $questionID]), 'text', 'answerID');

                            $i = 0;
                            $totalOption = 0;
                            foreach ($getQuestionAnswers as $answerID => $text) {
                                if(isset($answers[$i])) {
                                    $totalOption++;
                                    $this->question_answer_m->update_question_answer(['text' => $answers[$i]], $answerID);
                                } else {
                                    $this->question_answer_m->delete_question_answer($answerID);
                                }
                                $i++;
                            }

                            for($j = $i; $j< count($answers); $j++) {
                                $ansData = [
                                    'questionID' => $questionID,
                                    'text' => $answers[$j],
                                    'typeNumber' => $this->input->post("type")
                                ];
                                $this->question_answer_m->insert_question_answer($ansData);
                                $totalOption++;
                            }

                            if($totalOption != $this->input->post("totalOption")) {
                                $question_bank['totalOption'] = $totalOption;
                            }
                            $this->question_bank_m->update_question_bank($question_bank, $questionID);
                        }

                        // $this->session->set_flashdata('success', $this->lang->line('menu_success'));
                        // redirect(base_url("question_bank/index"));

                        if(count($imageUpload['error'])) {
                            $errorData = '';
                            foreach ($imageUpload['error'] as $imgErrorKey => $imgErrorValue) {
                                $optionErrors = implode(',', $imgErrorValue);
                                $errorData .= $imgErrorKey .' : '. $optionErrors.'<br/>';
                            }
                            $this->session->set_flashdata('error', $errorData);
                                redirect(base_url("question_bank/edit/$questionID"));
                        } else {
                            $this->session->set_flashdata('success', $this->lang->line('menu_success'));
                            redirect(base_url("question_bank/index"));
                        }
                    }
                } else {
                    $this->data["subview"] = "question/bank/edit";
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
        $this->data['headerassets'] = array(
            'css' => array(
                'assets/checkbox/checkbox.css',
            )
        );
        $questionID = htmlentities(escapeString($this->uri->segment(3)));
        if((int)$questionID) {
            $questionBank = $this->question_bank_m->get_single_question_bank(array('questionBankID' => $questionID));
            $this->data['question'] =  $questionBank;
            if($questionBank) {
                $this->data['groups'] = pluck($this->question_group_m->get_order_by_question_group(), 'obj', 'questionGroupID');
                $this->data['levels'] = pluck($this->question_level_m->get_order_by_question_level(), 'obj', 'questionLevelID');
                $this->data['types'] = pluck($this->question_type_m->get_order_by_question_type(), 'obj', 'typeNumber');
                $allOptions = $this->question_option_m->get_order_by_question_option();
                $options = [];
                foreach ($allOptions as $option) {
                    if($option->name == "" && $option->img == "") continue;
                    $options[$option->questionID][] = $option;
                }
                $this->data['options'] = $options;
                $allAnswers = $this->question_answer_m->get_order_by_question_answer();
                $answers = [];
                foreach ($allAnswers as $answer) {
                    $answers[$answer->questionID][] = $answer;
                }
                $this->data['answers'] = $answers;
                $this->data["subview"] = "question/bank/view";
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
            $this->data['question_bank'] = $this->question_bank_m->get_single_question_bank(array('questionBankID' => $id));
            if($this->data['question_bank']) {
                $this->question_bank_m->delete_question_bank($id);
                $this->session->set_flashdata('success', $this->lang->line('menu_success'));
                redirect(base_url("question_bank/index"));
            } else {
                redirect(base_url("question_bank/index"));
            }
        } else {
            redirect(base_url("question_bank/index"));
        }
    }

    public function print_preview() {
        $id = htmlentities(escapeString($this->uri->segment(3)));
        if((int)$id) {
            $this->data['question_bank'] = $this->question_bank_m->get_single_question_bank(array('questionBankID' => $id));
            if($this->data['question_bank']) {
                $this->data['panel_title'] = $this->lang->line('panel_title');
                $this->printView($this->data, 'question/bank/print_preview');
            } else {
                $this->data["subview"] = "error";
                $this->load->view('_layout_main', $this->data);
            }
        } else {
            $this->data["subview"] = "error";
            $this->load->view('_layout_main', $this->data);
        }
    }

    public function send_mail() {
        $id = $this->input->post('id');
        if ((int)$id) {
            $this->data['question_bank'] = $this->question_bank_m->get_single_question_bank(array('questionBankID' => $id));
            if($this->data['question_bank']) {
                $email = $this->input->post('to');
                $subject = $this->input->post('subject');
                $message = $this->input->post('message');

                $this->viewsendtomail($this->data['question_bank'], 'question/bank/print_preview', $email, $subject, $message);
            } else {
                $this->data["subview"] = "error";
                $this->load->view('_layout_main', $this->data);
            }
        } else {
            $this->data["subview"] = "error";
            $this->load->view('_layout_main', $this->data);
        }

    }

    public function unique_group() {
        if($this->input->post('group') == 0) {
            $this->form_validation->set_message("unique_group", "The %s field is required");
            return FALSE;
        }
        return TRUE;    
    }

    public function unique_level() {
        if($this->input->post('level') == 0) {
            $this->form_validation->set_message("unique_level", "The %s field is required");
            return FALSE;
        }
        return TRUE;
    }

    public function unique_type() {
        if($this->input->post('type') == 0) {
            $this->form_validation->set_message("unique_type", "The %s field is required");
            return FALSE;
        }
        return TRUE;
    }

    public function unique_answer() {
        if($this->input->post('type') == 3) {
            $f = 0;

            if(count($this->input->post("answer"))) {
                foreach ($this->input->post("answer") as $value) {
                    if($value != '') {
                        $f = 1;
                    }
                }
            }

            if($f != 1) {
                $this->form_validation->set_message("unique_answer", "Please Select Atleast one Answer");
                return FALSE;
            }
            return TRUE;
        } else {
            if(count($this->input->post('answer')) <= 0) {
                $this->form_validation->set_message("unique_answer", "Please Select Atleast one Answer");
                return FALSE;
            }
            return TRUE;
        }
    }


}
