<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

if (!function_exists('_is_user_login')) {

    function _is_user_login($thi) {
        $user_id = _get_current_user_id($thi);
        $user_type_id = _get_current_user_type_id($thi);
        $is_access = _get_user_type_access($thi, $user_type_id);

        if (isset($user_id) && $user_id != "" && isset($user_type_id)) {
            if ($is_access == true) {
                return true;
            } else {
                $thi->load->view('_no_access');
                return false;
            }
        } else {
            $thi->load->view('_no_access');
            return false;
        }
    }

}
if (!function_exists('_is_frontend_user_login')) {

    function _is_frontend_user_login($thi) {
        $userid = _get_current_user_id($thi);
        $usertype = _get_current_user_type_id($thi);

        if (isset($userid) && $userid != "" && isset($usertype)) {
            return true;
        } else {

            return false;
        }
    }

}
if (!function_exists('_get_current_user_id')) {

    function _get_current_user_id($thi) {
        return $thi->session->userdata("user_id");
    }

}
if (!function_exists('_get_current_fullname')) {

    function _get_current_fullname($thi) {
        $query = $thi->db->query("SELECT fullname FROM tbl_users WHERE user_id = " . $thi->session->userdata("user_id"));
        return $query->row('fullname');
    }

}


if (!function_exists('_get_current_user_type_id')) {

    function _get_current_user_type_id($thi) {
        return $thi->session->userdata("user_type_id");
    }

}
if (!function_exists('_get_user_type_access')) {

    function _get_user_type_access($thi, $user_type_id) {
        $cur_class = $thi->router->fetch_class();
        $cur_method = $thi->router->fetch_method();
        $result = $thi->db->query("select * from tbl_user_type_access where user_type_id = '" . $user_type_id . "' and class = '" . $cur_class . "' and (method = '" . $cur_method . "' or method='*')");
//        $row = $result->row();
        if ($result->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
        return false;
    }

}

if (!function_exists('_get_user_type_access1')) {

    function _get_user_type_access1($thi, $user_type_id, $class, $method) {
        $result = $thi->db->query("select * from tbl_user_type_access where user_type_id = '" . $user_type_id . "' and class = '" . $class . "' and (method = '" . $method . "' or method='*')");
//        $row = $result->row();
        if ($result->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
        return false;
    }

}

if (!function_exists('_get_user_redirect')) {

    function _get_user_redirect($thi) {
//        if (_get_current_user_type_id($thi) == 0) {
//            return "dashboard";
//        } else if (_get_current_user_type_id($thi) == 1) {
//            return "dashboard";
//        } else {
//            return "dashboard";
//        }
        return "dashboard";
    }

}
