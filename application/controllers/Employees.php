<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Employees extends CI_Controller
{

    public function index()
    {
        if (_is_user_login($this)) {
            $position = $this->uri->segment(2);
            if (($position >= 1) && ($position <= 5)) {
                $data['active'] = $position;
            } else {
                $data['active'] = 1;
            }
            $data['allconsultants'] = $this->employees->get_array("SELECT * FROM tbl_employees e INNER JOIN tbl_positions p ON e.position_id = p.position_id WHERE active = '1' AND e.position_id = '1'");
            $data['allsupervisors'] = $this->employees->get_array("SELECT * FROM tbl_employees e INNER JOIN tbl_positions p ON e.position_id = p.position_id WHERE active = '1' AND e.position_id = '2'");
            $data['allmanagers'] = $this->employees->get_array("SELECT * FROM tbl_employees e INNER JOIN tbl_positions p ON e.position_id = p.position_id WHERE active = '1' AND e.position_id = '3'");
            $data['allothers'] = $this->employees->get_array("SELECT * FROM tbl_employees e INNER JOIN tbl_positions p ON e.position_id = p.position_id WHERE active = '1' AND e.position_id != '1' AND e.position_id != '2' AND e.position_id != '3'");
            $data['allinactive'] = $this->employees->get_array("SELECT * FROM tbl_employees e INNER JOIN tbl_positions p ON e.position_id = p.position_id WHERE active = '0'");
//            $data['employees'] = $this->employees->get_array("SELECT * FROM tbl_employees WHERE active = '1'");
            $data['view'] = 'employees/_index.php';
            $this->load->view('_layout.php', $data);
        }
    }

    public function create()
    {
        if (_is_user_login($this)) {
            if ($this->input->post('submit_employee')) {
                $tab_id = $this->input->post('tab_id') ? $this->input->post('tab_id') : 1;
                $data_employee = array(
                    'fullname' => htmlentities(trim($this->input->post('fullname'))),
                    'emp_number' => htmlentities(trim($this->input->post('emp_number'))),
                    'national_id' => htmlentities(trim($this->input->post('national_id'))),
                    'gender' => htmlentities(trim($this->input->post('gender'))),
                    'date_of_birth' => htmlentities(trim($this->input->post('date_of_birth'))),
                    'phone' => htmlentities(trim($this->input->post('phone'))),
                    'email' => htmlentities(trim($this->input->post('email'))),
                    'branch_id' => $this->input->post('branch_id'),
                    'position_id' => $this->input->post('position_id'),
                    'base_salary' => $this->input->post('base_salary'),
                    'bank_name' => htmlentities(trim($this->input->post('bank_name'))),
                    'bank_account' => $this->input->post('bank_account'),
                    'branch_code' => htmlentities(trim($this->input->post('branch_code'))),
                    'bank_account_type' => $this->input->post('bank_account_type'),
                    'short_term' => $this->input->post('short_term'),
                    'premium' => $this->input->post('premium'),
                    'staff_party' => $this->input->post('staff_party'),
                    'long_term' => $this->input->post('long_term'),
                    'created' => (empty($this->input->post('created')))? date("Y-m-d H:i:s") : $this->input->post('created')
                );
                $national_id = htmlentities(trim($this->input->post('national_id')));
                $count_national_id = $this->employees->get_row("SELECT COUNT(national_id) AS total FROM tbl_employees WHERE national_id = '" . $national_id . "'");
                if ($count_national_id->total > 0) {
                    $this->session->set_flashdata('type', 'warning');
                    $this->session->set_flashdata('title', 'Warning');
                    $this->session->set_flashdata('text', 'Cannot Add Employee, ID/Passpord already exists');
                } else {
                    $id = $this->employees->add_employee($data_employee);
                    if ($id > 0) {
                        $this->employees->add_activity(array('activity_title' => 'Employee', 'activity_description' => 'Added new employee: ' . $this->input->post('employee_name'), 'user_id' => _get_current_user_id($this)));
                        $this->session->set_flashdata('type', 'success');
                        $this->session->set_flashdata('title', 'Success');
                        $this->session->set_flashdata('text', 'Added Successfully');
                    } else {
                        $this->session->set_flashdata('type', 'error');
                        $this->session->set_flashdata('title', 'Error');
                        $this->session->set_flashdata('text', 'Cannot Insert');
                    }
                    redirect('employees/' . $tab_id);
                }
                redirect('employees/' . $tab_id);
            } else {
                $data['pos_id'] = ($this->uri->segment(3) > 0) ? $this->uri->segment(3) : 0;
                $data['supervisors'] = $this->employees->get_array("SELECT * FROM tbl_employees e INNER JOIN tbl_positions p ON e.position_id = p.position_id WHERE active = '1' AND e.position_id = '2'");
                $data['managers'] = $this->employees->get_array("SELECT * FROM tbl_employees e INNER JOIN tbl_positions p ON e.position_id = p.position_id WHERE active = '1' AND e.position_id = '3'");
                $data['branches'] = $this->branches->get_array("SELECT * FROM tbl_branches");
                $data['view'] = 'employees/_create.php';
                $this->load->view('_layout.php', $data);
            }
        }
    }

    public function create_consultant()
    {
        if (_is_user_login($this)) {
            if ($this->input->post('submit_employee')) {
                $data_employee = array(

                    'fullname' => htmlentities(trim($this->input->post('fullname'))),
                    'emp_number' => htmlentities(trim($this->input->post('emp_number'))),
                    'national_id' => htmlentities(trim($this->input->post('national_id'))),
                    'gender' => htmlentities(trim($this->input->post('gender'))),
                    'date_of_birth' => htmlentities(trim($this->input->post('date_of_birth'))),
                    'phone' => htmlentities(trim($this->input->post('phone'))),
                    'email' => htmlentities(trim($this->input->post('email'))),
                    'branch_id' => $this->input->post('branch_id'),
                    'position_id' => 1,
					'base_salary' => $this->input->post('base_salary'),
                    'bank_name' => htmlentities(trim($this->input->post('bank_name'))),
                    'bank_account' => $this->input->post('bank_account'),
                    'branch_code' => htmlentities(trim($this->input->post('branch_code'))),
                    'bank_account_type' => $this->input->post('bank_account_type'),
                    'short_term' => $this->input->post('short_term'),
                    'long_term' => $this->input->post('long_term'),
                    'created' => (empty($this->input->post('created')))? date("Y-m-d H:i:s") : $this->input->post('created')
                );
                $national_id = htmlentities(trim($this->input->post('national_id')));
                $count_national_id = $this->employees->get_row("SELECT COUNT(national_id) AS total FROM tbl_employees WHERE national_id = '" . $national_id . "'");
                if ($count_national_id->total > 0) {
                    $this->session->set_flashdata('type', 'warning');
                    $this->session->set_flashdata('title', 'Warning');
                    $this->session->set_flashdata('text', 'Cannot Add Employee, ID/Passpord already exists');
                } else {
                    $id = $this->employees->add_employee($data_employee);
                    if ($id > 0) {
                        $this->employees->add_activity(array('activity_title' => 'Employee', 'activity_description' => 'Added new employee: ' . $this->input->post('employee_name'), 'user_id' => _get_current_user_id($this)));
                        $this->session->set_flashdata('type', 'success');
                        $this->session->set_flashdata('title', 'Success');
                        $this->session->set_flashdata('text', 'Added Successfully');
                    } else {
                        $this->session->set_flashdata('type', 'error');
                        $this->session->set_flashdata('title', 'Error');
                        $this->session->set_flashdata('text', 'Cannot Insert');
                    }
                    redirect('employees/' . $this->input->post('position_id'));
                }
                redirect('employees/' . $this->input->post('position_id'));
            } else {
                $data['supervisors'] = $this->employees->get_array("SELECT * FROM tbl_employees e INNER JOIN tbl_positions p ON e.position_id = p.position_id WHERE active = '1' AND e.position_id = '2'");
                $data['managers'] = $this->employees->get_array("SELECT * FROM tbl_employees e INNER JOIN tbl_positions p ON e.position_id = p.position_id WHERE active = '1' AND e.position_id = '3'");
                $data['branches'] = $this->branches->get_array("SELECT * FROM tbl_branches");
                $data['view'] = 'employees/_create_consultant.php';
                $this->load->view('_layout.php', $data);
            }
        }
    }

    public function edit()
    {
        if (_is_user_login($this)) {
            if ($this->input->post('update_employee')) {
                $tab_id = $this->input->post('tab_id') ? $this->input->post('tab_id') : 1;
                $data_employee = array(
                    'national_id' => htmlentities(trim($this->input->post('national_id'))),
                    'fullname' => htmlentities(trim($this->input->post('fullname'))),
                    'emp_number' => htmlentities(trim($this->input->post('emp_number'))),
                    'gender' => htmlentities(trim($this->input->post('gender'))),
                    'date_of_birth' => htmlentities(trim($this->input->post('date_of_birth'))),
                    'phone' => htmlentities(trim($this->input->post('phone'))),
                    'email' => htmlentities(trim($this->input->post('email'))),
                    'branch_id' => $this->input->post('branch_id'),
                    'position_id' => $this->input->post('position_id'),
                    'base_salary' => $this->input->post('base_salary'),
                    'bank_name' => htmlentities(trim($this->input->post('bank_name'))),
                    'bank_account' => $this->input->post('bank_account'),
                    'branch_code' => htmlentities(trim($this->input->post('branch_code'))),
                    'bank_account_type' => $this->input->post('bank_account_type'),
                    'short_term' => $this->input->post('short_term'),
                    'long_term' => $this->input->post('long_term'),
                    'premium' => $this->input->post('premium'),
                    'staff_party' => $this->input->post('staff_party'),
                    'created' => (empty($this->input->post('created')))? date("Y-m-d H:i:s") : $this->input->post('created')
                );
                if ($tab_id == 5) { // Activate an employee
                    $data_employee['active'] = '1';
                    $data_employee['inactive_reason'] = '';
                }
                $where = array(
                    'emp_id' => $this->input->post('emp_id'),
                );
                $id = $this->employees->update($data_employee, $where);
                if ($id > 0) {
                    $this->employees->add_activity(array('activity_title' => 'Employee', 'activity_description' => 'Updated employee: ' . $this->input->post('employee_name'), 'user_id' => _get_current_user_id($this)));
                    $this->session->set_flashdata('type', 'success');
                    $this->session->set_flashdata('title', 'Success');
                    $this->session->set_flashdata('text', 'Updated Successfully');
                } else {
                    $this->session->set_flashdata('type', 'error');
                    $this->session->set_flashdata('title', 'Error');
                    $this->session->set_flashdata('text', 'Cannot Update');
                }
                
                redirect('employees/' . $tab_id);
            } else {
                $id = ($this->uri->segment(3) > 1) ? $this->uri->segment(3) : 1;
                if ($id > 0) {
                    $data['employee'] = $this->employees->get_row("SELECT * FROM tbl_employees WHERE emp_id = " . $id);
                    $data['branches'] = $this->branches->get_array("SELECT * FROM tbl_branches");
                    $data['view'] = 'employees/_edit.php';
                    $this->load->view('_layout.php', $data);
                } else {
                    redirect('employees');
                }
            }
        }
    }

    public function edit_consultant()
    {
        if (_is_user_login($this)) {
            if ($this->input->post('update_employee')) {
                $data_employee = array(
                    'national_id' => htmlentities(trim($this->input->post('national_id'))),
                    'fullname' => htmlentities(trim($this->input->post('fullname'))),
                    'emp_number' => htmlentities(trim($this->input->post('emp_number'))),
                    'gender' => htmlentities(trim($this->input->post('gender'))),
                    'date_of_birth' => htmlentities(trim($this->input->post('date_of_birth'))),
                    'phone' => htmlentities(trim($this->input->post('phone'))),
                    'email' => htmlentities(trim($this->input->post('email'))),
                    'branch_id' => $this->input->post('branch_id'),
                    'bank_name' => htmlentities(trim($this->input->post('bank_name'))),
                    'bank_account' => $this->input->post('bank_account'),
                    'branch_code' => htmlentities(trim($this->input->post('branch_code'))),
                    'bank_account_type' => $this->input->post('bank_account_type'),
					'base_salary' => $this->input->post('base_salary'),
                    'short_term' => $this->input->post('short_term'),
                    'long_term' => $this->input->post('long_term'),
                    'created' => (empty($this->input->post('created')))? date("Y-m-d H:i:s") : $this->input->post('created')
                );
                $where = array(
                    'emp_id' => $this->input->post('emp_id'),
                );
                $id = $this->employees->update($data_employee, $where);
                if ($id > 0) {
                    $this->employees->add_activity(array('activity_title' => 'Employee', 'activity_description' => 'Updated employee: ' . $this->input->post('employee_name'), 'user_id' => _get_current_user_id($this)));
                    $this->session->set_flashdata('type', 'success');
                    $this->session->set_flashdata('title', 'Success');
                    $this->session->set_flashdata('text', 'Updated Successfully');
                } else {
                    $this->session->set_flashdata('type', 'error');
                    $this->session->set_flashdata('title', 'Error');
                    $this->session->set_flashdata('text', 'Cannot Update');
                }
                redirect('employees');
            } else {
                $id = ($this->uri->segment(3) > 1) ? $this->uri->segment(3) : 1;
                if ($id > 0) {
                    $data['employee'] = $this->employees->get_row("SELECT * FROM tbl_employees WHERE emp_id = " . $id);
                    $data['branches'] = $this->branches->get_array("SELECT * FROM tbl_branches");
                    $data['view'] = 'employees/_edit_consultant.php';
                    $this->load->view('_layout.php', $data);
                } else {
                    redirect('employees');
                }
            }
        }
    }

    public function assign_manager()
    {
        if (_is_user_login($this)) {
            $emp_id = $this->input->post('emp_id');
            $manager_id = $this->input->post('manager_id');
            if (($emp_id > 0) && ($manager_id > 0)) {
                $id = $this->employees->edit('tbl_employees', array("manager_id" => $manager_id), array("emp_id" => $emp_id));
                if ($id > 0) {
                    $this->employees->add_activity(array('activity_title' => 'Employee', 'activity_description' => 'Updated employee Manager with id ' . $emp_id, 'user_id' => _get_current_user_id($this)));
                    $this->session->set_flashdata('type', 'success');
                    $this->session->set_flashdata('title', 'Success');
                    $this->session->set_flashdata('text', 'Updated Successfully');
                } else {
                    $this->session->set_flashdata('type', 'error');
                    $this->session->set_flashdata('title', 'Error');
                    $this->session->set_flashdata('text', 'Cannot Update');
                }
            } else {
                $this->session->set_flashdata('type', 'error');
                $this->session->set_flashdata('title', 'Error');
                $this->session->set_flashdata('text', 'Some error occured');
            }
            redirect('employees/2');
        }
    }

    public function assign_supervisor()
    {
        if (_is_user_login($this)) {
            $emp_id = $this->input->post('emp_id');
            $supervisor_id = $this->input->post('supervisor_id');
            if (($emp_id > 0) && ($supervisor_id > 0)) {
                $id = $this->employees->edit('tbl_employees', array("supervisor_id" => $supervisor_id), array("emp_id" => $emp_id));
                if ($id > 0) {
                    $this->employees->add_activity(array('activity_title' => 'Employee', 'activity_description' => 'Updated employee Supervisor with id: ' . $emp_id, 'user_id' => _get_current_user_id($this)));
                    $this->session->set_flashdata('type', 'success');
                    $this->session->set_flashdata('title', 'Success');
                    $this->session->set_flashdata('text', 'Updated Successfully');
                } else {
                    $this->session->set_flashdata('type', 'error');
                    $this->session->set_flashdata('title', 'Error');
                    $this->session->set_flashdata('text', 'Cannot Update');
                }
            } else {
                $this->session->set_flashdata('type', 'error');
                $this->session->set_flashdata('title', 'Error');
                $this->session->set_flashdata('text', 'Some error occured');
            }
            redirect('employees/1');
        }
    }

    public function delete()
    {
        if (_is_user_login($this)) {
            $id = ($this->uri->segment(3) > 1) ? $this->uri->segment(3) : 1;
            $employee = $this->employees->get_row("SELECT * FROM tbl_employees WHERE emp_id = " . $id);
            $data['employee'] = $employee;
            if (empty($employee)) {
                redirect('employees');
            } else {
                if ($this->input->post('delete_employee')) {
                    $emp_id = $this->input->post('emp_id');
                    $inactive_reason = htmlentities(trim($this->input->post('inactive_reason')));
                    $id = $this->employees->update(['active' => '0', 'inactive_reason' => $inactive_reason], ['emp_id' => $emp_id]);
                    if ($id > 0) {
                        $this->employees->add_activity(array('activity_title' => 'Employee', 'activity_description' => 'Removed employee: ' . $employee->fullname, 'user_id' => _get_current_user_id($this)));
                        $this->session->set_flashdata('type', 'success');
                        $this->session->set_flashdata('title', 'Success');
                        $this->session->set_flashdata('text', 'Deleted Successfully');
                    } else {
                        $this->session->set_flashdata('type', 'error');
                        $this->session->set_flashdata('title', 'Error');
                        $this->session->set_flashdata('text', 'Cannot Delete');
                    }
                    $tab_id = $this->input->post('tab_id') ? $this->input->post('tab_id') : 1;
                    redirect('employees/' . $tab_id);

                } else {
                    $data['view'] = 'employees/_delete.php';
                    $this->load->view('_layout.php', $data);
                }
            }
        }
    }

}