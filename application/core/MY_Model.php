<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function insert($table, $data) {
        $this->db->insert($table, $data);
        return $this->db->insert_id();
    }

    public function edit($table, $data, $where) {
        $this->db->update($table, $data, $where);
        return $this->db->affected_rows();
    }

    public function delete($tables, $where) {
        $this->db->where($where);
        $this->db->delete($tables);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function get_count($table) {
        return $this->db->count_all($table);
    }

    public function get_row($sql) {
        $query = $this->db->query($sql);
        return $query->row();
    }

    public function get_array($sql) {
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function add_activity($data) {
        return $this->insert('tbl_user_activities', $data);
    }

}
