<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class User_access_model extends MY_Model {

    protected $table_role = 'tbl_user_types';
    protected $table_access = 'tbl_user_type_access';

    public function __construct() {
        parent::__construct();
    }

    public function add_role($data) {
        return $this->insert($this->table_role, $data);
    }

    public function add_access($data) {
        return $this->insert($this->table_access, $data);
    }

    public function update_role($data, $where) {
        return $this->edit($this->table_role, $data, $where);
    }

    public function update_access($data, $where) {
        return $this->edit($this->table_access, $data, $where);
    }

    public function delete_role($user_type_id) {
        $tables = array($this->table_role);
        $where = array(
            'user_type_id' => $user_type_id
        );
        return $this->delete($tables, $where);
    }

    public function delete_access($user_type_access_id) {
        $tables = array($this->table_access);
        $where = array(
            'user_type_access_id' => $user_type_access_id
        );
        return $this->delete($tables, $where);
    }

    public function delete_access_role($user_type_id) {
        $tables = array($this->table_access);
        $where = array(
            'user_type_id' => $user_type_id
        );
        return $this->delete($tables, $where);
    }

}
