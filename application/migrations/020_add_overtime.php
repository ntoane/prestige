<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Add_overtime extends CI_Migration
{

    public function up()
    {
        $this->dbforge->add_field(array(
            'overtime_id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ),
            'num_days' => array(
                'type' => 'INT',
                'constraint' => '11',
                'null' => false,
            ),
            'amount' => array(
                'type' => 'DOUBLE',
                'null' => false,
            ),
            'pay_month' => array(
                'type' => 'VARCHAR',
                'constraint' => '20',
                'null' => false,
            ),
            'emp_id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => false,
            ),
            'created datetime default current_timestamp',
        ));

        $this->dbforge->add_key('overtime_id', true);
        $this->dbforge->create_table('tbl_overtime');
    }

    public function down()
    {
        $this->dbforge->drop_table('tbl_overtime');
    }

}