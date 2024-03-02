<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Modify_consultant_commission extends CI_Migration {

    public function up() {
        $this->dbforge->drop_column('tbl_consultant_commission', 'commission_amount');
        $this->dbforge->add_column('tbl_consultant_commission', array(
            'business_commission' => array(
                'type' => 'DOUBLE',
                'null' => true,
                'default' => 0
            )
        ));

        $this->dbforge->add_column('tbl_consultant_commission', array(
            'recurring_commission' => array(
                'type' => 'DOUBLE',
                'null' => true,
                'default' => 0
            )
        ));
    }

    public function down() {
        $this->dbforge->drop_column('tbl_consultant_commission', 'business_commission');
        $this->dbforge->drop_column('tbl_consultant_commission', 'recurring_commission');
    }

}
