<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Add_salary_deduction extends CI_Migration {

    public function up() {
        $this->dbforge->add_field(array(
            'deduction_id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ),
            'deduction_label' => array(
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => false,
            ),
            'deduction_value' => array(
                'type' => 'DOUBLE',
                'null' => false,
            ),
            'deduction_month' => array(
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

        $this->dbforge->add_key('deduction_id', true);
        $this->dbforge->create_table('tbl_salary_deduction');
    }

    public function down() {
        $this->dbforge->drop_table('tbl_salary_deduction');
    }

}
