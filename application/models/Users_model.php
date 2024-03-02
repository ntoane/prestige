<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Users_model extends MY_Model {

    protected $table = 'tbl_users';

    public function __construct() {
        parent::__construct();
    }

    public function add_user($data) {
        return $this->insert($this->table, $data);
    }

    public function add_activity($data) {
        return $this->insert('tbl_user_activities', $data);
    }

    public function update($data, $where) {
        return $this->edit($this->table, $data, $where);
    }

    public function delete_user($user_id) {
        $tables = array($this->table);
        $where = array(
            'user_id' => $user_id
        );
        return $this->delete($tables, $where);
    }

    public function get_user_by_credentials($email, $password) {
        $sql = "SELECT * FROM tbl_users WHERE email = '" . $email . "' and password = '" . $password . "'";
        $query = $this->db->query($sql);
        return $query->row();
    }

}
