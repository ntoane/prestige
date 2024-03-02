<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Add_user_activities extends CI_Migration {

    public function up() {
        $this->dbforge->add_field(array(
            'activity_id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ),
            'activity_title' => array(
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => false,
            ),
            'activity_description' => array(
                'type' => 'TEXT',
                'null' => false,
            ),
            'user_id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'null' => false,
            ),
            'created datetime default current_timestamp'
        ));

        $this->dbforge->add_key('activity_id', true);
        $this->dbforge->create_table('tbl_user_activities');
    }

    public function down() {
        $this->dbforge->drop_table('tbl_user_activities');
    }

}
