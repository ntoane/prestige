<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Employees_model extends MY_Model {

    protected $table = 'tbl_employees';

    public function __construct() {
        parent::__construct();
    }

    public function add_employee($data) {
        return $this->insert($this->table, $data);
    }

    public function update($data, $where) {
        return $this->edit($this->table, $data, $where);
    }

    public function delete_employee($emp_id) {
        $tables = array($this->table);
        $where = array(
            'emp_id' => $emp_id
        );
        return $this->delete($tables, $where);
    }
    
    public function get_position($position_id) {
       /* if($position == 0) {
            return 'Consultant';
        } else if($position == 1) {
            return 'Supervisor';
        } else if($position == 2) {
            return 'Manager';
        } else {
            return 'Other';
        }*/
        $sql = "SELECT position_name FROM tbl_positions WHERE position_id = ".$position_id;
        $query = $this->db->query($sql);
        return $query->row();
    }

    public function get_fullname($emp_id) {
        $sql = "SELECT fullname FROM tbl_employees WHERE emp_id = ".$emp_id;
        $query = $this->db->query($sql);
        return $query->row();
    }

    public function get_emp_number($emp_id) {
        $sql = "SELECT emp_number FROM tbl_employees WHERE emp_id = ".$emp_id;
        $query = $this->db->query($sql);
        return $query->row()->emp_number;
    }

    public function get_emp_details($emp_id){
        $sql = "SELECT * FROM tbl_employees e INNER JOIN tbl_positions p ON e.position_id = p.position_id WHERE emp_id = ".$emp_id;
        $query = $this->db->query($sql);
        return $query->row();
    }

    public function format_emp_id($emp_id){
        $emp_id_return = "0";
        if($emp_id < 10){
            $emp_id_return = "00".$emp_id;
        }else if($emp_id < 100 && $emp_id > 9){
            $emp_id_return = "0".$emp_id;
        }else{
            $emp_id_return = $emp_id;
        }

        return $emp_id_return;
    }

}
