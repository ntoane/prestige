<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Modify_loan_status extends CI_Migration
{

    public function up()
    {
        $this->dbforge->modify_column('tbl_loans', array(
            'loan_status' => array(
                'type' => 'ENUM("0", "1", "2", "3")',
                'comment' => '0=active , 1=settled, 2=revolved, 3=relieve',
                'null' => false,
            ),
        ));
    }

    public function down()
    {
        $this->dbforge->modify_column('tbl_loans', array(
            'loan_status' => array(
                'type' => 'ENUM("0", "1", "2")',
                'comment' => '0=active , 1=settled, 2=revolved',
                'null' => false,
            ),
        ));
    }

}