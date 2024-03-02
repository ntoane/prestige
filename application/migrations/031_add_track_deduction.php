<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Add_track_deduction extends CI_Migration
{

    public function up()
    {
        $this->dbforge->add_field(array(
            'deduction_id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'null' => false,
            ),
            'pay_month' => array(
                'type' => 'VARCHAR',
                'constraint' => '20',
                'null' => false,
            ),
            'created datetime default current_timestamp',
        ));

        $this->dbforge->add_key('deduction_id', true);
        $this->dbforge->add_key('pay_month', true);
        $this->dbforge->create_table('tbl_track_deduction');
    }

    public function down()
    {
        $this->dbforge->drop_table('tbl_track_deduction');
    }
}