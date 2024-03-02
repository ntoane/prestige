<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Add_user_roles extends CI_Migration
{

    public function up()
    {
        $this->dbforge->add_field(array(
            'user_type_id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ),
            'role' => array(
                'type' => 'VARCHAR',
                'constraint' => '30',
                'null' => false,
            ),
        ));

        $this->dbforge->add_key('user_type_id', true);
        $this->dbforge->create_table('tbl_user_types');

        foreach ($this->seedData as $seed) {
            $sql = "INSERT INTO tbl_user_types (`role`) VALUES " . $seed;
            $this->db->query($sql);
        }
    }

    public function down()
    {
        $this->dbforge->drop_table('tbl_user_types');
    }

    private $seedData = array(
        '("System Developer")',
        '("ICT Director")',
        '("System Admin")',
        '("Accountant")',
        '("General Manager")',
        '("CEO")',
    );

}