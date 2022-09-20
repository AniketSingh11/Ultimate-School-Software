<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Frontend extends Frontend_Controller {
    

    protected $_pageName;
    protected $_templateName;

    function __construct() {
        parent::__construct();
        $this->load->model('pages_m');
        $this->load->model('media_gallery_m');
        $this->load->model('slider_m');
    }

    public function page() {
        $url = htmlentities(escapeString($this->uri->segment(3)));
        if($url) {

            if($url == 'login') {
                redirect(base_url('signin/index'));
            }

            $pages = $this->pages_m->get_pages();
            $page = $this->pages_m->get_single_pages(array('url' => $url));
            $featured_image = array();

            if(count($page)) {

                if(!empty($page->featured_image)) {
                    $featured_image = $this->media_gallery_m->get_single_media_gallery(array('media_galleryID' => $page->featured_image));
                }   

                $sliders = $this->slider_m->get_slider_join_with_media_gallery($page->pagesID);

                $this->_pageName = $page->title;
                $this->_templateName = $page->template;
                if($page->template == 'none') {
                    $this->bladeView->render('views/templates/none', compact('page', 'featured_image', 'sliders'));
                } else {
                    $this->bladeView->render('views/templates/'.$this->_templateName, compact('page', 'featured_image', 'sliders'));
                }
            } else {
                $this->_templateName = 'page404';
                $this->bladeView->render('views/templates/'.$this->_templateName);
            }
        } else {
            if(count($this->data['homepage'])) {

                $this->_templateName = 'home';

                $pages = $this->pages_m->get_pages();
                $page = $this->pages_m->get_single_pages(array('url' => $this->data['homepage']->url));
                $featured_image = array();

                if(!empty($page->featured_image)) {
                    $featured_image = $this->media_gallery_m->get_single_media_gallery(array('media_galleryID' => $page->featured_image));
                }   

                $sliders = $this->slider_m->get_slider_join_with_media_gallery($page->pagesID);

                $this->bladeView->render('views/templates/'.$this->_templateName, compact('page', 'featured_image', 'sliders'));
            } else {
                $this->_templateName = 'homeempty';
                $this->bladeView->render('views/templates/'.$this->_templateName);
            }            
        }       
    }

    function event()
    {

        $id = htmlentities(escapeString($this->uri->segment(3)));
        if((int)$id) {
            $eventView = $this->event_m->get_single_event(array('eventID' => $id));
            if(count($eventView)) {
                $this->bladeView->render('views/templates/eventview', compact('eventView'));
            } else {
                $this->_templateName = 'page404';
                $this->bladeView->render('views/templates/'.$this->_templateName);
            }
        } else {
            $this->_templateName = 'page404';
            $this->bladeView->render('views/templates/'.$this->_templateName);
        }
    }

    function eventGoing()
    {
        $status = FALSE;
        $message = '';
        $id = $this->input->post('id');

        if((int)$id) {
            if($this->session->userdata('loggedin')) {

                $event = $this->event_m->get_single_event(array('eventID' => $id));

                if(count($event)) {
                    $username = $this->session->userdata("username");
                    $usertype = $this->session->userdata("usertype");
                    $photo = $this->session->userdata("photo");
                    $name = $this->session->userdata("name");

                    $this->load->model('eventcounter_m');
                    $have = $this->eventcounter_m->get_order_by_eventcounter(array("eventID" => $id, "username" => $username, "type" => $usertype),TRUE);

                    if(count($have)) {
                        $array = array('status' => 1);
                        $this->eventcounter_m->update($array,$have[0]->eventcounterID);
                        $status = TRUE;
                        $message = 'You are add this event';
                    } else {
                        $array = array('eventID' => $id,
                            'username' => $username,
                            'type' => $usertype,
                            'photo' => $photo,
                            'name' => $name,
                            'status' => 1
                        );
                        $this->eventcounter_m->insert($array);
                        $status = TRUE;
                        $message = 'You are add this event';
                    }
                } else {
                    $message = 'Event id does not found';
                }
            } else {
                $message = 'Please login';
            }
        } else {
            $message = 'ID is not int';
        }

        $json = array(
            "message" => $message, 
            'status' => $status,
        );
        header("Content-Type: application/json", true);
        echo json_encode($json);
        exit;
    }


    function notice()
    {
        $id = htmlentities(escapeString($this->uri->segment(3)));
        if((int)$id) {
            $noticeView = $this->notice_m->get_single_notice(array('noticeID' => $id));


            if(count($noticeView)) {
                $this->bladeView->render('views/templates/noticeview', compact('noticeView'));
            } else {
                $this->_templateName = 'page404';
                $this->bladeView->render('views/templates/'.$this->_templateName);
            }
        } else {
            $this->_templateName = 'page404';
            $this->bladeView->render('views/templates/'.$this->_templateName);
        }
    }

    function contactMailSend() {
        $name = $this->input->post('name');
        $email = $this->input->post('email');
        $subject = $this->input->post('subject');
        $message = $this->input->post('message');
        if($name && $email && $subject && $message) {           
            $this->load->library('email');
            $this->email->set_mailtype("html");
            if(frontendData::get_backend('email')) {
                $this->email->from($email, frontendData::get_backend('sname'));
                $this->email->to(frontendData::get_backend('email'));
                $this->email->subject($subject);
                $this->email->message($message);
                $this->email->send();
                $this->session->set_flashdata('success', 'Email send successfully!');
                echo 'success';
            } else {
                $this->session->set_flashdata('error', 'Set your email in general setting');
            }
        } else {
            $this->session->set_flashdata('error', 'oops! Email not send!');
        }
    }
}