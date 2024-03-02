<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

if (!function_exists('_format_money')) {

    function _format_money($thi, $number, $fractional = false) {
        if ($fractional) {
            $number = sprintf('%.2f', $number);
        }
        while (true) {
            $replaced = preg_replace('/(-?\d+)(\d\d\d)/', '$1,$2', $number);
            if ($replaced != $number) {
                $number = $replaced;
            } else {
                break;
            }
        }
        return "M " . $number;
    }

}

