<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Add_salary_payment extends CI_Migration
{

    public function up()
    {
        $this->dbforge->add_field(array(
            'salary_payment_id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ),
            'emp_id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ),
            'payment_month' => array(
                'type' => 'VARCHAR',
                'constraint' => '20',
                'null' => false,
            ),
            'base_salary' => array(
                'type' => 'DOUBLE',
                'default' => 0,
                'null' => false,
            ),
            'business_commission' => array(
                'type' => 'DOUBLE',
                'default' => 0,
                'null' => false,
            ),
            'recurring_commission' => array(
                'type' => 'DOUBLE',
                'default' => 0,
                'null' => false,
            ),
            'long_term' => array(
                'type' => 'DOUBLE',
                'default' => 0,
                'null' => false,
            ),
            'short_term' => array(
                'type' => 'DOUBLE',
                'default' => 0,
                'null' => false,
            ),
            'tax' => array(
                'type' => 'DOUBLE',
                'default' => 0,
                'null' => false,
            ),
            'fine_deduction' => array(
                'type' => 'DOUBLE',
                'default' => 0,
                'null' => false,
            ),
            'loan_deduction' => array(
                'type' => 'DOUBLE',
                'default' => 0,
                'null' => false,
                'comment' => 'loan installment',
            ),
            'allowance' => array(
                'type' => 'DOUBLE',
                'default' => 0,
                'null' => false,
            ),
            'net_amount' => array(
                'type' => 'DOUBLE',
                'default' => 0,
                'null' => false,
            ),
            'payment_type' => array(
                'type' => 'VARCHAR',
                'constraint' => '20',
                'null' => false,
            ),
            'comments' => array(
                'type' => 'TEXT',
                'null' => true,
            ),
            'paid_date datetime default current_timestamp',
        ));

        $this->dbforge->add_key('salary_payment_id', true);
        $this->dbforge->create_table('tbl_salary_payment');
    }

    public function down()
    {
        $this->dbforge->drop_table('tbl_salary_payment');
    }

}