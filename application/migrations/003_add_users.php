<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Add_users extends CI_Migration {

    public function up() {
        $this->dbforge->add_field(array(
            'user_id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ),
            'fullname' => array(
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => false,
            ),
            'email' => array(
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => false,
            ),
            'password' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => false,
            ),
            'password_changed' => array(
                'type' => 'ENUM("0","1")',
                'default' => "0",
                'null' => false,
            ),
            'banned' => array(
                'type' => 'ENUM("0","1")',
                'default' => "0",
                'null' => false,
            ),
            'ban_reason' => array(
                'type' => 'TEXT',
                'null' => false,
            ),
            'user_type_id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'null' => true,
            ),
            'created_at datetime default current_timestamp',
        ));

        $this->dbforge->add_key('user_id', true);
        $this->dbforge->create_table('tbl_users');

        $password = password_hash('user12345', PASSWORD_BCRYPT);
        $password1 = password_hash('user123', PASSWORD_BCRYPT);

        $sql = "INSERT INTO tbl_users (`fullname`, `email`, `password`, `user_type_id`) VALUES "
                . "('System Developer','developer@admin.com','$password','1')";
        $this->db->query($sql);

        $sql1 = "INSERT INTO tbl_users (`fullname`, `email`, `password`, `user_type_id`) VALUES "
                . "('Monosi','monosi@sentebalefunerals.co.ls','$password1','3')";
        $this->db->query($sql1);
    }

    public function down() {
        $this->dbforge->drop_table('tbl_users');
    }

}
