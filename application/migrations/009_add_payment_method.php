<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Add_payment_method extends CI_Migration {

    public function up() {
        $this->dbforge->add_field(array(
            'method_id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ),
            'name' => array(
                'type' => 'VARCHAR',
                'constraint' => '30',
                'null' => false,
            )
        ));

        $this->dbforge->add_key('method_id', true);
        $this->dbforge->create_table('tbl_payment_method');

        foreach ($this->seedData as $seed) {
            $sql = "INSERT INTO tbl_payment_method (`name`) VALUES " . $seed;
            $this->db->query($sql);
        }
    }

    public function down() {
        $this->dbforge->drop_table('tbl_payment_method');
    }

    private $seedData = array(
        '("Bank")',
        '("Cash")',
        '("Other")'
    );

}
