<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Add_loans extends CI_Migration {

    public function up() {
        $this->dbforge->add_field(array(
            'loan_id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ),
            'emp_id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => false,
            ),
            'loan_amount' => array(
                'type' => 'DOUBLE',
                'null' => false,
            ),
            'loan_period' => array(
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => false,
            ),
            'outstanding_balance' => array(
                'type' => 'DOUBLE',
                'null' => false,
            ),
            'loan_installment' => array(
                'type' => 'DOUBLE',
                'null' => false,
            ),
            'settlement_amount' => array(
                'type' => 'DOUBLE',
                'null' => false,
                'default' => 0
            ),
            'loan_status' => array(
                'type' => 'ENUM("0", "1", "2")',
                'comment' => '0=active , 1=settled, 2=revolved',
                'null' => false,
            ),
            'created datetime default current_timestamp',
        ));

        $this->dbforge->add_key('loan_id', true);
        $this->dbforge->create_table('tbl_loans');
    }

    public function down() {
        $this->dbforge->drop_table('tbl_loans');
    }

}
