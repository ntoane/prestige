<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Add_branches extends CI_Migration {

    public function up() {
        $this->dbforge->add_field(array(
            'branch_id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ),
            'branch_code' => array(
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => false,
            ),
            'branch_name' => array(
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => false,
            ),
            'branch_district' => array(
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => false,
            )
        ));

        $this->dbforge->add_key('branch_id', true);
        $this->dbforge->create_table('tbl_branches');

        foreach ($this->seedData as $seed) {
            $sql = "INSERT INTO tbl_branches (`branch_code`, `branch_name`, `branch_district`) VALUES " . $seed;
            $this->db->query($sql);
        }
    }

    public function down() {
        $this->dbforge->drop_table('tbl_branches');
    }

    private $seedData = array(
        '("001", "Mohale\'s Hoek", "Mohale\'s Hoek")',
        '("002", "Mafeteng", "Mafeteng")',
        '("003", "Morija", "Maseru")',
        '("004", "Sefika", "Maseru")',
        '("005", "Teyateyaneng", "Berea")',
        '("006", "Sekamaneng", "Maseru")',
        '("007", "Hlotse", "Leribe")',
        '("008", "Thaba-Tseka", "Thaba-Tseka")',
        '("009", "Butha-Buthe", "Butha-Buthe")',
        '("010", "Semonkong", "Maseru")',
        '("010", "Mokhotlong", "Mokhotlong")',
        '("011", "Quthing", "Quthing")',
        '("012", "Qacha\'s Neck", "Qacha\'s Neck")',
    );

}
