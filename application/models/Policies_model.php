<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Policies_model extends MY_Model {

    protected $table = 'tbl_policies';

    public function __construct() {
        parent::__construct();
    }

    public function add_policy($data) {
        return $this->insert($this->table, $data);
    }

    public function update($data, $where) {
        return $this->edit($this->table, $data, $where);
    }

    public function delete_policy($policy_id) {
        $tables = array($this->table);
        $where = array(
            'policy_id' => $policy_id
        );
        return $this->delete($tables, $where);
    }

}
