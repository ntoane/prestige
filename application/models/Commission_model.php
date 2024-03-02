<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Commission_model extends MY_Model
{

    protected $table = 'tbl_consultant_commission';

    public function __construct()
    {
        parent::__construct();
    }

    public function add_commission($data)
    {
        $commission_data = $this->get_row("SELECT * FROM " . $this->table . " WHERE emp_id = " . $data['emp_id'] . " AND commission_month = '" . $data['commission_month'] . "'");
        if (empty($commission_data)) {
            $insert_id0 = $this->insert($this->table, $data);
            if ($insert_id0 > 0) {
                $supervisor = $this->get_row("SELECT supervisor_id FROM tbl_employees WHERE emp_id = " . $data['emp_id'] . " AND supervisor_id != 0");
                if (!empty($supervisor)) {
                    $insert_id1 = $this->insert($this->table, [
                        'emp_id' => $supervisor->supervisor_id,
                        'business_commission' => 0.1 * $data['business_commission'],
                        'recurring_commission' => 0,
                        'commission_month' => $data['commission_month'],
                    ]);
                    if ($insert_id1 > 0) {
                        $manager = $this->get_row("SELECT manager_id FROM tbl_employees WHERE emp_id = " . $supervisor->supervisor_id . " AND manager_id != 0");
                        if (!empty($manager)) {
                            $insert_id2 = $this->insert($this->table, [
                                'emp_id' => $manager->manager_id,
                                'business_commission' => 0.1 * $data['business_commission'],
                                'recurring_commission' => 0,
                                'commission_month' => $data['commission_month'],
                            ]);
                            if ($insert_id2 < 1) {
                                $this->delete_commission($insert_id0);
                                $this->delete_commission($insert_id1);
                            }
                            return $insert_id2;
                        }
                        return $insert_id1;
                    } else {
                        $this->delete_commission($insert_id0);
                        return 0;
                    }
                }
            }
        } else {
            
        }
    }

    public function update($data, $where)
    {
        return $this->edit($this->table, $data, $where);
    }

    public function delete_commission($commission_id)
    {
        $tables = array($this->table);
        $where = array(
            'commission_id' => $commission_id,
        );
        return $this->delete($tables, $where);
    }

    public function delete_where($tables = array(), $where =array()) {
        
        return $this->delete($tables, $where);
    }

    public function get_consultants_data($branch_id)
    {

        if ($branch_id == 0) {
            $q = $this->db->select('e.emp_id, e.fullname')
                ->from('tbl_employees as e')
                ->where('e.position_id', 1)
            // ->join('tbl_consultant_commission as c', 'e.emp_id = c.emp_id', 'LEFT')
                ->get();
            return $q->result_array();
        } else {
            $q = $this->db->select('e.emp_id, e.fullname')
                ->from('tbl_employees as e')
                ->where('e.position_id', 1)
                ->where('e.branch_id', $branch_id)
            // ->join('tbl_consultant_commission as c', 'e.emp_id = c.emp_id', 'LEFT')
                ->get();
            return $q->result_array();
        }
    }

    public function get_business_commission($emp_id, $pay_month)
    {
        $sql = "SELECT business_commission FROM tbl_consultant_commission WHERE emp_id = " . $emp_id . " AND commission_month = '" . $pay_month . "'";
        $query = $this->db->query($sql);
        return $query->row('business_commission');
    }

    public function get_recurring_commission($emp_id, $pay_month)
    {
        $sql = "SELECT recurring_commission FROM tbl_consultant_commission WHERE emp_id = " . $emp_id . " AND commission_month = '" . $pay_month . "'";
        $query = $this->db->query($sql);
        return $query->row('recurring_commission');
    }

    public function get_business_commission_total($emp_id, $pay_month)
    {
        $sql = "SELECT business_commission FROM tbl_consultant_commission WHERE emp_id = " . $emp_id . " AND commission_month = '" . $pay_month . "'";
        $bus_commission = $this->get_array($sql);
        $total = 0;
        foreach ($bus_commission as $bs) {
            $total = $total + $bs['business_commission'];
        }
        return $total;
    }

    public function get_recurring_commission_total($emp_id, $pay_month)
    {
        $sql = "SELECT recurring_commission FROM tbl_consultant_commission WHERE emp_id = " . $emp_id . " AND commission_month = '" . $pay_month . "'";
        $rec_commission = $this->get_array($sql);
        $total = 0;
        foreach ($rec_commission as $rs) {
            $total = $total + $rs['recurring_commission'];
        }
        return $total;
    }
}