<!-- Breadcrumbs-->
<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="<?= base_url() . 'payroll'; ?>">Payroll</a>
    </li>
    <li class="breadcrumb-item active">Make Short Term Payment</li>
</ol>

<!-- Page Content -->
<div class="row mb-3">

    <div class="col-md-3 mr-auto">
        <h6><strong>Branch: </strong><?= $branch_name; ?></h6>
        <h6><strong>Pay Month: </strong><?= $pay_month; ?></h6>
    </div>
    <div class="col-md-2 ml-auto">
        <form action="<?= base_url() . 'provident/pay_all_employees' ?>" method="POST">
            <input type="hidden" name="branch_id" value="<?= $branch_id; ?>" />
            <input type="hidden" name="payment_month" value="<?= $pay_month; ?>" />
            <button type="submit" class="btn btn-success btn-md">Pay All Employees</button>
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
                        <td><?= $employee['emp_id']; ?></td>
                        <td><?= $employee['fullname']; ?></td>
                        <td><?= $employee['position_name']; ?></td>
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
                                <?= _format_money($this, $this->payroll->get_short_term_balance($employee['emp_id'], $pay_month), true); ?></a>

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
                            if (!$this->payroll->is_employee_paid($employee['emp_id'], $pay_month)) {
                            ?>
                                <form action="<?= base_url() . 'provident/pay_employee' ?>" method="POST">
                                    <input type="hidden" name="emp_id" value="<?= $employee['emp_id']; ?>" />
                                    <input type="hidden" name="branch_id" value="<?= $branch_id; ?>" />
                                    <input type="hidden" name="payment_month" value="<?= $pay_month; ?>" />
                                    <button type="submit" class="btn btn-success btn-sm">Make Payment</button>
                                </form>
                                <?php
                            } else {
                                $salary_payment_record = $this->payroll->get_row("SELECT * FROM tbl_salary_payment WHERE emp_id = " . $employee['emp_id'] . " AND payment_month = '" . $pay_month . "'");
                                if (!empty($salary_payment_record)) {
                                    if ($salary_payment_record->approve == 2) {
                                ?>
                                        <form action="<?= base_url() . 'provident/pay_employee' ?>" method="POST">
                                            <input type="hidden" name="emp_id" value="<?= $employee['emp_id']; ?>" />
                                            <input type="hidden" name="branch_id" value="<?= $employee['branch_id']; ?>" />
                                            <input type="hidden" name="payment_month" value="<?= $pay_month; ?>" />
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