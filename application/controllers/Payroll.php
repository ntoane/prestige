<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Payroll extends CI_Controller
{

    public function index()
    {
        if (_is_user_login($this)) {
            $data['view'] = 'payroll/_index.php';
            $this->load->view('_layout.php', $data);
        }
    }

    public function adrequest()
    {
        if (_is_user_login($this)) {
            $branch_id = $this->uri->segment(3);

            if (($branch_id >= 0) && ($branch_id != null)) {
                if ($branch_id == 0) {
                    $employees = $this->employees->get_array("SELECT emp_id, emp_number, fullname FROM tbl_employees WHERE active ='1'");
                    $data['branch_id'] = 0;
                    $data['branch'] = "All Branches";
                } else {
                    $employees = $this->employees->get_array("SELECT emp_id, emp_number, fullname FROM tbl_employees WHERE branch_id = " . $branch_id . " AND active = '1'");
                    $branch = $this->employees->get_row("SELECT * FROM tbl_branches WHERE branch_id =" . $branch_id);
                    $data['branch'] = $branch->branch_name;
                    $data['branch_id'] = $branch_id;
                }
                $data['employees'] = $employees;
                $data['view'] = 'payroll/_allowances_deductions.php';
                $this->load->view('_layout.php', $data);
            } else {
                $data['branches'] = $this->employees->get_array("SELECT * FROM tbl_branches");
                $data['view'] = 'payroll/_allowance_deduction_request.php';
                $this->load->view('_layout.php', $data);
            }
        }
    }

    public function approve_payroll_request()
    {
        if (_is_user_login($this)) {
            $branch_id = $this->uri->segment(3);
            $current_month = $this->uri->segment(4);

            if (($branch_id >= 0) && ($current_month != null)) {
                if ($branch_id == 0) {
                    $data['branch_id'] = 0;
                    $data['branch_name'] = "All branches";
                    $payment = $this->payroll->get_array("SELECT *, s.long_term AS long_term_accum, s.short_term AS short_term_accum FROM tbl_salary_payment s INNER JOIN tbl_employees e ON s.emp_id = e.emp_id
                    WHERE s.payment_month = '" . $current_month . "'");
                } else {
                    $branch = $this->branches->get_row("SELECT * FROM tbl_branches WHERE branch_id = " . $branch_id);
                    if (!empty($branch)) {
                        $data['branch_id'] = $branch_id;
                        $data['branch_name'] = $branch->branch_name;
                        $payment = $this->payroll->get_array("SELECT *, s.long_term AS long_term_accum, s.short_term AS short_term_accum
                            FROM tbl_salary_payment s INNER JOIN tbl_employees e ON s.emp_id = e.emp_id
                            WHERE e.branch_id = " . $branch_id . " AND s.payment_month = '" . $current_month . "'");
                    } else {
                        redirect('payroll/approve_payroll_request');
                    }
                }
                $data['payment'] = $payment;
                $data['pay_month'] = $current_month;
                $data['view'] = 'payroll/_approve_payroll';
                $this->load->view('_layout.php', $data);
            } else {
                $data['branches'] = $this->employees->get_array("SELECT * FROM tbl_branches");
                $data['view'] = 'payroll/_approve_payroll_request';
                $this->load->view('_layout.php', $data);
            }
        }
    }

    public function approve_payroll()
    {
        if (_is_user_login($this)) {
            $salary_payment_id = $this->uri->segment(3);
            $branch_id = $this->uri->segment(4);
            $pay_month = $this->uri->segment(5);
            if ($salary_payment_id > 0) {
                $id = $this->payroll->edit_salary_payment(array('approve' => '1', 'reject_reason' => null), array('salary_payment_id' => $salary_payment_id));
                if ($id > 0) {
                    $this->payroll->add_activity(array('activity_title' => 'Payroll', 'activity_description' => 'Approved payment with id: ' . $salary_payment_id, 'user_id' => _get_current_user_id($this)));
                    $this->session->set_flashdata('type', 'success');
                    $this->session->set_flashdata('title', 'Success');
                    $this->session->set_flashdata('text', 'Payroll Updated Successfully');
                } else {
                    $this->session->set_flashdata('type', 'error');
                    $this->session->set_flashdata('title', 'Error');
                    $this->session->set_flashdata('text', 'No changes made to the Payroll');
                }
            }
            redirect('payroll/approve_payroll_request/' . $branch_id . '/' . $pay_month);
        }
    }

    public function approve_all_payroll()
    {
        $branch_id = $this->uri->segment(3);
        $current_month = $this->uri->segment(4);
        if (($branch_id >= 0) && ($current_month != null)) {
            if ($branch_id == 0) {
                $data_update = array('approve' => '1', 'reject_reason' => null);
                $data_where = array('payment_month' => $current_month);
                $id = $this->payroll->edit_salary_payment($data_update, $data_where);

                if ($id > 0) {
                    $this->session->set_flashdata('type', 'success');
                    $this->session->set_flashdata('title', 'Success');
                    $this->session->set_flashdata('text', 'Payroll Updated Successfully');
                } else {
                    $this->session->set_flashdata('type', 'error');
                    $this->session->set_flashdata('title', 'Error');
                    $this->session->set_flashdata('text', 'Unable to Update Payroll');
                }
            } else {
                $payroll_to_update = $this->payroll->get_array("SELECT * FROM tbl_salary_payment s INNER JOIN tbl_employees e ON s.emp_id = e.emp_id WHERE e.branch_id = " . $branch_id);
                $errors = 0;
                $data_update = array('approve' => '1');
                foreach ($payroll_to_update as $pay) {
                    $data_where = array('payment_month' => $current_month, 'salary_payment_id' => $pay['salary_payment_id']);
                    $id = $this->payroll->edit_salary_payment($data_update, $data_where);
                    if ($id < 1) {
                        $errors = $errors + 1;
                    }
                    $this->payroll->add_activity(array('activity_title' => 'Payroll', 'activity_description' => 'Approved payment with id: ' . $pay['salary_payment_id'], 'user_id' => _get_current_user_id($this)));
                }

                if ($errors == 0) {
                    $this->session->set_flashdata('type', 'success');
                    $this->session->set_flashdata('title', 'Success');
                    $this->session->set_flashdata('text', 'All Payroll Updated Successfully!');
                } else {
                    $this->session->set_flashdata('type', 'error');
                    $this->session->set_flashdata('title', 'Error');
                    $this->session->set_flashdata('text', 'Some Payroll may not have updated!');
                }
            }

            redirect('payroll/approve_payroll_request/' . $branch_id . '/' . $current_month);
        }
    }

    public function reject_payroll()
    {
        if (_is_user_login($this)) {
            if ($this->input->post('submit_reject')) {
                $salary_payment_id = $this->input->post('salary_payment_id');
                $reasons = $this->input->post('reasons');
                if ($salary_payment_id > 0) {
                    $id = $this->payroll->edit_salary_payment(array('approve' => '2', 'reject_reason' => $reasons), array('salary_payment_id' => $salary_payment_id));
                    if ($id > 0) {
                        $this->session->set_flashdata('type', 'success');
                        $this->session->set_flashdata('title', 'Success');
                        $this->session->set_flashdata('text', 'Payroll Rejected Successfully');
                    } else {
                        $this->session->set_flashdata('type', 'error');
                        $this->session->set_flashdata('title', 'Error');
                        $this->session->set_flashdata('text', 'No changes made to the Payroll');
                    }
                }
                redirect('payroll/approve_payroll_request');
            } else {
                $this->session->set_flashdata('type', 'error');
                $this->session->set_flashdata('title', 'Error');
                $this->session->set_flashdata('text', 'Error! Cannot reject this payroll');
                redirect('payroll/approve_payroll_request');
            }
        }
    }

    public function bank_csv()
    {
        if (_is_user_login($this)) {
            $branch_id = $this->uri->segment(3);
            $month = $this->uri->segment(4);

            if (($branch_id >= 0) && ($month != null)) {
                if ($branch_id == 0) {
                    $payment_data = $this->payroll->get_array("SELECT * FROM tbl_salary_payment s INNER JOIN tbl_employees e ON s.emp_id = e.emp_id
                     WHERE e.active ='1' AND s.payment_month = '" . $month . "' AND approve = '1'");
                    $data['branch_id'] = 0;
                    $data['branch'] = "All Branches";
                } else {
                    $payment_data = $this->payroll->get_array("SELECT * FROM tbl_salary_payment s INNER JOIN tbl_employees e ON s.emp_id = e.emp_id
                     WHERE e.active ='1' AND s.payment_month = '" . $month . "' AND e.branch_id ='" . $branch_id . "' AND approve = '1'");
                    $branch = $this->employees->get_row("SELECT * FROM tbl_branches WHERE branch_id =" . $branch_id);
                    $data['branch'] = $branch->branch_name;
                    $data['branch_id'] = $branch_id;
                }
                $data['payment_data'] = $payment_data;
                $data['pay_month'] = $month;
                $data['view'] = 'payroll/_bank_csv.php';
                $this->load->view('_layout.php', $data);
            } else {
                $data['branches'] = $this->employees->get_array("SELECT * FROM tbl_branches");
                $data['view'] = 'payroll/_bank_csv_request.php';
                $this->load->view('_layout.php', $data);
            }
        }
    }

    public function download_bank_csv()
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

    public function report_paye()
    {
        if (_is_user_login($this)) {
            $branch_id = $this->uri->segment(3);
            $month = $this->uri->segment(4);

            if (($branch_id >= 0) && ($month != null)) {
                if ($branch_id == 0) {
                    $report_paye = $this->payroll->get_array("SELECT * FROM tbl_salary_payment s INNER JOIN tbl_employees e ON s.emp_id = e.emp_id
                     WHERE e.active ='1' AND s.payment_month = '" . $month . "' AND s.approve ='1'");
                    $data['branch_id'] = 0;
                    $data['branch'] = "All Branches";
                } else {
                    $report_paye = $this->payroll->get_array("SELECT * FROM tbl_salary_payment s INNER JOIN tbl_employees e ON s.emp_id = e.emp_id
                     WHERE e.active ='1' AND s.payment_month = '" . $month . "' AND e.branch_id ='" . $branch_id . "' AND s.approve ='1'");
                    $branch = $this->employees->get_row("SELECT * FROM tbl_branches WHERE branch_id =" . $branch_id);
                    $data['branch'] = $branch->branch_name;
                    $data['branch_id'] = $branch_id;
                }
                $data['report_paye'] = $report_paye;
                $data['pay_month'] = $month;
                $data['view'] = 'payroll/_paye.php';
                $this->load->view('_layout.php', $data);
            } else {
                $data['branches'] = $this->employees->get_array("SELECT * FROM tbl_branches");
                $data['view'] = 'payroll/_paye_request.php';
                $this->load->view('_layout.php', $data);
            }
        }
    }

    public function individual_paye()
    {
        if (_is_user_login($this)) {
            $emp_id = $this->uri->segment(3);
            if ($emp_id > 0) {
                $emp_data = $this->employees->get_array("SELECT * FROM tbl_salary_payment WHERE approve ='1' AND emp_id = " . $emp_id);
                $data['emp_data'] = $emp_data;
                $data['emp_id'] = $emp_id;
                $data['view'] = 'payroll/_paye_individual.php';
                $this->load->view('_layout.php', $data);
            }
        }
    }

    public function add_allowance()
    {
        if (_is_user_login($this)) {
            $data_allowance = array(
                'emp_id' => $this->input->post('emp_id'),
                'allowance_label' => $this->input->post('allowance_label'),
                'allowance_value' => $this->input->post('allowance_value'),
            );
            $insert_id = $this->payroll->insert('tbl_salary_allowance', $data_allowance);
            if ($insert_id > 0) {
                $this->session->set_flashdata('type', 'success');
                $this->session->set_flashdata('title', 'Success');
                $this->session->set_flashdata('text', 'Allowance added Successful');
            } else {
                $this->session->set_flashdata('type', 'error');
                $this->session->set_flashdata('title', 'Error');
                $this->session->set_flashdata('text', 'Some error occured');
            }
            redirect('payroll/adrequest/' . $this->input->post('branch_id') . '/' . $this->input->post('pay_month'));
        }
    }

    public function delete_allowance()
    {
        if (_is_user_login($this)) {
            $deleted = $this->payroll->delete_salary_allowance($this->input->post('allowance_id'));
            if ($deleted > 0) {
                $this->session->set_flashdata('type', 'success');
                $this->session->set_flashdata('title', 'Success');
                $this->session->set_flashdata('text', 'Allowance deleted Successful');
            } else {
                $this->session->set_flashdata('type', 'error');
                $this->session->set_flashdata('title', 'Error');
                $this->session->set_flashdata('text', 'Some error occured');
            }
            redirect('payroll/adrequest/' . $this->input->post('branch_id') . '/' . $this->input->post('pay_month'));
        }
    }

    public function toggle_allowance()
    {
        if (_is_user_login($this)) {
            $branch_id = $this->uri->segment(3);
            $allowance_id = $this->uri->segment(4);
            $allowance = $this->payroll->get_salary_allowance($allowance_id);
            if (!empty($allowance)) {
                $allowance_status = ($allowance->allowance_status == 1) ? 0 : 1;
                $modified = $this->payroll->edit_salary_allowance(['allowance_id' => $allowance_id], ['allowance_status' => $allowance_status]);
                if ($modified > 0) {
                    $this->session->set_flashdata('type', 'success');
                    $this->session->set_flashdata('title', 'Success');
                    $this->session->set_flashdata('text', 'Allowance Deactivated');
                } else {
                    $this->session->set_flashdata('type', 'error');
                    $this->session->set_flashdata('title', 'Error');
                    $this->session->set_flashdata('text', 'Some error occured');
                }
            }
            redirect('payroll/adrequest/' . $branch_id);
        }
    }

    public function add_deduction()
    {
        if (_is_user_login($this)) {
            $data_deduction = array(
                'emp_id' => $this->input->post('emp_id'),
                'deduction_label' => $this->input->post('deduction_label'),
                'deduction_value' => $this->input->post('deduction_value'),
            );
            $insert_id = $this->payroll->insert('tbl_salary_deduction', $data_deduction);
            if ($insert_id > 0) {
                $this->session->set_flashdata('type', 'success');
                $this->session->set_flashdata('title', 'Success');
                $this->session->set_flashdata('text', 'Deduction added Successful');
            } else {
                $this->session->set_flashdata('type', 'error');
                $this->session->set_flashdata('title', 'Error');
                $this->session->set_flashdata('text', 'Some error occured');
            }
            redirect('payroll/adrequest/' . $this->input->post('branch_id') . '/' . $this->input->post('pay_month'));
        }
    }

    public function delete_deduction()
    {
        if (_is_user_login($this)) {
            $deleted = $this->payroll->delete_salary_deduction($this->input->post('deduction_id'));
            if ($deleted > 0) {
                $this->session->set_flashdata('type', 'success');
                $this->session->set_flashdata('title', 'Success');
                $this->session->set_flashdata('text', 'Deduction deleted Successful');
            } else {
                $this->session->set_flashdata('type', 'error');
                $this->session->set_flashdata('title', 'Error');
                $this->session->set_flashdata('text', 'Some error occured');
            }
            redirect('payroll/adrequest/' . $this->input->post('branch_id') . '/' . $this->input->post('pay_month'));
        }
    }

    public function toggle_deduction()
    {
        if (_is_user_login($this)) {
            $branch_id = $this->uri->segment(3);
            $deduction_id = $this->uri->segment(4);
            $deduction = $this->payroll->get_salary_deduction($deduction_id);
            if (!empty($deduction)) {
                $deduction_status = ($deduction->deduction_status == 1) ? 0 : 1;
                $modified = $this->payroll->edit_salary_deduction(['deduction_id' => $deduction_id], ['deduction_status' => $deduction_status]);
                if ($modified > 0) {
                    $this->session->set_flashdata('type', 'success');
                    $this->session->set_flashdata('title', 'Success');
                    $this->session->set_flashdata('text', 'Success');
                } else {
                    $this->session->set_flashdata('type', 'error');
                    $this->session->set_flashdata('title', 'Error');
                    $this->session->set_flashdata('text', 'Some error occured');
                }
            }
            redirect('payroll/adrequest/' . $branch_id);
        }
    }

    public function overtime_request()
    {
        if (_is_user_login($this)) {
            $branch_id = $this->uri->segment(3);
            $month = $this->uri->segment(4);

            if (($branch_id >= 0) && ($month != null)) {
                if ($branch_id == 0) {
                    $employees = $this->employees->get_array("SELECT emp_id, emp_number, fullname FROM tbl_employees WHERE active ='1'");
                    $data['branch_id'] = 0;
                    $data['branch'] = "All Branches";
                } else {
                    $employees = $this->employees->get_array("SELECT emp_id, emp_number, fullname FROM tbl_employees WHERE branch_id = " . $branch_id . " AND active = '1'");
                    $branch = $this->employees->get_row("SELECT * FROM tbl_branches WHERE branch_id =" . $branch_id);
                    $data['branch'] = $branch->branch_name;
                    $data['branch_id'] = $branch_id;
                }
                $data['employees'] = $employees;
                $data['pay_month'] = $month;
                $data['view'] = 'payroll/_overtime.php';
                $this->load->view('_layout.php', $data);
            } else {
                $data['branches'] = $this->employees->get_array("SELECT * FROM tbl_branches");
                $data['view'] = 'payroll/_overtime_request.php';
                $this->load->view('_layout.php', $data);
            }
        }
    }

    public function add_overtime()
    {
        if (_is_user_login($this)) {
            $emp_id = $this->input->post('emp_id');
            $num_days = $this->input->post('num_days');
            $employee = $this->payroll->get_row("SELECT * FROM tbl_employees WHERE emp_id = " . $emp_id);
            if (!empty($employee)) {
                $data_overtime = array(
                    'emp_id' => $this->input->post('emp_id'),
                    'pay_month' => $this->input->post('pay_month'),
                    'num_days' => $num_days,
                    'amount' => round(($employee->base_salary / 27) * $num_days * 2, 2),
                    'overtime_type' => 'overtime',
                );
                $insert_id = $this->payroll->insert('tbl_overtime', $data_overtime);
                if ($insert_id > 0) {
                    $this->session->set_flashdata('type', 'success');
                    $this->session->set_flashdata('title', 'Success');
                    $this->session->set_flashdata('text', 'Overtime added Successful');
                } else {
                    $this->session->set_flashdata('type', 'error');
                    $this->session->set_flashdata('title', 'Error');
                    $this->session->set_flashdata('text', 'Some error occured');
                }
            } else {
                $this->session->set_flashdata('type', 'error');
                $this->session->set_flashdata('title', 'Error');
                $this->session->set_flashdata('text', 'Employee not found');
            }
            redirect('payroll/overtime_request/' . $this->input->post('branch_id') . '/' . $this->input->post('pay_month'));
        }
    }

    public function delete_overtime()
    {
        if (_is_user_login($this)) {
            $deleted = $this->payroll->delete_overtime($this->input->post('overtime_id'));
            if ($deleted > 0) {
                $this->session->set_flashdata('type', 'success');
                $this->session->set_flashdata('title', 'Success');
                $this->session->set_flashdata('text', 'Overtime deleted Successful');
            } else {
                $this->session->set_flashdata('type', 'error');
                $this->session->set_flashdata('title', 'Error');
                $this->session->set_flashdata('text', 'Some error occured');
            }
            redirect('payroll/overtime_request/' . $this->input->post('branch_id') . '/' . $this->input->post('pay_month'));
        }
    }

    public function add_sundaypay()
    {
        if (_is_user_login($this)) {
            $emp_id = $this->input->post('emp_id');
            $num_days = $this->input->post('num_days');
            $employee = $this->payroll->get_row("SELECT * FROM tbl_employees WHERE emp_id = " . $emp_id);
            if (!empty($employee)) {
                $data_overtime = array(
                    'emp_id' => $this->input->post('emp_id'),
                    'pay_month' => $this->input->post('pay_month'),
                    'num_days' => $num_days,
                    'amount' => 100 * $num_days,
                    'overtime_type' => 'sunday_pay',
                );
                $insert_id = $this->payroll->insert('tbl_overtime', $data_overtime);
                if ($insert_id > 0) {
                    $this->session->set_flashdata('type', 'success');
                    $this->session->set_flashdata('title', 'Success');
                    $this->session->set_flashdata('text', 'Sunday pay added Successful');
                } else {
                    $this->session->set_flashdata('type', 'error');
                    $this->session->set_flashdata('title', 'Error');
                    $this->session->set_flashdata('text', 'Some error occured');
                }
            } else {
                $this->session->set_flashdata('type', 'error');
                $this->session->set_flashdata('title', 'Error');
                $this->session->set_flashdata('text', 'Employee not found');
            }
            redirect('payroll/overtime_request/' . $this->input->post('branch_id') . '/' . $this->input->post('pay_month'));
        }
    }

    public function delete_sundaypay()
    {
        if (_is_user_login($this)) {
            $deleted = $this->payroll->delete_overtime($this->input->post('overtime_id'));
            if ($deleted > 0) {
                $this->session->set_flashdata('type', 'success');
                $this->session->set_flashdata('title', 'Success');
                $this->session->set_flashdata('text', 'Sunday pay deleted Successful');
            } else {
                $this->session->set_flashdata('type', 'error');
                $this->session->set_flashdata('title', 'Error');
                $this->session->set_flashdata('text', 'Some error occured');
            }
            redirect('payroll/overtime_request/' . $this->input->post('branch_id') . '/' . $this->input->post('pay_month'));
        }
    }

    public function make_payment()
    {
        if (_is_user_login($this)) {
            $branch_id = $this->uri->segment(3);
            $payment_month = $this->uri->segment(4);
            if (($branch_id >= 0) && ($payment_month != null)) {
                if ($branch_id == 0) {
                    $data['branch_name'] = 'All Branches';
                    $data['branch_id'] = 0;
                    $data['pay_month'] = $payment_month;
                    $data['branch_employees'] = $this->employees->get_array("SELECT * FROM tbl_employees e INNER JOIN tbl_branches b ON e.branch_id = b.branch_id INNER JOIN tbl_positions p ON e.position_id = p.position_id WHERE e.active = '1'");
                    $data['view'] = 'payroll/_make_payment.php';
                    $this->load->view('_layout.php', $data);
                } else {
                    $branch = $this->branches->get_row("SELECT * FROM tbl_branches WHERE branch_id = " . $branch_id);
                    if (!empty($branch)) {
                        $data['branch'] = $branch;
                        $data['branch_id'] = $branch->branch_id;
                        $data['branch_name'] = $branch->branch_name;
                        $data['pay_month'] = $payment_month;
                        $data['branch_employees'] = $this->employees->get_array("SELECT * FROM tbl_employees e INNER JOIN tbl_branches b ON e.branch_id = b.branch_id INNER JOIN tbl_positions p ON e.position_id = p.position_id WHERE e.active = '1' AND e.branch_id = " . $branch_id);
                        $data['view'] = 'payroll/_make_payment.php';
                        $this->load->view('_layout.php', $data);
                    } else {
                        redirect('payroll/make_payment');
                    }
                }
            } else {
                $data['branches'] = $this->branches->get_array("SELECT * FROM tbl_branches");
                $data['view'] = 'payroll/_make_payment_request.php';
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
                $loan = $this->loan->get_row("SELECT * FROM tbl_loans WHERE emp_id = " . $emp_id . " AND loan_status = '0' AND loan_type ='loan'");
                $scheduled_deduction = $this->loan->get_row("SELECT * FROM tbl_loans WHERE emp_id = " . $emp_id . " AND loan_status = '0' AND loan_type ='deduction'");
                $scheduled_allowance = $this->loan->get_row("SELECT * FROM tbl_loans WHERE emp_id = " . $emp_id . " AND loan_status = '0' AND loan_type ='allowance'");
                $allowances = $this->payroll->get_active_sum_of_allowances($emp_id);
                $overtime = $this->payroll->get_sum_of_overtimes($emp_id, $payment_month);
                $sundaypay = $this->payroll->get_sum_of_sundaypays($emp_id, $payment_month);
                $premium = !empty($employee->premium) ? $employee->premium : 0;
                $staff_party = !empty($employee->staff_party) ? $employee->staff_party : 0;

                if (!empty($scheduled_allowance)) {
                    $allowances += $scheduled_allowance->loan_installment;
                }
                $deductions = $this->payroll->get_active_sum_of_deductions($emp_id);
                if (!empty($scheduled_deduction)) {
                    $deductions += $scheduled_deduction->loan_installment;
                }
                $commission = $this->commission->get_business_commission_total($emp_id, $payment_month) + $this->commission->get_recurring_commission_total($emp_id, $payment_month);

                if ($employee->position_id == 1) { //Retention fund
                    $long_term = $this->calculateLongTerm($this->commission->get_business_commission_total($emp_id, $payment_month) + $employee->base_salary, $employee->long_term);
                } else {
                    $long_term = $this->calculateLongTerm($employee->base_salary, $employee->long_term);
                }
                $short_term = $this->calculateShortTerm($employee->base_salary, $employee->short_term, $employee->position_id);
                $total_income = $employee->base_salary + $overtime + $sundaypay + $commission + $allowances;
                $income_taxable = $total_income - $long_term;
                $tax = $this->calculateTax($income_taxable);
                $loan_install = !empty($loan) ? $loan->loan_installment : 0;
                $total_deductions = $deductions + $long_term + $short_term + $tax + $loan_install + $premium + $staff_party;
                $net_pay = $total_income - $total_deductions;

                $pay_data = array(
                    "emp_id" => $emp_id,
                    "payment_month" => $payment_month,
                    "base_salary" => $employee->base_salary,
                    "business_commission" => $this->commission->get_business_commission_total($emp_id, $payment_month),
                    "recurring_commission" => $this->commission->get_recurring_commission_total($emp_id, $payment_month),
                    "fine_deduction" => ($deductions > 0) ? $deductions : 0,
                    "allowance" => ($allowances > 0) ? $allowances : 0,
                    "overtime" => $overtime,
                    "sunday_pay" => $sundaypay,
                    "loan_deduction" => $loan_install,
                    "long_term" => $long_term,
                    "short_term" => $short_term,
                    "tax" => $tax,
                    "net_amount" => $net_pay,
                    "payment_type" => 'Bank Tranfer',
                    "comments" => '',
                );
                if (!($this->payroll->is_employee_paid($emp_id, $payment_month))) {
                    $id = $this->payroll->insert('tbl_salary_payment', $pay_data);
                    if ($id > 0) {
                        $allowance_list = $this->payroll->get_active_salary_allowances($emp_id);
                        foreach ($allowance_list as $list) {
                            $this->payroll->insert('tbl_track_allowance', ['allowance_id' => $list['allowance_id'], 'pay_month' => $payment_month]);
                        }
                        $deduction_list = $this->payroll->get_active_salary_deductions($emp_id);
                        foreach ($deduction_list as $list) {
                            $this->payroll->insert('tbl_track_deduction', ['deduction_id' => $list['deduction_id'], 'pay_month' => $payment_month]);
                        }
                        if (!empty($loan)) {
                            $data_loan = array(
                                "outstanding_balance" => ($loan->outstanding_balance - $loan_install),
                            );
                            $where = array(
                                "loan_id" => $loan->loan_id,
                                "emp_id" => $loan->emp_id,
                            );
                            $this->payroll->edit('tbl_loans', $data_loan, $where);
                            $loan_updated = $this->loan->get_row("SELECT * FROM tbl_loans WHERE loan_id = " . $loan->loan_id);
                            if (!empty($loan_updated)) {
                                // track loan
                                $this->payroll->insert('tbl_track_loan', ['loan_id' => $loan->loan_id, 'pay_month' => $payment_month]);
                                if ($loan_updated->outstanding_balance <= 0.1) {
                                    $this->payroll->edit('tbl_loans', array("loan_status" => '1'), array("loan_id" => $loan_updated->loan_id));
                                }
                            }
                        }
                        if (!empty($scheduled_deduction)) {
                            $data_deduction = array(
                                "outstanding_balance" => ($scheduled_deduction->outstanding_balance - $scheduled_deduction->loan_installment),
                            );
                            $where = array(
                                "loan_id" => $scheduled_deduction->loan_id,
                                "emp_id" => $scheduled_deduction->emp_id,
                            );
                            $this->payroll->edit('tbl_loans', $data_deduction, $where);

                            $scheduled_deduction_updated = $this->loan->get_row("SELECT * FROM tbl_loans WHERE loan_id = " . $scheduled_deduction->loan_id);
                            if (!empty($scheduled_deduction_updated)) {
                                // track loan
                                $this->payroll->insert('tbl_track_loan', ['loan_id' => $scheduled_deduction->loan_id, 'pay_month' => $payment_month]);
                                if ($scheduled_deduction_updated->outstanding_balance <= 0.1) {
                                    $this->payroll->edit('tbl_loans', array("loan_status" => '1'), array("loan_id" => $scheduled_deduction_updated->loan_id));
                                }
                            }
                        }
                        if (!empty($scheduled_allowance)) {
                            $data_allowance = array(
                                "outstanding_balance" => ($scheduled_allowance->outstanding_balance - $scheduled_allowance->loan_installment),
                            );
                            $where = array(
                                "loan_id" => $scheduled_allowance->loan_id,
                                "emp_id" => $scheduled_allowance->emp_id,
                            );
                            $this->payroll->edit('tbl_loans', $data_allowance, $where);

                            $scheduled_allowance_updated = $this->loan->get_row("SELECT * FROM tbl_loans WHERE loan_id = " . $scheduled_allowance->loan_id);
                            if (!empty($scheduled_allowance_updated)) {
                                // track loan
                                $this->payroll->insert('tbl_track_loan', ['loan_id' => $scheduled_allowance->loan_id, 'pay_month' => $payment_month]);
                                if ($scheduled_allowance_updated->outstanding_balance <= 0.1) {
                                    $this->payroll->edit('tbl_loans', array("loan_status" => '1'), array("loan_id" => $scheduled_allowance_updated->loan_id));
                                }
                            }
                        }
                        $this->payroll->add_activity(array('activity_title' => 'Payroll', 'activity_description' => 'Processed payment for: ' . $employee->fullname, 'user_id' => _get_current_user_id($this)));
                        $this->session->set_flashdata('type', 'success');
                        $this->session->set_flashdata('title', 'Success');
                        $this->session->set_flashdata('text', 'Payment Successful');
                        redirect('payroll/make_payment/' . $branch_id . '/' . $payment_month);
                    } else {
                        $this->session->set_flashdata('type', 'error');
                        $this->session->set_flashdata('title', 'Error');
                        $this->session->set_flashdata('text', 'Some error occured');
                        redirect('payroll/make_payment/' . $branch_id . '/' . $payment_month);
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
                    redirect('payroll/make_payment/' . $branch_id . '/' . $payment_month);
                }
            } else {
                redirect('payroll/make_payment');
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
                $loan = $this->loan->get_row("SELECT * FROM tbl_loans WHERE emp_id = " . $employee['emp_id'] . " AND loan_status = '0' AND loan_type ='loan'");
                $scheduled_deduction = $this->loan->get_row("SELECT * FROM tbl_loans WHERE emp_id = " . $employee['emp_id'] . " AND loan_status = '0' AND loan_type ='deduction'");
                $scheduled_allowance = $this->loan->get_row("SELECT * FROM tbl_loans WHERE emp_id = " . $employee['emp_id'] . " AND loan_status = '0' AND loan_type ='allowance'");
                $allowances = $this->payroll->get_active_sum_of_allowances($employee['emp_id']);
                $overtime = $this->payroll->get_sum_of_overtimes($employee['emp_id'], $payment_month);
                $sundaypay = $this->payroll->get_sum_of_sundaypays($employee['emp_id'], $payment_month);
                $premium = !empty($employee['premium']) ? $employee['premium'] : 0;
                $staff_party = !empty($employee['staff_party']) ? $employee['staff_party'] : 0;

                if (!empty($scheduled_allowance)) {
                    $allowances += $scheduled_allowance->loan_installment;
                }
                $deductions = $this->payroll->get_active_sum_of_deductions($employee['emp_id']);
                if (!empty($scheduled_deduction)) {
                    $deductions += $scheduled_deduction->loan_installment;
                }
                $commission = $this->commission->get_business_commission_total($employee['emp_id'], $payment_month) + $this->commission->get_recurring_commission_total($employee['emp_id'], $payment_month);

                if ($employee['position_id'] == 1) { //Retenssion fund
                    $long_term = $this->calculateLongTerm($this->commission->get_business_commission_total($employee['emp_id'], $payment_month) + $employee['base_salary'], $employee['long_term']);
                } else {
                    $long_term = $this->calculateLongTerm($employee['base_salary'], $employee['long_term']);
                }

                $short_term = $this->calculateShortTerm($employee['base_salary'], $employee['short_term'], $employee['position_id']);
                $total_income = $employee['base_salary'] + $overtime + $sundaypay + $commission + $allowances;
                $income_taxable = $total_income - $long_term;
                $tax = $this->calculateTax($income_taxable);
                $loan_install = !empty($loan) ? $loan->loan_installment : 0;
                $total_deductions = $deductions + $long_term + $short_term + $tax + $loan_install + $premium + $staff_party;
                $net_pay = $total_income - $total_deductions;

                $pay_data = array(
                    "emp_id" => $employee['emp_id'],
                    "payment_month" => $payment_month,
                    "base_salary" => $employee['base_salary'],
                    "business_commission" => $this->commission->get_business_commission_total($employee['emp_id'], $payment_month),
                    "recurring_commission" => $this->commission->get_recurring_commission_total($employee['emp_id'], $payment_month),
                    "fine_deduction" => ($deductions > 0) ? $deductions : 0,
                    "allowance" => ($allowances > 0) ? $allowances : 0,
                    "overtime" => $overtime,
                    "sunday_pay" => $sundaypay,
                    "loan_deduction" => $loan_install,
                    "long_term" => $long_term,
                    "short_term" => $short_term,
                    "tax" => $tax,
                    "net_amount" => $net_pay,
                    "payment_type" => 'Bank Tranfer',
                    "comments" => '',
                );
                if (!($this->payroll->is_employee_paid($employee['emp_id'], $payment_month))) {
                    $id = $this->payroll->insert('tbl_salary_payment', $pay_data);
                    if ($id > 0) {
                        $allowance_list = $this->payroll->get_active_salary_allowances($employee['emp_id']);
                        foreach ($allowance_list as $list) {
                            $this->payroll->insert('tbl_track_allowance', ['allowance_id' => $list['allowance_id'], 'pay_month' => $payment_month]);
                        }
                        $deduction_list = $this->payroll->get_active_salary_deductions($employee['emp_id']);
                        foreach ($deduction_list as $list) {
                            $this->payroll->insert('tbl_track_deduction', ['deduction_id' => $list['deduction_id'], 'pay_month' => $payment_month]);
                        }
                        if (!empty($loan)) {
                            $data_loan = array(
                                "outstanding_balance" => ($loan->outstanding_balance - $loan->loan_installment),
                            );
                            $where = array(
                                "loan_id" => $loan->loan_id,
                                "emp_id" => $loan->emp_id,
                            );
                            $this->payroll->edit('tbl_loans', $data_loan, $where);

                            $loan_updated = $this->loan->get_row("SELECT * FROM tbl_loans WHERE loan_id = " . $loan->loan_id);
                            if (!empty($loan_updated)) {
                                // track loan
                                $this->payroll->insert('tbl_track_loan', ['loan_id' => $loan->loan_id, 'pay_month' => $payment_month]);
                                if ($loan_updated->outstanding_balance <= 0.1) {
                                    $this->payroll->edit('tbl_loans', array("loan_status" => '1'), array("loan_id" => $loan_updated->loan_id));
                                }
                            }
                        }
                        if (!empty($scheduled_deduction)) {
                            $data_deduction = array(
                                "outstanding_balance" => ($scheduled_deduction->outstanding_balance - $scheduled_deduction->loan_installment),
                            );
                            $where = array(
                                "loan_id" => $scheduled_deduction->loan_id,
                                "emp_id" => $scheduled_deduction->emp_id,
                            );
                            $this->payroll->edit('tbl_loans', $data_deduction, $where);

                            $scheduled_deduction_updated = $this->loan->get_row("SELECT * FROM tbl_loans WHERE loan_id = " . $scheduled_deduction->loan_id);
                            if (!empty($scheduled_deduction_updated)) {
                                // track loan
                                $this->payroll->insert('tbl_track_loan', ['loan_id' => $scheduled_deduction->loan_id, 'pay_month' => $payment_month]);
                                if ($scheduled_deduction_updated->outstanding_balance <= 0.1) {
                                    $this->payroll->edit('tbl_loans', array("loan_status" => '1'), array("loan_id" => $scheduled_deduction_updated->loan_id));
                                }
                            }
                        }
                        if (!empty($scheduled_allowance)) {
                            $data_allowance = array(
                                "outstanding_balance" => ($scheduled_allowance->outstanding_balance - $scheduled_allowance->loan_installment),
                            );
                            $where = array(
                                "loan_id" => $scheduled_allowance->loan_id,
                                "emp_id" => $scheduled_allowance->emp_id,
                            );
                            $this->payroll->edit('tbl_loans', $data_allowance, $where);

                            $scheduled_allowance_updated = $this->loan->get_row("SELECT * FROM tbl_loans WHERE loan_id = " . $scheduled_allowance->loan_id);
                            if (!empty($scheduled_allowance_updated)) {
                                // track loan
                                $this->payroll->insert('tbl_track_loan', ['loan_id' => $scheduled_allowance->loan_id, 'pay_month' => $payment_month]);
                                if ($scheduled_allowance_updated->outstanding_balance <= 0.1) {
                                    $this->payroll->edit('tbl_loans', array("loan_status" => '1'), array("loan_id" => $scheduled_allowance_updated->loan_id));
                                }
                            }
                        }
                        $this->payroll->add_activity(array('activity_title' => 'Payroll', 'activity_description' => 'Processed payment for: ' . $employee['fullname'], 'user_id' => _get_current_user_id($this)));
                    }
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
            redirect('payroll/make_payment/' . $branch_id . '/' . $payment_month);
        }

    }

    public function calculateTax($salary)
    {
        if ($salary < 0) {
            return 0;
        } else {
            if ($salary <= 4510) {
                return 0;
            } else if (($salary > 4510) && ($salary <= 5760)) {
                return ($salary * 0.2) - 902;
            } else {
                return (((5760 * 0.2) + (($salary - 5760) * 0.3)) - 902);
            }
        }
    }

    public function calculateLongTerm($salary, $long_term)
    {
        // $long_term = $this->provident->get_long_term()->long_term / 100;
        return ($long_term / 100) * $salary;
    }

    public function calculateShortTerm($salary, $short_term, $position)
    {
        // $short_term = $this->provident->get_short_term()->short_term / 100;
        if ($position == 1) {
            return ($short_term / 100) * $salary;
        }
        return $short_term;
    }

    /* Salary Allowances */

    public function get_salary_allowances()
    {
        $salary = json_decode(file_get_contents("php://input"));
        $emp_id = $salary->emp_id;
        $pay_month = $salary->pay_month;
        $data = $this->payroll->get_salary_allowances($emp_id, $pay_month);
        echo json_encode($data);
    }

    public function get_sum_of_allowances()
    {
        $emp_id = $this->input->post('emp_id');
        $pay_month = $this->input->post('pay_month');
        $sum = $this->payroll->get_sum_of_allowances($emp_id, $pay_month);
        if ($sum > 0) {
            echo $sum;
        } else {
            echo 0;
        }
    }

    public function save_salary_allowance()
    {
        $out = array('error' => false);
//        if ($this->user->isLoggedIn()) {
        $allowance = json_decode(file_get_contents("php://input"));

        $allowance_label = $allowance->allowance_label;
        $allowance_value = $allowance->allowance_value;
        $allowance_month = $allowance->pay_month;
        $emp_id = $allowance->emp_id;

        $data = array(
            'allowance_label' => $allowance_label,
            'allowance_value' => $allowance_value,
            'allowance_month' => $allowance_month,
            'emp_id' => $emp_id,
        );

        if ($this->payroll->add_salary_allowance($data) > 0) {
            $out['message'] = "Allowance saved Successfully";
        } else {
            $out['error'] = true;
            $out['message'] = "Cannot insert Allowance";
        }
//        } else {
        //            $out['error'] = true;
        //            $out['message'] = "Cannot insert Allowance";
        //        }

        echo json_encode($out);
    }

    public function edit_salary_allowance()
    {
        $out = array('error' => false);
//        if ($this->user->isLoggedIn()) {
        $allowance = json_decode(file_get_contents("php://input"));

        $allowance_label = $allowance->allowance_label;
        $allowance_value = $allowance->allowance_value;
        $allowance_id = $allowance->allowance_id;

        $data = array(
            'allowance_label' => $allowance_label,
            'allowance_value' => $allowance_value,
        );

        if ($this->payroll->edit_salary_allowance(array('allowance_id' => $allowance_id), $data) > 0) {
            $out['message'] = "Allowance updated Successfully";
        } else {
            $out['error'] = true;
            $out['message'] = "Nothing  Updated";
        }
//        } else {
        //            $out['error'] = true;
        //            $out['message'] = "Cannot insert Allowance";
        //        }

        echo json_encode($out);
    }

    public function delete_salary_allowance()
    {
        $out = array('error' => false);
//        if ($this->user->isLoggedIn()) {
        $allowance = json_decode(file_get_contents("php://input"));

        $allowance_id = $allowance->allowance_id;
        $allowance1 = $this->payroll->get_salary_allowance($allowance_id);
        if ($this->payroll->delete_salary_allowance($allowance_id)) {
            $out['message'] = "Allowance deleted Successfully";
        } else {
            $out['error'] = true;
            $out['message'] = "Cannot delete allowance";
        }
//        } else {
        //            $out['error'] = true;
        //            $out['message'] = "Cannot insert Allowance";
        //        }
        echo json_encode($out);
    }

    /* Salary Deductions */

    public function get_salary_deductions()
    {
        $salary = json_decode(file_get_contents("php://input"));
        $emp_id = $salary->emp_id;
        $pay_month = $salary->pay_month;
        $data = $this->payroll->get_salary_deductions($emp_id, $pay_month);
        echo json_encode($data);
    }

    public function get_sum_of_deductions()
    {
        $emp_id = $this->input->post('emp_id');
        $pay_month = $this->input->post('pay_month');
        $sum = $this->payroll->get_sum_of_deductions($emp_id, $pay_month);
        if ($sum > 0) {
            echo $sum;
        } else {
            echo 0;
        }
    }

    public function save_salary_deduction()
    {
        $out = array('error' => false);
//        if ($this->user->isLoggedIn()) {
        $deduction = json_decode(file_get_contents("php://input"));

        $deduction_label = $deduction->deduction_label;
        $deduction_value = $deduction->deduction_value;
        $deduction_month = $deduction->pay_month;
        $emp_id = $deduction->emp_id;

        $data = array(
            'deduction_label' => $deduction_label,
            'deduction_value' => $deduction_value,
            'deduction_month' => $deduction_month,
            'emp_id' => $emp_id,
        );

        if ($this->payroll->add_salary_deduction($data) > 0) {
            $out['message'] = "Deduction saved Successfully";
        } else {
            $out['error'] = true;
            $out['message'] = "Cannot insert Deduction";
        }
//        } else {
        //            $out['error'] = true;
        //            $out['message'] = "Cannot insert Deduction";
        //        }

        echo json_encode($out);
    }

    public function edit_salary_deduction()
    {
        $out = array('error' => false);
//        if ($this->user->isLoggedIn()) {
        $deduction = json_decode(file_get_contents("php://input"));

        $deduction_label = $deduction->deduction_label;
        $deduction_value = $deduction->deduction_value;
        $deduction_id = $deduction->deduction_id;

        $data = array(
            'deduction_label' => $deduction_label,
            'deduction_value' => $deduction_value,
        );

        if ($this->payroll->edit_salary_deduction(array('deduction_id' => $deduction_id), $data) > 0) {
            $out['message'] = "Deduction updated Successfully";
        } else {
            $out['error'] = true;
            $out['message'] = "Nothing  Updated";
        }
//        } else {
        //            $out['error'] = true;
        //            $out['message'] = "Cannot insert Allowance";
        //        }

        echo json_encode($out);
    }

    public function delete_salary_deduction()
    {
        $out = array('error' => false);
//        if ($this->user->isLoggedIn()) {
        $deduction = json_decode(file_get_contents("php://input"));

        $deduction_id = $deduction->deduction_id;
        $deduction1 = $this->payroll->get_salary_deduction($deduction_id);
        if ($this->payroll->delete_salary_deduction($deduction_id)) {
            $out['message'] = "Deduction deleted Successfully";
        } else {
            $out['error'] = true;
            $out['message'] = "Cannot delete deduction";
        }
//        } else {
        //            $out['error'] = true;
        //            $out['message'] = "Cannot insert Allowance";
        //        }
        echo json_encode($out);
    }

    public function salary_payment_file()
    {
        if (_is_user_login($this)) {
            $branch_id = $this->uri->segment(3);
            $payment_month = $this->uri->segment(4);
            if ($payment_month != null) {
                if ($branch_id > 0) {
                    $data['branch_id'] = $branch_id;
                    $sql = "SELECT *, sp.long_term as long_t, sp.short_term as short_t FROM tbl_salary_payment sp INNER JOIN tbl_employees e ON e.emp_id = sp.emp_id WHERE sp.payment_month = '" . $payment_month . "' AND e.branch_id = " . $branch_id;
                    $data['payment_data'] = $this->payroll->get_array($sql);
                } else {
                    $data['branch_id'] = -1;
                    $sql = "SELECT *, sp.long_term as long_t, sp.short_term as short_t FROM tbl_salary_payment sp INNER JOIN tbl_employees e ON e.emp_id = sp.emp_id WHERE sp.payment_month = '" . $payment_month . "'";
                    $data['payment_data'] = $this->payroll->get_array($sql);
                }
                $data['pay_month'] = $payment_month;
                $data['view'] = 'payroll/_salary_payment_file.php';
                $this->load->view('_layout.php', $data);
            } else {
                $data['branches'] = $this->branches->get_array("SELECT * FROM tbl_branches");
                $data['view'] = 'payroll/_salary_payment_request.php';
                $this->load->view('_layout.php', $data);
            }
        }
    }

    public function generate_payslip()
    {
        if (_is_user_login($this)) {
            $branch_id = $this->uri->segment(3);
            $payment_month = $this->uri->segment(4);
            if (($branch_id >= 0) && ($payment_month != null)) {
                if ($branch_id > 0) {
                    $branch = $this->branches->get_row("SELECT * FROM tbl_branches WHERE branch_id = " . $branch_id);
                    if (!empty($branch)) {
                        $data['branch_id'] = $branch_id;
                        $data['branch'] = $branch->branch_name;
                        $data['branch_employees'] = $this->employees->get_array("SELECT * FROM tbl_employees e INNER JOIN tbl_branches b ON e.branch_id = b.branch_id WHERE e.branch_id = " . $branch_id);
                    } else {
                        redirect('payroll/makepayment');
                    }
                } else {
                    $data['branch_id'] = 0;
                    $data['branch'] = "All Branches";
                    $data['branch_employees'] = $this->employees->get_array("SELECT * FROM tbl_employees e INNER JOIN tbl_branches b ON e.branch_id = b.branch_id");
                }
                $data['pay_month'] = $payment_month;
                $data['payment_data'] = $this->employees->get_array("SELECT * FROM tbl_salary_payment  WHERE payment_month = '" . $payment_month . "'");
                $data['view'] = 'payroll/_generate_payslip.php';
                $this->load->view('_layout.php', $data);
            } else {
                $data['branches'] = $this->branches->get_array("SELECT * FROM tbl_branches");
                $data['view'] = 'payroll/_generate_payslip_request.php';
                $this->load->view('_layout.php', $data);
            }
        }
    }

    public function print_payslip()
    {
        if (_is_user_login($this)) {
            $data['title'] = ucfirst('Payslip');
            $emp_id = $this->uri->segment(3);
            $payment_month = $this->uri->segment(4);
            $data['emp_id'] = $emp_id;
            $data['payment_month'] = $payment_month;
            $data['payslip'] = $this->payroll->get_payslip($emp_id, $payment_month);

            $emp_name = $this->employees->get_fullname($emp_id);
            $this->employees->add_activity(array('activity_title' => 'Payroll', 'activity_description' => 'Printed Payslip for: ' . $emp_name->fullname . ', Month: ' . $payment_month, 'user_id' => _get_current_user_id($this)));

            $data['view'] = 'payroll/_print_payslip.php';
            $this->load->view('_layout.php', $data);
        }
    }

    public function print_all_payslip()
    {
        if (_is_user_login($this)) {
            if (isset($_POST['submit_payslip'])) {
                $branch_id = $this->input->post('branch_id');
                $pay_month = $this->input->post('payment_month');

                if (($branch_id >= 0) && ($pay_month != null)) {
                    if ($branch_id > 0) {
                        $branch = $this->branches->get_row("SELECT * FROM tbl_branches WHERE branch_id = " . $branch_id);
                        if (!empty($branch)) {
                            $data['branch_id'] = $branch_id;
                            $data['branch'] = $branch->branch_name;
                            $data['payslips'] = $this->payroll->get_all_payslip($branch_id, $pay_month);
                        } else {
                            redirect('payroll/generate_payslip/' . $branch_id . '/' . $pay_month);
                        }

                    } else {
                        $data['branch_id'] = 0;
                        $data['branch'] = "All Branches";
                        $data['payslips'] = $this->payroll->get_all_payslip(0, $pay_month);
                    }
                    // $emp_name = $this->employees->get_fullname($emp_id);
                    // $this->employees->add_activity(array('activity_title' => 'Payroll', 'activity_description' => 'Printed Payslip for: ' . $emp_name->fullname . ', Month: ' . $payment_month, 'user_id' => _get_current_user_id($this)));

                    $data['pay_month'] = $pay_month;
                    $data['view'] = 'payroll/_print_all_payslip.php';
                    $this->load->view('_layout.php', $data);
                } else {
                    redirect('payroll/generate_payslip');
                }
            } else {
                redirect('payroll/generate_payslip');
            }
        }
    }

    public function payroll_activities()
    {
        if (_is_user_login($this)) {
            $data['payroll_activities'] = $this->users->get_array("SELECT * FROM tbl_user_activities ua INNER JOIN tbl_users u ON u.user_id = ua.user_id WHERE (activity_title = 'Payroll' OR activity_title = 'Provident') ORDER BY ua.activity_id DESC");
            $data['view'] = 'payroll/_payroll_activities.php';
            $this->load->view('_layout.php', $data);
        }
    }

    public function salary_list()
    {
        if (_is_user_login($this)) {
            $data['salary_list'] = $this->users->get_array("SELECT * FROM tbl_employees e INNER JOIN tbl_positions p ON e.position_id=p.position_id WHERE p.position_id !='1' AND active ='1'");
            $data['view'] = 'payroll/_salary_list.php';
            $this->load->view('_layout.php', $data);
        }
    }

    public function update_base_salary()
    {
        if (_is_user_login($this)) {
            $emp_id = $this->input->post('emp_id');
            $base_salary = $this->input->post('base_salary');
            if (($emp_id > 0) && ($base_salary > 0)) {
                $id = $this->employees->edit('tbl_employees', array("base_salary" => $base_salary), array("emp_id" => $emp_id));
                $employee = $this->employees->get_row("SELECT fullname, base_salary FROM tbl_employees WHERE emp_id = " . $emp_id);
                if ($id > 0) {
                    $this->employees->add_activity(array('activity_title' => 'Payroll', 'activity_description' => 'Updated base salary of ' . $employee->fullname . ', to ' . $employee->base_salary, 'user_id' => _get_current_user_id($this)));
                    $this->session->set_flashdata('type', 'success');
                    $this->session->set_flashdata('title', 'Success');
                    $this->session->set_flashdata('text', 'Updated Successfully');
                } else {
                    $this->session->set_flashdata('type', 'danger');
                    $this->session->set_flashdata('title', 'Error');
                    $this->session->set_flashdata('text', 'Cannot Update');
                }
            } else {
                $this->session->set_flashdata('type', 'danger');
                $this->session->set_flashdata('title', 'Error');
                $this->session->set_flashdata('text', 'Some error occured');
            }
            redirect('payroll/salary_list');
        }
    }

}