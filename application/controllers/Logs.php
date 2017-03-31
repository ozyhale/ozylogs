<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Logs
 *
 * @author ozyhale
 */
class Logs extends MY_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->model('log_model');
        $this->load->helper(array('form', 'url'));
    }

    public function index($month_year = "") {

        $all_logs = $this->log_model->get_all();
        $month_year_filter_selections = array();

        foreach ($all_logs as $value) {
            if (!in_array(date('F Y', strtotime($value->datetime)), $month_year_filter_selections)) {
                array_push($month_year_filter_selections, date('F Y', strtotime($value->datetime)));
            }
        }

        $month_year_filter_selections_reversed = array_reverse($month_year_filter_selections);
        
        $logs2 = array();

        if ($month_year == "latest") {
            $month_year = strtolower(str_replace(" ", "-", $month_year_filter_selections_reversed[0]));
        }
        
        if($month_year != ""){
            
            $logs = $this->log_model->get_all_order_by('datetime', 'ASC', array('month_and_year' => $month_year));

            $numberOfDays = date("t", strtotime($month_year));
            $month_year_exploded = explode('-', $month_year);
            $meridiem = array("am", "pm");

            for($i=1;$i<=$numberOfDays;$i++){

                foreach($meridiem as $value2){

                    $logExists = false;

                    foreach($logs as $value){
                        if(date("j a", strtotime($value->datetime)) == ($i . " " . $value2)){
                            $logs2[] = $value;
                            $logExists = true;
                            break;
                        }
                    }

                    if(!$logExists){

                        $log = new stdClass();
                        $log->id = 0;
                        $log->title = "--- --- ---";
                        $log->text = "--- --- ---";

                        $log->datetime = date("Y-m-d H:i:s", strtotime($month_year_exploded[0] . " " . $i . " " . $month_year_exploded[1] . " 06:00 " . $value2));
                        $logs2[] = $log;
                    }
                }
            }
        }else{
            $logs2 = $this->log_model->get_all_order_by('datetime', 'ASC');
        }

        $vars['logs'] = $logs2;
        $vars['month_year_filter_selections'] = $month_year_filter_selections_reversed;
        $vars['month_year_filter'] = $month_year;

        $this->render('v_list', $vars);
    }

    public function create($time = "") {
        $vars['action'] = site_url('logs/save');
        
        if($time != ""){
            $vars['time'] = $time;
        }
        
        $this->render('v_form', $vars);
    }

    public function save($id = '') {

        if (!$this->input->post()) {
            redirect('logs/create');
            return;
        }

        $this->load->library('form_validation');

        $this->form_validation->set_rules('title', 'Title', 'required|xss_clean');
        $this->form_validation->set_rules('text', 'Logs', 'required|xss_clean');
        $this->form_validation->set_rules('datetime', 'Date and Time', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->notify_error(validation_errors(), false);
            $this->create();
            return;
        }
        
        $wholeday = $this->input->post('wholeday');
        $datetime = $this->input->post('datetime');
        
        $data = array();
        $data['title'] = $this->input->post('title');
        $data['text'] = $this->input->post('text');
        
        if(isset($wholeday) && $wholeday == "on"){
            
            $a_datetime = explode(" ", $datetime);
            
            $times = array("06:00:00", "18:00:00");
            
            foreach($times as $time){
                $data['datetime'] = $a_datetime[0] . " " . $time;
                $this->log_model->insert($data);
            }
            
            $this->notify_success('Logs Successfully Created!');
            
        }else{
            $data['datetime'] = $datetime;

            if ($id === '') {
                $this->log_model->insert($data);
                $this->notify_success('Log Successfully Created!');
            } else {
                $this->log_model->update($id, $data);
                $this->notify_success('Log Successfully Updated!');
            }
        }

        redirect('logs/index/latest');
    }

    public function delete($id) {
        $this->log_model->delete($id);

        $this->notify_success('Log Successfully Deleted!');

        redirect('logs/index/latest');
    }

    public function edit($id) {

        $vars['action'] = site_url('logs/save/' . $id);
        $vars['log'] = $this->log_model->get($id);

        $this->render('v_form', $vars);
    }

    public function duplicate($id) {

        $vars['action'] = site_url('logs/save/');
        $vars['log'] = $this->log_model->get($id);

        $this->render('v_form', $vars);
    }

    public function export($month_year) {

        $this->load->library('excel');
        $this->excel->setActiveSheetIndex(0);

        $logs = $this->log_model->get_all_order_by('datetime', 'ASC', array('month_and_year' => $month_year));

        foreach ($logs as $key => $log) {

            $this->excel->getActiveSheet()->setCellValue('A' . ($key + 1), date('F d, Y h:i:s a', strtotime($log->datetime)));
            $this->excel->getActiveSheet()->getStyle('A' . ($key + 1))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER)->setWrapText(TRUE);

            $this->excel->getActiveSheet()->setCellValue('B' . ($key + 1), $log->title . ": " . $log->text);
            $this->excel->getActiveSheet()->getStyle('B' . ($key + 1))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER)->setWrapText(TRUE);

            //$this->excel->getActiveSheet()->mergeCells('B' . ($key + 1) . ':F' . ($key + 1));
        }

        //$this->excel->getActiveSheet()->getRowDimension('2')->setRowHeight(-1);
        $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
        $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(150);
        
        //$this->excel->getActiveSheet()->getStyle('B')->getFont()->setName('Arial')->setSize(20);

        /* //change the font size
          $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(20);
          //make the font become bold
          $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
          //merge cell A1 until D1
          $this->excel->getActiveSheet()->mergeCells('A1:D1');
         */

        $filename = 'export.xls'; 

        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="' . $filename . '"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache
        //
        //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
        //if you want to save it as .XLSX Excel 2007 format
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
        //force user to download the Excel file without writing it to server's HD
        $objWriter->save('php://output');
    }

}
