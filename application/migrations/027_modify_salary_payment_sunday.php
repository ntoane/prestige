<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Modify_salary_payment_sunday extends CI_Migration
{
    
    public function up()
    {
        $this->dbforge->add_column('tbl_salary_payment', array(
            'sunday_pay' => array(
                'type' => 'DOUBLE',
                'default' => 0,
                'null' => false,
            ),
        ));
    }

    public function down()
    {
        $this->dbforge->drop_column('tbl_salary_payment', 'sunday_pay');
    }

}