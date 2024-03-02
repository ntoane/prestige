<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Modify_salary_payment_approve extends CI_Migration {

    public function up() {
        $this->dbforge->add_column('tbl_salary_payment', array(
            'approve' => array(
                'type' => 'ENUM("0", "1", "2")',
                'default' => '0',
                'comment' => '0=Not approved , 1=Approved, 2=Rejected'
            )
        ));
        $this->dbforge->add_column('tbl_salary_payment', array(
            'reject_reason' => array(
                'type' => 'TEXT',
                'null' => false,
                'default' => null
            )
        ));
    }

    public function down() {
        $this->dbforge->drop_column('tbl_salary_payment', 'approve');
        $this->dbforge->drop_column('tbl_salary_payment', 'reject_reason');
    }

}
