<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Calendar extends MY_Controller {
    
    public function __construct() {
        parent::__construct();
        
        $this->load->model('log_model');
    }

    public function index() {
        
        $all_logs = $this->log_model->get_all();
        $month_year_filter_selections = array();
        $month_year_filter_selections_w_date = array();

        foreach ($all_logs as $value) {
            if (!in_array(date('F Y', strtotime($value->datetime)), $month_year_filter_selections)) {
                array_push($month_year_filter_selections, date('F Y', strtotime($value->datetime)));
                
                $month_year_filter_selections_w_date_temp = array(
                    "month_year" => date('F Y', strtotime($value->datetime)),
                    "date" => date('Y-m-01', strtotime($value->datetime))
                );
                
                array_push($month_year_filter_selections_w_date, $month_year_filter_selections_w_date_temp);
                
            }
        }

        $vars['month_year_filter_selections_w_date'] = array_reverse($month_year_filter_selections_w_date);
        
        $this->render("v_index", $vars);
    }
    
    public function ajaxfetchevents() {
        
        $starttime = $this->input->get("from");
        $endtime = $this->input->get("to");
        
        $params["starttime"] = date("Y-m-d H:i:s", $starttime / 1000);
        $params["endtime"] = date("Y-m-d H:i:s", $endtime / 1000);
        
        $logs = $this->log_model->get_all_order_by('datetime', 'ASC', $params);
        
        foreach ($logs as &$value) {
            $value->start = strtotime($value->datetime) . "000";
            $value->end = (strtotime($value->datetime) + 3600*4) . "000";
            
            if(date("a", strtotime($value->datetime)) == "pm"){
                $value->class = "event-info";
            }
            
            $value->url = "#";
        }
        
        echo json_encode(array('success' => 1, 'result' => $logs));
    }

}