<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Provident extends CI_Controller
{

    public function index()
    {

    }
    public function long_term()
    {
        $branch_id = $this->uri->segment(3);
        $month = $this->uri->segment(4);

        if (($branch_id >= 0) && ($month != null)) {
            if ($branch_id == 0) {
                $long_term_data = $this->payroll->get_array("SELECT *, s.long_term AS salary_long_term FROM tbl_salary_payment s INNER JOIN tbl_employees e ON s.emp_id = e.emp_id
                 WHERE e.active ='1' AND s.payment_month = '" . $month . "' AND s.approve ='1'");
                $data['branch_id'] = 0;
                $data['branch'] = "All Branches";
            } else {
                $long_term_data = $this->payroll->get_array("SELECT *, s.long_term AS salary_long_term FROM tbl_salary_payment s INNER JOIN tbl_employees e ON s.emp_id = e.emp_id
                 WHERE e.active ='1' AND s.payment_month = '" . $month . "' AND e.branch_id ='" . $branch_id . "' AND s.approve ='1'");
                $branch = $this->employees->get_row("SELECT * FROM tbl_branches WHERE branch_id =" . $branch_id);
                $data['branch'] = $branch->branch_name;
                $data['branch_id'] = $branch_id;
            }
            $data['long_term_data'] = $long_term_data;
            $data['pay_month'] = $month;
            $data['view'] = 'provident/_long_term.php';
            $this->load->view('_layout.php', $data);
        } else {
            $data['branches'] = $this->employees->get_array("SELECT * FROM tbl_branches");
            $data['view'] = 'provident/_long_term_request.php';
            $this->load->view('_layout.php', $data);
        }
    }

    public function individual_long_term()
    {
        if (_is_user_login($this)) {
            $emp_id = $this->uri->segment(3);
            if ($emp_id > 0) {
                $emp_data = $this->employees->get_array("SELECT * FROM tbl_salary_payment WHERE approve ='1' AND emp_id = " . $emp_id);
                $data['emp_data'] = $emp_data;
                $data['emp_id'] = $emp_id;
                $data['view'] = 'provident/_individual_long_term.php';
                $this->load->view('_layout.php', $data);
            }
        }
    }

    public function short_term()
    {
        $branch_id = $this->uri->segment(3);
        $month = $this->uri->segment(4);

        if (($branch_id >= 0) && ($month != null)) {
            if ($branch_id == 0) {
                $short_term_data = $this->payroll->get_array("SELECT *, s.short_term AS salary_short_term FROM tbl_salary_payment s INNER JOIN tbl_employees e ON s.emp_id = e.emp_id
                 WHERE e.active ='1' AND s.payment_month = '" . $month . "' AND s.approve ='1'");
                $data['branch_id'] = 0;
                $data['branch'] = "All Branches";
            } else {
                $short_term_data = $this->payroll->get_array("SELECT *, s.short_term AS salary_short_term FROM tbl_salary_payment s INNER JOIN tbl_employees e ON s.emp_id = e.emp_id
                 WHERE e.active ='1' AND s.payment_month = '" . $month . "' AND e.branch_id ='" . $branch_id . "' AND s.approve ='1'");
                $branch = $this->employees->get_row("SELECT * FROM tbl_branches WHERE branch_id =" . $branch_id);
                $data['branch'] = $branch->branch_name;
                $data['branch_id'] = $branch_id;
            }
            $data['short_term_data'] = $short_term_data;
            $data['pay_month'] = $month;
            $data['view'] = 'provident/_short_term.php';
            $this->load->view('_layout.php', $data);
        } else {
            $data['branches'] = $this->employees->get_array("SELECT * FROM tbl_branches");
            $data['view'] = 'provident/_short_term_request.php';
            $this->load->view('_layout.php', $data);
        }
    }

    public function individual_short_term()
    {
        if (_is_user_login($this)) {
            $emp_id = $this->uri->segment(3);
            if ($emp_id > 0) {
                $emp_data = $this->employees->get_array("SELECT * FROM tbl_salary_payment WHERE approve ='1' AND emp_id = " . $emp_id);
                $data['emp_data'] = $emp_data;
                $data['emp_id'] = $emp_id;
                $data['view'] = 'provident/_individual_short_term.php';
                $this->load->view('_layout.php', $data);
            }
        }
    }

    public function make_short_term_payment()
    {
        if (_is_user_login($this)) {
            $branch_id = $this->uri->segment(3);
            $payment_month = $this->uri->segment(4);
            if (($branch_id >= 0) && ($payment_month != null)) {
                if ($branch_id == 0) {
                    $data['branch_name'] = 'All Branches';
                    $data['branch_id'] = 0;
                    $data['pay_month'] = $payment_month;
                    $data['branch_employees'] = $this->employees->get_array("SELECT * FROM tbl_employees e INNER JOIN tbl_branches b ON e.branch_id = b.branch_id INNER JOIN tbl_positions p ON e.position_id = p.position_id");
                    $data['view'] = 'provident/_make_short_term_payment.php';
                    $this->load->view('_layout.php', $data);
                } else {
                    $branch = $this->branches->get_row("SELECT * FROM tbl_branches WHERE branch_id = " . $branch_id);
                    if (!empty($branch)) {
                        $data['branch'] = $branch;
                        $data['branch_id'] = $branch->branch_id;
                        $data['branch_name'] = $branch->branch_name;
                        $data['pay_month'] = $payment_month;
                        $data['branch_employees'] = $this->employees->get_array("SELECT * FROM tbl_employees e INNER JOIN tbl_branches b ON e.branch_id = b.branch_id INNER JOIN tbl_positions p ON e.position_id = p.position_id WHERE e.branch_id = " . $branch_id);
                        $data['view'] = 'provident/_make_short_term_payment.php';
                        $this->load->view('_layout.php', $data);
                    } else {
                        redirect('provident/make_short_term_payment');
                    }
                }
            } else {
                $data['branches'] = $this->branches->get_array("SELECT * FROM tbl_branches");
                $data['view'] = 'provident/_make_st_payment_request.php';
                $this->load->view('_layout.php', $data);
            }
        }
    }

    public function pay_employee()
    {
        if (_is_user_login($this)) {
            $emp_id = $this->input->post('emp_id');
            $branch_id = $this->input->post('branch_id');
            $payment_month = $this->input->post('payment_month');

            $employee = $this->employees->get_row("SELECT * FROM tbl_employees WHERE emp_id = " . $emp_id);
            if (!empty($employee)) {
                $pay_data = array(
                    "emp_id" => $emp_id,
                    "payment_month" => $payment_month,
                    "base_salary" => 0,
                    "business_commission" => 0,
                    "recurring_commission" => 0,
                    "fine_deduction" => 0,
                    "allowance" => 0,
                    "loan_deduction" => 0,
                    "long_term" => 0,
                    "short_term" => 0,
                    "tax" => 0,
                    "net_amount" => $this->payroll->get_short_term_balance($emp_id, $payment_month),
                    "payment_type" => 'Bank Tranfer',
                    "comments" => 'Short Term Payment',
                );
                if (!$this->payroll->is_employee_paid($emp_id, $payment_month)) {
                    if ($this->payroll->get_short_term_balance($emp_id, $payment_month) > 0) {
                        $id = $this->payroll->insert('tbl_salary_payment', $pay_data);
                        if ($id > 0) {
                            $this->session->set_flashdata('type', 'success');
                            $this->session->set_flashdata('title', 'Success');
                            $this->session->set_flashdata('text', 'Payment Successful');
                            redirect('provident/make_short_term_payment/' . $branch_id . '/' . $payment_month);
                        } else {
                            $this->session->set_flashdata('type', 'error');
                            $this->session->set_flashdata('title', 'Error');
                            $this->session->set_flashdata('text', 'Some error occured');
                            redirect('provident/make_short_term_payment/' . $branch_id . '/' . $payment_month);
                        }
                    } else {
                        $this->session->set_flashdata('type', 'error');
                        $this->session->set_flashdata('title', 'Error');
                        $this->session->set_flashdata('text', 'Cannot pay zero balance');
                        redirect('provident/make_short_term_payment/' . $branch_id . '/' . $payment_month);
                    }
                } else {
                    $affected_rows = $this->payroll->edit('tbl_salary_payment', $pay_data, [
                        'emp_id' => $emp_id,
                        'payment_month' => $payment_month,
                    ]);
                    if ($affected_rows) {
                        $this->payroll->edit('tbl_salary_payment', ['approve' => '0'], [
                            'emp_id' => $emp_id,
                            'payment_month' => $payment_month,
                        ]);
                    }
                    $this->session->set_flashdata('type', 'success');
                    $this->session->set_flashdata('title', 'Success');
                    $this->session->set_flashdata('text', 'Payment corrected successfully');
                    redirect('provident/make_short_term_payment/' . $branch_id . '/' . $payment_month);
                }
            } else {
                redirect('provident/make_short_term_payment');
            }
        }
    }

    public function pay_all_employees()
    {
        if (_is_user_login($this)) {
            $branch_id = $this->input->post('branch_id');
            $payment_month = $this->input->post('payment_month');

            $employees = array();
            if ($branch_id == 0) {
                $employees = $this->payroll->get_array("SELECT * FROM tbl_employees WHERE active = '1'");

            } else {
                $employees = $this->payroll->get_array("SELECT * FROM tbl_employees WHERE active = '1' AND branch_id = " . $branch_id);
            }
            foreach ($employees as $employee) {
                $pay_data = array(
                    "emp_id" => $employee['emp_id'],
                    "payment_month" => $payment_month,
                    "base_salary" => 0,
                    "business_commission" => 0,
                    "recurring_commission" => 0,
                    "fine_deduction" => 0,
                    "allowance" => 0,
                    "loan_deduction" => 0,
                    "long_term" => 0,
                    "short_term" => 0,
                    "tax" => 0,
                    "net_amount" => $this->payroll->get_short_term_balance($employee['emp_id'], $payment_month),
                    "payment_type" => 'Bank Tranfer',
                    "comments" => 'Short Term Payment',
                );
                if (!$this->payroll->is_employee_paid($employee['emp_id'], $payment_month) && ($this->payroll->get_short_term_balance($employee['emp_id'], $payment_month) > 0)) {
                    $id = $this->payroll->insert('tbl_salary_payment', $pay_data);
                } else {
                    $affected_rows = $this->payroll->edit('tbl_salary_payment', $pay_data, [
                        'emp_id' => $employee['emp_id'],
                        'payment_month' => $payment_month,
                    ]);
                    if ($affected_rows) {
                        $this->payroll->edit('tbl_salary_payment', ['approve' => '0'], [
                            'emp_id' => $employee['emp_id'],
                            'payment_month' => $payment_month,
                        ]);
                    }
                }
            }
            $this->session->set_flashdata('type', 'success');
            $this->session->set_flashdata('title', 'Success');
            $this->session->set_flashdata('text', 'Payment processed successful');
            redirect('provident/make_short_term_payment/' . $branch_id . '/' . $payment_month);
        }
    }

    public function approve_short_term_payment()
    {
        if (_is_user_login($this)) {
            $branch_id = $this->uri->segment(3);
            $payment_month = $this->uri->segment(4);
            if (($branch_id >= 0) && ($payment_month != null)) {
                if ($branch_id == 0) {
                    $data['branch_name'] = 'All Branches';
                    $data['branch_id'] = 0;
                    $data['pay_month'] = $payment_month;
                    $data['branch_employees'] = $this->employees->get_array("SELECT * FROM tbl_salary_payment sp INNER JOIN tbl_employees e ON sp.emp_id = e.emp_id INNER JOIN tbl_branches b ON e.branch_id = b.branch_id INNER JOIN tbl_positions p ON e.position_id = p.position_id WHERE sp.payment_month = '" . $payment_month . "'");
                    $data['view'] = 'provident/_approve_short_term_payment.php';
                    $this->load->view('_layout.php', $data);
                } else {
                    $branch = $this->branches->get_row("SELECT * FROM tbl_branches WHERE branch_id = " . $branch_id);
                    if (!empty($branch)) {
                        $data['branch'] = $branch;
                        $data['branch_id'] = $branch->branch_id;
                        $data['branch_name'] = $branch->branch_name;
                        $data['pay_month'] = $payment_month;
                        $data['branch_employees'] = $this->employees->get_array("SELECT * FROM tbl_salary_payment sp INNER JOIN tbl_employees e ON sp.emp_id = e.emp_id INNER JOIN tbl_branches b ON e.branch_id = b.branch_id INNER JOIN tbl_positions p ON e.position_id = p.position_id WHERE e.branch_id = " . $branch_id . " AND sp.payment_month = '" . $payment_month . "'");
                        $data['view'] = 'provident/_approve_short_term_payment.php';
                        $this->load->view('_layout.php', $data);
                    } else {
                        redirect('provident/_approve_short_term_payment');
                    }
                }
            } else {
                $data['branches'] = $this->branches->get_array("SELECT * FROM tbl_branches");
                $data['view'] = 'provident/_approve_st_request.php';
                $this->load->view('_layout.php', $data);
            }
        }
    }

    public function approve_st_payment()
    {
        if (_is_user_login($this)) {
            $emp_id = $this->input->post('emp_id');
            $branch_id = $this->input->post('branch_id');
            $payment_month = $this->input->post('payment_month');
            if ($this->input->post('approve')) {
                $salary_payment = $this->payroll->get_row("SELECT * FROM tbl_salary_payment WHERE emp_id = " . $emp_id . " AND payment_month = '" . $payment_month . "'");
                if (!empty($salary_payment)) {
                    $id = $this->payroll->edit_salary_payment(array('approve' => '1', 'reject_reason' => null), array('salary_payment_id' => $salary_payment->salary_payment_id));
                    if ($id > 0) {
                        $this->session->set_flashdata('type', 'success');
                        $this->session->set_flashdata('title', 'Success');
                        $this->session->set_flashdata('text', 'Payment Updated Successfully');
                    } else {
                        $this->session->set_flashdata('type', 'error');
                        $this->session->set_flashdata('title', 'Error');
                        $this->session->set_flashdata('text', 'No changes made to the Payment Record');
                    }
                }
                redirect('provident/approve_short_term_payment/' . $branch_id . '/' . $payment_month);
            } else {
                $salary_payment = $this->payroll->get_row("SELECT * FROM tbl_salary_payment WHERE emp_id = " . $emp_id . " AND payment_month = '" . $payment_month . "'");
                if (!empty($salary_payment)) {
                    $id = $this->payroll->edit_salary_payment(array('approve' => '2', 'reject_reason' => null), array('salary_payment_id' => $salary_payment->salary_payment_id));
                    if ($id > 0) {
                        $this->session->set_flashdata('type', 'success');
                        $this->session->set_flashdata('title', 'Success');
                        $this->session->set_flashdata('text', 'Payment Rejected');
                    } else {
                        $this->session->set_flashdata('type', 'error');
                        $this->session->set_flashdata('title', 'Error');
                        $this->session->set_flashdata('text', 'No changes made to the Payment Record');
                    }
                }
                redirect('provident/approve_short_term_payment/' . $branch_id . '/' . $payment_month);
            }
        }
    }

    public function approve_st_payments()
    {
        if (_is_user_login($this)) {
            $branch_id = $this->input->post('branch_id');
            $payment_month = $this->input->post('payment_month');
            $employees = array();
            if ($branch_id == 0) {
                $employees = $this->payroll->get_array("SELECT * FROM tbl_employees WHERE active = '1'");

            } else {
                $employees = $this->payroll->get_array("SELECT * FROM tbl_employees WHERE active = '1' AND branch_id = " . $branch_id);
            }
            if ($this->input->post('approve')) {
                foreach ($employees as $employee) {
                    $salary_payment = $this->payroll->get_row("SELECT * FROM tbl_salary_payment WHERE emp_id = " . $employee['emp_id'] . " AND payment_month = '" . $payment_month . "'");
                    if (!empty($salary_payment)) {
                        $id = $this->payroll->edit_salary_payment(array('approve' => '1', 'reject_reason' => null), array('salary_payment_id' => $salary_payment->salary_payment_id));
                        if ($id > 0) {
                            $this->session->set_flashdata('type', 'success');
                            $this->session->set_flashdata('title', 'Success');
                            $this->session->set_flashdata('text', 'Payment Updated Successfully');
                        } else {
                            $this->session->set_flashdata('type', 'error');
                            $this->session->set_flashdata('title', 'Error');
                            $this->session->set_flashdata('text', 'No changes made to the Payment Record');
                        }
                    }
                }
                redirect('provident/approve_short_term_payment/' . $branch_id . '/' . $payment_month);
            } else {
                foreach ($employees as $employee) {
                    $salary_payment = $this->payroll->get_row("SELECT * FROM tbl_salary_payment WHERE emp_id = " . $employee['emp_id'] . " AND payment_month = '" . $payment_month . "'");
                    if (!empty($salary_payment)) {
                        $id = $this->payroll->edit_salary_payment(array('approve' => '2', 'reject_reason' => null), array('salary_payment_id' => $salary_payment->salary_payment_id));
                        if ($id > 0) {
                            $this->session->set_flashdata('type', 'success');
                            $this->session->set_flashdata('title', 'Success');
                            $this->session->set_flashdata('text', 'Payment Rejected');
                        } else {
                            $this->session->set_flashdata('type', 'error');
                            $this->session->set_flashdata('title', 'Error');
                            $this->session->set_flashdata('text', 'No changes made to the Payment Record');
                        }
                    }
                }
                redirect('provident/approve_short_term_payment/' . $branch_id . '/' . $payment_month);
            }
        }
    }

    public function st_bank_csv()
    {
        if (_is_user_login($this)) {
            $branch_id = $this->uri->segment(3);
            $month = $this->uri->segment(4);

            if (($branch_id >= 0) && ($month != null)) {
                if ($branch_id == 0) {
                    $payment_data = $this->payroll->get_array("SELECT * FROM tbl_salary_payment s INNER JOIN tbl_employees e ON s.emp_id = e.emp_id
                     WHERE e.active ='1' AND s.payment_month = '" . $month . "'");
                    $data['branch_id'] = 0;
                    $data['branch'] = "All Branches";
                } else {
                    $payment_data = $this->payroll->get_array("SELECT * FROM tbl_salary_payment s INNER JOIN tbl_employees e ON s.emp_id = e.emp_id
                     WHERE e.active ='1' AND s.payment_month = '" . $month . "' AND e.branch_id ='" . $branch_id . "'");
                    $branch = $this->employees->get_row("SELECT * FROM tbl_branches WHERE branch_id =" . $branch_id);
                    $data['branch'] = $branch->branch_name;
                    $data['branch_id'] = $branch_id;
                }
                $data['payment_data'] = $payment_data;
                $data['pay_month'] = $month;
                $data['view'] = 'provident/_st_bank_csv.php';
                $this->load->view('_layout.php', $data);
            } else {
                $data['branches'] = $this->employees->get_array("SELECT * FROM tbl_branches");
                $data['view'] = 'provident/_st_bank_csv_request.php';
                $this->load->view('_layout.php', $data);
            }
        }
    }

    public function download_st_bank_csv()
    {
        $branch_id = $this->uri->segment(3);
        $pay_month = $this->uri->segment(4);
        // file name
        $filename = 'salaries_' . date('Ymd') . '.csv';
        header("Content-Description: File Transfer");
        header("Content-Disposition: attachment; filename=$filename");
        header("Content-Type: application/csv; ");
        // get data
        if (($branch_id >= 0) && ($pay_month != null)) {
            if ($branch_id == 0) {
                $salary_data = $this->payroll->get_array("SELECT s.net_amount, e.emp_id, e.fullname, e.bank_account, e.branch_code FROM tbl_salary_payment s
                    INNER JOIN tbl_employees e ON s.emp_id = e.emp_id WHERE e.active ='1' AND s.payment_month = '" . $pay_month . "'");
            } else {
                $salary_data = $this->payroll->get_array("SELECT * FROM tbl_salary_payment s INNER JOIN tbl_employees e ON s.emp_id = e.emp_id
                 WHERE e.active ='1' AND s.payment_month = '" . $pay_month . "' AND e.branch_id ='" . $branch_id . "'");
            }
        }
        // file creation
        $file = fopen('php://output', 'w');
        $header = array("Employee Name", "Account Number", "Branch Code", "Netpay", "Reference");
        fputcsv($file, $header);
        foreach ($salary_data as $key => $line) {
            fputcsv($file, $line);
        }
        fclose($file);
        exit;
    }

}