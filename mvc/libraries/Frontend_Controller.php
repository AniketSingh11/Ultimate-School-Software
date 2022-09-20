<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @property document_m $document_m
 * @property email_m $email_m
 * @property error_m $error_m
 */
class Frontend_Controller extends MY_Controller {
    

    private $_frontendTheme = '';
    private $_frontendThemePath = '';
    private $_frontendThemeBasePath = '';


    protected $bladeView;

    function __construct () {
        parent::__construct();
        $this->load->driver('cache', array('adapter' => 'file'));
        $this->load->library('blade');
        $this->load->library("session");
        $this->load->library('form_validation');
        $this->load->helper('url');
        $this->load->helper('language');
        $this->load->helper('date');
        $this->load->helper('form');
        $this->load->helper('traffic');
        $this->load->helper("frontenddata");
        $this->load->model('frontend_setting_m');
        $this->load->model('setting_m');
        $this->load->model('pages_m');
        $this->load->model('fmenu_relation_m');
        $this->load->model('fmenu_m');
        $this->load->model('event_m');
        $this->load->model('teacher_m');
        $this->load->model('notice_m');


        /* Start All Data Call */
        $this->data['homepage'] = $this->pages_m->get_one();
        $this->data['events'] = $this->event_m->get_order_by_event();
        $this->data['teachers'] = $this->teacher_m->get_teacher();
        $this->data['notices'] = $this->notice_m->get_order_by_notice(array('schoolyearID' => frontendData::get_backend('school_year')));
        /* Close All Data Call */

        $this->data['backend_setting'] = $this->setting_m->get_setting();
        $this->data['frontend_setting'] = $this->frontend_setting_m->get_frontend_setting();
        $this->data['frontend_topbar'] = $this->fmenu_m->get_single_fmenu(array('topbar' => 1));
        $this->data['frontend_socal'] = $this->fmenu_m->get_single_fmenu(array('socal' => 1));

        $this->_frontendTheme = strtolower($this->data["backend_setting"]->frontend_theme);;
        $this->_frontendThemePath = 'frontend/'. $this->_frontendTheme.'/';
        $this->_frontendThemeBasePath = FCPATH.'frontend/'. $this->_frontendTheme.'/';

        $this->blade->load_view_root($this->_frontendThemeBasePath);
        $this->bladeView = $this->blade;
        $this->bladeView->set('backend', $this->data['backend_setting']);
        $this->bladeView->set('frontend', $this->data['frontend_setting']);
        $this->bladeView->set('frontendThemePath', $this->_frontendThemePath);

        $this->bladeView->set('frontendTopbar', $this->data['frontend_topbar']);
        $this->bladeView->set('frontendSocal', $this->data['frontend_socal']);

        $this->bladeView->set('homepage', $this->data['homepage']);
        $this->bladeView->set('events', $this->data['events']);
        $this->bladeView->set('teachers', $this->data['teachers']);
        $this->bladeView->set('notices', $this->data['notices']);
    }
}

