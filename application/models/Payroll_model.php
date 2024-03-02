<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Payroll_model extends MY_Model
{

    public $salary_deduction = 'tbl_salary_deduction';
    public $salary_allowance = 'tbl_salary_allowance';
    public $salary_payment = 'tbl_salary_payment';

    public function __construct()
    {
        parent::__construct();
    }

    public function is_employee_paid($emp_id, $month)
    {
        $sql = "SELECT count(*) AS total FROM tbl_salary_payment WHERE emp_id = " . $emp_id . " AND payment_month = '" . $month . "'";
        $query = $this->db->query($sql);
        if ($query->row('total') > 0) {
            return true;
        }
        return false;
    }

    public function is_payment_approved($emp_id, $month)
    {
        $sql = "SELECT approve FROM tbl_salary_payment WHERE emp_id = " . $emp_id . " AND payment_month = '" . $month . "'";
        $query = $this->db->query($sql);
        if ($query->row('approve') == 1) {
            return true;
        }
        return false;
    }
    /* payslip */
    public function get_payslip($emp_id, $payment_month)
    {
        $sql = "SELECT * FROM tbl_salary_payment WHERE emp_id = " . $emp_id . " AND payment_month = '" . $payment_month . "' AND approve = '1' ";
        $query = $this->db->query($sql);
        return $query->row();
    }

    public function get_all_payslip($branch_id, $payment_month)
    {
        if ($branch_id > 0) {
            $sql = "SELECT *, e.emp_id, e.branch_id, p.long_term as long_t, p.short_term as short_t FROM tbl_salary_payment p INNER JOIN tbl_employees e ON p.emp_id = e.emp_id
                WHERE  p.payment_month = '" . $payment_month . "' AND e.branch_id = " . $branch_id . " AND p.approve = '1' ";
        } else {
            $sql = "SELECT *, e.emp_id, e.branch_id, p.long_term as long_t, p.short_term as short_t FROM tbl_salary_payment p INNER JOIN tbl_employees e ON p.emp_id = e.emp_id
                WHERE  p.payment_month = '" . $payment_month . "' AND p.approve = '1' ";
        }
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    /* deductions */

    public function add_salary_deduction($data)
    {
        $this->db->insert($this->salary_deduction, $data);
        return $this->db->insert_id();
    }

    public function edit_salary_deduction($where, $data)
    {
        $this->db->update($this->salary_deduction, $data, $where);
        return $this->db->affected_rows();
    }

    public function delete_salary_deduction($id)
    {
        $this->db->where('deduction_id', $id);
        return $this->db->delete($this->salary_deduction);
        // return true;
    }

    public function get_salary_deduction($id)
    {
        $sql = "SELECT * FROM tbl_salary_deduction WHERE deduction_id = " . $id;
        $query = $this->db->query($sql);
        return $query->row();
    }

    public function get_active_salary_deductions($emp_id)
    {
        $sql = "SELECT * FROM tbl_salary_deduction WHERE emp_id = " . $emp_id . " AND deduction_status = 1";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function get_active_sum_of_deductions($emp_id)
    {
        $sql = "SELECT SUM(deduction_value) AS total_sum FROM tbl_salary_deduction WHERE emp_id = " . $emp_id . " AND deduction_status = 1";
        $query = $this->db->query($sql);
        return ($query->row('total_sum') > 0) ? $query->row('total_sum') : 0;
    }

    public function get_salary_deductions($emp_id)
    {
        $sql = "SELECT * FROM tbl_salary_deduction WHERE emp_id = " . $emp_id;
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function get_payslip_deductions($emp_id, $pay_month)
    {
        $sql = "SELECT * FROM tbl_salary_deduction sd INNER JOIN tbl_track_deduction td ON sd.deduction_id = td.deduction_id
		 WHERE sd.emp_id = " . $emp_id . " AND td.pay_month = '" . $pay_month . "'";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    /* end deductions */

    /* allowances */

    public function add_salary_allowance($data)
    {
        $this->db->insert($this->salary_allowance, $data);
        return $this->db->insert_id();
    }

    public function edit_salary_allowance($where, $data)
    {
        $this->db->update($this->salary_allowance, $data, $where);
        return $this->db->affected_rows();
    }

    public function delete_salary_allowance($id)
    {
        $this->db->where('allowance_id', $id);
        return $this->db->delete($this->salary_allowance);
        // return true;
    }

    public function get_salary_allowance($id)
    {
        $sql = "SELECT * FROM tbl_salary_allowance WHERE allowance_id = " . $id;
        $query = $this->db->query($sql);
        return $query->row();
    }

    public function get_active_salary_allowances($emp_id)
    {
        $sql = "SELECT * FROM tbl_salary_allowance WHERE emp_id = " . $emp_id . " AND allowance_status = 1";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function get_active_sum_of_allowances($emp_id)
    {
        $sql = "SELECT SUM(allowance_value) AS total_sum FROM tbl_salary_allowance WHERE emp_id = " . $emp_id . " AND allowance_status = 1";
        $query = $this->db->query($sql);
        return ($query->row('total_sum') > 0) ? $query->row('total_sum') : 0;
    }

    public function get_salary_allowances($emp_id)
    {
        $sql = "SELECT * FROM tbl_salary_allowance WHERE emp_id = " . $emp_id;
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function get_payslip_allowances($emp_id, $pay_month)
    {
        $sql = "SELECT * FROM tbl_salary_allowance sa INNER JOIN tbl_track_allowance ta ON sa.allowance_id = ta.allowance_id
		 WHERE sa.emp_id = " . $emp_id . " AND ta.pay_month = '" . $pay_month . "'";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    /* end allowance */

    public function edit_salary_payment($data, $where)
    {
        $this->db->update($this->salary_payment, $data, $where);
        return $this->db->affected_rows();
    }

    /* Short term */
    public function get_short_term_balance($emp_id, $pay_month)
    {
        $dismantled = explode("-", $pay_month);
        $year = $dismantled[1];
        $sql = "SELECT SUM(short_term) AS short_term_balance FROM tbl_salary_payment WHERE approve = '1' AND emp_id = " . $emp_id . " AND payment_month LIKE '%$year'";
        $query = $this->db->query($sql);
        return ($query->row('short_term_balance') > 0) ? $query->row('short_term_balance') : 0;
    }

    public function get_short_term($emp_id, $pay_month)
    {
        $dismantled = explode("-", $pay_month);
        $year = $dismantled[1];
        $sql = "SELECT short_term FROM tbl_salary_payment WHERE approve = '1' AND emp_id = " . $emp_id . " AND payment_month LIKE '%$year'";
        $query = $this->db->query($sql);
        return ($query->row('short_term') > 0) ? $query->row('short_term') : 0;
    }

    /* Overtime */
    public function get_overtimes($emp_id, $month)
    {
        $sql = "SELECT * FROM tbl_overtime WHERE emp_id = " . $emp_id . " AND pay_month = '" . $month . "' AND overtime_type = 'overtime'";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function get_sum_of_overtimes($emp_id, $month)
    {
        $sql = "SELECT SUM(amount) AS total_sum FROM tbl_overtime WHERE emp_id = " . $emp_id . " AND pay_month = '" . $month . "' AND overtime_type = 'overtime'";
        $query = $this->db->query($sql);
        return ($query->row('total_sum') > 0) ? $query->row('total_sum') : 0;
    }

    public function delete_overtime($id)
    {
        $this->db->where('overtime_id', $id);
        return $this->db->delete('tbl_overtime');
        // return true;
    }

    /* Sunday pay */
    public function get_sundaypays($emp_id, $month)
    {
        $sql = "SELECT * FROM tbl_overtime WHERE emp_id = " . $emp_id . " AND pay_month = '" . $month . "' AND overtime_type = 'sunday_pay'";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function get_sum_of_sundaypays($emp_id, $month)
    {
        $sql = "SELECT SUM(amount) AS total_sum FROM tbl_overtime WHERE emp_id = " . $emp_id . " AND pay_month = '" . $month . "' AND overtime_type = 'sunday_pay'";
        $query = $this->db->query($sql);
        return ($query->row('total_sum') > 0) ? $query->row('total_sum') : 0;
    }

    public function delete_sundaypay($id)
    {
        $this->db->where('overtime_id', $id);
        return $this->db->delete('tbl_overtime');
        // return true;
    }

    //Year to date of short and long term
    public function get_sum_of_long_term($emp_id, $pay_month)
    {
        $id_record = $this->get_row("SELECT salary_payment_id FROM tbl_salary_payment WHERE emp_id = " . $emp_id . " AND payment_month = '" . $pay_month . "'");
        if (!empty($id_record)) {
            $id = $id_record->salary_payment_id;
            $sql = "SELECT SUM(long_term) AS total_sum FROM tbl_salary_payment WHERE (emp_id = " . $emp_id . " AND approve ='1' ) AND (payment_month = 'Mar-2021'  OR salary_payment_id <= " . $id.")";
            $query = $this->db->query($sql);
            return ($query->row('total_sum') > 0) ? $query->row('total_sum') : 0;
        }
        return 0;
    }

    public function get_sum_of_short_term($emp_id, $pay_month)
    {
        $id_record = $this->get_row("SELECT salary_payment_id FROM tbl_salary_payment WHERE emp_id = " . $emp_id . " AND payment_month = '" . $pay_month . "'");
        if (!empty($id_record)) {
            $id = $id_record->salary_payment_id;
            $sql = "SELECT SUM(short_term) AS total_sum FROM tbl_salary_payment WHERE (emp_id = " . $emp_id . " AND approve ='1' ) AND (payment_month = 'Mar-2021'  OR salary_payment_id <= " . $id.")";
            $query = $this->db->query($sql);
            return ($query->row('total_sum') > 0) ? $query->row('total_sum') : 0;
        }
        return 0;
    }

    // public function get_sum_of_short_term($emp_id)
    // {
    //     $sql = "SELECT short_term FROM tbl_salary_payment WHERE emp_id = " . $emp_id . " AND approve ='1' ORDER BY salary_payment_id ASC";
    //     $query = $this->db->query($sql);
    //     $short_terms = $query->result_array();
    //     $total = 0;
    //     foreach ($short_terms as $short) {
    //         if ($short['short_term'] == 0) {
    //             $total = 0;
    //         } else {
    //             $total += $short['short_term'];
    //         }
    //     }
    //     return $total;
    // }

}