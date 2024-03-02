<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Modify_employee_designation extends CI_Migration {

    public function up() {
        $this->dbforge->drop_column('tbl_employees', 'designation_id');
    }

    public function down() {
        $this->dbforge->add_column('tbl_employees', array(
            'designation_id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            )
        ));
    }

}
