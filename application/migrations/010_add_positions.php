<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Add_positions extends CI_Migration {

    public function up() {
        $this->dbforge->add_field(array(
            'position_id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ),
            'position_name' => array(
                'type' => 'VARCHAR',
                'constraint' => '20',
                'null' => false,
            )
        ));

        $this->dbforge->add_key('position_id', true);
        $this->dbforge->create_table('tbl_positions');

        foreach ($this->seedData as $seed) {
            $sql = "INSERT INTO tbl_positions (`position_name`) VALUES " . $seed;
            $this->db->query($sql);
        }
    }

    public function down() {
        $this->dbforge->drop_table('tbl_positions');
    }

    private $seedData = array(
        '("Consultant")',
        '("Supervisor")',
        '("General Manager")',
        '("Managing Director")',
        '("Director General")',
        '("CEO")'
    );

}
