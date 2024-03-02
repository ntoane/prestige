<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Branches extends CI_Controller {

    public function index() {
        if (_is_user_login($this)) {
            $data['branches'] = $this->users->get_array("SELECT * FROM tbl_branches");
            $data['view'] = 'branches/_index.php';
            $this->load->view('_layout.php', $data);
        }
    }

    public function create() {
        if (_is_user_login($this)) {
            if ($this->input->post('submit_branch')) {
                $data_branch = array(
                    'branch_code' => $this->input->post('branch_code'),
                    'branch_name' => $this->input->post('branch_name'),
                    'branch_district' => $this->input->post('branch_district')
                );
                $id = $this->branches->add_branch($data_branch);
                if ($id > 0) {
                    $this->branches->add_activity(array('activity_title' => 'Branch', 'activity_description' => 'Added new branch: ' . $this->input->post('branch_name'), 'user_id' => _get_current_user_id($this)));
                    $this->session->set_flashdata('type', 'success');
                    $this->session->set_flashdata('title', 'Success');
                    $this->session->set_flashdata('text', 'Added Successfully');
                } else {
                    $this->session->set_flashdata('type', 'danger');
                    $this->session->set_flashdata('title', 'Error');
                    $this->session->set_flashdata('text', 'Cannot Insert');
                }
                redirect('branches');
            } else {
                $data['view'] = 'branches/_create.php';
                $this->load->view('_layout.php', $data);
            }
        }
    }

    public function edit() {
        if (_is_user_login($this)) {
            if ($this->input->post('update_branch')) {
                $data_branch = array(
                    'branch_code' => $this->input->post('branch_code'),
                    'branch_name' => $this->input->post('branch_name'),
                    'branch_district' => $this->input->post('branch_district')
                );
                $where = array(
                    'branch_id' => $this->input->post('branch_id')
                );
                $id = $this->branches->update($data_branch, $where);
                if ($id > 0) {
                    $this->branches->add_activity(array('activity_title' => 'Branch', 'activity_description' => 'Updated branch: ' . $this->input->post('branch_name'), 'user_id' => _get_current_user_id($this)));
                    $this->session->set_flashdata('type', 'success');
                    $this->session->set_flashdata('title', 'Success');
                    $this->session->set_flashdata('text', 'Updated Successfully');
                } else {
                    $this->session->set_flashdata('type', 'danger');
                    $this->session->set_flashdata('title', 'Error');
                    $this->session->set_flashdata('text', 'Cannot Update');
                }
                redirect('branches');
            } else {
                $id = ($this->uri->segment(3) > 0) ? $this->uri->segment(3) : 0;
                if ($id > 0) {
                    $data['branch'] = $this->branches->get_row("SELECT * FROM tbl_branches WHERE branch_id = " . $id);
                    $data['view'] = 'branches/_edit.php';
                    $this->load->view('_layout.php', $data);
                } else {
                    redirect('branches');
                }
            }
        }
    }

    public function is_associative ($branch_id) {
        if (_is_user_login($this)) {
            $has_records = $this->branches->get_array("SELECT * FROM tbl_branches b INNER JOIN tbl_employees e ON b.branch_id = e.branch_id 
                WHERE b.branch_id = ".$branch_id);
            if(!empty($has_records)) {
                return true;
            }else {
                return false;
            }
        }
    }

    public function delete() {
        if (_is_user_login($this)) {
            $branch_id = $this->uri->segment(3);
            if ($branch_id > 0) {
                if($this->is_associative($branch_id)) {
                    $this->session->set_flashdata('type', 'error');
                    $this->session->set_flashdata('title', 'Error');
                    $this->session->set_flashdata('text', 'Cannot delete this Branch Name, it is already associated with an employee data, You can only edit!');
                    redirect('branches');
                }else {
                    $delete_flag=$this->branches->delete_branch($branch_id);
                    if($delete_flag) {
                        $this->session->set_flashdata('type', 'success');
                        $this->session->set_flashdata('title', 'Success');
                        $this->session->set_flashdata('text', 'Branch name removed Successfully');
                    }else {
                        $this->session->set_flashdata('type', 'error');
                        $this->session->set_flashdata('title', 'Error');
                        $this->session->set_flashdata('text', 'Unable to delete this Branch name');
                    }
                }
                redirect('branches');
            } else {
                redirect('branches');
            }
        } 
    }

}
