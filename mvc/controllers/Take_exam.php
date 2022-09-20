<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

Class Take_exam extends Admin_Controller {
    
    function __construct() {
        parent::__construct();
        $this->load->model('online_exam_m');
        $this->load->model('online_exam_question_m');
        $this->load->model('instruction_m');
        $this->load->model('question_bank_m');
        $this->load->model('question_option_m');
        $this->load->model('question_answer_m');
        $this->load->model('online_exam_user_answer_m');
        $this->load->model('online_exam_user_status_m');
        $this->load->model('online_exam_user_answer_option_m');
        $language = $this->session->userdata('lang');
        $this->lang->load('take_exam', $language);
    }

    public function index() {
        $this->data['headerassets'] = array(
            'css' => array(
                'assets/select2/css/select2.css',
                'assets/select2/css/select2-bootstrap.css'
            ),
            'js' => array(
                'assets/select2/select2.js'
            )
        );
        $usertypeID = $this->session->userdata("usertypeID");
        $this->data['onlineExams'] = $this->online_exam_m->get_order_by_online_exam(['userTypeID' => $usertypeID]);
        $this->data["subview"] = "online_exam/take_exam/index";
        $this->load->view('_layout_main', $this->data);
    }

    public function show()
    {
        $this->data['headerassets'] = array(
            'css' => array(
                'assets/checkbox/checkbox.css',
                'assets/inilabs/form/fuelux.min.css'
            )
        );
        $this->data['footerassets'] = array(
            'js' => array(
                'assets/inilabs/form/fuelux.min.js'
            )
        );
        $userID = $this->session->userdata("loginuserID");
        $onlineExamID = htmlentities(escapeString($this->uri->segment(3)));
        if((int) $onlineExamID) {
            $this->data['onlineExam'] = $this->online_exam_m->get_single_online_exam(['onlineExamID' => $onlineExamID]);
            $onlineExamQuestions = $this->online_exam_question_m->get_order_by_online_exam_question([
                'onlineExamID' => $onlineExamID
            ]);
            if($this->data['onlineExam']->random != 0) {
                $onlineExamQuestions = $this->randAssociativeArray($onlineExamQuestions, $this->data['onlineExam']->random);
            }
            $this->data['onlineExamQuestions'] = $onlineExamQuestions;
            $onlineExamQuestions = pluck($onlineExamQuestions, 'obj', 'questionID');
            $questionsBank = pluck($this->question_bank_m->get_order_by_question_bank(), 'obj', 'questionBankID');
            $this->data['questions'] = $questionsBank;
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
            if($_POST) {
//                dd($this->input->post());
//                dd($onlineExamQuestions);
                $time = date("Y-m-d h:i:s");
                $mainQuestionAnswer = [];
                $userAnswer = $this->input->post('answer');
//            dump($allAnswers);
                foreach ($allAnswers as $answer) {
                    if($answer->typeNumber == 3) {
                        $mainQuestionAnswer[$answer->typeNumber][$answer->questionID][$answer->answerID] = $answer->text;
                    } else {
                        $mainQuestionAnswer[$answer->typeNumber][$answer->questionID][] = $answer->optionID;
                    }
                }

                $questionStatus = [];
                $correctAnswer = 0;
                $totalQuestionMark = 0;
                $totalCorrectMark = 0;
                $visited = [];

                foreach ($mainQuestionAnswer as $typeID => $questions) {
                    if(!isset($userAnswer[$typeID])) continue;
                    foreach ($questions as $questionID => $options) {
                        if(isset($onlineExamQuestions[$questionID])) {
                            $onlineExamQuestionID = $onlineExamQuestions[$questionID]->onlineExamQuestionID;
                            $onlineExamUserAnswerID = $this->online_exam_user_answer_m->insert([
                                'onlineExamQuestionID' => $onlineExamQuestionID,
                                'userID' => $userID
                            ]);
                        }
                        if(isset($userAnswer[$typeID][$questionID])) {
                            $totalCorrectMark += isset($questionsBank[$questionID]) ? $questionsBank[$questionID]->mark : 0;
                            $totalQuestionMark += isset($questionsBank[$questionID]) ? $questionsBank[$questionID]->mark : 0;

                            $questionStatus[$questionID] = 1;
                            $correctAnswer++;
                            $f = 1;
                            if($typeID == 3) {
                                foreach ($options as $answerID => $answer) {
                                    $takeAnswer = strtolower($answer);
                                    $getAnswer = isset($userAnswer[$typeID][$questionID][$answerID]) ? strtolower($userAnswer[$typeID][$questionID][$answerID]) : '';
                                    $this->online_exam_user_answer_option_m->insert([
                                        'questionID' => $questionID,
                                        'typeID' => $typeID,
                                        'text' => $getAnswer,
                                        'time' => $time
                                    ]);
                                    if($getAnswer != $takeAnswer) {
                                        $f = 0;
                                    }
                                }
                            } elseif($typeID == 1 || $typeID == 2) {
                                if(count($options) != count($userAnswer[$typeID][$questionID])) {
                                    $f = 0;
                                } else {
                                    if(!isset($visited[$typeID][$questionID])) {
                                        foreach ($userAnswer[$typeID][$questionID] as $userOption) {
                                            $this->online_exam_user_answer_option_m->insert([
                                                'questionID' => $questionID,
                                                'optionID' => $userOption,
                                                'typeID' => $typeID,
                                                'time' => $time
                                            ]);
                                        }
                                        $visited[$typeID][$questionID] = 1;
                                    }
                                    foreach ($options as $answerID => $answer) {
                                        if(!in_array($answer, $userAnswer[$typeID][$questionID])) {
                                            $f = 0;
                                            break;
                                        }
                                    }
                                }
                            }

                            if(!$f) {
                                $questionStatus[$questionID] = 0;
                                $correctAnswer--;
                                $totalCorrectMark -= $questionsBank[$questionID]->mark;
                            }
                        }
                    }
                }

                $this->online_exam_user_status_m->insert([
                    'onlineExamID' => $this->data['onlineExam']->onlineExamID,
                    'time' => $time,
                    'totalQuestion' => count($onlineExamQuestions),
                    'nagetiveMark' => $this->data['onlineExam']->negativeMark,
                    'duration' => $this->data['onlineExam']->duration,
                    'score' => $correctAnswer
                ]);

                $this->data['fail'] = $f;
                $this->data['questionStatus'] = $questionStatus;
                $this->data['correctAnswer'] = $correctAnswer;
                $this->data['totalCorrectMark'] = $totalCorrectMark;
                $this->data['totalQuestionMark'] = $totalQuestionMark;
                $this->data["subview"] = "online_exam/take_exam/result";
                return $this->load->view('_layout_main', $this->data);
            }

            $this->data["subview"] = "online_exam/take_exam/question";
            return $this->load->view('_layout_main', $this->data);
        } else {
            $this->data["subview"] = "error";
            $this->load->view('_layout_main', $this->data);
        }

    }

    public function instruction()
    {
        $onlineExamID = htmlentities(escapeString($this->uri->segment(3)));
        if((int) $onlineExamID) {
            $instructions = pluck($this->instruction_m->get_order_by_instruction(), 'obj', 'instructionID');
            $onlineExam = $this->online_exam_m->get_single_online_exam(['onlineExamID' => $onlineExamID]);
            $this->data['onlineExam'] = $onlineExam;
            if(!isset($instructions[$onlineExam->instructionID])) {
                redirect(base_url('take_exam/show/'.$onlineExamID));
            }
            $this->data['instruction'] = $instructions[$onlineExam->instructionID];
            $this->data["subview"] = "online_exam/take_exam/instruction";
            return $this->load->view('_layout_main', $this->data);
        } else {
            $this->data["subview"] = "error";
            $this->load->view('_layout_main', $this->data);
        }
    }

    public function randAssociativeArray($array, $number = 0)
    {
        $returnArray = [];
        $countArray = count($array);
        if($number > $countArray || $number == 0) {
            $number = $countArray;
        }
        if($countArray == 1) {
            $randomKey[] = 0;
        } else {
            $randomKey = array_rand($array, $number);
        }
//        dd($randomKey);
        if(is_array($randomKey)) {
            shuffle($randomKey);
        }

        foreach ($randomKey as $key) {
            $returnArray[] = $array[$key];
        }
        return $returnArray;
    }
}
