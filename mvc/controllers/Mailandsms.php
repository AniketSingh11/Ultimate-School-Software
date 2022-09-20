<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mailandsms extends Admin_Controller {

	function __construct () {
		parent::__construct();
		$this->load->model('usertype_m');
		$this->load->model("smssettings_m");
		$this->load->model('systemadmin_m');
		$this->load->model('teacher_m');
		$this->load->model('student_m');
		$this->load->model('parents_m');
		$this->load->model('user_m');
		$this->load->model('classes_m');
		$this->load->model('section_m');
		$this->load->model("mark_m");
		$this->load->model("grade_m");
		$this->load->model("exam_m");
		$this->load->model('mailandsms_m');
		$this->load->model('mailandsmstemplate_m');
		$this->load->model('mailandsmstemplatetag_m');
		$this->load->model('studentgroup_m');
		$this->load->model('subject_m');
		$this->load->library("email");
		$this->load->library("clickatell");
		$this->load->library("twilio");
		$this->load->library("bulk");
		$this->load->library("msg91");
		$language = $this->session->userdata('lang');
		$this->lang->load('mailandsms', $language);

	}

	protected function rules_mail() {
		$rules = array(
			array(
				'field' => 'email_usertypeID',
				'label' => $this->lang->line("mailandsms_usertype"),
				'rules' => 'trim|required|xss_clean|max_length[15]|callback_check_email_usertypeID'
			),
			array(
				'field' => 'email_schoolyear',
				'label' => $this->lang->line("mailandsms_schoolyear"),
				'rules' => 'trim|xss_clean'
			),
			array(
				'field' => 'email_class',
				'label' => $this->lang->line("mailandsms_class"),
				'rules' => 'trim|xss_clean'
			),
			array(
				'field' => 'email_users',
				'label' => $this->lang->line("mailandsms_users"),
				'rules' => 'trim|xss_clean'
			),
			array(
				'field' => 'email_template',
				'label' => $this->lang->line("mailandsms_template"),
				'rules' => 'trim|xss_clean'
			),
			array(
				'field' => 'email_subject',
				'label' => $this->lang->line("mailandsms_subject"),
				'rules' => 'trim|required|xss_clean|max_length[255]'
			),
			array(
				'field' => 'email_message',
				'label' => $this->lang->line("mailandsms_message"),
				'rules' => 'trim|required|xss_clean|max_length[20000]'
			),
		);
		return $rules;
	}

	protected function rules_sms() {
		$rules = array(
			array(
				'field' => 'sms_usertypeID',
				'label' => $this->lang->line("mailandsms_usertype"),
				'rules' => 'trim|required|xss_clean|max_length[15]|callback_check_sms_usertypeID'
			),
			array(
				'field' => 'sms_schoolyear',
				'label' => $this->lang->line("mailandsms_schoolyear"),
				'rules' => 'trim|xss_clean'
			),
			array(
				'field' => 'sms_class',
				'label' => $this->lang->line("mailandsms_select_class"),
				'rules' => 'trim|xss_clean'
			),
			array(
				'field' => 'sms_users',
				'label' => $this->lang->line("mailandsms_users"),
				'rules' => 'trim|xss_clean'
			),
			array(
				'field' => 'sms_template',
				'label' => $this->lang->line("mailandsms_template"),
				'rules' => 'trim|xss_clean'
			),
			array(
				'field' => 'sms_getway',
				'label' => $this->lang->line("mailandsms_getway"),
				'rules' => 'trim|required|xss_clean|max_length[15]|callback_check_getway'
			),
			array(
				'field' => 'sms_message',
				'label' => $this->lang->line("mailandsms_message"),
				'rules' => 'trim|required|xss_clean|max_length[20000]'
			),
		);
		return $rules;
	}

	public function index() {
		$this->data['mailandsmss'] = $this->mailandsms_m->get_mailandsms_with_usertypeID();
		$this->data["subview"] = "mailandsms/index";
		$this->load->view('_layout_main', $this->data);
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
		$this->data['schoolyears'] = $this->schoolyear_m->get_schoolyear();
		$this->data['allClasses'] = $this->classes_m->get_classes();

		/* Start For Email */
		$email_usertypeID = $this->input->post("email_usertypeID");
		if($email_usertypeID && $email_usertypeID != 'select') {
			$this->data['email_usertypeID'] = $email_usertypeID;
		} else {
			$this->data['email_usertypeID'] = 'select';
		}
		/* End For Email */

		/* Start For SMS */
		$sms_usertypeID = $this->input->post("sms_usertypeID");
		if($sms_usertypeID && $sms_usertypeID != 'select') {
			$this->data['sms_usertypeID'] = $sms_usertypeID;
		} else {
			$this->data['sms_usertypeID'] = 'select';
		}
		/* End For SMS */

		if($_POST) {
			if($this->input->post('type') == "email") {
				$rules = $this->rules_mail();
				$this->form_validation->set_rules($rules);
				if ($this->form_validation->run() == FALSE) {
					$this->data['emailUserID'] = $this->input->post('email_users');
					$this->data['emailTemplateID'] = $this->input->post('email_template');

					$this->data['allStudents'] = $this->student_m->get_order_by_student(array('schoolyearID' => $this->input->post('email_schoolyear'), 'classesID' => $this->input->post('email_class')));


					$this->data['smsUserID'] = 0;
					$this->data['smsTemplateID'] = 0;

					$this->data["email"] = 1;
					$this->data["sms"] = 0;
					$this->data["subview"] = "mailandsms/add";
					$this->load->view('_layout_main', $this->data);
				} else {
					$usertypeID = $this->input->post('email_usertypeID');
					$schoolyearID = $this->input->post('email_schoolyear');

					if($usertypeID == 1) { /* FOR ADMIN */
						$systemadminID = $this->input->post('email_users');
						if($systemadminID == 'select') {
							$message = $this->input->post('email_message');
							$multisystemadmins = $this->systemadmin_m->get_systemadmin();
							if(count($multisystemadmins)) {
								$countusers = '';
								foreach ($multisystemadmins as $key => $multisystemadmin) {
									$this->userConfigEmail($message, $multisystemadmin, $usertypeID, $schoolyearID);
									$countusers .= $multisystemadmin->name .' ,';
								}
								$array = array(
									'usertypeID' => $usertypeID,
									'users' => $countusers,
									'type' => ucfirst($this->input->post('type')),
									'message' => $this->input->post('email_message'),
									'year' => date('Y'),
									'senderusertypeID' => $this->session->userdata('usertypeID'),
									'senderID' => $this->session->userdata('loginuserID')
								);
								$this->mailandsms_m->insert_mailandsms($array);
								redirect(base_url('mailandsms/index'));
							} else {
								$this->session->set_flashdata('error', $this->lang->line('mailandsms_notfound_error'));
								redirect(base_url('mailandsms/add'));
							}
						} else {
							$message = $this->input->post('email_message');
							$singlesystemadmin = $this->systemadmin_m->get_systemadmin($systemadminID);
							if(count($singlesystemadmin)) {
								$this->userConfigEmail($message, $singlesystemadmin, $usertypeID);
								$array = array(
									'usertypeID' => $usertypeID,
									'users' => $singlesystemadmin->name,
									'type' => ucfirst($this->input->post('type')),
									'message' => $this->input->post('email_message'),
									'year' => date('Y'),
									'senderusertypeID' => $this->session->userdata('usertypeID'),
									'senderID' => $this->session->userdata('loginuserID')
								);
								$this->mailandsms_m->insert_mailandsms($array);
								redirect(base_url('mailandsms/index'));
							} else {
								$this->session->set_flashdata('error', $this->lang->line('mailandsms_notfound_error'));
								redirect(base_url('mailandsms/add'));
							}
						}
					} elseif($usertypeID == 2) { /* FOR TEACHER */
						$teacherID = $this->input->post('email_users');
						if($teacherID == 'select') {
							$message = $this->input->post('email_message');
							$multiteachers = $this->teacher_m->get_teacher();
							if(count($multiteachers)) {
								$countusers = '';
								foreach ($multiteachers as $key => $multiteacher) {
									$this->userConfigEmail($message, $multiteacher, $usertypeID);
									$countusers .= $multiteacher->name .' ,';
								}
								$array = array(
									'usertypeID' => $usertypeID,
									'users' => $countusers,
									'type' => ucfirst($this->input->post('type')),
									'message' => $this->input->post('email_message'),
									'year' => date('Y'),
									'senderusertypeID' => $this->session->userdata('usertypeID'),
									'senderID' => $this->session->userdata('loginuserID')
								);
								$this->mailandsms_m->insert_mailandsms($array);
								redirect(base_url('mailandsms/index'));
							} else {
								$this->session->set_flashdata('error', $this->lang->line('mailandsms_notfound_error'));
								redirect(base_url('mailandsms/add'));
							}
						} else {
							$message = $this->input->post('email_message');
							$singleteacher = $this->teacher_m->get_teacher($teacherID);
							if(count($singleteacher)) {
								$this->userConfigEmail($message, $singleteacher, $usertypeID);
								$array = array(
									'usertypeID' => $usertypeID,
									'users' => $singleteacher->name,
									'type' => ucfirst($this->input->post('type')),
									'message' => $this->input->post('email_message'),
									'year' => date('Y'),
									'senderusertypeID' => $this->session->userdata('usertypeID'),
									'senderID' => $this->session->userdata('loginuserID')
								);
								$this->mailandsms_m->insert_mailandsms($array);
								redirect(base_url('mailandsms/index'));

							} else {
								$this->session->set_flashdata('error', $this->lang->line('mailandsms_notfound_error'));
								redirect(base_url('mailandsms/add'));
							}
						}
					} elseif($usertypeID == 3) { /* FOR STUDENT */

						$studentID = $this->input->post('email_users');
						if($studentID == 'select') {
							$class = $this->input->post('email_class');
							if($class == 'select') {
								/* Multi School Year */
								$schoolyear = $this->input->post('email_schoolyear');
								if($schoolyear == 'select') {
									$message = $this->input->post('email_message');
									$multiSchoolYearStudents = $this->student_m->get_student();
									if(count($multiSchoolYearStudents)) {
										$countusers = '';
										foreach ($multiSchoolYearStudents as $key => $multiSchoolYearStudent) {
											$this->userConfigEmail($message, $multiSchoolYearStudent, $usertypeID, $multiSchoolYearStudent->schoolyearID);
											$countusers .= $multiSchoolYearStudent->name .' ,';
										}
										$array = array(
											'usertypeID' => $usertypeID,
											'users' => $countusers,
											'type' => ucfirst($this->input->post('type')),
											'message' => $this->input->post('email_message'),
											'year' => date('Y'),
											'senderusertypeID' => $this->session->userdata('usertypeID'),
											'senderID' => $this->session->userdata('loginuserID')
										);
										$this->mailandsms_m->insert_mailandsms($array);
										redirect(base_url('mailandsms/index'));
									} else {
										$this->session->set_flashdata('error', $this->lang->line('mailandsms_notfound_error'));
										redirect(base_url('mailandsms/add'));
									}
								} else {
									/* Single school Year Student */
									$message = $this->input->post('email_message');
									$singleSchoolYear = $this->input->post('email_schoolyear');
									$singleSchoolYearStudents = $this->student_m->get_order_by_student(array('schoolyearID' => $singleSchoolYear));
									if(count($singleSchoolYearStudents)) {
										$countusers = '';
										foreach ($singleSchoolYearStudents as $key => $singleSchoolYearStudent) {
											$this->userConfigEmail($message, $singleSchoolYearStudent, $usertypeID, $schoolyearID);
											$countusers .= $singleSchoolYearStudent->name .' ,';
										}
										$array = array(
											'usertypeID' => $usertypeID,
											'users' => $countusers,
											'type' => ucfirst($this->input->post('type')),
											'message' => $this->input->post('email_message'),
											'year' => date('Y'),
											'senderusertypeID' => $this->session->userdata('usertypeID'),
											'senderID' => $this->session->userdata('loginuserID')
										);
										$this->mailandsms_m->insert_mailandsms($array);
										redirect(base_url('mailandsms/index'));
									} else {
										$this->session->set_flashdata('error', $this->lang->line('mailandsms_notfound_error'));
										redirect(base_url('mailandsms/add'));
									}
								}
							} else {
								/* Single Class Student */
								$message = $this->input->post('email_message');
								$singleClass = $this->input->post('email_class');
								$singleClassStudents = $this->student_m->get_order_by_student(array('classesID' => $singleClass, 'schoolyearID' => $schoolyearID));

								if(count($singleClassStudents)) {
									$countusers = '';
									foreach ($singleClassStudents as $key => $singleClassStudent) {
										$this->userConfigEmail($message, $singleClassStudent, $usertypeID, $schoolyearID);
										$countusers .= $singleClassStudent->name .' ,';
									}
									$array = array(
										'usertypeID' => $usertypeID,
										'users' => $countusers,
										'type' => ucfirst($this->input->post('type')),
										'message' => $this->input->post('email_message'),
										'year' => date('Y'),
										'senderusertypeID' => $this->session->userdata('usertypeID'),
										'senderID' => $this->session->userdata('loginuserID')
									);
									$this->mailandsms_m->insert_mailandsms($array);
									redirect(base_url('mailandsms/index'));
								} else {
									$this->session->set_flashdata('error', $this->lang->line('mailandsms_notfound_error'));
									redirect(base_url('mailandsms/add'));
								}
							}
						} else {
							/* Single Student */
							$message = $this->input->post('email_message');
							$singlestudent = $this->student_m->get_student($studentID);
							if(count($singlestudent)) {
								$this->userConfigEmail($message, $singlestudent, $usertypeID, $schoolyearID);
								$array = array(
									'usertypeID' => $usertypeID,
									'users' => $singlestudent->name,
									'type' => ucfirst($this->input->post('type')),
									'message' => $this->input->post('email_message'),
									'year' => date('Y'),
									'senderusertypeID' => $this->session->userdata('usertypeID'),
									'senderID' => $this->session->userdata('loginuserID')
								);

								$this->mailandsms_m->insert_mailandsms($array);
								redirect(base_url('mailandsms/index'));
							} else {
								$this->session->set_flashdata('error', $this->lang->line('mailandsms_notfound_error'));
								redirect(base_url('mailandsms/add'));
							}
						}
					} elseif($usertypeID == 4) { /* FOR PARENTS */
						$parentsID = $this->input->post('email_users');
						if($parentsID == 'select') {
							$message = $this->input->post('email_message');
							$multiparents = $this->parents_m->get_parents();
							if(count($multiparents)) {
								$countusers = '';
								foreach ($multiparents as $key => $multiparent) {
									$this->userConfigEmail($message, $multiparent, $usertypeID);
									$countusers .= $multiparent->name .' ,';
								}
								$array = array(
									'usertypeID' => $usertypeID,
									'users' => $countusers,
									'type' => ucfirst($this->input->post('type')),
									'message' => $this->input->post('email_message'),
									'year' => date('Y'),
									'senderusertypeID' => $this->session->userdata('usertypeID'),
									'senderID' => $this->session->userdata('loginuserID')
								);
								$this->mailandsms_m->insert_mailandsms($array);
								redirect(base_url('mailandsms/index'));
							} else {
								$this->session->set_flashdata('error', $this->lang->line('mailandsms_notfound_error'));
								redirect(base_url('mailandsms/add'));
							}
						} else {
							$message = $this->input->post('email_message');
							$singleparent = $this->parents_m->get_parents($parentsID);
							if(count($singleparent)) {
								$this->userConfigEmail($message, $singleparent, $usertypeID);
								$array = array(
									'usertypeID' => $usertypeID,
									'users' => $singleparent->name,
									'type' => ucfirst($this->input->post('type')),
									'message' => $this->input->post('email_message'),
									'year' => date('Y'),
									'senderusertypeID' => $this->session->userdata('usertypeID'),
									'senderID' => $this->session->userdata('loginuserID')
								);
								$this->mailandsms_m->insert_mailandsms($array);
								redirect(base_url('mailandsms/index'));
							} else {
								$this->session->set_flashdata('error', $this->lang->line('mailandsms_notfound_error'));
								redirect(base_url('mailandsms/add'));
							}
						}
					} else { /* FOR ALL USERS */
						$userID = $this->input->post('email_users');
						if($userID == 'select') {
							$message = $this->input->post('email_message');
							$multiusers = $this->user_m->get_order_by_user(array('usertypeID' => $usertypeID));
							if(count($multiusers)) {
								$countusers = '';
								foreach ($multiusers as $key => $multiuser) {
									$this->userConfigEmail($message, $multiuser, $usertypeID);
									$countusers .= $multiuser->name .' ,';
								}
								$array = array(
									'usertypeID' => $usertypeID,
									'users' => $countusers,
									'type' => ucfirst($this->input->post('type')),
									'message' => $this->input->post('email_message'),
									'year' => date('Y'),
									'senderusertypeID' => $this->session->userdata('usertypeID'),
									'senderID' => $this->session->userdata('loginuserID')
								);
								$this->mailandsms_m->insert_mailandsms($array);
								redirect(base_url('mailandsms/index'));
							} else {
								$this->session->set_flashdata('error', $this->lang->line('mailandsms_notfound_error'));
								redirect(base_url('mailandsms/add'));
							}
						} else {
							$message = $this->input->post('email_message');
							$singleuser = $this->user_m->get_user($userID);
							if(count($singleuser)) {
								$this->userConfigEmail($message, $singleuser, $usertypeID);
								$array = array(
									'usertypeID' => $usertypeID,
									'users' => $singleuser->name,
									'type' => ucfirst($this->input->post('type')),
									'message' => $this->input->post('email_message'),
									'year' => date('Y'),
									'senderusertypeID' => $this->session->userdata('usertypeID'),
									'senderID' => $this->session->userdata('loginuserID')
								);
								$this->mailandsms_m->insert_mailandsms($array);
								redirect(base_url('mailandsms/index'));
							} else {
								$this->session->set_flashdata('error', $this->lang->line('mailandsms_notfound_error'));
								redirect(base_url('mailandsms/add'));
							}
						}
					}
				}
			} elseif($this->input->post('type') == "sms") {
				$rules = $this->rules_sms();
				$this->form_validation->set_rules($rules);
				if ($this->form_validation->run() == FALSE) {
					$this->data['smsUserID'] = $this->input->post('sms_users');
					$this->data['smsTemplateID'] = $this->input->post('sms_template');

					$this->data['allStudents'] = $this->student_m->get_order_by_student(array('schoolyearID' => $this->input->post('sms_schoolyear'), 'classesID' => $this->input->post('sms_class')));

					$this->data['emailUserID'] = 0;
					$this->data['emailTemplateID'] = 0;

					$this->data["email"] = 0;
					$this->data["sms"] = 1;
					$this->data["subview"] = "mailandsms/add";
					$this->load->view('_layout_main', $this->data);
				} else {
					$getway = $this->input->post('sms_getway');
					$usertypeID = $this->input->post('sms_usertypeID');
					$schoolyearID = $this->input->post('sms_schoolyear');

					if($usertypeID == 1) { /* FOR ADMIN */
						$systemadminID = $this->input->post('sms_users');
						if($systemadminID == 'select') {
							$countusers = '';
							$retval = 1;
							$retmess = '';

							$message = $this->input->post('sms_message');
							$multisystemadmins = $this->systemadmin_m->get_systemadmin();
							if(count($multisystemadmins)) {

								foreach ($multisystemadmins as $key => $multisystemadmin) {
									$status = $this->userConfigSMS($message, $multisystemadmin, $usertypeID, $getway);
									$countusers .= $multisystemadmin->name .' ,';

									if($status['check'] == FALSE) {
										$retval = 0;
										$retmess = $status['message'];
										break;
									}

								}
								if($retval == 1) {
									$array = array(
										'usertypeID' => $usertypeID,
										'users' => $countusers,
										'type' => ucfirst($this->input->post('type')),
										'message' => $this->input->post('sms_message'),
										'year' => date('Y'),
										'senderusertypeID' => $this->session->userdata('usertypeID'),
										'senderID' => $this->session->userdata('loginuserID')
									);
									$this->mailandsms_m->insert_mailandsms($array);
									redirect(base_url('mailandsms/index'));
								} else {
									$this->session->set_flashdata('error', $retmess);
									redirect(base_url("mailandsms/add"));
								}
							} else {
								$this->session->set_flashdata('error', $this->lang->line('mailandsms_notfound_error'));
								redirect(base_url('mailandsms/add'));
							}
						} else {
							$retval = 1;
							$retmess = '';
							$message = $this->input->post('sms_message');
							$singlesystemadmin = $this->systemadmin_m->get_systemadmin($systemadminID);
							if(count($singlesystemadmin)) {
								$status = $this->userConfigSMS($message, $singlesystemadmin, $usertypeID, $getway);
								if($status['check'] == FALSE) {
									$retval = 0;
									$retmess = $status['message'];
								}

								if($retval == 1) {
									$array = array(
										'usertypeID' => $usertypeID,
										'users' => $singlesystemadmin->name,
										'type' => ucfirst($this->input->post('type')),
										'message' => $this->input->post('sms_message'),
										'year' => date('Y'),
										'senderusertypeID' => $this->session->userdata('usertypeID'),
										'senderID' => $this->session->userdata('loginuserID')
									);
									$this->mailandsms_m->insert_mailandsms($array);
									redirect(base_url('mailandsms/index'));
								} else {
									$this->session->set_flashdata('error', $retmess);
									redirect(base_url("mailandsms/add"));
								}
							} else {
								$this->session->set_flashdata('error', $this->lang->line('mailandsms_notfound_error'));
								redirect(base_url('mailandsms/add'));
							}
						}
					} elseif($usertypeID == 2) { /* FOR TEACHER */
						$teacherID = $this->input->post('sms_users');
						if($teacherID == 'select') {
							$message = $this->input->post('sms_message');
							$multiteachers = $this->teacher_m->get_teacher();
							if(count($multiteachers)) {
								$countusers = '';
								$retval = 1;
								$retmess = '';
								foreach ($multiteachers as $key => $multiteacher) {
									$status = $this->userConfigSMS($message, $multiteacher, $usertypeID, $getway);
									$countusers .= $multiteacher->name .' ,';

									if($status['check'] == FALSE) {
										$retval = 0;
										$retmess = $status['message'];
										break;
									}

								}
								if($retval == 1) {
									$array = array(
										'usertypeID' => $usertypeID,
										'users' => $countusers,
										'type' => ucfirst($this->input->post('type')),
										'message' => $this->input->post('sms_message'),
										'year' => date('Y'),
										'senderusertypeID' => $this->session->userdata('usertypeID'),
										'senderID' => $this->session->userdata('loginuserID')
									);
									$this->mailandsms_m->insert_mailandsms($array);
									redirect(base_url('mailandsms/index'));
								} else {
									$this->session->set_flashdata('error', $retmess);
									redirect(base_url("mailandsms/add"));
								}
							} else {
								$this->session->set_flashdata('error', $this->lang->line('mailandsms_notfound_error'));
								redirect(base_url('mailandsms/add'));
							}
						} else {
							$retval = 1;
							$retmess = '';
							$message = $this->input->post('sms_message');
							$singleteacher = $this->teacher_m->get_teacher($teacherID);
							if(count($singleteacher)) {
								$status = $this->userConfigSMS($message, $singleteacher, $usertypeID, $getway);
								if($status['check'] == FALSE) {
									$retval = 0;
									$retmess = $status['message'];
								}

								if($retval == 1) {
									$array = array(
										'usertypeID' => $usertypeID,
										'users' => $singleteacher->name,
										'type' => ucfirst($this->input->post('type')),
										'message' => $this->input->post('sms_message'),
										'year' => date('Y'),
										'senderusertypeID' => $this->session->userdata('usertypeID'),
										'senderID' => $this->session->userdata('loginuserID')
									);
									$this->mailandsms_m->insert_mailandsms($array);
									redirect(base_url('mailandsms/index'));
								} else {
									$this->session->set_flashdata('error', $retmess);
									redirect(base_url("mailandsms/add"));
								}
							} else {
								$this->session->set_flashdata('error', $this->lang->line('mailandsms_notfound_error'));
								redirect(base_url('mailandsms/add'));
							}
						}
					} elseif($usertypeID == 3) { /* FOR STUDENT */

						$studentID = $this->input->post('sms_users');
						if($studentID == 'select') {
							$class = $this->input->post('sms_class');
							if($class == 'select') {
								/* Multi School Year */
								$countusers = '';
								$retval = 1;
								$retmess = '';

								$schoolyear = $this->input->post('sms_schoolyear');
								if($schoolyear == 'select') {
									$message = $this->input->post('sms_message');
									$multiSchoolYearStudents = $this->student_m->get_student();
									if(count($multiSchoolYearStudents)) {
										foreach ($multiSchoolYearStudents as $key => $multiSchoolYearStudent) {
											$status = $this->userConfigSMS($message, $multiSchoolYearStudent, $usertypeID, $getway, $multiSchoolYearStudent->schoolyearID);
											$countusers .= $multiSchoolYearStudent->name .' ,';
											if($status['check'] == FALSE) {
												$retval = 0;
												$retmess = $status['message'];
												break;
											}
										}

										if($retval == 1) {
											$array = array(
												'usertypeID' => $usertypeID,
												'users' => $countusers,
												'type' => ucfirst($this->input->post('type')),
												'message' => $this->input->post('sms_message'),
												'year' => date('Y'),
												'senderusertypeID' => $this->session->userdata('usertypeID'),
												'senderID' => $this->session->userdata('loginuserID')
											);
											$this->mailandsms_m->insert_mailandsms($array);
											redirect(base_url('mailandsms/index'));
										} else {
											$this->session->set_flashdata('error', $retmess);
											redirect(base_url('mailandsms/add'));
										}
									} else {
										$this->session->set_flashdata('error', $this->lang->line('mailandsms_notfound_error'));
										redirect(base_url('mailandsms/add'));
									}
								} else {
									/* Single school Year Student */
									$countusers = '';
									$retval = 1;
									$retmess = '';
									$message = $this->input->post('sms_message');
									$singleSchoolYear = $this->input->post('sms_schoolyear');
									$singleSchoolYearStudents = $this->student_m->get_order_by_student(array('schoolyearID' => $singleSchoolYear));
									if(count($singleSchoolYearStudents)) {

										foreach ($singleSchoolYearStudents as $key => $singleSchoolYearStudent) {
											$status = $this->userConfigSMS($message, $singleSchoolYearStudent, $usertypeID, $getway, $schoolyearID);
											$countusers .= $singleSchoolYearStudent->name .' ,';
											if($status['check'] == FALSE) {
												$retval = 0;
												$retmess = $status['message'];
												break;
											}
										}
										if($retval == 1) {
											$array = array(
												'usertypeID' => $usertypeID,
												'users' => $countusers,
												'type' => ucfirst($this->input->post('type')),
												'message' => $this->input->post('sms_message'),
												'year' => date('Y'),
												'senderusertypeID' => $this->session->userdata('usertypeID'),
												'senderID' => $this->session->userdata('loginuserID')
											);
											$this->mailandsms_m->insert_mailandsms($array);
											redirect(base_url('mailandsms/index'));
										} else {
											$this->session->set_flashdata('error', $retmess);
											redirect(base_url("mailandsms/add"));
										}
									} else {
										$this->session->set_flashdata('error', $this->lang->line('mailandsms_notfound_error'));
										redirect(base_url('mailandsms/add'));
									}
								}
							} else {
								/* Single Class Student */
								$countusers = '';
								$retval = 1;
								$retmess = '';

								$message = $this->input->post('sms_message');
								$singleClass = $this->input->post('sms_class');
								$singleClassStudents = $this->student_m->get_order_by_student(array('classesID' => $singleClass, 'schoolyearID' => $schoolyearID));
								if(count($singleClassStudents)) {
									$countusers = '';
									foreach ($singleClassStudents as $key => $singleClassStudent) {
										$status = $this->userConfigSMS($message, $singleClassStudent, $usertypeID, $getway, $schoolyearID);
										$countusers .= $singleClassStudent->name .' ,';
										if($status['check'] == FALSE) {
											$retval = 0;
											$retmess = $status['message'];
											break;
										}
									}

									if($retval == 1) {
										$array = array(
											'usertypeID' => $usertypeID,
											'users' => $countusers,
											'type' => ucfirst($this->input->post('type')),
											'message' => $this->input->post('sms_message'),
											'year' => date('Y'),
											'senderusertypeID' => $this->session->userdata('usertypeID'),
											'senderID' => $this->session->userdata('loginuserID')
										);
										$this->mailandsms_m->insert_mailandsms($array);
										redirect(base_url('mailandsms/index'));
									} else {
										$this->session->set_flashdata('error', $retmess);
										redirect(base_url("mailandsms/add"));
									}
								} else {
									$this->session->set_flashdata('error', $this->lang->line('mailandsms_notfound_error'));
									redirect(base_url('mailandsms/add'));
								}
							}
						} else {
							/* Single Student */
							$retval = 1;
							$retmess = '';

							$message = $this->input->post('sms_message');
							$singlestudent = $this->student_m->get_student($studentID);
							if(count($singlestudent)) {
								$status = $this->userConfigSMS($message, $singlestudent, $usertypeID, $getway, $schoolyearID);
								if($status['check'] == FALSE) {
									$retval = 0;
									$retmess = $status['message'];
								}
								if($retval == 1) {
									$array = array(
										'usertypeID' => $usertypeID,
										'users' =>  $singlestudent->name,
										'type' => ucfirst($this->input->post('type')),
										'message' => $this->input->post('sms_message'),
										'year' => date('Y'),
										'senderusertypeID' => $this->session->userdata('usertypeID'),
										'senderID' => $this->session->userdata('loginuserID')
									);
									$this->mailandsms_m->insert_mailandsms($array);
									redirect(base_url('mailandsms/index'));
								} else {
									$this->session->set_flashdata('error', $retmess);
									redirect(base_url("mailandsms/add"));
								}
							} else {
								$this->session->set_flashdata('error', $this->lang->line('mailandsms_notfound_error'));
								redirect(base_url('mailandsms/add'));
							}

						}
					} elseif($usertypeID == 4) { /* FOR PARENTS */
						$parentsID = $this->input->post('sms_users');
						if($parentsID == 'select') {
							$countusers = '';
							$retval = 1;
							$retmess = '';

							$message = $this->input->post('sms_message');
							$multiparents = $this->parents_m->get_parents();
							if(count($multiparents)) {

								foreach ($multiparents as $key => $multiparent) {
									$status = $this->userConfigSMS($message, $multiparent, $usertypeID, $getway);
									$countusers .= $multiparent->name .' ,';

									if($status['check'] == FALSE) {
										$retval = 0;
										$retmess = $status['message'];
										break;
									}
								}

								if($retval == 1) {
									$array = array(
										'usertypeID' => $usertypeID,
										'users' => $countusers,
										'type' => ucfirst($this->input->post('type')),
										'message' => $this->input->post('sms_message'),
										'year' => date('Y'),
										'senderusertypeID' => $this->session->userdata('usertypeID'),
										'senderID' => $this->session->userdata('loginuserID')
									);
									$this->mailandsms_m->insert_mailandsms($array);
									redirect(base_url('mailandsms/index'));
								} else {
									$this->session->set_flashdata('error', $retmess);
									redirect(base_url("mailandsms/add"));
								}
							} else {
								$this->session->set_flashdata('error', $this->lang->line('mailandsms_notfound_error'));
								redirect(base_url('mailandsms/add'));
							}
						} else {
							$retval = 1;
							$retmess = '';

							$message = $this->input->post('sms_message');
							$singleparent = $this->parents_m->get_parents($parentsID);
							if(count($singleparent)) {
								$status = $this->userConfigSMS($message, $singleparent, $usertypeID, $getway);
								if($status['check'] == FALSE) {
									$retval = 0;
									$retmess = $status['message'];

								}

								if($retval == 1) {
									$array = array(
										'usertypeID' => $usertypeID,
										'users' => $singleparent->name,
										'type' => ucfirst($this->input->post('type')),
										'message' => $this->input->post('sms_message'),
										'year' => date('Y'),
										'senderusertypeID' => $this->session->userdata('usertypeID'),
										'senderID' => $this->session->userdata('loginuserID')
									);
									$this->mailandsms_m->insert_mailandsms($array);
									redirect(base_url('mailandsms/index'));
								} else {
									$this->session->set_flashdata('error', $retmess);
									redirect(base_url("mailandsms/add"));
								}

							} else {
								$this->session->set_flashdata('error', $this->lang->line('mailandsms_notfound_error'));
								redirect(base_url('mailandsms/add'));
							}
						}
					} else { /* FOR ALL USERS */
						$userID = $this->input->post('sms_users');
						if($userID == 'select') {
							$countusers = '';
							$retval = 1;
							$retmess = '';
							$message = $this->input->post('sms_message');
							$multiusers = $this->user_m->get_order_by_user(array('usertypeID' => $usertypeID));
							if(count($multiusers)) {
								foreach ($multiusers as $key => $multiuser) {
									$status = $this->userConfigSMS($message, $multiuser, $usertypeID, $getway);
									$countusers .= $multiuser->name .' ,';

									if($status['check'] == FALSE) {
										$retval = 0;
										$retmess = $status['message'];
										break;
									}
								}

								if($retval == 1) {
									$array = array(
										'usertypeID' => $usertypeID,
										'users' => $countusers,
										'type' => ucfirst($this->input->post('type')),
										'message' => $this->input->post('sms_message'),
										'year' => date('Y'),
										'senderusertypeID' => $this->session->userdata('usertypeID'),
										'senderID' => $this->session->userdata('loginuserID')
									);
									$this->mailandsms_m->insert_mailandsms($array);
									redirect(base_url('mailandsms/index'));
								} else {
									$this->session->set_flashdata('error', $retmess);
									redirect(base_url("mailandsms/add"));
								}
							} else {
								$this->session->set_flashdata('error', $this->lang->line('mailandsms_notfound_error'));
								redirect(base_url('mailandsms/add'));
							}
						} else {
							$retval = 1;
							$retmess = '';
							$message = $this->input->post('sms_message');
							$singleuser = $this->user_m->get_user($userID);
							if(count($singleuser)) {
								$status = $this->userConfigSMS($message, $singleuser, $usertypeID, $getway);
								if($status['check'] == FALSE) {
									$retval = 0;
									$retmess = $status['message'];
								}

								if($retval == 1) {
									$array = array(
										'usertypeID' => $usertypeID,
										'users' => $singleuser->name,
										'type' => ucfirst($this->input->post('type')),
										'message' => $this->input->post('sms_message'),
										'year' => date('Y'),
										'senderusertypeID' => $this->session->userdata('usertypeID'),
										'senderID' => $this->session->userdata('loginuserID')
									);
									$this->mailandsms_m->insert_mailandsms($array);
									redirect(base_url('mailandsms/index'));
								} else {
									$this->session->set_flashdata('error', $retmess);
									redirect(base_url("mailandsms/add"));
								}
							} else {
								$this->session->set_flashdata('error', $this->lang->line('mailandsms_notfound_error'));
								redirect(base_url('mailandsms/add'));
							}
						}
					}
				}
			}
		} else {
			$this->data['emailUserID'] = 0;
			$this->data['emailTemplateID'] = 0;

			$this->data['smsUserID'] = 0;
			$this->data['smsTemplateID'] = 0;

			$this->data["email"] = 1;
			$this->data["sms"] = 0;

			$this->data['allStudents'] = array();
			$this->data["subview"] = "mailandsms/add";
			$this->load->view('_layout_main', $this->data);
		}
	}

	function userConfigEmail($message, $user, $usertypeID, $schoolyearID = 1) {
		if($user && $usertypeID) {
			$userTags = $this->mailandsmstemplatetag_m->get_order_by_mailandsmstemplatetag(array('usertypeID' => $usertypeID));

			if($usertypeID == 2) {
				$userTags = $this->mailandsmstemplatetag_m->get_order_by_mailandsmstemplatetag(array('usertypeID' => 2));
			} elseif($usertypeID == 3) {
				$userTags = $this->mailandsmstemplatetag_m->get_order_by_mailandsmstemplatetag(array('usertypeID' => 3));
			} elseif($usertypeID == 4) {
				$userTags = $this->mailandsmstemplatetag_m->get_order_by_mailandsmstemplatetag(array('usertypeID' => 4));
			} else {
				$userTags = $this->mailandsmstemplatetag_m->get_order_by_mailandsmstemplatetag(array('usertypeID' => 1));
			}

			$message = $this->tagConvertor($userTags, $user, $message, 'email', $schoolyearID);

			if($user->email) {
				$subject = $this->input->post('email_subject');
				$email = $user->email;
				$this->email->set_mailtype("html");
				$this->email->from($this->data['siteinfos']->email, $this->data['siteinfos']->sname);
				$this->email->to($email);
				$this->email->subject($subject);
				$this->email->message($message);

				if($this->email->send()) {
					$this->session->set_flashdata('success', $this->lang->line('mail_success'));
				} else {
					$this->session->set_flashdata('error', $this->lang->line('mail_error'));
				}
			}
		}
	}

	function userConfigSMS($message, $user, $usertypeID, $getway, $schoolyearID = 1) {
		if($user && $usertypeID) {
			$userTags = $this->mailandsmstemplatetag_m->get_order_by_mailandsmstemplatetag(array('usertypeID' => $usertypeID));

			if($usertypeID == 2) {
				$userTags = $this->mailandsmstemplatetag_m->get_order_by_mailandsmstemplatetag(array('usertypeID' => 2));
			} elseif($usertypeID == 3) {
				$userTags = $this->mailandsmstemplatetag_m->get_order_by_mailandsmstemplatetag(array('usertypeID' => 3));
			} elseif($usertypeID == 4) {
				$userTags = $this->mailandsmstemplatetag_m->get_order_by_mailandsmstemplatetag(array('usertypeID' => 4));
			} else {
				$userTags = $this->mailandsmstemplatetag_m->get_order_by_mailandsmstemplatetag(array('usertypeID' => 1));
			}

			$message = $this->tagConvertor($userTags, $user, $message, 'SMS', $schoolyearID);

			if($user->phone) {
				$send = $this->allgetway_send_message($getway, $user->phone, $message);
				return $send;
			} else {
				$send = array('check' => TRUE);
				return $send;
			}
		}
	}

	function tagConvertor($userTags, $user, $message, $sendType, $schoolyearID) {
		if(count($userTags)) {
			foreach ($userTags as $key => $userTag) {
				if($userTag->tagname == '[name]') {
					if($user->name) {
						$message = str_replace('[name]', $user->name, $message);
					} else {
						$message = str_replace('[name]', ' ', $message);
					}
				} elseif($userTag->tagname == '[designation]') {
					if($user->designation) {
						$message = str_replace('[designation]', $user->designation, $message);
					} else {
						$message = str_replace('[designation]', ' ', $message);
					}
				} elseif($userTag->tagname == '[dob]') {
					if($user->dob) {
						$dob =  date("d M Y", strtotime($user->dob));
						$message = str_replace('[dob]', $dob, $message);
					} else {
						$message = str_replace('[dob]', ' ', $message);
					}
				} elseif($userTag->tagname == '[gender]') {
					if($user->sex) {
						$message = str_replace('[gender]', $user->sex, $message);
					} else {
						$message = str_replace('[gender]', ' ', $message);
					}
				} elseif($userTag->tagname == '[religion]') {
					if($user->religion) {
						$message = str_replace('[religion]', $user->religion, $message);
					} else {
						$message = str_replace('[religion]', ' ', $message);
					}
				} elseif($userTag->tagname == '[email]') {
					if($user->email) {
						$message = str_replace('[email]', $user->email, $message);
					} else {
						$message = str_replace('[email]', ' ', $message);
					}
				} elseif($userTag->tagname == '[phone]') {
					if($user->phone) {
						$message = str_replace('[phone]', $user->phone, $message);
					} else {
						$message = str_replace('[phone]', ' ', $message);
					}
				} elseif($userTag->tagname == '[address]') {
					if($user->address) {
						$message = str_replace('[address]', $user->address, $message);
					} else {
						$message = str_replace('[address]', ' ', $message);
					}
				} elseif($userTag->tagname == '[jod]') {
					if($user->jod) {
						$jod =  date("d M Y", strtotime($user->jod));
						$message = str_replace('[jod]', $jod, $message);
					} else {
						$message = str_replace('[jod]', ' ', $message);
					}
				} elseif($userTag->tagname == '[username]') {
					if($user->username) {
						$message = str_replace('[username]', $user->username, $message);
					} else {
						$message = str_replace('[username]', ' ', $message);
					}
				} elseif($userTag->tagname == "[father's_name]") {
					if($user->father_name) {
						$message = str_replace("[father's_name]", $user->father_name, $message);
					} else {
						$message = str_replace("[father's_name]", ' ', $message);
					}
				} elseif($userTag->tagname == "[mother's_name]") {
					if($user->mother_name) {
						$message = str_replace("[mother's_name]", $user->mother_name, $message);
					} else {
						$message = str_replace("[mother's_name]", ' ', $message);
					}
				} elseif($userTag->tagname == "[father's_profession]") {
					if($user->father_profession) {
						$message = str_replace("[father's_profession]", $user->father_profession, $message);
					} else {
						$message = str_replace("[father's_profession]", ' ', $message);
					}
				} elseif($userTag->tagname == "[mother's_profession]") {
					if($user->mother_profession) {
						$message = str_replace("[mother's_profession]", $user->mother_profession, $message);
					} else {
						$message = str_replace("[mother's_profession]", ' ', $message);
					}
				} elseif($userTag->tagname == '[class]') {
					$classes = $this->classes_m->get_classes($user->classesID);
					if(count($classes)) {
						$message = str_replace('[class]', $classes->classes, $message);
					} else {
						$message = str_replace('[class]', ' ', $message);
					}
				} elseif($userTag->tagname == '[roll]') {
					if($user->roll) {
						$message = str_replace("[roll]", $user->roll, $message);
					} else {
						$message = str_replace("[roll]", ' ', $message);
					}
				} elseif($userTag->tagname == '[country]') {
					if($user->country) {
						$message = str_replace("[country]", $this->data['allcountry'][$user->country], $message);
					} else {
						$message = str_replace("[country]", ' ', $message);
					}
				} elseif($userTag->tagname == '[state]') {
					if($user->state) {
						$message = str_replace("[state]", $user->state, $message);
					} else {
						$message = str_replace("[state]", ' ', $message);
					}
				} elseif($userTag->tagname == '[register_no]') {
					if($user->registerNO) {
						$message = str_replace("[register_no]", $user->registerNO, $message);
					} else {
						$message = str_replace("[register_no]", ' ', $message);
					}
				} elseif($userTag->tagname == '[section]') {
					if($user->sectionID) {
						$section = $this->section_m->get_section($user->sectionID);
						if(count($section)) {
							$message = str_replace('[section]', $section->section, $message);
						} else {
							$message = str_replace('[section]',' ', $message);
						}
					} else {
						$message = str_replace("[section]", ' ', $message);
					}
				} elseif($userTag->tagname == '[blood_group]') {
					if($user->bloodgroup && $user->bloodgroup != '0') {
						$message = str_replace("[blood_group]", $user->bloodgroup, $message);
					} else {
						$message = str_replace("[blood_group]", ' ', $message);
					}
				} elseif($userTag->tagname == '[group]') {
					if($user->studentgroupID && $user->studentgroupID != 0) {
						$group = $this->studentgroup_m->get_studentgroup($user->studentgroupID);
						if(count($group)) {
							$message = str_replace('[group]', $group->group, $message);
						} else {
							$message = str_replace('[group]',' ', $message);
						}
					} else {
						$message = str_replace('[group]',' ', $message);
					}
				} elseif($userTag->tagname == '[optional_subject]') {
					if($user->optionalsubjectID && $user->optionalsubjectID != 0) {
						$subject = $this->subject_m->get_single_subject(array('subjectID' => $user->optionalsubjectID));
						if(count($subject)) {
							$message = str_replace('[optional_subject]', $subject->subject, $message);
						} else {
							$message = str_replace('[optional_subject]',' ', $message);
						}
					} else {
						$message = str_replace('[optional_subject]',' ', $message);
					}
				} elseif($userTag->tagname == '[extra_curricular_activities]') {
					if($user->extracurricularactivities) {
						$message = str_replace("[extra_curricular_activities]", $user->extracurricularactivities, $message);
					} else {
						$message = str_replace("[extra_curricular_activities]", ' ', $message);
					}
				} elseif($userTag->tagname == '[remarks]') {
					if($user->remarks) {
						$message = str_replace("[remarks]", $user->remarks, $message);
					} else {
						$message = str_replace("[remarks]", ' ', $message);
					}
				} elseif($userTag->tagname == '[result_table]') {
					if($sendType == 'email') {
						if($user->usertypeID == 3) {
							$result = $this->resultTableEmail($user->studentID, $user->classesID, $schoolyearID);
						} else {
							$result = '';
						}
						$message = str_replace("[result_table]", $result, $message);
					} elseif($sendType == 'SMS') {
						if($user->usertypeID == 3) {
							$result = $this->resultTableSMS($user->studentID, $user->classesID, $schoolyearID);
						} else {
							$result = '';
						}
						$message = str_replace("[result_table]", $result, $message);
					}
				}
			}
		}

		return $message;
	}

	function alltemplate() {
		if($this->input->post('usertypeID') == 'select') {
			echo '<option value="select">'.$this->lang->line('mailandsms_select_template').'</option>';
		} else {
			$usertypeID = $this->input->post('usertypeID');
			$type = $this->input->post('type');

			$templates = $this->mailandsmstemplate_m->get_order_by_mailandsmstemplate(array('usertypeID' => $usertypeID, 'type' => $type));
			echo '<option value="select">'.$this->lang->line('mailandsms_select_template').'</option>';
			if(count($templates)) {
				foreach ($templates as $key => $template) {
					echo '<option value="'.$template->mailandsmstemplateID.'">'. $template->name  .'</option>';
				}
			}
		}
	}

	function allusers() {
		if($this->input->post('usertypeID') == 'select') {
			echo '<option value="select">'.$this->lang->line('mailandsms_select_users').'</option>';
		} else {
			$usertypeID = $this->input->post('usertypeID');
			$userID = $this->input->post('userID');

			if($usertypeID == 1) {
				$systemadmins = $this->systemadmin_m->get_systemadmin();
				if(count($systemadmins)) {
					echo "<option value='select'>".$this->lang->line('mailandsms_select_users')."</option>";
					foreach ($systemadmins as $key => $systemadmin) {
						echo "<option value='".$systemadmin->systemadminID."'>".$systemadmin->name.'</option>';
					}
				} else {
					echo '<option value="select">'.$this->lang->line('mailandsms_select_users').'</option>';
				}
			} elseif($usertypeID == 2) {
				$teachers = $this->teacher_m->get_teacher();
				if(count($teachers)) {
					echo "<option value='select'>".$this->lang->line('mailandsms_select_users')."</option>";
					foreach ($teachers as $key => $teacher) {
						echo "<option value='".$teacher->teacherID."'>".$teacher->name.'</option>';
					}
				} else {
					echo '<option value="select">'.$this->lang->line('mailandsms_select_users').'</option>';
				}
			} elseif($usertypeID == 3) {
				$classes = $this->classes_m->get_classes();
				if(count($classes)) {
					echo "<option value='select'>".$this->lang->line('mailandsms_select_class')."</option>";
					foreach ($classes as $key => $classm) {
						echo "<option value='".$classm->classesID."'>".$classm->classes.'</option>';
					}
				} else {
					echo '<option value="select">'.$this->lang->line('mailandsms_select_class').'</option>';
				}
			} elseif($usertypeID == 4) {
				$parents = $this->parents_m->get_parents();
				if(count($parents)) {
					echo "<option value='select'>".$this->lang->line('mailandsms_select_users')."</option>";
					foreach ($parents as $key => $parent) {
						echo "<option value='".$parent->parentsID."'>".$parent->name.'</option>';
					}
				} else {
					echo '<option value="select">'.$this->lang->line('mailandsms_select_users').'</option>';
				}
			} else {
				$users = $this->user_m->get_order_by_user(array('usertypeID' => $usertypeID));
				if(count($users)) {
					echo "<option value='select'>".$this->lang->line('mailandsms_select_users')."</option>";
					foreach ($users as $key => $user) {
						echo "<option value='".$user->userID."'>".$user->name.'</option>';
					}
				} else {
					echo '<option value="select">'.$this->lang->line('mailandsms_select_users').'</option>';
				}
			}
		}
	}

	function allstudent() {
		$schoolyearID = $this->input->post('schoolyear');
		$classesID = $this->input->post('classes');
		if((int)$schoolyearID && (int)$classesID) {
			$students = $this->student_m->get_order_by_student(array('schoolyearID' => $schoolyearID, 'classesID' => $classesID));

			if(count($students)) {
				echo '<option value="select">'.$this->lang->line('mailandsms_select_users').'</option>';
				foreach ($students as $key => $student) {
					echo '<option value="'.$student->studentID.'">'.$student->name.'</option>';
				}
			} else {
				echo '<option value="select">'.$this->lang->line('mailandsms_select_users').'</option>';
			}
		} else {
			echo '<option value="select">'.$this->lang->line('mailandsms_select_users').'</option>';
		}
	}

	function check_email_usertypeID() {
		if($this->input->post('email_usertypeID') == 'select') {
			$this->form_validation->set_message("check_email_usertypeID", "The %s field is required");
	     	return FALSE;
		} else {
			return TRUE;
		}
	}

	function alltemplatedesign() {
		if((int)$this->input->post('templateID')) {
			$templateID = $this->input->post('templateID');
			$templates = $this->mailandsmstemplate_m->get_mailandsmstemplate($templateID);
			if(count($templates)) {
				echo $templates->template;
			}
		} else {
			echo '';
		}
	}

	function check_sms_usertypeID() {
		if($this->input->post('sms_usertypeID') == 'select') {
			$this->form_validation->set_message("check_sms_usertypeID", "The %s field is required");
	     	return FALSE;
		} else {
			return TRUE;
		}
	}

	function check_getway() {
		if($this->input->post('sms_getway') == 'select') {
			$this->form_validation->set_message("check_getway", "The %s field is required");
	     	return FALSE;
		} else {

			$getway = $this->input->post('sms_getway');
			$arrgetway = array('clickatell', 'twilio', 'bulk', 'msg91');
			if(in_array($getway, $arrgetway)) {
				if($getway == "clickatell") {
					if($this->clickatell->ping() == TRUE) {
						return TRUE;
					} else {
						$this->form_validation->set_message("check_getway", 'Setup Your clickatell Account');
	     				return FALSE;
					}
				} elseif($getway == 'twilio') {
					$get = $this->twilio->get_twilio();
					$ApiVersion = $get['version'];
					$AccountSid = $get['accountSID'];
					$check = $this->twilio->request("/$ApiVersion/Accounts/$AccountSid/Calls");

					if($check->IsError) {
						$this->form_validation->set_message("check_getway", $check->ErrorMessage);
	     				return FALSE;
					}
					return TRUE;
				} elseif($getway == 'bulk') {
					if($this->bulk->ping() == TRUE) {
						return TRUE;
					} else {
						$this->form_validation->set_message("check_getway", 'Invalid Username or Password');
	     				return FALSE;
					}
				} elseif($getway == 'msg91') {
                    return true;
				}
			} else {
				$this->form_validation->set_message("check_getway", "The %s field is required");
	     		return FALSE;
			}


		}
	}

	private function allgetway_send_message($getway, $to, $message) {
		$result = array();
		if($getway == "clickatell") {
			if($to) {
				$this->clickatell->send_message($to, $message);
				$result['check'] = TRUE;
				return $result;
			}
		} elseif($getway == 'twilio') {
			$get = $this->twilio->get_twilio();
			$from = $get['number'];
			if($to) {
				$response = $this->twilio->sms($from, $to, $message);
				if($response->IsError) {
					$result['check'] = FALSE;
					$result['message'] = $response->ErrorMessage;
					return $result;
				} else {
					$result['check'] = TRUE;
					return $result;
				}

			}
		} elseif($getway == 'bulk') {
			if($to) {
				if($this->bulk->send($to, $message) == TRUE)  {
					$result['check'] = TRUE;
					return $result;
				} else {
					$result['check'] = FALSE;
					$result['message'] = "Check your bulk account";
					return $result;
				}
			}
		} elseif($getway == 'msg91') {
			if($to) {
				if($this->msg91->send($to, $message) == TRUE)  {
					$result['check'] = TRUE;
					return $result;
				} else {
					$result['check'] = FALSE;
					$result['message'] = "Check your msg91 account";
					return $result;
				}
			}
		}
	}

	public function view() {
		$id = htmlentities(escapeString($this->uri->segment(3)));
		if((int)$id) {
			$this->data['mailandsms'] = $this->mailandsms_m->get_mailandsms($id);
			if($this->data['mailandsms']) {
				$this->data["subview"] = "mailandsms/view";
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

	public function resultTableEmail($studentID, $classesID, $schoolyearID) {
		$string = '<br>';
		$markArray = $this->getMarkArray($studentID, $classesID, $schoolyearID);
		if(count($markArray['separatedMarks'])) {
			if(count($markArray['exams'])) { 
				foreach ($markArray['exams'] as $markArrayExamKey => $markArrayExam) { 
					if(count($markArray['separatedMarks'])) { 
						if(isset($markArray['separatedMarks'][$markArrayExam->examID])) {
							$string.= '<div style="border: 1px solid #ddd;margin:5px;display:inline-block">';
								$string.= '<h3 style="padding:10px;margin:0px">'.$markArrayExam->exam.'</h3>';

								if(count($markArray['markpercentages'])) {
									$string.= '<table class="table-bordered">';
										$string.= '<tr style="border: 1px solid #ddd;">';
											$string.= '<td style="border: 1px solid #ddd;padding: 8px;line-height: 1.428571429;vertical-align: top;">';
												$string.= $this->lang->line('mailandsms_subject');
											$string.= '</td>';

											foreach ($markArray['markpercentages'] as $markArrayMarkPercentageKey => $markArrayMarkPercentage) {
												$string.= '<td style="border: 1px solid #ddd;padding: 8px;line-height: 1.428571429;vertical-align: top;">';
													$string.= $markArrayMarkPercentage;
												$string.= '</td>';
											}

											$string.= '<td style="border: 1px solid #ddd;padding: 8px;line-height: 1.428571429;vertical-align: top;">';
												$string.= $this->lang->line('mailandsms_total_mark');
											$string.= '</td>';

											$string.= '<td style="border: 1px solid #ddd;padding: 8px;line-height: 1.428571429;vertical-align: top;">';
												$string.= $this->lang->line('mailandsms_point');
											$string.= '</td>';

											$string.= '<td style="border: 1px solid #ddd;padding: 8px;line-height: 1.428571429;vertical-align: top;">';
												$string.= $this->lang->line('mailandsms_grade');
											$string.= '</td>';
										$string.= '</tr>';
									foreach ($markArray['separatedMarks'][$markArrayExam->examID] as $markArraySeparatedMarkKey => $markArraySeparatedMark) {
										if(count($markArraySeparatedMark)) {
												$string.= '<tr>';
													$string.= '<td style="border: 1px solid #ddd;padding: 8px;line-height: 1.428571429;vertical-align: top;">'; 
														if(isset($markArraySeparatedMark['subject'])) {
															$string.= $markArraySeparatedMark['subject'];
														}
													$string.= '</td>';

													$totalMark = 0;
													foreach ($markArraySeparatedMark as $markArrayPercentageKey => $markArrayPercentage) {
														if($markArrayPercentageKey != 'subject') {
															if(isset($markArray['markpercentages'][$markArrayPercentageKey])) {
																$string.= '<td style="border: 1px solid #ddd;padding: 8px;line-height: 1.428571429;vertical-align: top;">'; 
																	$string.= $markArrayPercentage;
																$string.= '</td>';

																$totalMark += $markArrayPercentage;
															}										
														}
													}

													$string.= '<td style="border: 1px solid #ddd;padding: 8px;line-height: 1.428571429;vertical-align: top;">';
														$string.= $totalMark;
													$string.= '</td>';

													$string.= '<td style="border: 1px solid #ddd;padding: 8px;line-height: 1.428571429;vertical-align: top;">';
														if(count($markArray['grades'])) {
															foreach ($markArray['grades'] as $markArrayGradeKey => $markArrayGrade) {
																if($totalMark >= $markArrayGrade->gradefrom  && $totalMark <= $markArrayGrade->gradeupto) {
																	$string.= $markArrayGrade->point;
																}
															}
														}
													$string.= '</td>';

													$string.= '<td style="border: 1px solid #ddd;padding: 8px;line-height: 1.428571429;vertical-align: top;">';
														if(count($markArray['grades'])) {
															foreach ($markArray['grades'] as $markArrayGradeKey => $markArrayGrade) {
																if($totalMark >= $markArrayGrade->gradefrom  && $totalMark <= $markArrayGrade->gradeupto) {
																	$string.= $markArrayGrade->grade;
																}
															}
														}
													$string.= '</td>';

												$string.= '</tr>';
										}
									}
									$string.= '</table>';
								}
							$string.= '</div><br>	';

						}
					}
				}
			}
			return $string;
		} else {
			$string = ' '.$this->lang->line('mailandsms_not_found');
			return $string;
		}
	}

	public function resultTableSMS($studentID, $classesID, $schoolyearID) {
		$string = ' ';
		$markArray = $this->getMarkArray($studentID, $classesID, $schoolyearID);
		if(count($markArray['separatedMarks'])) {
			if(count($markArray['exams'])) { 
				foreach ($markArray['exams'] as $markArrayExamKey => $markArrayExam) { 
					if(count($markArray['separatedMarks'])) { 
						if(isset($markArray['separatedMarks'][$markArrayExam->examID])) {
							$string.= $markArrayExam->exam.', ';

							if(count($markArray['markpercentages'])) {
								foreach ($markArray['separatedMarks'][$markArrayExam->examID] as $markArraySeparatedMarkKey => $markArraySeparatedMark) {
									if(count($markArraySeparatedMark)) {
										if(isset($markArraySeparatedMark['subject'])) {
											$string.= $markArraySeparatedMark['subject'] .' ';
										}

										$totalMark = 0;
										foreach ($markArraySeparatedMark as $markArrayPercentageKey => $markArrayPercentage) {
											if($markArrayPercentageKey != 'subject') {
												if(isset($markArray['markpercentages'][$markArrayPercentageKey])) {
														$string.= $markArray['markpercentages'][$markArrayPercentageKey].' : ';
														$string.= $markArrayPercentage.', ';
												}										
											}
										}
									}
								}
							}
						}
					}
				}
			}
			return strip_tags($string);
		} else {
			$string = ' '.$this->lang->line('mailandsms_not_found');
			return $string;
		}
	}

	function getMarkArray($studentID, $classesID, $schoolyearID) {
		$this->load->model('markpercentage_m');
		$this->load->model('markrelation_m');
		$studentID = $studentID;
		$classID = $classesID;
		$schoolyearID = $schoolyearID;
		if((int)$studentID && (int)$classID) {
			$this->data['generate']["student"] 				= $this->student_m->get_student($studentID);
			$this->data['generate']["classes"] 				= $this->student_m->get_class($classID);
			if($this->data['generate']["student"] && $this->data['generate']["classes"]) {
				$this->data['generate']['set'] 				= $classID;
				$this->data['generate']["exams"] 			= $this->exam_m->get_exam();
				$this->data['generate']["grades"] 			= $this->grade_m->get_grade();
				$this->data['generate']['markpercentages']	= $this->markpercentage_m->get_markpercentage();
				$subjects 									= $this->subject_m->get_subject_call($classID);

					$allMarkWithRelation = $this->markrelation_m->get_all_mark_with_relation($classID, $schoolyearID);
					$studentMarkPercentage = array();
					foreach ($allMarkWithRelation as $key => $value) {
						$studentMarkPercentage[$value->studentID][$value->examID]['markpercentage'][] = $value->markpercentageID;
						$studentMarkPercentage[$value->studentID][$value->examID][$value->subjectID] = $value->markID;
					}

					$markpercentages = pluck($this->data['generate']['markpercentages'], 'markpercentageID');
					foreach ($this->data['generate']["exams"] as $exam) {
						$studentPercentage = isset($studentMarkPercentage[$studentID][$exam->examID]['markpercentage']) ? $studentMarkPercentage[$studentID][$exam->examID]['markpercentage'] : [] ;
						if(count($studentPercentage)) {
							$diffMarkPercentage = array_diff($markpercentages, $studentMarkPercentage[$studentID][$exam->examID]['markpercentage']);
							foreach ($diffMarkPercentage as $item) {
								if(isset($studentMarkPercentage[$studentID][$exam->examID]) && count($studentMarkPercentage[$studentID][$exam->examID])) {
									foreach ($studentMarkPercentage[$studentID][$exam->examID] as $subjectID => $markID) {
										if($subjectID == 'markpercentage') continue;
										$markRelation = [
											"markID" => $markID,
											"markpercentageID" => $item
										];
										$this->markrelation_m->insert($markRelation);
									}
								}
							}
						}
					}

				$this->data['generate']['markpercentages'] = $this->get_setting_mark_percentage();
				$marks = $this->mark_m->get_order_by_student_mark_with_subject($classID, $schoolyearID, $studentID);
				$allStudentMarks = $this->mark_m->get_order_by_student_mark_with_subject($classID, $schoolyearID);
				$this->data['generate']['marks'] = $marks;
				$separatedMarks = array();
				foreach ($marks as $key => $value) {
					$separatedMarks[$value->examID][$value->subjectID]['subject'] = $value->subject;
					$separatedMarks[$value->examID][$value->subjectID][$value->markpercentageID]= $value->mark;
				}
				$this->data['generate']['separatedMarks'] = $separatedMarks;
				$this->data['generate']["section"] = $this->section_m->get_section($this->data['generate']['student']->sectionID);


				$this->data['markArray']['separatedMarks'] 	= $this->data['generate']['separatedMarks'];
				$this->data['markArray']['exams'] 			= $this->data['generate']["exams"];
				$this->data['markArray']['grades'] 			= $this->data['generate']["grades"];
				$this->data['markArray']['markpercentages'] = pluck($this->data['generate']['markpercentages'], 'markpercentagetype', 'markpercentageID');

				return $this->data['markArray'];
			}
		} else {
			$this->data['markArray'] = array();
			return $this->data['markArray'];
		}
	}

	function get_setting_mark_percentage() {
		$markpercentagesDatabases = $this->markpercentage_m->get_markpercentage();
		$markpercentagesSettings = $this->setting_m->get_markpercentage();
		$markpercentages = array();
		$array = array();
		if(count($markpercentagesSettings)) {
			foreach ($markpercentagesSettings as $key => $markpercentagesSetting) {
				$expfieldname = explode('_', $markpercentagesSetting->fieldoption);
				$array[] = (int)$expfieldname[1];
			}
		}

		if(count($markpercentagesDatabases)) {
			foreach ($markpercentagesDatabases as $key => $markpercentagesDatabase) {
				if(in_array($markpercentagesDatabase->markpercentageID, $array)) {
					$markpercentages[] = $markpercentagesDatabase;
				}
			}
		}
		return $markpercentages;
	}
}

/* End of file student.php */
/* Location: .//D/xampp/htdocs/school/mvc/controllers/student.php */
