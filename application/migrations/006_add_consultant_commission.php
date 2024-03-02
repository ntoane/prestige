<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Add_consultant_commission extends CI_Migration {

    public function up() {
        $this->dbforge->add_field(array(
            'commission_id' => array(
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
            'commission_amount' => array(
                'type' => 'DOUBLE',
                'null' => false,
            ),
            'commission_month' => array(
                'type' => 'VARCHAR',
                'constraint' => '20',
                'null' => false,
            ),
            'created datetime default current_timestamp',
        ));

        $this->dbforge->add_key('commission_id', true);
        $this->dbforge->create_table('tbl_consultant_commission');
    }

    public function down() {
        $this->dbforge->drop_table('tbl_consultant_commission');
    }

}
