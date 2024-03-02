<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Add_employees extends CI_Migration
{

    public function up()
    {
        $this->dbforge->add_field(array(
            'emp_id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ),
            'national_id' => array(
                'type' => 'VARCHAR',
                'constraint' => '20',
                'null' => false,
            ),
            'fullname' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => false,
            ),
            'gender' => array(
                'type' => 'VARCHAR',
                'constraint' => '10',
                'null' => false,
            ),
            'date_of_birth' => array(
                'type' => 'DATETIME',
                'null' => false,
            ),
            'phone' => array(
                'type' => 'VARCHAR',
                'constraint' => '20',
                'null' => false,
            ),
            'email' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => false,
            ),
            'position_id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'comment' => '1=consultant , 2=supervisor, 3=manager, 4=other',
            ),
            'designation_id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ),
            'branch_id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ),
            'supervisor_id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ),
            'manager_id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ),
            'base_salary' => array(
                'type' => 'DOUBLE',
                'null' => true,
            ),
            'bank_name' => array(
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => true,
            ),
            'bank_account' => array(
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => true,
            ),
            'branch_code' => array(
                'type' => 'VARCHAR',
                'constraint' => '20',
                'null' => true,
            ),
            'bank_account_type' => array(
                'type' => 'VARCHAR',
                'constraint' => '10',
                'null' => true,
            ),
            'long_term' => array(
                'type' => 'DOUBLE',
                'null' => false,
                'default' => 0,
                'comment' => 'in %',
            ),
            'short_term' => array(
                'type' => 'DOUBLE',
                'null' => false,
                'default' => 0,
                'comment' => 'static amount',
            ),
            'active' => array(
                'type' => 'ENUM("0", "1")',
                'default' => '1',
                'comment' => '0=inactive , 1=active',
            ),
            'inactive_reason' => array(
                'type' => 'TEXT',
                'null' => true,
            ),
            'created datetime default current_timestamp',
        ));

        $this->dbforge->add_key('emp_id', true);
        $this->dbforge->create_table('tbl_employees');
    }

    public function down()
    {
        $this->dbforge->drop_table('tbl_employees');
    }

}