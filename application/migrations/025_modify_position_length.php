<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Modify_position_length extends CI_Migration {
    
    public function up() {
        $this->dbforge->modify_column('tbl_positions', array(
            'position_name' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => false
            )
        ));

    }

    public function down() {
        $this->dbforge->modify_column('tbl_positions', array(
            'position_name' => array(
                'type' => 'VARCHAR',
                'constraint' => '20',
                'null' => false,
            )
        ));
    }

}
