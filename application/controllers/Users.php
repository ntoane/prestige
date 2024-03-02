<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {

    public function index() {
        if (_is_user_login($this)) {
        $data['users'] = $this->users->get_array("SELECT * FROM tbl_users u INNER JOIN tbl_user_types ut ON u.user_type_id = ut.user_type_id WHERE user_id !=1");
        $data['view'] = 'users/_index.php';
        $this->load->view('_layout.php', $data);
        }
    }

    public function create() {
        if (_is_user_login($this)) {
        if ($this->input->post('submit_user')) {
            $password = $password = password_hash('user123', PASSWORD_BCRYPT);
            $data_user = array(
                'fullname' => $this->input->post('fullname'),
                'email' => $this->input->post('email'),
                'user_type_id' => $this->input->post('user_type_id'),
                'password' => $password
            );
            $id = $this->users->add_user($data_user);
            if ($id > 0) {
                $this->users->add_activity(array('activity_title' => 'User', 'activity_description' => 'Added new user: ' . $this->input->post('fullname'), 'user_id' => _get_current_user_id($this)));
                $this->session->set_flashdata('type', 'success');
                $this->session->set_flashdata('title', 'Success');
                $this->session->set_flashdata('text', 'Added Successfully, default password is user123');
                redirect('users/send_user_password/' . $id);
            } else {
                $this->session->set_flashdata('type', 'danger');
                $this->session->set_flashdata('title', 'Error');
                $this->session->set_flashdata('text', 'Cannot Insert');
            }
            redirect('users');
        } else {
            $data['user_types'] = $this->users->get_array("SELECT * FROM tbl_user_types WHERE user_type_id !=1");
            $data['view'] = 'users/_create.php';
            $this->load->view('_layout.php', $data);
        }
        }
    }

    public function edit() {
        if (_is_user_login($this)) {
        if ($this->input->post('update_user')) {
            $data_user = array(
                'fullname' => $this->input->post('fullname'),
                'email' => $this->input->post('email'),
                'user_type_id' => $this->input->post('user_type_id')
            );
            $where = array(
                'user_id' => $this->input->post('user_id')
            );
            $id = $this->users->update($data_user, $where);
            if ($id > 0) {
                $this->users->add_activity(array('activity_title' => 'User', 'activity_description' => 'Updated user: ' . $this->input->post('fullname'), 'user_id' => _get_current_user_id($this)));
                $this->session->set_flashdata('type', 'success');
                $this->session->set_flashdata('title', 'Success');
                $this->session->set_flashdata('text', 'Updated Successfully');
            } else {
                $this->session->set_flashdata('type', 'danger');
                $this->session->set_flashdata('title', 'Error');
                $this->session->set_flashdata('text', 'Cannot Update');
            }
            redirect('users');
        } else {
            $id = ($this->uri->segment(3) > 0) ? $this->uri->segment(3) : 0;
            if ($id > 0) {
                $data['user'] = $this->users->get_row("SELECT * FROM tbl_users WHERE user_id = " . $id);
                $data['user_types'] = $this->users->get_array("SELECT * FROM tbl_user_types");
                $data['view'] = 'users/_edit.php';
                $this->load->view('_layout.php', $data);
            } else {
                redirect('users');
            }
        }
        }
    }

    public function block() {
        if (_is_user_login($this)) {
            if ($this->input->post('submit_block') == "block") {
                $user_id = $this->input->post('user_id');
                $reason = $this->input->post('reason');
                if ($user_id > 0) {
                    $name = $this->users->get_row("SELECT * FROM tbl_users WHERE user_id =".$user_id);
                    $data_user = array(
                        'banned' => '1',
                        'ban_reason' => $reason
                    );
                    $where = array(
                        'user_id' => $user_id
                    );
                    $id = $this->users->update($data_user, $where);
        
                    if ($id > 0) {
                        $this->users->add_activity(array('activity_title' => 'Block User', 'activity_description' => 'Blocked new user: ' . $name->fullname, 'user_id' => _get_current_user_id($this)));
                        $this->session->set_flashdata('type', 'success');
                        $this->session->set_flashdata('title', 'Success');
                        $this->session->set_flashdata('text', 'User Blocked Successfully');
                    } else {
                        $this->session->set_flashdata('type', 'danger');
                        $this->session->set_flashdata('title', 'Error');
                        $this->session->set_flashdata('text', 'Cannot Block User');
                    }
                    redirect('users');
                }else {
                    redirect('users');
                }
        }else {
            redirect('users');
        }
      }
    }

    public function unblock() {
        if (_is_user_login($this)) {
            if ($this->input->post('submit_unblock') == "unblock") {
                $user_id = $this->input->post('user_id');
                $reason = $this->input->post('reason');
                echo 'UserId: '.$user_id.', Reason: '.$reason;
                if ($user_id > 0) {
                    $name = $this->users->get_row("SELECT * FROM tbl_users WHERE user_id =".$user_id);
                    $data_user = array(
                        'banned' => '0',
                        'ban_reason' => $reason
                    );
                    $where = array(
                        'user_id' => $user_id
                    );
                    $id = $this->users->update($data_user, $where);
        
                    if ($id > 0) {
                        $this->users->add_activity(array('activity_title' => 'Unblock User', 'activity_description' => 'Unblocked new user: ' . $name->fullname, 'user_id' => _get_current_user_id($this)));
                        $this->session->set_flashdata('type', 'success');
                        $this->session->set_flashdata('title', 'Success');
                        $this->session->set_flashdata('text', 'User Unblocked Successfully');
                    } else {
                        $this->session->set_flashdata('type', 'danger');
                        $this->session->set_flashdata('title', 'Error');
                        $this->session->set_flashdata('text', 'Cannot Unblock this User');
                    }
                    redirect('users');
                }else {
                    redirect('users');
                }
        }else {
            redirect('users');
        }
      }
    }
  

    public function activities() {
        if (_is_user_login($this)) {
        $data['user_activities'] = $this->users->get_array("SELECT * FROM tbl_user_activities ua INNER JOIN tbl_users u ON u.user_id = ua.user_id ORDER BY ua.activity_id DESC");
        $data['view'] = 'users/_activities.php';
        $this->load->view('_layout.php', $data);
        }
    }

    public function send_user_password() {
        $id = ($this->uri->segment(3) > 0) ? $this->uri->segment(3) : 0;
        if ($id > 0) {
            $user = $this->users->get_row("SELECT * FROM tbl_users WHERE user_id = " . $id);
            if (!empty($user)) {
                $password = $user->password;
                $email = filter_var($user->email, FILTER_SANITIZE_EMAIL);
                $message_content = '<strong>Email</strong> ' . $email . '<br>';
                $message_content .= '<strong>Password</strong> ' . $password . '<br>';
//        $message_content .= '<strong>' . $message_title . '</strong> ' . nl2br($message);

                $url = 'https://api.elasticemail.com/v2/email/send';

                try {
                    $post = array('from' => 'morolongkj@gmail.com',
                        'fromName' => 'From Sentebale Payroll System',
                        'apikey' => '808437dd-9248-411e-a02a-e7ef9dde1e6b-agrf',
                        'subject' => 'Password to access Payroll System',
                        'to' => $email,
                        'bodyHtml' => $message_content,
                        /* 'bodyText' => $message_content, */
                        'isTransactional' => false);

                    $ch = curl_init();
                    curl_setopt_array($ch, array(
                        CURLOPT_URL => $url,
                        CURLOPT_POST => true,
                        CURLOPT_POSTFIELDS => $post,
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_HEADER => false,
                        CURLOPT_SSL_VERIFYPEER => false
                    ));

                    $result = curl_exec($ch);
                    curl_close($ch);

                    // echo $result;	
//            echo 'OK';
                    $this->session->set_flashdata('type', 'success');
                    $this->session->set_flashdata('title', 'Success');
                    $this->session->set_flashdata('text', 'Operation successful, Email with credentials is sent');
                    redirect('users');
                } catch (Exception $ex) {
//            echo $ex->getMessage();
                    $this->session->set_flashdata('type', 'danger');
                    $this->session->set_flashdata('title', 'Error');
                    $this->session->set_flashdata('text', 'Some error occured');
                    redirect('users');
                }
            } else {
                $this->session->set_flashdata('type', 'danger');
                $this->session->set_flashdata('title', 'Error');
                $this->session->set_flashdata('text', 'User with this email is not found.');
                redirect('users');
            }
        } else {
            redirect('users');
        }
    }

    public function change_password() {
        $password = $this->input->post("password");
        $new_password = $this->input->post("new_password");
        $confirm_password = $this->input->post("confirm_password");
        if (_is_user_login($this)) {
            $current_user = $this->users->get_row("SELECT * FROM tbl_users WHERE user_id = " . _get_current_user_id($this));
            if (!empty($current_user)) {
                $email = filter_var($current_user->email, FILTER_SANITIZE_EMAIL);
                //$user = $this->users->get_user_by_credentials($email, $password);
                $user = $this->users->get_row("SELECT * FROM tbl_users WHERE email = '" . $email . "' AND banned = '0' ");
                if (!empty($user) || password_verify($password, $user->password)) {
                    /* correct password, attempt to change it */
                    if ($new_password == $confirm_password) {
                        /* change password */
                        $data_user = array(
                            'password' => password_hash($new_password, PASSWORD_BCRYPT)
                        );
                        $where = array(
                            'user_id' => _get_current_user_id($this)
                        );
                        $id = $this->users->update($data_user, $where);
                        if ($id > 0) {
                            $this->users->add_activity(array('activity_title' => 'User', 'activity_description' => 'Changed Password', 'user_id' => _get_current_user_id($this)));
                            redirect('users/send_user_password/' . $id);
                        } else {
                            $this->session->set_flashdata('type', 'error');
                            $this->session->set_flashdata('title', 'Error');
                            $this->session->set_flashdata('text', 'Cannot Change Password');
                            redirect('users');
                        }
                    } else {
                        /* passwords do not match */
                        $this->session->set_flashdata('type', 'error');
                        $this->session->set_flashdata('title', 'Error');
                        $this->session->set_flashdata('text', 'Passwords do not match');
                        redirect('users');
                    }
                } else {
                    /* wrong password */
                    $this->session->set_flashdata('type', 'error');
                    $this->session->set_flashdata('title', 'Error');
                    $this->session->set_flashdata('text', 'Wrong Password');
                    redirect('users');
                }
            }
        }
        redirect('users');
    }

}
