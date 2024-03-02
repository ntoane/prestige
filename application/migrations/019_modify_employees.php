<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Modify_Employees extends CI_Migration
{

    public function up()
    {
        $this->dbforge->add_column('tbl_employees', array(
            'emp_number' => array(
                'type' => 'VARCHAR',
                'constraint' => '20',
                'null' => true,
            ),
        ));
    }

    public function down()
    {
        $this->dbforge->drop_column('tbl_employees', 'emp_number');
    }

}