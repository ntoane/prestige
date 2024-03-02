<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Designations_model extends MY_Model {

    protected $table = 'tbl_positions';

    public function __construct() {
        parent::__construct();
    }

    public function add_designation($data) {
        return $this->insert($this->table, $data);
    }

    public function update($data, $where) {
        return $this->edit($this->table, $data, $where);
    }

    public function delete_designation($position_id) {
        $tables = array($this->table);
        $where = array(
            'position_id' => $position_id
        );
        return $this->delete($tables, $where);
    }

    public function get_position_name($position_id) {
        $sql = "SELECT position_name FROM tbl_positions WHERE position_id = ".$position_id;
        $query = $this->db->query($sql);
        return $query->row();;
    }

}
