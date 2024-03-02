<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class User_access extends CI_Controller {

    public function index() {
        if (_is_user_login($this)) {
            $data['user_access'] = $this->users->get_array("SELECT * FROM tbl_user_types WHERE user_type_id !=1");
            $data['view'] = 'user_access/_user_access__request.php';
            $this->load->view('_layout.php', $data);
        }
    }

    public function load_roles() {
        if (_is_user_login($this)) {
            $data['user_roles'] = $this->users->get_array("SELECT * FROM tbl_user_types WHERE user_type_id !=1");
            $data['view'] = 'user_access/_roles.php';
            $this->load->view('_layout.php', $data);
        }
    }

    public function create_role() {
        if (_is_user_login($this)) {
            if ($this->input->post('submit_role')) {
                $data_role = array(
                    'role' => $this->input->post('role_name')
                );
                $id = $this->user_access->add_role($data_role);
                if ($id > 0) {
                    $this->user_access->add_activity(array('activity_title' => 'User Role', 'activity_description' => 'Added new User Role: ' . $this->input->post('role_name'), 'user_id' => _get_current_user_id($this)));
                    $this->session->set_flashdata('type', 'success');
                    $this->session->set_flashdata('title', 'Success');
                    $this->session->set_flashdata('text', 'User Role Added Successfully');
                } else {
                    $this->session->set_flashdata('type', 'danger');
                    $this->session->set_flashdata('title', 'Error');
                    $this->session->set_flashdata('text', 'Cannot Insert');
                }
                redirect('user_access/load_roles');
            } else {
                $data['view'] = 'user_access/_create_role.php';
                $this->load->view('_layout.php', $data);
            }
        }
    }

    public function edit_role() {
        if (_is_user_login($this)) {
            if ($this->input->post('update_role')) {
                $data_role = array(
                    'role' => $this->input->post('role_name')
                );
                $where = array(
                    'user_type_id' => $this->input->post('user_type_id')
                );
                $id = $this->user_access->update_role($data_role, $where);
                if ($id > 0) {
                    $this->user_access->add_activity(array('activity_title' => 'User Role', 'activity_description' => 'Updated user role: ' . $this->input->post('role_name'), 'user_id' => _get_current_user_id($this)));
                    $this->session->set_flashdata('type', 'success');
                    $this->session->set_flashdata('title', 'Success');
                    $this->session->set_flashdata('text', 'User Role Updated Successfully');
                } else {
                    $this->session->set_flashdata('type', 'danger');
                    $this->session->set_flashdata('title', 'Error');
                    $this->session->set_flashdata('text', 'Cannot Update');
                }
                redirect('user_access/load_roles');
            } else {
                $id = ($this->uri->segment(3) > 0) ? $this->uri->segment(3) : 0;
                if ($id > 0) {
                    $data['role'] = $this->policies->get_row("SELECT * FROM tbl_user_types WHERE user_type_id = " . $id);
                    $data['view'] = 'user_access/_edit_role.php';
                    $this->load->view('_layout.php', $data);
                } else {
                    redirect('user_access/load_roles');
                }
            }
        }
    }

    public function is_associative ($user_type_id) {
        if (_is_user_login($this)) {
            $has_records = $this->user_access->get_array("SELECT * FROM tbl_user_types t INNER JOIN tbl_users u ON t.user_type_id= u.user_type_id 
                WHERE t.user_type_id = ".$user_type_id);
            if(!empty($has_records)) {
                return true;
            }else {
                return false;
            }
        }
    }

    public function delete_role() {
        if(_is_user_login($this)) {
            $user_type_id = $this->uri->segment(3);
            if($user_type_id > 0) {
                if($this->is_associative($user_type_id)) {
                    $this->session->set_flashdata('type', 'error');
                    $this->session->set_flashdata('title', 'Error');
                    $this->session->set_flashdata('text', 'Cannot delete this User Role, it is already associated with a user data, You can only edit!');
                    redirect('user_access/load_roles');
                }else {
                    $role_to_delete = $this->user_access->get_row("SELECT * FROM tbl_user_types WHERE user_type_id = ".$user_type_id);
                    $delete_flag = $this->user_access->delete_role($user_type_id);
                    if ($delete_flag) {
                        $this->user_access->delete_access_role($user_type_id);

                        $this->users->add_activity(array('activity_title' => 'User Role', 'activity_description' => 'Deleted User Role: ' .$role_to_delete->role));
                        $this->session->set_flashdata('type', 'success');
                        $this->session->set_flashdata('title', 'Success');
                        $this->session->set_flashdata('text', 'Deleted User Role Successfully');
                    } else {
                        $this->session->set_flashdata('type', 'error');
                        $this->session->set_flashdata('title', 'Error');
                        $this->session->set_flashdata('text', 'Cannot Delete this User Role');
                    }
                }
            }
            redirect('user_access/load_roles');
        }
    }


    public function load_access() {
        if (_is_user_login($this)) {
            $user_type_id = $this->uri->segment(3);
            if ($user_type_id > 0) {
                $role = $this->users->get_row("SELECT * FROM tbl_user_types WHERE user_type_id = ".$user_type_id);
                $data['role'] = $role->role;
                $data['user_type_id'] = $user_type_id;
                $user_access = $this->users->get_array("SELECT * FROM tbl_user_types u INNER JOIN tbl_user_type_access a ON u.user_type_id = a.user_type_id WHERE u.user_type_id = " . $user_type_id ." AND u.user_type_id !=1");
                $data['user_access'] = $user_access;
                $data['view'] = 'user_access/_create_access.php';
                $this->load->view('_layout.php', $data);
            } else {
                $data['user_access'] = $this->users->get_array("SELECT * FROM tbl_user_types WHERE user_type_id !=1");
                $data['view'] = 'user_access/_user_access__request.php';
                $this->load->view('_layout.php', $data);
            }
        }
    }

    public function create_access() {
        if (_is_user_login($this)) {
            if ($this->input->post('submit_access')) {
                $user_type_id = $this->input->post('user_type_id');
                $class_name = $this->input->post('class');
                $method_name = $this->input->post('method');

                $data_access = array(
                    'user_type_id' => $user_type_id,
                    'class' => $class_name,
                    'method' => $method_name,
                    'access' => 1
                );
                 $id = $this->user_access->add_access($data_access);
                if ($id > 0) {
                    $role_name = $this->users->get_row("SELECT * FROM tbl_user_types WHERE user_type_id = ".$user_type_id);
                    $this->users->add_activity(array('activity_title' => 'User Role', 'activity_description' => 'Added User Access Role' .$class_name .' For: ' . $role_name->role));
                    $this->session->set_flashdata('type', 'success');
                    $this->session->set_flashdata('title', 'Success');
                    $this->session->set_flashdata('text', 'Class Added Successfully');
                } else {
                    $this->session->set_flashdata('type', 'danger');
                    $this->session->set_flashdata('title', 'Error');
                    $this->session->set_flashdata('text', 'Cannot Insert');
                }
                redirect('user_access/load_access/' . $user_type_id);
            } else {
                $data['view'] = 'user_access';
                $this->load->view('_layout.php', $data);
            }
        }
    }

    public function delete_access() {
        if(_is_user_login($this)) {
            $user_type_access_id = $this->uri->segment(3);
            if($user_type_access_id > 0) {
                $access_to_delete = $this->user_access->get_row("SELECT * FROM tbl_user_type_access WHERE user_type_access_id = ".$user_type_access_id);
                $delete_flag = $this->user_access->delete_access($user_type_access_id);
                if ($delete_flag) {
                    $this->users->add_activity(array('activity_title' => 'User Role', 'activity_description' => 'Deleted Class: ' .$access_to_delete->class .'For: ' .$access_to_delete->user_type_id));
                    $this->session->set_flashdata('type', 'success');
                    $this->session->set_flashdata('title', 'Success');
                    $this->session->set_flashdata('text', 'Deleted Class Successfully');
                } else {
                    $this->session->set_flashdata('type', 'error');
                    $this->session->set_flashdata('title', 'Error');
                    $this->session->set_flashdata('text', 'Cannot Delete Record');
                }
            }
            redirect('user_access/load_access/'. $access_to_delete->user_type_id);
        }
    }
}
