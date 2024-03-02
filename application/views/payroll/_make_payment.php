<!-- Breadcrumbs-->
<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="<?=base_url() . 'payroll';?>">Payroll</a>
    </li>
    <li class="breadcrumb-item active">Make Payment</li>
</ol>

<!-- Page Content -->
<div class="row mb-3">

    <div class="col-md-3 mr-auto">
        <h6><strong>Branch: </strong><?=$branch_name;?></h6>
        <h6><strong>Pay Month: </strong><?=$pay_month;?></h6>
    </div>
    <div class="col-md-2 ml-auto">
        <form action="<?=base_url() . 'payroll/pay_all_employees'?>" method="POST">
            <input type="hidden" name="branch_id" value="<?=$branch_id;?>" />
            <input type="hidden" name="payment_month" value="<?=$pay_month;?>" />
            <!-- <div class="form-check">
                <input type="checkbox" class="form-check-input" id="pay_short_term_all" name="pay_short_term"
                    value="1" />
                <label class="form-check-label" for="pay_short_term_all">Pay Short
                    Term
                </label>
            </div> -->
            <button type="submit" class="btn btn-success btn-md">Pay All Employees</button>
        </form>
    </div>
</div>
<div class="card shadow-sm mb-5">
    <div class="card-body">
        <table id="data-table" class="table table-striped table-hover dt-responsive" style="width:100%">
            <thead>
                <tr>
                    <th>Employee Number</th>
                    <th>Name</th>
                    <th>Position</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
foreach ($branch_employees as $employee) {
    ?>
                <tr>
                    <td><?=$employee['emp_number'];?></td>
                    <td><?=$employee['fullname'];?></td>
                    <td><?=$employee['position_name'];?></td>
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
if (!$this->payroll->is_employee_paid($employee['emp_id'], $pay_month)) {
        ?>
                        <form action="<?=base_url() . 'payroll/pay_employee'?>" method="POST">
                            <input type="hidden" name="emp_id" value="<?=$employee['emp_id'];?>" />
                            <input type="hidden" name="branch_id" value="<?=$branch_id;?>" />
                            <input type="hidden" name="payment_month" value="<?=$pay_month;?>" />
                            <!-- <div class="form-check">
                                <input type="checkbox" class="form-check-input"
                                    id="pay_short_term_<?=$employee['emp_id'];?>" name="pay_short_term" value="1" />
                                <label class="form-check-label" for="pay_short_term_<?=$employee['emp_id'];?>">Pay Short
                                    Term
                                </label>
                            </div> -->
                            <!-- <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="pay_long_term"
                                    name="pay_long_term" />
                                <label class="form-check-label" for="pay_long_term">Pay Long Term</label>
                            </div> -->
                            <button type="submit" class="btn btn-success btn-sm">Make Payment</button>
                        </form>
                        <?php
} else {
        $salary_payment_record = $this->payroll->get_row("SELECT * FROM tbl_salary_payment WHERE emp_id = " . $employee['emp_id'] . " AND payment_month = '" . $pay_month . "'");
        if (!empty($salary_payment_record)) {
            if ($salary_payment_record->approve == 2) {
                ?>
                        <form action="<?=base_url() . 'payroll/pay_employee'?>" method="POST">
                            <input type="hidden" name="emp_id" value="<?=$employee['emp_id'];?>" />
                            <input type="hidden" name="branch_id" value="<?=$employee['branch_id'];?>" />
                            <input type="hidden" name="payment_month" value="<?=$pay_month;?>" />
                            <button type="submit" class="btn btn-success btn-sm">Make Payment</button>
                        </form>
                        <?php
}
        }
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