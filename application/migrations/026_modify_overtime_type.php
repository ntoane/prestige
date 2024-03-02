<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Modify_overtime_type extends CI_Migration {
    
    public function up() {
        $this->dbforge->add_column('tbl_overtime', array(
            'overtime_type' => array(
                'type' => 'ENUM("overtime", "sunday_pay")',
                'default' => 'overtime',
                'after' => 'emp_id'
            )
        ));
    }

    public function down() {
        $this->dbforge->drop_column('tbl_overtime', 'overtime_type');
    }

}
