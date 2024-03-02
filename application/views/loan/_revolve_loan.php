<!-- Breadcrumbs-->
<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="<?php echo base_url(); ?>Loan">Loan</a>
    </li>
    <li class="breadcrumb-item active">Revolve Loan</li>
</ol>

<div class="row">
    <div class="col-md-6">
        <div class="card shadow-sm mb-5">
            <div class="card-body">
                <?php
$loan = $this->users->get_row("SELECT * FROM tbl_loans WHERE loan_id=$loan_id");
$emp_id = $loan->emp_id;
$emp_name = $this->users->get_row("SELECT fullname FROM tbl_employees WHERE emp_id=$emp_id");
?>
                <h4 class="tile-title">Revolve Loan for <i class="font-italic"><?php echo $emp_name->fullname; ?></i>
                </h4>
                <br>
                <div class="tile-body">
                    <div class="row">
                        <div class="col-md-12">
                            <form action="<?php echo base_url(); ?>loan/revolved_loan" method="POST">
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label h5" for="loan_amount">Loan Amount:</label>
                                    <div class="col-sm-8">
                                        <input class="form-control" type="text" name="loan_amount"
                                            value="<?php echo round($loan->loan_amount, 2) ?>" readonly>
                                        <input type="hidden" name="emp_id" value="<?php echo $emp_id; ?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label h5" for="period">Loan Period:</label>
                                    <div class="col-sm-8">
                                        <input class="form-control" type="text" name="period"
                                            value="<?php echo $loan->loan_period ?>" readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label h5" for="outstanding_balance">Outstanding
                                        Balance:</label>
                                    <div class="col-sm-8">
                                        <input class="form-control" type="text" name="outstanding_balance"
                                            value="<?php echo round($loan->outstanding_balance, 2) ?>" readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label h5" for="loan_installment">Loan
                                        Installment:</label>
                                    <div class="col-sm-8">
                                        <input class="form-control" type="text" name="loan_installment"
                                            value="<?php echo round($loan->loan_installment, 2) ?>" readonly>
                                        <input type="hidden" name="loan_id" value="<?php echo $loan_id; ?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label h5" for="settlement_amount">Payable
                                        Amount:</label>
                                    <div class="col-sm-8">
                                        <input class="form-control" type="text" name="settlement_amount"
                                            value="<?php echo round($loan->outstanding_balance, 2) ?>" readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label h5" for="date">Topup Amount:</label>
                                    <div class="col-sm-8">
                                        <input class="form-control" type="text" name="topup_amount" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="period" class="col-sm-4 col-form-label h5">Period in Months:</label>
                                    <div class="col-sm-8">
                                        <select name="loan_period" class="form-control selectpicker"
                                            data-live-search="true" data-title="Select Period in Months"
                                            data-width="100%" required>
                                            <?php for ($count = 1; $count <= 72; $count++) {
    echo "<option value=\"{$count}\">{$count}</option>";
}

?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-10 d-flex justify-content-end">
                                    <button class="btn btn-success" type="submit"><i
                                            class="fa fa-fw fa-lg fa-check-circle"></i>Confirm</button>&nbsp;&nbsp;&nbsp;<a
                                        class="btn btn-secondary" href="<?php echo base_url(); ?>loan"><i
                                            class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>