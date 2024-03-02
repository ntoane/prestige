<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Provident_model extends MY_Model {

    protected $table = 'tbl_provident_fund';

    public function __construct() {
        parent::__construct();
    }

    public function add_provident($data) {
        return $this->insert($this->table, $data);
    }

    public function update($data, $where) {
        return $this->edit($this->table, $data, $where);
    }

    public function delete_provident($policy_id) {
        $tables = array($this->table);
        $where = array(
            'provident_fund_id' => $policy_id
        );
        return $this->delete($tables, $where);
    }

    public function get_short_term() {
        $sql = "SELECT short_term FROM tbl_provident_fund";
        $query = $this->db->query($sql);
        return $query->row();;
    }

    public function get_long_term() {
    $sql = "SELECT long_term FROM tbl_provident_fund";
    $query = $this->db->query($sql);
    return $query->row();;
    }

}
