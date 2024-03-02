<!-- Breadcrumbs-->
<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="<?php echo base_url(); ?>Loan">Loan</a>
    </li>
    <li class="breadcrumb-item active">Loan Application</li>
</ol>

<div class="card shadow-sm mb-5 pl-2 pr-2 pt-3 pb-2">
<div class="row">
    <div class="col-md-8">
        <div class="tile">
            <h5 class="tile-title">Loan Application</h5>
            <form action="<?php echo base_url(); ?>loan/record_loan" method="POST">
                <div class="tile-body">

                    <div class="form-group row">
                        <label for="emp_id" class="control-label col-md-3">Employee Name:</label>
                        <div class="col-md-6">
                            <?php
                                $emp_name = $this->users->get_row("SELECT fullname FROM tbl_employees WHERE emp_id = $emp_id");
                            ?>
                            <input class="form-control" type="text" name="emp_id" value="<?php echo $emp_name->fullname;?>" readonly>
                            <input type="hidden" name="emp_id" value="<?php echo $emp_id; ?>">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="loan_amount" class="control-label col-md-3">Loan Amount:</label>
                        <div class="col-md-6">
                            <input class="form-control" type="text" name="loan_amount" value="<?php echo _format_money($this,$loan_amount, true);?>" readonly>
                            <input type="hidden" name="loan_amount" value="<?php echo $loan_amount; ?>">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="period" class="control-label col-md-3">Period in Months:</label>
                        <div class="col-md-6">
                            <input class="form-control" type="text" name="period" value="<?php echo $period;?>" readonly>
                            <input type="hidden" name="period" value="<?php echo $period; ?>">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="installment" class="control-label col-md-3">Installment:</label>
                        <div class="col-md-6">
                            <?php
                                $installment = $loan_amount / $period;
                            ?>
                            <input class="form-control" type="text" name="installment" value="<?php echo  _format_money($this,$installment,true) ?>" readonly>
                            <input type="hidden" name="installment" value="<?php echo $installment; ?>">
                        </div>
                    </div>
                </div>
                <div class="tile-footer">
                    <?php
                        $active_loan = count($this->users->get_array("SELECT loan_status FROM tbl_loans WHERE loan_status = '0' AND loan_type = 'loan' AND emp_id = " . $emp_id));
                        if($active_loan> 0 ){
                    ?>
                    <div class="row">
                        <div class="col-md-8 d-flex justify-content-end">
                            <a class="btn btn-secondary" href="<?php echo base_url(); ?>loan/new_loan"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
                        </div>
                    </div>
                    <div class="col-md-8 d-flex justify-content-end">
                        <small class="text-danger">*<?= $emp_name->fullname ?> have active loan, you can only revolve or settle outstanding loan before applying for a new loan</small>
                    </div>
                    <?php
                    }else{ ?>
                    <div class="row">
                        <div class="col-md-8 d-flex justify-content-end">
                            <button class="btn btn-success" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Confirm</button>&nbsp;&nbsp;&nbsp;<a class="btn btn-secondary" href="<?php echo base_url(); ?>loan/new_loan"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
                        </div>
                    </div>
                    <?php } ?>
                </div>
                <hr>
            </form>
        </div>
    </div>

    <div class="col-md-4">
            <div class="tile">
                <h5 class="tile-title"><?= $emp_name->fullname; ?></h5>
                <div class="tile-body">
                    <table class="table">
                        <tbody>
                            <tr>
                                <td><strong>Base Salary : </strong></td>
                                <?php
                                $base_salary = $this->users->get_row("SELECT base_salary FROM tbl_employees WHERE emp_id = $emp_id");
                                ?>
                                <td><?= _format_money($this,$base_salary->base_salary, true); ?></td>
                            </tr>
                            <tr>
                                <td><strong>Number of Active Loans : </strong></td>
                                <?php
                                $active_loan = count($this->users->get_array("SELECT loan_status FROM tbl_loans WHERE loan_status = '0' AND loan_type = 'loan' AND emp_id = ". $emp_id));
                                ?>
                                <td><?= $active_loan; ?></td>
                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>
    </div>
</div>
<br><br>
<div class="row">
    <div class="col-md-12">
        <div class="tile">
            <h5 class="tile-title">Loan History of <?= $emp_name->fullname; ?></h5>
            <?php $loan_history = $this->users->get_array("SELECT * FROM tbl_loans WHERE loan_type = 'loan' AND emp_id = $emp_id ORDER BY loan_status"); ?>
            <div class="tile-body">
                <div class="table-responsive">
                    <table class="table table-hover" id="dataTable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Amount</th>
                                <th>Oustanding Balance</th>
                                <th>Installment</th>
                                <th>Settlement Amount</th>
                                <th>Period</th>
                                <th>Loan Status</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $count=1;
                            foreach ($loan_history as $history) {
                                ?>
                                <tr>
                                    <td><?= $count ?></td>
                                    <td><?= _format_money($this,$history['loan_amount'],true); ?></td>
                                    <td><?= _format_money($this,$history['outstanding_balance'],true); ?></td>
                                    <td><?= _format_money($this,$history['loan_installment'],true); ?></td>
                                    <td><?= _format_money($this,$history['settlement_amount'],true); ?></td>
                                    <td><?= $history['loan_period']; ?></td>
                                    <td><?php
                                        $loan_status = $history['loan_status'];
                                        if($loan_status==0){
                                            echo "Active";
                                        }else if($loan_status==1){
                                            echo "Settled";
                                        }else if($loan_status==2){
                                            echo "Revolved";
                                        }else{
                                            echo "Undefined";
                                        }

                                    ?></td>
                                    <td><?= $history['created']; ?></td>
                                    <?php $count = $count+1; ?>
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
</div>
</div>