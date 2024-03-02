<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Modify_salary_deduction extends CI_Migration
{

    public function up()
    {
        $this->dbforge->drop_column('tbl_salary_deduction', 'deduction_month');
        $this->dbforge->add_column('tbl_salary_deduction', array(
            'deduction_status' => array(
                'type' => 'INT',
                'constraint' => '2',
                'default' => 1,
            ),
        ));
    }

    public function down()
    {
        $this->dbforge->drop_column('tbl_salary_deduction', 'deduction_status');
        $this->dbforge->add_column('tbl_salary_deduction', array(
            'deduction_month' => array(
                'type' => 'VARCHAR',
                'constraint' => '10',
                'null' => false,
            ),
        ));
    }

}