<!-- Breadcrumbs-->
<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="<?=base_url() . 'employees';?>">Employees</a>
    </li>
    <li class="breadcrumb-item active"><?php
if ($pos_id == 2) {
    echo "New Supervisor";
} else if ($pos_id == 3) {
    echo "New Manager";
} else {
    echo "New Employee";
}
?></li>
</ol>

<!-- Page Content -->
<div class="card shadow-sm mb-5">
    <div class="card-body">
        <form action="<?=base_url() . 'employees/create'?>" method="POST">
        <input  type="hidden" name="tab_id" value="<?=$this->uri->segment(3)?>" />
            <div class="row">
                <div class="form-group col-md-4">
                    <label for="fullname"><strong>Fullname<span class="text-danger">*</span></strong></label>
                    <input type="text" name="fullname" class="form-control" required="" />
                </div>
                <div class="form-group col-md-2">
                    <label for="national_id"><strong>ID/Passport</strong></label>
                    <input type="text" name="national_id" class="form-control" />
                </div>
                <div class="form-group col-md-2">
                    <label for="emp_number"><strong>Employment Number</strong></label>
                    <input type="text" name="emp_number" class="form-control" />
                </div>
                <div class="form-group col-md-2">
                    <label for="gender"><strong>Gender<span class="text-danger">*</span></strong></label>
                    <select name="gender" class="form-control" required="">
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                    </select>
                </div>
                <div class="form-group col-md-2">
                    <label for="date_of_birth"><strong>Date of Birth<span class="text-danger">*</span></strong></label>
                    <input type="date" name="date_of_birth" class="form-control" required="" />
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-4">
                    <label for="bank_name"><strong>Bank Name</strong></label>
                    <input type="text" name="bank_name" value="Standard Lesotho Bank" class="form-control" />
                </div>
                <div class="form-group col-md-4">
                    <label for="bank_account"><strong>Bank Account</strong></label>
                    <input type="text" name="bank_account" class="form-control" onkeypress='validate(event)' />
                </div>
                <div class="form-group col-md-2">
                    <label for="branch_code"><strong>Branch Code</strong></label>
                    <input type="text" name="branch_code" value="060667" class="form-control" required />
                </div>
                <div class="form-group col-md-2">
                    <label for="bank_account_type"><strong>Account Type</strong></label>
                    <select name="bank_account_type" class="form-control">
                        <option value="savings">Savings</option>
                        <option value="current">Current</option>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-4">
                    <label for="email"><strong>Email</strong></label>
                    <input type="email" name="email" class="form-control" />
                </div>
                <div class="form-group col-md-4">
                    <label for="phone"><strong>Phone</strong></label>
                    <input type="text" name="phone" class="form-control" />
                </div>
                <div class="form-group col-md-2">
                    <label for="base_salary"><strong>Basic Salary<span class="text-danger">*</span></strong></label>
                    <input type="number" name="base_salary" class="form-control" onkeypress='validate(event)'
                        required="" />
                </div>
                <div class="form-group col-md-2">
                    <label for="created"><strong>Employment Date</label>
                    <input type="date" name="created" class="form-control" />
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-2">
                    <label for="branch_id"><strong>Branch<span class="text-danger">*</span></strong></label>
                    <select name="branch_id" class="form-control" required="">
                        <option value="" selected="" disabled="">Select Branch</option>
                        <?php
foreach ($branches as $branch) {
    ?>
                        <option value="<?=$branch['branch_id'];?>"><?=$branch['branch_name'];?></option>
                        <?php
}
?>
                    </select>
                </div>
                <div class="form-group col-md-2">
                    <?php $positions = $this->employees->get_array("SELECT * FROM tbl_positions WHERE position_id !=1");?>
                    <label for="position"><strong>Position<span class="text-danger">*</span></strong></label>
                    <select id="position_id" name="position_id" class="form-control selectpicker" required
                        data-size="<?=count($positions);?>" data-live-search="true" data-title="Select Designation"
                        data-width="100%">
                        <?php
foreach ($positions as $position) {
    ?>
                        <option value="<?=$position['position_id'];?>"
                            <?=($pos_id == $position['position_id']) ? "selected" : ""?>>
                            <?=$position['position_name'];?></option>
                        <?php
}
?>
                    </select>
                </div>

                <div class="form-group col-md-2">
                    <label for="premium"><strong>Premium</strong></label>
                    <input type="number" name="premium" class="form-control" value="0" step="any" />
                </div>

                <div class="form-group col-md-2">
                    <label for="staff_party"><strong>Staff Party</strong></label>
                    <input type="number" name="staff_party" class="form-control" value="0" step="any" />
                </div>

                <div class="form-group col-md-2">
                    <label for="short_term"><strong>Short Term</strong></label>
                    <input type="number" name="short_term" value="0" class="form-control" step="any" min="0" required />
                </div>
                <div class="form-group col-md-2">
                    <label for="long_term"><strong>Long Term (%)</strong></label>
                    <input type="number" name="long_term" value="8" class="form-control" step="any" min="0"
                        required="" />
                </div>
            </div>

            <div class="row mt-4">
                <div class="form-group col-md-4">
                    <input class="btn btn-success btn-block" name="submit_employee" type="submit" value="Save" />
                </div>
                <div class="form-group col-md-4">
                    <a href="<?=base_url() . 'employees/' . $this->uri->segment(3) ;?>" class="btn btn-dark btn-block">Cancel</a>
                </div>
            </div>
        </form>
        </ div>
    </div>