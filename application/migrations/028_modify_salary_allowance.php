<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Modify_salary_allowance extends CI_Migration
{

    public function up()
    {
        $this->dbforge->drop_column('tbl_salary_allowance', 'allowance_month');
        $this->dbforge->add_column('tbl_salary_allowance', array(
            'allowance_status' => array(
                'type' => 'INT',
                'constraint' => '2',
                'default' => 1,
            ),
        ));
    }

    public function down()
    {
        $this->dbforge->drop_column('tbl_salary_allowance', 'allowance_status');
        $this->dbforge->add_column('tbl_salary_allowance', array(
            'allowance_month' => array(
                'type' => 'VARCHAR',
                'constraint' => '10',
                'null' => false,
            ),
        ));
    }

}