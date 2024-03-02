<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Loan_model extends MY_Model {

    protected $table = 'tbl_loans';

    public function __construct() {
        parent::__construct();
    }

    public function add_loan($data) {
        return $this->insert($this->table, $data);
    }

    public function update_loan($data, $where) {
        return $this->edit($this->table, $data, $where);
    }

    public function delete_loan($loan_id) {
        $tables = array($this->table);
        $where = array(
            'loan_id' => $loan_id
        );
        return $this->delete($tables, $where);
    }

}
