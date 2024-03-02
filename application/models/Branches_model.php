<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Branches_model extends MY_Model {

    protected $table = 'tbl_branches';

    public function __construct() {
        parent::__construct();
    }

    public function add_branch($data) {
        return $this->insert($this->table, $data);
    }

    public function update($data, $where) {
        return $this->edit($this->table, $data, $where);
    }

    public function delete_branch($branch_id) {
        $tables = array($this->table);
        $where = array(
            'branch_id' => $branch_id
        );
        return $this->delete($tables, $where);
    }

    public function get_branch_name($branch_id) {
        $sql = "SELECT branch_name FROM tbl_branches WHERE branch_id = ".$branch_id;
        $query = $this->db->query($sql);
        return $query->row();;
    }

}
