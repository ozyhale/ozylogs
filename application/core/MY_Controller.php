<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MY_Controller
 *
 * @author ozyhale
 */

/**
 * @property CI_DB_active_record $db
 * @property CI_DB_forge $dbforge
 * @property CI_Benchmark $benchmark
 * @property CI_Calendar $calendar
 * @property CI_Cart $cart
 * @property CI_Config $config
 * @property CI_Controller $controller
 * @property CI_Email $email
 * @property CI_Encrypt $encrypt
 * @property CI_Exceptions $exceptions
 * @property CI_Form_validation $form_validation
 * @property CI_Ftp $ftp
 * @property CI_Hooks $hooks
 * @property CI_Image_lib $image_lib
 * @property CI_Input $input
 * @property CI_Language $language
 * @property CI_Loader $load
 * @property CI_Log $log
 * @property CI_Model $model
 * @property CI_Output $output
 * @property CI_Pagination $pagination
 * @property CI_Parser $parser
 * @property CI_Profiler $profiler
 * @property CI_Router $router
 * @property CI_Session $session
 * @property CI_Sha1 $sha1
 * @property CI_Table $table
 * @property CI_Trackback $trackback
 * @property CI_Typography $typography
 * @property CI_Unit_test $unit_test
 * @property CI_Upload $upload
 * @property CI_URI $uri
 * @property CI_User_agent $agent
 * @property CI_Validation $validation
 * @property CI_Xmlrpc $xmlrpc
 * @property CI_Xmlrpcs $xmlrpcs
 * @property CI_Zip $zip
 * @property template $template
 * @property log_model $log_model
 */
class MY_Controller extends CI_Controller {

    public function __construct() {
        parent::__construct();

        date_default_timezone_set('Asia/Manila');

        $this->load->library('template');
    }

    public function notify_error($message, $redirect = true) {
        if ($redirect) {
            $this->session->set_flashdata(Template::NOTIFICATION_ERROR, $message);
        }else{
            $this->load->vars(Template::NOTIFICATION_ERROR, $message);
        }
    }

    public function notify_warning($message) {
        $this->session->set_flashdata(Template::NOTIFICATION_WARNING, $message);
    }

    public function notify_info($message) {
        $this->session->set_flashdata(Template::NOTIFICATION_INFO, $message);
    }

    public function notify_success($message) {
        $this->session->set_flashdata(Template::NOTIFICATION_SUCCESS, $message);
    }

    protected function render($view, $vars = array(), $include_module = true) {

        if ($this->session->flashdata(Template::NOTIFICATION_ERROR)) {
            $vars[Template::NOTIFICATION_ERROR] = $this->session->flashdata(Template::NOTIFICATION_ERROR);
        }

        if ($this->session->flashdata(Template::NOTIFICATION_WARNING)) {
            $vars[Template::NOTIFICATION_WARNING] = $this->session->flashdata(Template::NOTIFICATION_WARNING);
        }

        if ($this->session->flashdata(Template::NOTIFICATION_INFO)) {
            $vars[Template::NOTIFICATION_INFO] = $this->session->flashdata(Template::NOTIFICATION_INFO);
        }

        if ($this->session->flashdata(Template::NOTIFICATION_SUCCESS)) {
            $vars[Template::NOTIFICATION_SUCCESS] = $this->session->flashdata(Template::NOTIFICATION_SUCCESS);
        }

        $module = get_class($this) . '/';

        if ($include_module === false) {
            $module = '';
        }

        $vars2[Template::CONTENT] = $this->load->view($module . $view, $vars, true);
        $this->load->view(Template::VIEW, $vars2);
    }

}
