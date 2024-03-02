<!-- Breadcrumbs-->
<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="<?php echo base_url(); ?>Loan">Loan</a>
    </li>
    <li class="breadcrumb-item active">Deduction Application</li>
</ol>

<div class="row">
    <div class="col-md-6">
    <div class="card shadow-sm">
    <div class="card-body">
    <h4 class="tile-title">Make New Deduction Application</h4>
    <br>
        <div class="row">
        <div class="col-md-12">
        <form action="<?php echo base_url(); ?>loan/record_deduction" method="POST">
            <div class="form-group row">
                <label for="emp_id" class="col-sm-4 col-form-label h5">Employee Name:</label>
                <div class="col-sm-8">
                <select name="emp_id" class="form-control selectpicker" data-live-search="true" data-title="Select Employee" data-width="100%" required>
                <?php
                    foreach ($employees as $emp) {
                        $emp_id=$emp['emp_id'];
                        $emp_name=$emp['fullname'];
                    echo "<option value=\"{$emp_id}\">{$emp_name}</option>";
                    }
                    ?>
                </select>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-4 col-form-label h5" for="date">Deduction Label:</label>
                <div class="col-sm-8">
                    <input class="form-control"  type="text" name="deduction_label" required>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-4 col-form-label h5" for="date">Deduction Amount:</label>
                <div class="col-sm-8">
                    <input class="form-control"  type="text" name="deduction_amount" required>
                </div>
            </div>
            <div class="form-group row">
                <label for="period" class="col-sm-4 col-form-label h5">Period in Months:</label>
                <div class="col-sm-8">
                <select name="period" class="form-control selectpicker" data-live-search="true" data-title="Select Period in Months" data-width="100%" required>
                    <?php for($count=1; $count <=72; $count++)
                    echo "<option value=\"{$count}\">{$count}</option>";
                    ?>
                </select>
                </div>
            </div>
            <div class="col-md-8 d-flex justify-content-end">
                <button class="btn btn-success" type="submit" name="deduction"><i class="fa fa-fw fa-lg fa-check-circle"></i>Confirm</button>&nbsp;&nbsp;&nbsp;<a class="btn btn-secondary" href="<?php echo base_url(); ?>loan/load_deductions"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
            </div>
        </form>
        </div>
        </div>
    </div>
    </div>
    </div>
</div>