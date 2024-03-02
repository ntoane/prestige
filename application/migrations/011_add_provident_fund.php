<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Add_provident_fund extends CI_Migration {

    public function up() {
        $this->dbforge->add_field(array(
            'provident_fund_id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ),
            'short_term' => array(
                'type' => 'DOUBLE',
                'null' => false,
            ),
            'long_term' => array(
                'type' => 'DOUBLE',
                'null' => false,
            )
        ));

        $this->dbforge->add_key('provident_fund_id', true);
        $this->dbforge->create_table('tbl_provident_fund');
    }

    public function down() {
        $this->dbforge->drop_table('tbl_provident_fund');
    }

}
