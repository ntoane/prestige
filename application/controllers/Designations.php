<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Designations extends CI_Controller {

    public function index() {
        if (_is_user_login($this)) {
            $data['designations'] = $this->users->get_array("SELECT * FROM tbl_positions");
            $data['view'] = 'designations/_index.php';
            $this->load->view('_layout.php', $data);
        }
    }

    public function create() {
        if (_is_user_login($this)) {
            if ($this->input->post('submit_designation')) {
                $data_designation = array(
                    'position_name' => $this->input->post('designation_name')
                );
                $id = $this->designations->add_designation($data_designation);
                if ($id > 0) {
                    $this->designations->add_activity(array('activity_title' => 'Designation', 'activity_description' => 'Added new Designation: ' . $this->input->post('designation_name'), 'user_id' => _get_current_user_id($this)));
                    $this->session->set_flashdata('type', 'success');
                    $this->session->set_flashdata('title', 'Success');
                    $this->session->set_flashdata('text', 'Designation Added Successfully');
                } else {
                    $this->session->set_flashdata('type', 'danger');
                    $this->session->set_flashdata('title', 'Error');
                    $this->session->set_flashdata('text', 'Cannot Insert');
                }
                redirect('designations');
            } else {
                $data['view'] = 'designations/_create.php';
                $this->load->view('_layout.php', $data);
            }
        }
    }

    public function edit() {
        if (_is_user_login($this)) {
            if ($this->input->post('update_designation')) {
                $data_designation = array(
                    'position_name' => $this->input->post('designation_name')
                );
                $where = array(
                    'position_id' => $this->input->post('designation_id')
                );
                $id = $this->designations->update($data_designation, $where);
                if ($id > 0) {
                    $this->designations->add_activity(array('activity_title' => 'Designation', 'activity_description' => 'Updated designation: ' . $this->input->post('designation_name'), 'user_id' => _get_current_user_id($this)));
                    $this->session->set_flashdata('type', 'success');
                    $this->session->set_flashdata('title', 'Success');
                    $this->session->set_flashdata('text', 'Designation Updated Successfully');
                } else {
                    $this->session->set_flashdata('type', 'danger');
                    $this->session->set_flashdata('title', 'Error');
                    $this->session->set_flashdata('text', 'Cannot Update');
                }
                redirect('designations');
            } else {
                $id = ($this->uri->segment(3) > 0) ? $this->uri->segment(3) : 0;
                if ($id > 0) {
                    $data['designation'] = $this->policies->get_row("SELECT * FROM tbl_positions WHERE position_id = " . $id);
                    $data['view'] = 'designations/_edit.php';
                    $this->load->view('_layout.php', $data);
                } else {
                    redirect('designations');
                }
            }
        }
    }

    public function is_associative ($position_id) {
        if (_is_user_login($this)) {
            $has_records = $this->designations->get_array("SELECT * FROM tbl_positions p INNER JOIN tbl_employees e ON p.position_id = e.position_id 
                WHERE p.position_id = ".$position_id);
            if(!empty($has_records)) {
                return true;
            }else {
                return false;
            }
        }
    }

    public function delete() {
        if (_is_user_login($this)) {
            $position_id = $this->uri->segment(3);
            if ($position_id > 0) {
                if($this->is_associative($position_id)) {
                    $this->session->set_flashdata('type', 'error');
                    $this->session->set_flashdata('title', 'Error');
                    $this->session->set_flashdata('text', 'Cannot delete this Designation, it is already associated with an employee data, You can only edit!');
                    redirect('designations');
                }else {
                    $delete_flag=$this->designations->delete_designation($position_id);
                    if($delete_flag) {
                        $this->session->set_flashdata('type', 'success');
                        $this->session->set_flashdata('title', 'Success');
                        $this->session->set_flashdata('text', 'Designation removed Successfully');
                    }else {
                        $this->session->set_flashdata('type', 'error');
                        $this->session->set_flashdata('title', 'Error');
                        $this->session->set_flashdata('text', 'Unable to delete Designation');
                    }
                }
                redirect('designations');
            } else {
                redirect('designations');
            }
        } 
    }

}
