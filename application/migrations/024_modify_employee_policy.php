<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Modify_employee_policy extends CI_Migration {

    public function up() {
        $this->dbforge->add_column('tbl_employees', array(
            'premium' => array(
                'type' => 'DOUBLE',
                'null' => true,
                'default' => 0,
                'after' => 'short_term'
            )
        ));

        $this->dbforge->add_column('tbl_employees', array(
            'staff_party' => array(
                'type' => 'DOUBLE',
                'null' => true,
                'default' => 0,
                'after' => 'premium'
            )
        ));
    }

    public function down() {
        $this->dbforge->drop_column('tbl_employees', 'premium');
        $this->dbforge->drop_column('tbl_employees', 'staff_party');
    }

}
