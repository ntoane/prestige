<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Modify_loan_type extends CI_Migration {

    public function up() {
        $this->dbforge->add_column('tbl_loans', array(
            'loan_type' => array(
                'type' => 'ENUM("loan", "allowance", "deduction")',
                'default' => 'loan'
            )
        ));
        $this->dbforge->add_column('tbl_loans', array(
            'debt_label' => array(
                'type' => 'VARCHAR',
                'constraint' => '30',
                'null' => false,
                'default' => 'Loan Deduction'
            )
            ));
    }

    public function down() {
        $this->dbforge->drop_column('tbl_loans', 'loan_type');
        $this->dbforge->drop_column('tbl_loans', 'debt_label');
    }

}
