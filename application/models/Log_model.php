<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of logs_model
 *
 * @author ozyhale
 */
class Log_model extends MY_Model {

    public function get_all_order_by($orderby, $direction, $params = array()) {

        if (isset($params['month_and_year']) && $params['month_and_year'] != "") {

            $month_year_exploded = explode('-', $params['month_and_year']);

            $this->db->where('MONTHNAME(datetime)', ucfirst($month_year_exploded[0]));
            $this->db->where('YEAR(datetime)', $month_year_exploded[1]);
        }
        
        if(isset($params['starttime']) && isset($params['endtime']) && $params['starttime'] != "" && $params['endtime'] != ""){
            $this->db->where("datetime BETWEEN '" . $params['starttime'] . "' AND '" . $params['endtime'] . "'");
        }

        $this->db->order_by($orderby, $direction);
        $query = $this->db->get($this->_table);
        return $query->result();
    }

}
