<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Commission extends CI_Controller
{

    public function index()
    {
        if (_is_user_login($this)) {
            $branch_id = $this->uri->segment(2);
            $commission_month = $this->uri->segment(3);

            if (($branch_id > 0) && ($commission_month != null)) {
                $data['commission_uploaded'] = $this->commission->get_row("SELECT COUNT(*) AS total FROM tbl_consultant_commission WHERE commission_month ='" . $commission_month ."'");
                $consultants = $this->employees->get_array("SELECT * FROM tbl_employees WHERE position_id ='1' AND branch_id = " . $branch_id);
                $branch = $this->employees->get_row("SELECT * FROM tbl_branches WHERE branch_id =" . $branch_id);
                $data['branch_id'] = $branch_id;
                $data['branch'] = $branch->branch_name;
                $data['pay_month'] = $commission_month;
                $data['consultants'] = $consultants;
                $data['view'] = 'commission/_index.php';
                $this->load->view('_layout.php', $data);
            } else if (($branch_id == 0) && ($commission_month != null)) {
                $data['commission_uploaded'] = $this->commission->get_row("SELECT COUNT(*) AS total FROM tbl_consultant_commission WHERE commission_month ='" . $commission_month . "' ");
                $consultants = $this->employees->get_array("SELECT emp_id,emp_number, fullname FROM tbl_employees WHERE position_id ='1'");
                $data['branch_id'] = 0;
                $data['branch'] = "All Branches";
                $data['pay_month'] = $commission_month;
                $data['consultants'] = $consultants;
                $data['view'] = 'commission/_index.php';
                $this->load->view('_layout.php', $data);
            } else {
                $data['branches'] = $this->employees->get_array("SELECT * FROM tbl_branches");
                $data['view'] = 'commission/_commission_request.php';
                $this->load->view('_layout.php', $data);
            }
        }
    }

    public function export_csv()
    {
        $branch_id = ($this->uri->segment(3) > 0) ? $this->uri->segment(3) : 0;
        // file name
        $filename = 'SalesAdvisors_' . date('d-m-Y') . '.xls';
        $consultantsData = $this->commission->get_consultants_data($branch_id);
        $columnHeader = '';
        $columnHeader = "System ID" . "\t" . "Consultant Name" . "\t" . "Commission" . "\t";

        $setData = '';
        foreach ($consultantsData as $consultant) {
            $rowData = '';
            foreach ($consultant as $value) {
                $value = '"' . $value . '"' . "\t";
                $rowData .= $value;
            }
            $setData .= trim($rowData) . "\n";
        }

        header("Content-type: application/octet-stream");
        header("Content-Disposition: attachment; filename=$filename");
        header("Pragma: no-cache");
        header("Expires: 0");

        echo ucwords($columnHeader) . "\n" . $setData . "\n";
    }

    public function import_csv()
    {
        $file = $_FILES['file']['tmp_name'];
        $handle = fopen($file, "r");
        $c = 0;
        while (($filesop = fgetcsv($handle, 1000, "\t")) !== false) {
            $data = array(
                'emp_id' => $filesop[0],
                'business_commission' => $filesop[2],
                'commission_month' => $this->input->post('pay_month'),
            );
            if ($c != 0) { /* SKIP THE FIRST ROW */
                $id = $this->commission->add_commission($data);
            }

            $c = $c + 1;
        }

        // if ($id > 0) {
        $this->session->set_flashdata('type', 'success');
        $this->session->set_flashdata('title', 'Success');
        $this->session->set_flashdata('text', 'Excel File Uploaded Successfully');
        // } else {
        //     $this->session->set_flashdata('type', 'error');
        //     $this->session->set_flashdata('title', 'Error');
        //     $this->session->set_flashdata('text', 'Error uploading excel file');
        // }
        redirect('commission/' . $this->input->post('branch_id') . '/' . $this->input->post('pay_month'));
    }

    public function delete_commission_file()
    {
        $commission_month = $this->uri->segment(3);
        if ($commission_month != null) {
            $id = $this->commission->delete_where(['tbl_consultant_commission'], ['commission_month' => $commission_month]);

            if ($id > 0) {
                $this->session->set_flashdata('type', 'success');
                $this->session->set_flashdata('title', 'Success');
                $this->session->set_flashdata('text', 'Commission File Successfully Deleted!');
            } else {
                $this->session->set_flashdata('type', 'error');
                $this->session->set_flashdata('title', 'Error');
                $this->session->set_flashdata('text', 'Error Deleting Commission File!');
            }

            redirect('commission/0/' . $commission_month);
        }
    }

}