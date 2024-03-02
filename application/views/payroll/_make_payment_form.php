<!-- Breadcrumbs-->
<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="<?= base_url() . 'payroll'; ?>">Payroll</a>
    </li>
    <li class="breadcrumb-item active">Make Payment</li>
</ol>

<!-- Page Content -->
<div class="row mb-3">
    <div class="col-md-2 mr-auto">
        <a href="<?= base_url() . 'payroll/make_payment'; ?>" class="btn btn-primary btn-block"><i class="fa fa-arrow-left"></i> Back</a>
    </div>
    <div class="col-md-3 ml-auto">
        <h6><strong>Branch: </strong><?= $employee->branch_name; ?></h6>
        <h6><strong>Pay Month: </strong><?= $pay_month; ?></h6>
    </div>
</div>
<div class="card shadow-sm mb-5">
    <div class="card-header">
        <div class="row">
            <div class="col-md-4 border-right">
                <h6>Employee Particulars</h6>
                <hr />
                <h6>Employee ID: <span class="text-muted"><?= !(empty($employee)) ? $this->employees->format_emp_id($employee->emp_id) : 0; ?></span></h6>
                <h6>Names: <span class="text-muted"><?= !(empty($employee)) ? $employee->fullname : 0; ?></span></h6>
                <h6>Position: <span class="text-muted"><?= !(empty($employee)) ? $employee->position_name : 0; ?></span></h6>
            </div>
            <div class="col-md-4 border-right">
                <h6>Contact Details</h6>
                <hr />
                <h6>Phone: <span class="text-muted"><?= !(empty($employee)) ? $employee->phone : 0; ?></span></h6>
                <h6>Email: <span class="text-muted"><?= !(empty($employee)) ? $employee->email : 0; ?></span></h6>
            </div>
            <div class="col-md-4">
                <h6>Account Information</h6>
                <hr />
                <h6>Bank: <span class="text-muted"><?= !(empty($employee)) ? $employee->bank_name : 0; ?></span></h6>
                <h6>Account Number: <span class="text-muted"><?= !(empty($employee)) ? $employee->bank_account : 0; ?></span></h6>
                <h6>Account Type: <span class="text-muted"><?= !(empty($employee)) ? ucfirst($employee->bank_account_type) : 0; ?></span></h6>
            </div>
        </div>
    </div>
    <div class="card-body">
        <form method="POST" action="<?= base_url() . 'payroll/pay_employee'; ?>">
            <input type="hidden" name="emp_id" value="<?= !empty($employee) ? $employee->emp_id : 0; ?>" />
            <input type="hidden" name="payment_month" value="<?= $pay_month; ?>" />
            <input type="hidden" name="branch_id" value="<?= !empty($employee) ? $employee->branch_id : 0; ?>" />
            <div class="row">
                <div class="form-group col-md-3">
                    <label for="">
                        <a href="#" data-toggle="popover" title="Employee Salary" data-content="<?= 'Base Salary: ' . _format_money($this, $employee->base_salary, true) . '<br />Commission: ' . _format_money($this, $commission->total_commission, true); ?>" data-placement="top" data-html="true">
                            Base Salary + Commission
                        </a>
                    </label>
                    <input type="text" class="form-control" value="<?= !(empty($salary_record)) ? _format_money($this, $salary_record['base_salary'], true) : 0; ?>" readonly=""/>
                    <input type="hidden" class="form-control" name="base_salary" value="<?= !(empty($salary_record)) ? $salary_record['base_salary'] : 0; ?>"/>
                </div>
                <div class="form-group col-md-3">
                    <label for="">Deductions <a href="#" onclick="openDeductions()"><i class="fa fa-plus-circle"></i> Deduction</a></span></label>
                    <input type="text" class="form-control" value="<?= !(empty($salary_record)) ? _format_money($this, $salary_record['deductions'], true) : 0; ?>" readonly=""/>
                    <input type="hidden" class="form-control" name="fine_deduction" value="<?= !(empty($salary_record)) ? $salary_record['deductions'] : 0; ?>" />
                </div>
                <div class="form-group col-md-3">
                    <label for="">Allowances <a href="#" onclick="openAllowances()"><i class="fa fa-plus-circle"></i> Allowance</a></label>
                    <input type="text" class="form-control" value="<?= !(empty($salary_record)) ? _format_money($this, $salary_record['allowances'], true) : 0; ?>" readonly=""/>
                    <input type="hidden" class="form-control" name="allowance" value="<?= !(empty($salary_record)) ? $salary_record['allowances'] : 0; ?>" />
                </div>
                <div class="form-group col-md-3">
                    <label for="">
                        <a href="#" data-toggle="popover" title="Loan" 
                           data-content="
                           <?php
                           if (!empty($loan)) {
                               echo 'Loan: ' . _format_money($this, $loan->loan_amount, true) . '<br />';
                               echo 'Period: ' . $loan->loan_period . '<br />';
                               echo 'Outstanding balance: ' . _format_money($this, $loan->outstanding_balance, true) . '<br />';
                               echo 'Installment: ' . _format_money($this, $loan->loan_installment, true) . '<br />';
                           } else {
                               echo 'No Active Loan';
                           }
                           ?>" 
                           data-placement="top" data-html="true">
                            Loan Installment
                        </a>
                    </label>
                    <input type="text" class="form-control" value="<?= !(empty($salary_record)) ? _format_money($this, $salary_record['loan_installment'], true) : 0; ?>" readonly=""/>
                    <input type="hidden" class="form-control" name="loan_installment" value="<?= !(empty($salary_record)) ? $salary_record['loan_installment'] : 0; ?>" />
                    <input type="hidden" class="form-control" name="loan_id" value="<?= !(empty($loan)) ? $loan->loan_id : 0; ?>" />
                </div>
            </div>

            <div class="row">
                <div class="form-group col-md-3">
                    <label for="">Long Term</label>
                    <input type="text" class="form-control" value="<?= !(empty($salary_record)) ? _format_money($this, $salary_record['longTerm'], true) : 0; ?>" readonly=""/>
                    <input type="hidden" class="form-control" name="long_term" value="<?= !(empty($salary_record)) ? $salary_record['longTerm'] : 0; ?>" />
                </div>
                <div class="form-group col-md-3">
                    <label for="">Short Term</label>
                    <input type="text" class="form-control" value="<?= !(empty($salary_record)) ? _format_money($this, $salary_record['shortTerm'], true) : 0; ?>" readonly=""/>
                    <input type="hidden" class="form-control" name="short_term" value="<?= !(empty($salary_record)) ? $salary_record['shortTerm'] : 0; ?>" />
                </div>
                <div class="form-group col-md-3">
                    <label for="">PAYE</label>
                    <input type="text" class="form-control" value="<?= !(empty($salary_record)) ? _format_money($this, $salary_record['tax'], true) : 0; ?>" readonly=""/>
                    <input type="hidden" class="form-control" name="tax" value="<?= !(empty($salary_record)) ? $salary_record['tax'] : 0; ?>" />
                </div>
                <div class="form-group col-md-3">
                    <label for="">Net Pay</label>
                    <input type="text" class="form-control" value="<?= !(empty($salary_record)) ? _format_money($this, $salary_record['netPay'], true) : 0; ?>" readonly=""/>
                    <input type="hidden" class="form-control" name="net_amount" value="<?= !(empty($salary_record)) ? $salary_record['netPay'] : 0; ?>" />
                </div>
            </div>

            <div class="row"> 
                <div class="form-group col-md-3">
                    <label for="">Payment Method</label>
                    <select class="form-control" name="payment_type" required>
                        <option value="" selected disabled>Select Payment Method</option>
                        <?php
                        $payment_types = $this->payroll->get_array("SELECT * FROM tbl_payment_method");
                        foreach ($payment_types as $pt) {
                            echo "<option value='" . $pt['name'] . "'>" . $pt['name'] . "</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group col-md-9">
                    <label for="">Comments</label>
                    <input type="text" class="form-control" name="comments" placeholder="If any," />
                </div>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Update</button>

        </form>
    </div>
</div>



<!-- Modals -->
<div class="modal fade" id="payment_allowanceModal" tabindex="-1" role="dialog" aria-labelledby="salary_detailsModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="payment_allowanceModalLabel">Allowances</h4>
                <!--<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>-->
            </div>
            <div class="modal-body" ng-controller="AllowanceCtrl">
                <div class="row"> 
                    <input type="hidden" id="emp_id" value="<?= $employee->emp_id; ?>" />
                    <input type="hidden" id="pmonth" value="<?= $pmonth . '-' . $pyear; ?>" />
                    <div class="col-md-12" ng-init="fetch()">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Label</th>
                                    <th>Allowance</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr ng-repeat="allowance in allowances" ng-include="getTemplate(allowance)">
                                </tr>
                                <tr>
                                    <td><input type="text" placeholder="New Label" class="form-control"  ng-model="addallowance.allowance_label"></td>
                                    <td><input type="text" placeholder="Amount" class="form-control"  ng-model="addallowance.allowance_value">
                                        <input type="hidden" ng-model="addallowance.pay_month" />
                                    </td>
                                    <td>
                                        <button type="button" ng-click="save(addallowance)" class="btn btn-primary btn-sm"><i class="fa fa-save"></i> Add</button>
                                        <button type="button" ng-click="reset()" class="btn btn-default btn-sm"> Cancel</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <script type="text/ng-template" id="normal_l">
                            <td>{{allowance.allowance_label}}</td>
                            <td>{{allowance.allowance_value}}</td>
                            <td>
                            <button type="button" ng-click="edit(allowance)" class="btn btn-success btn-sm"><i class="fa fa-edit"></i> Edit</button>
                            <button type="button" ng-click="delete(allowance)" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> Delete</button>
                            </td>
                        </script>
                        <script type="text/ng-template" id="edit_l">
                            <td><input type="text" class="form-control"  ng-model="editallowance.allowance_label"></td>
                            <td><input type="text" class="form-control"  ng-model="editallowance.allowance_value"></td>
                            <td>
                            <button type="button" ng-click="save_changes(editallowance)" class="btn btn-primary btn-sm"><i class="fa fa-save"></i> Save</button>
                            <button type="button" ng-click="reset()" class="btn btn-default btn-sm"> Cancel</button>
                            </td>
                        </script>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <!--<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>-->
                <input type="hidden" value="<?= $pmonth; ?>" id="apmonth" />
                <button type="button" class="btn btn-success" onclick="closeAllowances(<?= $employee->branch_id . ',' . $pyear . ',' . $employee->emp_id; ?>)">Save Allowances</button>
                                <!--<a href="<?= base_url() . 'payroll/make_payment_form/' . $employee->branch_id . '/' . $pay_month . '/' . $employee->emp_id ?>" class="btn btn-success" >Save Allowances</a>-->
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="payment_deductionModal" tabindex="-1" role="dialog" aria-labelledby="salary_deductionsModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="payment_deductionModalLabel">Deductions</h4>
                <!--<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>-->
            </div>
            <div class="modal-body" ng-controller="DeductionCtrl">
                <div class="row"> 
                    <input type="hidden" id="emp_id" value="<?= $employee->emp_id; ?>" />
                    <input type="hidden" id="pmonth" value="<?= $pmonth . '-' . $pyear; ?>" />
                    <div class="col-md-12" ng-init="fetch()">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Label</th>
                                    <th>Deduction</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr ng-repeat="deduction in deductions" ng-include="getTemplate(deduction)">
                                </tr>
                                <tr>
                                    <td><input type="text" placeholder="New Label" class="form-control"  ng-model="adddeduction.deduction_label"></td>
                                    <td><input type="text" placeholder="Amount" class="form-control"  ng-model="adddeduction.deduction_value">
                                        <input type="hidden" ng-model="adddeduction.pay_month" />
                                    </td>
                                    <td>
                                        <button type="button" ng-click="save(adddeduction)" class="btn btn-primary btn-sm"><i class="fa fa-save"></i> Add</button>
                                        <button type="button" ng-click="reset()" class="btn btn-default btn-sm"> Cancel</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <script type="text/ng-template" id="normal_2">
                            <td>{{deduction.deduction_label}}</td>
                            <td>{{deduction.deduction_value}}</td>
                            <td>
                            <button type="button" ng-click="edit(deduction)" class="btn btn-success btn-sm"><i class="fa fa-edit"></i> Edit</button>
                            <button type="button" ng-click="delete(deduction)" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> Delete</button>
                            </td>
                        </script>
                        <script type="text/ng-template" id="edit_2">
                            <td><input type="text" class="form-control"  ng-model="editdeduction.deduction_label"></td>
                            <td><input type="text" class="form-control"  ng-model="editdeduction.deduction_value"></td>
                            <td>
                            <button type="button" ng-click="save_changes(editdeduction)" class="btn btn-primary btn-sm"><i class="fa fa-save"></i> Save</button>
                            <button type="button" ng-click="reset()" class="btn btn-default btn-sm"> Cancel</button>
                            </td>
                        </script>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <!--<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>-->
                <input type="hidden" value="<?= $pmonth; ?>" id="dpmonth" />
                <button type="button" class="btn btn-success" onclick="closeDeductions(<?= $employee->branch_id . ',' . $pyear . ',' . $employee->emp_id; ?>)">Save Deductions</button>
            </div>
        </div>
    </div>
</div>