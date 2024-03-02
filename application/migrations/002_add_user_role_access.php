<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Add_user_role_access extends CI_Migration
{

    public function up()
    {
        $this->dbforge->add_field(array(
            'user_type_access_id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ),
            'user_type_id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ),
            'class' => array(
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => false,
            ),
            'method' => array(
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => false,
            ),
            'access' => array(
                'type' => 'ENUM("1","2")',
                'null' => false,
            ),
        ));

        $this->dbforge->add_key('user_type_access_id', true);
        $this->dbforge->create_table('tbl_user_type_access');

        foreach ($this->seedData as $seed) {
            $sql = "INSERT INTO tbl_user_type_access (`user_type_id`, `class`, `method`) VALUES " . $seed;
            $this->db->query($sql);
        }

        foreach ($this->seedDataICT as $seed) {
            $sql = "INSERT INTO tbl_user_type_access (`user_type_id`, `class`, `method`) VALUES " . $seed;
            $this->db->query($sql);
        }

        foreach ($this->seedDataAdmin as $seed) {
            $sql = "INSERT INTO tbl_user_type_access (`user_type_id`, `class`, `method`) VALUES " . $seed;
            $this->db->query($sql);
        }
    }

    public function down()
    {
        $this->dbforge->drop_table('tbl_user_type_access');
    }

    private $seedData = array(
        '("1", "dashboard", "*")',
        '("1", "commission", "*")',
        '("1", "loan", "*")',
        '("1", "payroll", "*")',
        '("1", "employees", "*")',
        '("1", "provident", "*")',
        '("1", "users", "*")',
        '("1", "branches", "*")',
        '("1", "designations", "*")',
        '("1", "user_access", "*")',
    );

    private $seedDataAdmin = array(
        '("3", "dashboard", "*")',
        '("3", "commission", "*")',
        '("3", "loan", "*")',
        '("3", "payroll", "*")',
        '("3", "employees", "*")',
        '("3", "provident", "*")',
        '("3", "users", "*")',
        '("3", "branches", "*")',
        '("3", "designations", "*")',
        '("3", "user_access", "*")',
    );

}