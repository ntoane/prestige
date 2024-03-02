<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Loan extends CI_Controller
{

    public function index()
    {
        if (_is_user_login($this)) {
            if ($this->input->post('submit_loan') == 'Go') {
                $loan_type = $this->input->post('loan_type');
                if ($loan_type == '1') {
                    redirect('loan/active_loans');
                } else if ($loan_type == 2) {
                    redirect('loan/load_deductions');
                } else if ($loan_type == 3) {
                    redirect('loan/load_allowances');
                } else {
                    redirect('loan');
                }
            } else {
                $data['view'] = 'loan/_loan_request';
                $this->load->view('_layout', $data);
            }
        }
    }

    public function load_deductions()
    {
        if (_is_user_login($this)) {
            $data['deductions'] = $this->loan->get_array("SELECT * FROM tbl_loans WHERE loan_type ='deduction' ORDER BY emp_id, loan_status");
            $data['view'] = 'loan/_deductions';
            $this->load->view('_layout', $data);
        }
    }

    public function new_deduction()
    {
        if (_is_user_login($this)) {
            $data['employees'] = $this->loan->get_array("SELECT * FROM tbl_employees WHERE active='1'");
            $data['view'] = 'loan/_new_deduction';
            $this->load->view('_layout', $data);
        }
    }

    public function record_deduction()
    {
        if (_is_user_login($this)) {
            if (isset($_POST['deduction'])) {
                $deduction_exist = $this->loan->get_row("SELECT * FROM tbl_loans WHERE loan_type = 'deduction' AND loan_status='0' AND emp_id=" . $this->input->post('emp_id'));
                if (empty($deduction_exist)) {
                    $data = array(
                        'emp_id' => $this->input->post('emp_id'),
                        'debt_label' => $this->input->post('deduction_label'),
                        'loan_amount' => round($this->input->post('deduction_amount'), 2),
                        'outstanding_balance' => $this->input->post('deduction_amount'),
                        'loan_period' => $this->input->post('period'),
                        'loan_installment' => round($this->input->post('deduction_amount') / $this->input->post('period'), 2),
                        'loan_status' => "0",
                        'loan_type' => "deduction",
                    );

                    $id = $this->loan->add_loan($data);
                    if ($id > 0) {
                        $this->session->set_flashdata('type', 'success');
                        $this->session->set_flashdata('title', 'Success');
                        $this->session->set_flashdata('text', 'Deduction Added Successfully');
                    } else {
                        $this->session->set_flashdata('type', 'error');
                        $this->session->set_flashdata('title', 'Error');
                        $this->session->set_flashdata('text', 'Deduction NOT Added');
                    }
                } else {
                    $this->session->set_flashdata('type', 'error');
                    $this->session->set_flashdata('title', 'Error');
                    $this->session->set_flashdata('text', 'There is already a scheduled Deduction');
                }
            }

            redirect('loan/load_deductions');
        }
    }

    public function delete_deduction()
    {
        if (_is_user_login($this)) {
            $loan_id = $this->uri->segment(3);
            if ($loan_id > 0) {
                $delete_flag = $this->loan->delete_loan($loan_id);
                if ($delete_flag) {
                    $this->session->set_flashdata('type', 'success');
                    $this->session->set_flashdata('title', 'Success');
                    $this->session->set_flashdata('text', 'Deduction removed Successfully');
                } else {
                    $this->session->set_flashdata('type', 'error');
                    $this->session->set_flashdata('title', 'Error');
                    $this->session->set_flashdata('text', 'Unable to delete this Deduction');
                }
            }
            redirect('loan/load_deductions');
        }
    }

    public function load_allowances()
    {
        if (_is_user_login($this)) {
            $data['allowances'] = $this->loan->get_array("SELECT * FROM tbl_loans WHERE loan_type ='allowance' ORDER BY emp_id, loan_status");
            $data['view'] = 'loan/_allowances';
            $this->load->view('_layout', $data);
        }
    }

    public function new_allowance()
    {
        if (_is_user_login($this)) {
            $data['employees'] = $this->loan->get_array("SELECT * FROM tbl_employees WHERE active='1'");
            $data['view'] = 'loan/_new_allowance';
            $this->load->view('_layout', $data);
        }
    }

    public function record_allowance()
    {
        if (_is_user_login($this)) {
            if (isset($_POST['allowance'])) {
                $allowance_exist = $this->loan->get_row("SELECT * FROM tbl_loans WHERE loan_type = 'allowance' AND loan_status='0' AND emp_id=" . $this->input->post('emp_id'));
                if (empty($allowance_exist)) {
                    $data = array(
                        'emp_id' => $this->input->post('emp_id'),
                        'debt_label' => $this->input->post('allowance_label'),
                        'loan_amount' => round($this->input->post('allowance_amount'), 2),
                        'outstanding_balance' => $this->input->post('allowance_amount'),
                        'loan_period' => $this->input->post('period'),
                        'loan_installment' => round($this->input->post('allowance_amount') / $this->input->post('period'), 2),
                        'loan_status' => "0",
                        'loan_type' => "allowance",
                    );

                    $id = $this->loan->add_loan($data);
                    if ($id > 0) {
                        $this->session->set_flashdata('type', 'success');
                        $this->session->set_flashdata('title', 'Success');
                        $this->session->set_flashdata('text', 'Allowance Added Successfully');
                    } else {
                        $this->session->set_flashdata('type', 'error');
                        $this->session->set_flashdata('title', 'Error');
                        $this->session->set_flashdata('text', 'Allowance NOT Added');
                    }
                } else {
                    $this->session->set_flashdata('type', 'error');
                    $this->session->set_flashdata('title', 'Error');
                    $this->session->set_flashdata('text', 'There is already a scheduled Allowance');
                }
            }

            redirect('loan/load_allowances');
        }
    }

    public function delete_allowance()
    {
        if (_is_user_login($this)) {
            $loan_id = $this->uri->segment(3);
            if ($loan_id > 0) {
                $delete_flag = $this->loan->delete_loan($loan_id);
                if ($delete_flag) {
                    $this->session->set_flashdata('type', 'success');
                    $this->session->set_flashdata('title', 'Success');
                    $this->session->set_flashdata('text', 'Allowance removed Successfully');
                } else {
                    $this->session->set_flashdata('type', 'error');
                    $this->session->set_flashdata('title', 'Error');
                    $this->session->set_flashdata('text', 'Unable to delete this Allowance');
                }
            }
            redirect('loan/load_allowances');
        }
    }

    public function active_loans()
    {
        if (_is_user_login($this)) {
            $data['title'] = ucfirst('Loan');
            $data['active_loans'] = $this->loan->get_array("SELECT * FROM tbl_loans WHERE loan_type ='loan' AND loan_status = '0' OR loan_status = '3'");
            $data['view'] = 'loan/_active_loans';
            $this->load->view('_layout', $data);
        }
    }

    public function new_loan()
    {
        if (_is_user_login($this)) {
            $data['title'] = ucfirst('New Loan Application');
            $data['view'] = 'loan/_new_loan';
            $this->load->view('_layout', $data);
        }
    }
    public function confirm_loan()
    {
        if (_is_user_login($this)) {
            $data = array(
                'emp_id' => $this->input->post('emp_id'),
                'loan_amount' => $this->input->post('loan_amount'),
                'period' => $this->input->post('period'),
            );

            $data['title'] = ucfirst('New Loan Application');
            $data['view'] = 'loan/_confirm_loan';
            $this->load->view('_layout', $data);
        }
    }

    public function record_loan()
    {
        if (_is_user_login($this)) {
            $data = array(
                'emp_id' => $this->input->post('emp_id'),
                'loan_amount' => round($this->input->post('loan_amount'), 2),
                'outstanding_balance' => round($this->input->post('loan_amount'), 2),
                'loan_period' => $this->input->post('period'),
                'loan_installment' => round($this->input->post('installment'), 2),
                'loan_status' => "0",
            );

            $this->loan->add_loan($data);
            $this->session->set_flashdata('type', 'success');
            $this->session->set_flashdata('title', 'Success');
            $this->session->set_flashdata('text', 'Loan Applied Successfully');
            redirect('loan/active_loans');
        }
    }

    public function settled_loans()
    {
        if (_is_user_login($this)) {
            $settled_loans = $this->users->get_array("SELECT * FROM tbl_loans WHERE loan_status='1' AND loan_type ='loan' ");
            $data['settled_loans'] = $settled_loans;
            $data['title'] = ucfirst('Settled Loans');
            $data['view'] = 'loan/_settled_loans';
            $this->load->view('_layout', $data);
        }
    }

    public function revolved_loans()
    {
        if (_is_user_login($this)) {
            $revolved_loans = $this->users->get_array("SELECT * FROM tbl_loans WHERE loan_status='2' AND loan_type ='loan' ");
            $data['revolved_loans'] = $revolved_loans;
            $data['title'] = ucfirst('Reveloved Loans');
            $data['view'] = 'loan/_revolved_loans';
            $this->load->view('_layout', $data);
        }
    }

    public function all_loans()
    {
        if (_is_user_login($this)) {
            $all_loans = $this->users->get_array("SELECT * FROM tbl_loans WHERE loan_type ='loan'");
            $data['all_loans'] = $all_loans;
            $data['title'] = ucfirst('All Loans');
            $data['view'] = 'loan/_all_loans';
            $this->load->view('_layout', $data);
        }
    }

    public function settle_loan()
    {
        if (_is_user_login($this)) {
            $loan_id = $this->uri->segment(3);
            $data['loan_id'] = $loan_id;
            $data['title'] = ucfirst('All Loans');
            $data['view'] = 'loan/_settle_loan';
            $this->load->view('_layout', $data);
        }
    }

    public function settled_loan()
    {
        if (_is_user_login($this)) {
            $outstanding_balance = $this->input->post('outstanding_balance');
            $settlement_amount = $this->input->post('settlement_amount');
            $loan_id = $this->input->post('loan_id');
            $where = array('loan_id' => $loan_id);
            $get_settlement_amount = $this->users->get_row("SELECT settlement_amount FROM tbl_loans WHERE loan_id=" . $loan_id);
            $record_settlement_amount = $settlement_amount + $get_settlement_amount->settlement_amount;

            if ($outstanding_balance == $settlement_amount) {
                $data = array('outstanding_balance' => 0, 'settlement_amount' => $record_settlement_amount, 'loan_status' => '1');
                $id = $this->loan->update_loan($data, $where);
            } else {
                $update_outstanding = $outstanding_balance - $settlement_amount;
                $data = array('outstanding_balance' => $update_outstanding, 'settlement_amount' => $record_settlement_amount);
                $id = $this->loan->update_loan($data, $where);
            }
            $this->session->set_flashdata('type', 'success');
            $this->session->set_flashdata('title', 'Success');
            $this->session->set_flashdata('text', 'Loan Updated Successfully');
            redirect('loan/settled_loans');
        }
    }

    public function revolve_loan()
    {
        if (_is_user_login($this)) {
            $loan_id = $this->uri->segment(3);
            $data['loan_id'] = $loan_id;
            $data['title'] = ucfirst('All Loans');
            $data['view'] = 'loan/_revolve_loan';
            $this->load->view('_layout', $data);
        }
    }

    public function revolved_loan()
    {
        if (_is_user_login($this)) {
            $outstanding_balance = $this->input->post('outstanding_balance');
            $settlement_amount = $this->input->post('settlement_amount');
            $topup_amount = $this->input->post('topup_amount');
            $loan_period = $this->input->post('loan_period');
            $loan_id = $this->input->post('loan_id');
            $where = array('loan_id' => $loan_id);

            $get_settlement_amount = $this->users->get_row("SELECT settlement_amount FROM tbl_loans WHERE loan_id=$loan_id");
            $record_settlement_amount = $settlement_amount + $get_settlement_amount->settlement_amount;

            $data = array('outstanding_balance' => 0, 'settlement_amount' => $record_settlement_amount, 'loan_status' => '2');
            $topup_amount = $this->input->post('topup_amount');
            $new_loan_amount = $topup_amount + $outstanding_balance;
            $loan_period = $this->input->post('loan_period');
            $installment = $new_loan_amount / $loan_period;
            $data_1 = array(
                'emp_id' => $this->input->post('emp_id'),
                'loan_amount' => $new_loan_amount,
                'outstanding_balance' => $new_loan_amount,
                'loan_period' => $loan_period,
                'loan_installment' => $installment,
                'loan_status' => "0",
            );

            $this->loan->add_loan($data_1);
            $this->loan->update_loan($data, $where);

            $this->session->set_flashdata('type', 'success');
            $this->session->set_flashdata('title', 'Success');
            $this->session->set_flashdata('text', 'Loan Revolved and New Loan Applied Successfully');
            redirect('loan/revolved_loans');
        }
    }

    public function relieve_loan() {
        if(_is_user_login($this)) {
            $loan_id = $this->uri->segment(3);
            $data = array('loan_status' => '3');
            $where = array('loan_id' => $loan_id);

            if($loan_id > 0) {
                $id = $this->loan->update_loan($data, $where);

                if($id > 0) {
                    $this->session->set_flashdata('type', 'success');
                    $this->session->set_flashdata('title', 'Success');
                    $this->session->set_flashdata('text', 'Loan Relieved successfully');
                }else {
                    $this->session->set_flashdata('type', 'error');
                    $this->session->set_flashdata('title', 'Error');
                    $this->session->set_flashdata('text', 'Loan was NOT updated!');
                }
            }else {
                $this->session->set_flashdata('type', 'error');
                $this->session->set_flashdata('title', 'Error');
                $this->session->set_flashdata('text', 'Loan Undefined');
            }
            redirect('loan/active_loans');
        }   
    }

    public function unrelieve_loan() {
        if(_is_user_login($this)) {
            $loan_id = $this->uri->segment(3);
            $data = array('loan_status' => '0');
            $where = array('loan_id' => $loan_id);

            if($loan_id > 0) {
                $id = $this->loan->update_loan($data, $where);

                if($id > 0) {
                    $this->session->set_flashdata('type', 'success');
                    $this->session->set_flashdata('title', 'Success');
                    $this->session->set_flashdata('text', 'Loan Unrelieved successfully');
                }else {
                    $this->session->set_flashdata('type', 'error');
                    $this->session->set_flashdata('title', 'Error');
                    $this->session->set_flashdata('text', 'Loan was NOT updated!');
                }
            }else {
                $this->session->set_flashdata('type', 'error');
                $this->session->set_flashdata('title', 'Error');
                $this->session->set_flashdata('text', 'Loan Undefined');
            }
            redirect('loan/active_loans');
        }   
    }
}