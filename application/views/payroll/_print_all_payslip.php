<style>
td,
th {
    font-size: 12px;
}

h6 {
    font-size: 14px;
    font-weight: 300;
}

h6>span {
    font-weight: bolder;
}

h5 {
    font-size: 16px;
    font-weight: 400;
    text-transform: uppercase;
}

.h-light {
    color: #495057;
    background-color: #e9ecef;
    border-color: #dee2e6;
    font-weight: bold;
}

.tile {
    margin-top: -0.5cm;
}

tr,
th {
    line-height: 8px;
    font-size: 16px;
}
</style>

<div class="row">

    <div class="col-md-10 noprint">
        <h6><strong>Branch: </strong><?=$branch;?></h6>
        <h6><strong>Month: </strong><?=$pay_month;?></h6>
    </div>

    <div class="col-md-2 noprint">
        <button onclick="javascript:window.print()" type="button" class="btn btn-success btn-sm"><i
                class="fa fa-print"></i> Print All Payslip</button>
    </div>
</div>
<br>

<?php
foreach ($payslips as $payslip) {
    ?>
<div class="tile mr-3 ml-3 watermark break-page">
    <div class="row">

        <div class="text-left col-sm-12">
            <?php
$emp = $this->employees->get_emp_details($payslip['emp_id']);
    ?>
            <table class="table">
                <thead>
                    <tr>
                        <th width="20%">
                            <img src="<?php echo base_url(); ?>assets/images/logo.jpeg" alt="Prestige Furnitures "
                                width="237" height="92">
                            <h5 class="my-2">Branch Name:
                                <?php
$branch = $this->branches->get_branch_name($emp->branch_id);
    echo $branch->branch_name;
    $overtime = $this->payroll->get_sum_of_overtimes($payslip['emp_id'], $pay_month);
    $sunday_pay = $this->payroll->get_sum_of_sundaypays($payslip['emp_id'], $pay_month);
    ?></h5>
                        </th>
                        <th>
                            <h6>Employee Name: <span><?=$emp->fullname;?></span></h6>
                            <h6>Employement Number:
                                <span><?=$this->employees->get_emp_number($payslip['emp_id']);?></span>
                            </h6>
                            <h6>Position: <span><?php echo $emp->position_name; ?></span></h6>

                        </th>
                        <th class="align-top">
                            <h6 class="text-right">Date: <?=date("d-m-Y", strtotime($payslip['paid_date']));?></h6>
                        </th>
                    </tr>
                </thead>
            </table>
            <br>
        </div>
        <!-- <hr> -->

        <div class="col-sm-12">
            <h5 class="h-light py-3 text-center">Prestige Furnitures - PAYSLIP</h5>
        </div>
        <div class="col-sm-12">
            <div class="row my-1 text-center">
                <div class="col-sm-1">
                    <img src="<?php echo base_url(); ?>assets/images/logo.jpeg" alt="Prestige Furnitures  Logo"
                        width="95" height="37">
                </div>
                <div class="col-sm-3 align-self-center">
                    <h6 class="my-auto">Employement Number:
                        <span><?=$this->employees->get_emp_number($payslip['emp_id']);?></span>
                    </h6>
                </div>
                <div class="col-sm-5 align-self-center">
                    <h6>Employee Name: <span><?=$emp->fullname;?></span></h6>
                </div>
                <div class="col-sm-3 align-self-center">
                    <h6>Position: <span><?php echo $emp->position_name; ?></span></h6>
                </div>
            </div>
        </div>

        <div class="table-responsive col-sm-6">
            <table class="table table-bordered">
                <thead class="thead-light">
                    <tr class="text-center">
                        <!--<th>ID/Passport Number</th>-->
                        <th>Date of Birth</th>
                        <th>Employement Date</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="text-center">
                        <?php
?>
                        <!--<td><?php echo $emp->national_id; ?></td>-->
                        <td><?php echo date("d-M-Y", strtotime($emp->date_of_birth)); ?></td>
                        <td><?php echo date("d-M-Y", strtotime($emp->created)); ?></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="table-responsive col-sm-3">
            <table class="table table-bordered">
                <thead class="thead-light">
                    <tr class="text-center">
                        <th>Payment Date</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="text-center">
                        <td><?=date("d-M-Y", strtotime($payslip['paid_date']));?></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="table-responsive col-sm-3">
            <table class="table table-bordered">
                <thead class="thead-light">
                    <tr class="text-center">
                        <th>Payslip Number</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="text-center">
                        <td><?php echo $payslip['salary_payment_id']; ?></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="col-sm-4">
            <table class="table">
                <thead>
                    <tr class="text-center">
                        <th colSpan="2">EARNINGS</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
if ($payslip['base_salary'] != 0) {
        ?>
                    <tr>
                        <td>BASIC SALARY</td>
                        <td><?php echo _format_money($this, $payslip['base_salary'], true); ?></td>
                    </tr>
                    <?php }?>
                    <?php if ($overtime > 0) {?>
                    <tr>
                        <td>OVERTIME</td>
                        <td><?php echo _format_money($this, $overtime, true); ?></td>
                    </tr>
                    <?php }?>

                    <?php if ($sunday_pay > 0) {?>
                    <tr>
                        <td>SUNDAY PAY</td>
                        <td><?php echo _format_money($this, $sunday_pay, true); ?></td>
                    </tr>
                    <?php }
    $scheduled_allowances = $this->payroll->get_row("SELECT * FROM tbl_loans l INNER JOIN tbl_track_loan tl ON l.loan_id = tl.loan_id  WHERE l.emp_id = " . $payslip['emp_id'] . " AND l.loan_type ='allowance' AND tl.pay_month='" . $pay_month . "'");
    $onceoff_allowances = $this->payroll->get_payslip_allowances($payslip['emp_id'], $pay_month);
    if (!empty($scheduled_allowances)) {
        ?>
                    <tr>
                        <td>
                            <?php
echo strtoupper($scheduled_allowances->debt_label);
        ?>
                        </td>
                        <td>
                            <?php
echo _format_money($this, $scheduled_allowances->loan_installment, true);
        ?>
                        </td>
                    </tr>
                    <?php
}
    if (!empty($onceoff_allowances)) {
        foreach ($onceoff_allowances as $once) {
            ?>
                    <tr>
                        <td>
                            <?php
echo strtoupper($once['allowance_label']);
            ?>
                        </td>
                        <td>
                            <?php
echo _format_money($this, $once['allowance_value'], true);
            ?>
                        </td>
                    </tr>
                    <?php
}
    }
    ?>
                    <?php
if ($payslip['business_commission'] != 0) {
        ?>
                    <tr>
                        <td>
                            BUSINESS COMMISSION
                        </td>
                        <td>
                            <?php
echo _format_money($this, $payslip['business_commission'], true);
        ?>
                        </td>

                        <?php
}
    if ($payslip['recurring_commission'] != 0) {
        ?>
                    <tr>
                        <td>
                            RECURRING COMMISSION
                        </td>
                        <td>
                            <?php
echo _format_money($this, $payslip['recurring_commission'], true);
        ?>
                        </td>
                        <td>
                            <?php
}
    ?>

                    <tr>
                        <?php
$total_allowances = $payslip['base_salary'] + $payslip['allowance'] + $payslip['business_commission'] + $payslip['recurring_commission'] + $overtime + $sunday_pay;
    ?>
                        <td><?php if ($total_allowances > 0) {?><strong>Total</strong><?php }?></td>
                        <td>
                            <?php
if ($total_allowances > 0) {
        echo '<strong>' . _format_money($this, $total_allowances, true) . '</strong>';
    }
    ?>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="col-sm-4">
            <table class="table">
                <thead>
                    <tr class="text-center">
                        <th colSpan="2">DEDUCTIONS</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
if ($payslip['premium'] > 0) {
        ?>
                    <tr>
                        <td>PREMIUM</td>
                        <td><?=_format_money($this, $payslip['premium'], true)?></td>
                    </tr>

                    <?php }
    if ($payslip['staff_party'] > 0) {
        ?>
                    <tr>
                        <td>STAFF PARTY</td>
                        <td><?=_format_money($this, $payslip['staff_party'], true)?></td>
                    </tr>
                    <?php }?>
                    <?php
$scheduled_deductions = $this->payroll->get_row("SELECT * FROM tbl_loans l INNER JOIN tbl_track_loan tl ON l.loan_id = tl.loan_id WHERE l.emp_id = " . $payslip['emp_id'] . " AND l.loan_type ='deduction' AND tl.pay_month='" . $pay_month . "'");
    $onceoff_deductions = $this->payroll->get_payslip_deductions($payslip['emp_id'], $pay_month);
    if (!empty($scheduled_deductions)) {
        ?>
                    <tr>
                        <td><?=strtoupper($scheduled_deductions->debt_label);?></td>
                        <td><?=_format_money($this, $scheduled_deductions->loan_installment, true);?></td>
                    </tr>
                    <?php
}
    if (!empty($onceoff_deductions)) {
        foreach ($onceoff_deductions as $once) {
            ?>
                    <tr>
                        <td><?=strtoupper($once['deduction_label']);?></td>
                        <td><?=_format_money($this, $once['deduction_value'], true);?></td>
                    </tr>
                    <?php
}
    }
    if ($payslip['long_term'] > 0) {
        ?>
                    <tr>
                        <td>LONG TERM</td>
                        <td><?=_format_money($this, $payslip['long_t'], true);?></td>
                    </tr>
                    <?php
}
    if ($payslip['short_term'] > 0) {
        ?>
                    <tr>
                        <td>SHORT TERM</td>
                        <td><?=_format_money($this, $payslip['short_t'], true);?></td>
                    </tr>
                    <?php
}
    if ($payslip['loan_deduction'] > 0) {
        ?>
                    <tr>
                        <td>LOAN DEDUCTION</td>
                        <td><?=_format_money($this, $payslip['loan_deduction'], true);?></td>
                    </tr>
                    <?php
}
    if ($payslip['tax'] > 0) {
        ?>
                    <tr>
                        <td>PAYE</td>
                        <td><?=_format_money($this, $payslip['tax'], true);?></td>
                    </tr>
                    <?php
}
    ?>

                    <tr>
                        <?php $total_deductions = $payslip['loan_deduction'] + $payslip['fine_deduction'] + $payslip['tax'] + $payslip['long_t'] + $payslip['short_t'] + $payslip['premium'] + $payslip['staff_party'];?>
                        <td><?php if ($total_deductions > 0) {?><strong>Total</strong><?php }?></td>
                        <td> <strong><?php
if ($total_deductions > 0) {
        echo _format_money($this, $total_deductions, true);
    }
    ?></strong></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="col-sm-4">
            <table class="table">
                <thead>
                    <tr class="text-center" colSpan="2">
                        <th>BANK DETAILS</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <?php
$emp_bank = $this->employees->get_emp_details($payslip['emp_id']);
    if (!empty($emp_bank)) {
        ?>
                        <td>
                            <?php
echo "BANK TRANSFER: " . $emp_bank->bank_name . "<br><br><br><br>";
        echo strtoupper($emp_bank->bank_account_type) . " ACCOUNT No " . $emp_bank->bank_account;
        ?>
                        </td>
                        <?php
} else {
        echo "<td> No banking details! </td>";}
    ?>

                    </tr>
                </tbody>
            </table>
        </div>

        <div class="table-responsive col-sm-6">
            <table class="table table-bordered">
                <thead class="thead-light">
                    <tr class="text-center">
                        <th>Long Term To Date</th>
                        <th>Short Term To Date</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="text-center">
                        <td>
                            <?=_format_money($this, $this->payroll->get_sum_of_long_term($payslip['emp_id'], $pay_month), true);?>
                        </td>
                        <td>
                            <?=_format_money($this, $this->payroll->get_sum_of_short_term($payslip['emp_id'], $pay_month), true);?>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="table-responsive col-sm-6">
            <table class="table table-bordered">
                <thead class="thead-light">
                    <tr class="text-center">
                        <th class="align-middle">Taxable Income</th>
                        <th class="align-middle">Net Salary</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="text-center">
                        <td>
                            <?php
$overtime = $this->payroll->get_sum_of_overtimes($payslip['emp_id'], $pay_month);
    $commission = $this->commission->get_business_commission_total($payslip['emp_id'], $pay_month) + $this->commission->get_recurring_commission_total($payslip['emp_id'], $pay_month);
    $total_income = $payslip['base_salary'] + $overtime + $sunday_pay + $commission + $payslip['allowance'];

    $income_taxable = $total_income - $payslip['long_t'];
    echo _format_money($this, $income_taxable, true);
    ?>
                        </td>
                        <td><?php echo _format_money($this, $payslip['net_amount'], true); ?></td>
                    </tr>
                </tbody>

            </table>
        </div>
    </div>
</div>
<?php }?>