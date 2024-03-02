<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    public function index() {
        if (!_is_frontend_user_login($this)) {
            $this->load->view('login/_index.php');
        } else {
            redirect('dashboard');
        }
    }

    public function forgot_password() {
        if (!_is_frontend_user_login($this)) {
            $this->load->view('login/_forgot_password.php');
        } else {
            redirect('dashboard');
        }
    }

    public function send_password() {
        $email = filter_var($this->input->post('email'), FILTER_SANITIZE_EMAIL);
        $user = $this->users->get_row("SELECT * FROM tbl_users WHERE email = '" . $email . "'");
        if (!empty($user)) {
            $password = $user->password;
            $message_content = '<strong>Email</strong> ' . $email . '<br>';
            $message_content .= '<strong>Password</strong> ' . $password . '<br>';
//        $message_content .= '<strong>' . $message_title . '</strong> ' . nl2br($message);

            $url = 'https://api.elasticemail.com/v2/email/send';

            try {
                $post = array('from' => 'morolongkj@gmail.com',
                    'fromName' => 'Payroll System',
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
                $this->session->set_flashdata('text', 'Use password from your mail to login');
                redirect('login');
            } catch (Exception $ex) {
//            echo $ex->getMessage();
                $this->session->set_flashdata('type', 'danger');
                $this->session->set_flashdata('title', 'Error');
                $this->session->set_flashdata('text', 'Some error occured');
                redirect('login/forgot_password');
            }
        } else {
            $this->session->set_flashdata('type', 'danger');
            $this->session->set_flashdata('title', 'Error');
            $this->session->set_flashdata('text', 'User with this email is not found.');
            redirect('login/forgot_password');
        }
    }

    public function signin() {
        if (_is_user_login($this)) {
            redirect(_get_user_redirect($this));
        } else {
            $email = $this->input->post('email');
            $password = $this->input->post('password');
//            echo $email.' '.$password;
            if ($this->do_login($email, $password)) {
                redirect(_get_user_redirect($this));
            } else {
                $this->session->set_flashdata('type', 'danger');
                $this->session->set_flashdata('title', 'Error');
                $this->session->set_flashdata('text', 'Wrong email and/or password');
                redirect('login');
            }
        }
    }

    public function do_login($email, $password) {
        $user = $this->users->get_row("SELECT * FROM tbl_users WHERE email = '" . $email . "' AND banned = '0' ");
        if (empty($user) || !password_verify($password, $user->password)) {
            return false;
        }else {
            $data = array(
                'user_id' => $user->user_id,
                'user_type_id' => $user->user_type_id,
                'is_logged_in' => true
            );
            $this->session->set_userdata($data);
            $this->users->add_activity(array('activity_title' => 'User', 'activity_description' => 'Logged into the system', 'user_id' => _get_current_user_id($this)));
        return true;
        }
    }

    public function logout() {
        $array_items = array('user_id', 'user_type_id', 'is_logged_in');
        $this->users->add_activity(array('activity_title' => 'User', 'activity_description' => 'Logged out of the system', 'user_id' => _get_current_user_id($this)));
        $this->session->unset_userdata($array_items);

        $this->session->sess_destroy();
        redirect('login');
    }

}
