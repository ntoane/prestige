<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Policies extends CI_Controller {

    public function index() {
        if (_is_user_login($this)) {
            $data['policies'] = $this->users->get_array("SELECT * FROM tbl_policies");
            $data['view'] = 'policies/_index.php';
            $this->load->view('_layout.php', $data);
        }
    }

    public function create() {
        if (_is_user_login($this)) {
            if ($this->input->post('submit_policy')) {
                $data_policy = array(
                    'policy_name' => $this->input->post('policy_name'),
                    'policy_amount' => $this->input->post('policy_amount')
                );
                $id = $this->policies->add_policy($data_policy);
                if ($id > 0) {
                    $this->policies->add_activity(array('activity_title' => 'Policy', 'activity_description' => 'Added new policy: ' . $this->input->post('policy_name'), 'user_id' => _get_current_user_id($this)));
                    $this->session->set_flashdata('type', 'success');
                    $this->session->set_flashdata('title', 'Success');
                    $this->session->set_flashdata('text', 'Added Successfully');
                } else {
                    $this->session->set_flashdata('type', 'danger');
                    $this->session->set_flashdata('title', 'Error');
                    $this->session->set_flashdata('text', 'Cannot Insert');
                }
                redirect('policies');
            } else {
                $data['view'] = 'policies/_create.php';
                $this->load->view('_layout.php', $data);
            }
        }
    }

    public function edit() {
        if (_is_user_login($this)) {
            if ($this->input->post('update_policy')) {
                $data_policy = array(
                    'policy_name' => $this->input->post('policy_name'),
                    'policy_amount' => $this->input->post('policy_amount')
                );
                $where = array(
                    'policy_id' => $this->input->post('policy_id')
                );
                $id = $this->policies->update($data_policy, $where);
                if ($id > 0) {
                    $this->policies->add_activity(array('activity_title' => 'Policy', 'activity_description' => 'Updated policy: ' . $this->input->post('policy_name'), 'user_id' => _get_current_user_id($this)));
                    $this->session->set_flashdata('type', 'success');
                    $this->session->set_flashdata('title', 'Success');
                    $this->session->set_flashdata('text', 'Updated Successfully');
                } else {
                    $this->session->set_flashdata('type', 'danger');
                    $this->session->set_flashdata('title', 'Error');
                    $this->session->set_flashdata('text', 'Cannot Update');
                }
                redirect('policies');
            } else {
                $id = ($this->uri->segment(3) > 0) ? $this->uri->segment(3) : 0;
                if ($id > 0) {
                    $data['policy'] = $this->policies->get_row("SELECT * FROM tbl_policies WHERE policy_id = " . $id);
                    $data['view'] = 'policies/_edit.php';
                    $this->load->view('_layout.php', $data);
                } else {
                    redirect('policies');
                }
            }
        }
    }

}
