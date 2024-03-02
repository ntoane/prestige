<!-- Breadcrumbs-->
<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="<?= base_url() . 'payroll'; ?>">Payroll</a>
    </li>
    <li class="breadcrumb-item active">Salary Payment File</li>
</ol>

<!-- Page Content -->
<div class="row mb-3">
    <div class="col-md-2 mr-auto">
        <a href="<?= base_url() . 'payroll/salary_payment_file'; ?>" class="btn btn-primary btn-block"><i class="fa fa-arrow-left"></i> Back</a>
    </div>
    <div class="col-md-3 ml-auto">
        <h6><strong>Branch: </strong><?php
            if ($branch_id == -1) {
                echo 'All Branches';
            } else {
                $branch = $this->branches->get_row("SELECT * FROM tbl_branches WHERE branch_id = " . $branch_id);
                if (!empty($branch)) {
                    echo $branch->branch_name;
                }
            }
            ?></h6>
        <h6><strong>Pay Month: </strong><?= $pay_month; ?></h6>
    </div>
</div>
<div class="card shadow-sm mb-5">
    <div class="card-body">
        <table id="export-table" class="table table-striped table-hover dt-responsive display" style="width:100%">
            <thead>
                <tr>
                    <th>Employee Name</th>
                    <th>Base Salary</th>
                    <th>Long Term</th>
                    <th>Short Term</th>
                    <th>PAYE</th>
                    <th>Deduction</th>
                    <th>Loan Deduction</th>
                    <th>Allowance</th>
                    <th>Net Pay</th>
                    <th>Payment Month</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($payment_data as $payment) {
                    ?>
                    <tr>
                        <td><?php
                            $emp_name = $this->employees->get_fullname($payment['emp_id']);
                            echo $emp_name->fullname;
                            ?></td>
                        <td><?= _format_money($this, $payment['base_salary'], true); ?></td>
                        <td><?= _format_money($this,$payment['long_t'],true); ?></td>
                        <td><?= _format_money($this,$payment['short_t'],true); ?></td>
                        <td><?= _format_money($this,$payment['tax'],true); ?></td>
                        <td><?= _format_money($this,$payment['fine_deduction'],true); ?></td>
                        <td><?= _format_money($this,$payment['loan_deduction'],true); ?></td>
                        <td><?= _format_money($this,$payment['allowance'],true); ?></td>
                        <td><?= _format_money($this,$payment['net_amount'], true); ?></td>
                        <td><?= $payment['payment_month']; ?></td>
                    </tr>
                    <?php
                }
                ?>
            </tbody>
        </table>
    </div>
</div>