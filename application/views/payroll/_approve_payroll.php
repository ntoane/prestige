<!-- Breadcrumbs-->
<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="<?=base_url() . 'commission';?>">Payroll</a>
    </li>
    <li class="breadcrumb-item active">Approve Payroll</li>
</ol>


<div class="row mb-4">
    <div class="col-md-10">
        <h5><strong>Branch: </strong><?=$branch_name;?></h5>
        <h5><strong>Pay Month: </strong><?=$pay_month;?></h5>
    </div>
    <div class="col-md-2 mr-auto">
        <a href="#" class="btn btn-success mb-2" data-toggle="modal" data-target="#approveAllPayroll"
            data-recordid="<?=$branch_id;?>" data-recordid1="<?=$pay_month;?>"
            title="Click here to approve all payroll selected by branch"><i class="fa fa-check-circle"></i> Approve All
            Payroll</a>
    </div>
</div>

<div class="card shadow-sm mb-3">
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <table id="data-table" class="table table-striped table-hover dt-responsive" style="width:100%">
                    <thead>
                        <tr>
                            <th>Employee Name</th>
                            <th>Base Salary</th>
                            <th>Long Term</th>
                            <th>Short Term</th>
                            <th>PAYE</th>
                            <th>Total Deductions</th>
                            <th>Total Allowances</th>
                            <th>Net Pay</th>
                            <th>Payroll Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
foreach ($payment as $pay) {
    ?>
                        <tr>
                            <td><?=$pay['fullname'];?></td>
                            <td><?=_format_money($this, $pay['base_salary'], true);?></td>
                            <td><?=_format_money($this, $pay['long_term_accum'], true);?></td>
                            <td><?=_format_money($this, $pay['short_term_accum'], true);?></td>
                            <td><?=_format_money($this, $pay['tax'], true);?></td>
                            <td><?=_format_money($this, $pay['fine_deduction'] + $pay['loan_deduction'], true);?></td>
                            <td><?=_format_money($this, $pay['allowance'], true);?></td>
                            <td><?=_format_money($this, $pay['net_amount'], true);?></td>
                            <td>
                                <?php
if ($pay['approve'] == '0') {
        echo '<span class="badge badge-warning">Pending</span>';
    } else if ($pay['approve'] == '2') {
        echo '<span class="badge badge-danger">Rejected</span>';
    } else {
        echo '<span class="badge badge-success">Approved</span>';
    }
    ?>
                            </td>
                            <td>
                                <?php
if ($pay['approve'] == '0') {
        ?>
                                <a href="#" class="btn btn-success btn-sm" data-toggle="modal"
                                    data-target="#approvePayroll" data-recordid="<?=$pay['salary_payment_id']?>"
                                    data-recordid1="<?=$branch_id?>" data-recordid2="<?=$pay_month?>"
                                    title="Approve this payroll"><i class="fa fa-check-circle"></i></a>
                                <a href="#" class="btn btn-danger btn-sm" data-toggle="modal"
                                    data-target="#rejectPayroll_<?=$pay['salary_payment_id']?>"
                                    title="Reject this payroll"><i class="fa fa-times-circle"></i></a>
                                <!--Reject Payroll Modal -->
                                <div class="modal fade" id="rejectPayroll_<?=$pay['salary_payment_id']?>" tabindex="-1"
                                    role="dialog">
                                    <div class="modal-dialog modal-confirm">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <div class="icon-box">
                                                    <i class="fa fa-times-circle text-danger"></i> Reject Payroll
                                                </div>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-hidden="true">&times;</button>
                                            </div>
                                            <div class="modal-body">
                                                <form method="POST"
                                                    action="<?=base_url() . 'payroll/reject_payroll';?>">
                                                    <input type="hidden" name="salary_payment_id"
                                                        value="<?=$pay['salary_payment_id'];?>" />
                                                    <div class="row">
                                                        <div class="col-md-3 text-right">
                                                            <label><strong>Reasons</strong></label>
                                                        </div>
                                                        <div class="col-md-9">
                                                            <textarea class="form-control" name="reasons" rows="6"
                                                                required
                                                                placeholder="Please type as much information as you can that will guide another user to rectify this payroll"></textarea>
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <h6>Are you sure to reject this payroll?</h6>
                                                        </div>

                                                    </div>
                                                    <input type="submit" name="submit_reject" value="Yes, I confirm"
                                                        class="btn btn-danger btn-md float-right">
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php
}
    if ($pay['approve'] == '2') {
        ?>
                                <a href="#" class="btn btn-success btn-sm" data-toggle="modal"
                                    data-target="#approvePayroll" data-recordid="<?=$pay['salary_payment_id']?>"
                                    title="Approve this payroll"><i class="fa fa-check-circle"></i></a>
                                <?php
}
    ?>
                                <a href="#" class="btn btn-info btn-sm" role="button" data-toggle="modal"
                                    data-target="#payrollDetails_<?=$pay['salary_payment_id']?>" title="More details"><i
                                        class="fa fa-info-circle"></i></a>
                                <!-- Payroll details modal-->
                                <div class="modal fade" id="payrollDetails_<?=$pay['salary_payment_id']?>" tabindex="-1"
                                    role="dialog" aria-labelledby="payRollDetails" aria-hidden="true">
                                    <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Salary Payroll Payment
                                                    Details <?=$pay['fullname']?></h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <!-- <div class="container"> -->
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <table class="table table-light">
                                                            <thead class="thead-dark">
                                                                <tr>
                                                                    <th colspan="2"><?=$pay['fullname']?></span></th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td class="text-right"><strong>Employement Number :
                                                                            <?=$pay['emp_number']?></strong></td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="text-right"><strong>Branch :
                                                                            <?=$this->branches->get_branch_name($pay['branch_id'])->branch_name;?></strong>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="text-right"><strong>Designation :
                                                                            <?=$this->designations->get_position_name($pay['position_id'])->position_name;?></strong>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="text-right"><strong>Joining Date :
                                                                            <?php $created_date = strtotime($pay['created']);?>
                                                                            <?=date('d-m-Y', $created_date)?>
                                                                        </strong></td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <table class="table table-light">
                                                            <thead class="thead-dark">
                                                                <tr>
                                                                    <th colspan="2">Salary Details</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td>
                                                                        <div class="card mb-3 border-dark">
                                                                            <div class="card-body">
                                                                                <blockquote class="card-blockquote">
                                                                                    <p><strong>Basic Salary :
                                                                                            <?=_format_money($this, $pay['base_salary'], true)?></strong>
                                                                                    </p>
                                                                                    <p>
                                                                                        <?php
$overtime = $this->payroll->get_sum_of_overtimes($pay['emp_id'], $pay_month);
    if (!empty($overtime)) {
        echo '<strong> Overtime: ' . _format_money($this, $overtime, true) . '</strong>';
    }
    ?>
                                                                                    </p>
                                                                                    <p>
                                                                                        <?php
$commission = $this->commission->get_business_commission_total($pay['emp_id'], $pay_month) + $this->commission->get_recurring_commission_total($pay['emp_id'], $pay_month);
    if (!empty($commission)) {
        echo '<strong> Commission: ' . _format_money($this, $commission, true) . '</strong>';
    }
    ?>
                                                                                    </p>
                                                                                    <p>
                                                                                        <strong>Allowances:</strong>
                                                                                        <?php
$scheduled_allowances = $this->payroll->get_row("SELECT * FROM tbl_loans WHERE emp_id = " . $pay['emp_id'] . " AND loan_status = '0' AND loan_type ='allowance'");
    $onceoff_allowances = $this->payroll->get_payslip_allowances($pay['emp_id'], $pay_month);
    if (!empty($scheduled_allowances)) {
        echo '<br>' . $scheduled_allowances->debt_label . ': ' . _format_money($this, $scheduled_allowances->loan_installment, true);
    }
    if (!empty($onceoff_allowances)) {
        foreach ($onceoff_allowances as $once) {
            echo '<br>' . $once['allowance_label'] . ': ' . _format_money($this, $once['allowance_value'], true);
        }
    }
    ?>
                                                                                        <br><strong>Total :
                                                                                            <?=_format_money($this, $pay['allowance'], true)?></strong>
                                                                                    </p>
                                                                                </blockquote>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="card mb-3 border-dark">
                                                                            <div class="card-body">
                                                                                <blockquote class="card-blockquote">
                                                                                    <p><strong>Premium :
                                                                                            <?=_format_money($this, $pay['premium'], true)?></strong>
                                                                                    </p>
                                                                                    <p><strong>Staff Party :
                                                                                            <?=_format_money($this, $pay['staff_party'], true)?></strong>
                                                                                    </p>
                                                                                    <p>
                                                                                        <strong>Deductions:</strong>
                                                                                        <?php
$scheduled_deductions = $this->payroll->get_row("SELECT * FROM tbl_loans WHERE emp_id = " . $pay['emp_id'] . " AND loan_status = '0' AND loan_type ='deduction'");
    $onceoff_deductions = $this->payroll->get_payslip_deductions($pay['emp_id'], $pay_month);
    if (!empty($scheduled_deductions)) {
        echo '<br>' . $scheduled_deductions->debt_label . ': ' . _format_money($this, $scheduled_deductions->loan_installment, true);
    }
    if (!empty($onceoff_deductions)) {
        foreach ($onceoff_deductions as $once) {
            echo '<br>' . $once['deduction_label'] . ': ' . _format_money($this, $once['deduction_value'], true);
        }
    }
    ?>
                                                                                        <br><strong>Total :
                                                                                            <?=_format_money($this, $pay['fine_deduction'], true)?></strong>
                                                                                    </p>
                                                                                    <p><strong>Loan Deduction :
                                                                                            <?=_format_money($this, $pay['loan_deduction'], true)?></strong>
                                                                                    </p>
                                                                                    <p><strong>PAYE :
                                                                                            <?=_format_money($this, $pay['tax'], true)?></strong>
                                                                                    </p>
                                                                                    <p><strong>Long Term :
                                                                                            <?=_format_money($this, $pay['long_term_accum'], true)?></strong>
                                                                                    </p>
                                                                                    <p><strong>Short Term :
                                                                                            <?=_format_money($this, $pay['short_term_accum'], true)?></strong>
                                                                                    </p>
                                                                                </blockquote>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <table class="table table-light">
                                                            <thead class="thead-dark">
                                                                <tr>
                                                                    <th colspan="2">Total Salary Details</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td class="text-right">
                                                                        <?php
$gross_pay = $pay['base_salary'] + $pay['allowance'] + $commission + $overtime;
    ?>
                                                                        <strong>Gross Salary :
                                                                            <?=_format_money($this, $gross_pay, true)?></strong>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="text-right">
                                                                        <?php
$taxable_income = $gross_pay - $pay['long_term_accum'];
    ?>
                                                                        <strong>Taxable Income :
                                                                            <?=_format_money($this, $taxable_income, true)?></strong>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="text-right">
                                                                        <?php
$total_deductions = $pay['loan_deduction'] + $pay['fine_deduction'] + $pay['tax'] + $pay['long_term_accum'] + $pay['short_term_accum'] + $pay['premium'] + $pay['staff_party'];
    ?>
                                                                        <strong>Total Deductions :
                                                                            <?=_format_money($this, $total_deductions, true)?></strong>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="text-right">
                                                                        <?php
$net_pay = $gross_pay - $total_deductions;
    ?>
                                                                        <strong>Net Salary :
                                                                            <?=_format_money($this, $pay['net_amount'], true)?></strong>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                <div class="row bg-light">
                                                    <div class="col-md-6">
                                                        <?php
if ($pay['approve'] == 0) {
        ?>
                                                        <strong>Payroll Status: <span
                                                                class="badge badge-warning">Pending</span></strong>
                                                        <?php
} else if ($pay['approve'] == 1) {
        ?>
                                                        <strong>Payroll Status: <span
                                                                class="badge badge-success">Approved</span></strong>
                                                        <?php
} else {
        ?>
                                                        <strong>Payroll Status: <span
                                                                class="badge badge-danger">Rejected</span></strong>
                                                        <br>
                                                        <p><strong>Reasons: </strong><?=$pay['reject_reason']?></p>
                                                        <?php
}
    ?>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <strong>Payroll created: <span class="badge badge-info">
                                                                <?php $pay_date = strtotime($pay['paid_date']);?>
                                                                <?=date('d-m-Y', $pay_date)?>
                                                            </span></strong></strong>
                                                    </div>
                                                </div>
                                                <!-- </div> -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <?php
}
?>
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>

<!---Other Modals---->
<div class="modal fade" id="approvePayroll" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-confirm">
        <div class="modal-content">
            <div class="modal-header">
                <div class="icon-box">
                    <i class="fa fa-check-circle text-success"></i> Approve Payroll
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to approve this payroll?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-info" data-dismiss="modal">Cancel</button>
                <a href="#" id="approveRecord" class="btn btn-success"><span class="text-white">Approve</span></a>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="approveAllPayroll" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-confirm">
        <div class="modal-content">
            <div class="modal-header">
                <div class="icon-box">
                    <i class="fa fa-check-circle text-success"></i> Approve Payroll
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to approve all the visible payroll?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-info" data-dismiss="modal">Cancel</button>
                <a href="#" id="branchRecord" class="btn btn-success"><span class="text-white">Approve</span></a>
            </div>
        </div>
    </div>
</div>