<!-- Breadcrumbs-->
<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="<?=base_url() . 'payroll';?>">Payroll</a>
    </li>
    <li class="breadcrumb-item active">Approve Short Term Payment</li>
</ol>

<!-- Page Content -->
<div class="row mb-3">

    <div class="col-md-3 mr-auto">
        <h6><strong>Branch: </strong><?=$branch_name;?></h6>
        <h6><strong>Pay Month: </strong><?=$pay_month;?></h6>
    </div>
    <div class="col-md-4 ml-auto">
        <form action="<?=base_url() . 'provident/approve_st_payments'?>" method="POST">
            <input type="hidden" name="branch_id" value="<?=$branch_id;?>" />
            <input type="hidden" name="payment_month" value="<?=$pay_month;?>" />
            <div class="btn-group">
                <input type="submit" name="approve" value="Approve All Payments" class="btn btn-success btn-md" />
                <input type="submit" name="decline" value="Decline All Payments" class="btn btn-danger btn-md" />
            </div>
        </form>
    </div>
</div>
<div class="card shadow-sm mb-5">
    <div class="card-body">
        <table id="data-table" class="table table-striped table-hover dt-responsive" style="width:100%">
            <thead>
                <tr>
                    <th>Employee ID</th>
                    <th>Name</th>
                    <th>Position</th>
                    <th>Short Term</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
foreach ($branch_employees as $employee) {
    ?>
                <tr>
                    <td><?=$employee['emp_id'];?></td>
                    <td><?=$employee['fullname'];?></td>
                    <td><?=$employee['position_name'];?></td>
                    <td>
                        <a href="#" data-toggle="popover" title="Short Term Accumulation" data-content="
                                            <?php
$dismantled_month = explode('-', $pay_month);
    $year = $dismantled_month[1];
    $records = $this->payroll->get_array("SELECT payment_month, short_term FROM tbl_salary_payment WHERE approve = '1' AND emp_id = " . $employee['emp_id'] . " AND payment_month LIKE '%$year'");
    if (!empty($records)) {
        foreach ($records as $record) {
            echo "<i class='fa fa-calendar mr-1'></i>";
            echo $record['payment_month'] . ' : ' . _format_money($this, $record['short_term'], true) . '<br />';
        }
    }
    ?>" data-placement="top" data-html="true">
                            <?=_format_money($this, $this->payroll->get_short_term_balance($employee['emp_id'], $pay_month), true);?></a>

                    </td>
                    <td>
                        <?php
if ($this->payroll->is_employee_paid($employee['emp_id'], $pay_month)) {
        $salary_payment_record = $this->payroll->get_row("SELECT * FROM tbl_salary_payment WHERE emp_id = " . $employee['emp_id'] . " AND payment_month = '" . $pay_month . "'");
        if (!empty($salary_payment_record)) {
            if ($salary_payment_record->approve == 0) {
                echo "<span class='badge badge-primary'>Pending</span>";
            } else if ($salary_payment_record->approve == 1) {
                echo "<span class='badge badge-success'>Paid</span>";
            } else {
                echo "<span class='badge badge-warning'>Rejected</span>";
            }
        }
        // echo "<span class='badge badge-success'>Paid</span>";
    } else {
        echo "<span class='badge badge-danger'>Unpaid</span>";
    }
    ?>
                    </td>
                    <td>
                        <?php
if ($this->payroll->is_employee_paid($employee['emp_id'], $pay_month) && !($this->payroll->is_payment_approved($employee['emp_id'], $pay_month))) {
        ?>
                        <form action="<?=base_url() . 'provident/approve_st_payment'?>" method="POST">
                            <input type="hidden" name="emp_id" value="<?=$employee['emp_id'];?>" />
                            <input type="hidden" name="branch_id" value="<?=$branch_id;?>" />
                            <input type="hidden" name="payment_month" value="<?=$pay_month;?>" />
                            <div class="btn-group">
                                <input type="submit" name="approve" value="Approve" class="btn btn-success btn-sm" />
                                <input type="submit" name="decline" value="Decline" class="btn btn-danger btn-sm" />
                            </div>
                        </form>
                        <?php
}
    ?>
                    </td>
                </tr>
                <?php
}
?>
            </tbody>

        </table>
    </div>
</div>
