<!-- Breadcrumbs-->
<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="<?=base_url() . 'employees';?>">Branches</a>
    </li>
    <li class="breadcrumb-item active">Edit Branch</li>
</ol>

<!-- Page Content -->
<form action="<?=base_url() . 'employees/edit'?>" method="POST">
    <input type="hidden" name="emp_id" value="<?=(!empty($employee)) ? $employee->emp_id : '';?>" />
    <input  type="hidden" name="tab_id" value="<?=$this->uri->segment(4)?>" />
    <div class="row">
        <div class="form-group col-md-4">
            <label for="fullname"><strong>Fullname<span class="text-danger">*</span></strong></label>
            <input type="text" name="fullname" value="<?=(!empty($employee)) ? $employee->fullname : '';?>"
                class="form-control" required="" />
        </div>
        <div class="form-group col-md-2">
            <label for="national_id"><strong>ID/Passport<span class="text-danger">*</span></strong></label>
            <input type="text" name="national_id" value="<?=(!empty($employee)) ? $employee->national_id : '';?>"
                class="form-control" />
        </div>
        <div class="form-group col-md-2">
            <label for="emp_number"><strong>Employment Number<span class="text-danger">*</span></strong></label>
            <input type="text" name="emp_number" value="<?=(!empty($employee)) ? $employee->emp_number : '';?>"
                class="form-control" required="" />
        </div>
        <div class="form-group col-md-2">
            <label for="gender"><strong>Gender<span class="text-danger">*</span></strong></label>
            <select name="gender" class="form-control" required="">
                <option value="male" <?=(!empty($employee) && ($employee->gender == 'male')) ? 'selected' : ''?>>Male
                </option>
                <option value="female" <?=(!empty($employee) && ($employee->gender == 'female')) ? 'selected' : ''?>>
                    Female</option>
            </select>
        </div>
        <div class="form-group col-md-2">
            <label for="date_of_birth"><strong>Date of Birth<span class="text-danger">*</span></strong></label>
            <?php
$dob = (!empty($employee)) ? $employee->date_of_birth : '';
$datetime = new DateTime($dob);
?>
            <input type="datetime-local" name="date_of_birth" value="<?php echo $datetime->format('Y-m-d\TH:i:s'); ?>"
                class="form-control" required="" />
        </div>
    </div>
    <div class="row">
        <div class="form-group col-md-4">
            <label for="bank_name"><strong>Bank Name</strong></label>
            <input type="text" name="bank_name" value="<?=(!empty($employee)) ? $employee->bank_name : '';?>"
                class="form-control" />
        </div>
        <div class="form-group col-md-4">
            <label for="bank_account"><strong>Bank Account</strong></label>
            <input type="text" name="bank_account" value="<?=(!empty($employee)) ? $employee->bank_account : '';?>"
                class="form-control" onkeypress='validate(event)' />
        </div>
        <div class="form-group col-md-2">
            <label for="branch_code"><strong>Branch Code<span class="text-danger">*</span></strong></label>
            <input type="text" name="branch_code" value="<?=(!empty($employee)) ? $employee->branch_code : '';?>"
                class="form-control" required />
        </div>
        <div class="form-group col-md-2">
            <label for="bank_account_type"><strong>Account Type</strong></label>
            <select name="bank_account_type" class="form-control">
                <option value="savings"
                    <?=(!empty($employee) && ($employee->bank_account_type == 'savings')) ? 'selected' : ''?>>Savings
                </option>
                <option value="current"
                    <?=(!empty($employee) && ($employee->bank_account_type == 'current')) ? 'selected' : ''?>>Current
                </option>
            </select>
        </div>
    </div>
    <div class="row">
        <div class="form-group col-md-4">
            <label for="email"><strong>Email</strong></label>
            <input type="email" name="email" value="<?=(!empty($employee)) ? $employee->email : '';?>"
                class="form-control" />
        </div>
        <div class="form-group col-md-4">
            <label for="phone"><strong>Phone<span class="text-danger">*</span></strong></label>
            <input type="text" name="phone" value="<?=(!empty($employee)) ? $employee->phone : '';?>"
                class="form-control" />
        </div>
        <div class="form-group col-md-2">
            <label for="base_salary"><strong>Basic Salary<span class="text-danger">*</span></strong></label>
            <input type="number" name="base_salary" value="<?=(!empty($employee)) ? $employee->base_salary : '';?>"
                class="form-control" onkeypress='validate(event)' required="" />
        </div>
        <div class="form-group col-md-2">
            <label for="created"><strong>Employment Date</label>
            <?php
                    $dob = (!empty($employee)) ? $employee->created : '';
$datetime = new DateTime($dob);
?>
            <input type="datetime-local" name="created" value="<?php echo $datetime->format('Y-m-d\TH:i:s'); ?>"
                class="form-control" required="" />
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
                <option value="<?=$branch['branch_id'];?>"
                    <?=(!empty($employee) && ($employee->branch_id == $branch['branch_id'])) ? 'selected' : ''?>>
                    <?=$branch['branch_name'];?></option>
                <?php
}
?>
            </select>
        </div>
        <div class="form-group col-md-2">
            <?php $positions = $this->employees->get_array("SELECT * FROM tbl_positions WHERE position_id !=1");?>
            <label for="position"><strong>Position<span class="text-danger">*</span></strong></label>
            <select id="position_id" name="position_id" class="form-control" data-size="<?=count($positions);?>"
                data-live-search="true" data-title="Select Designation" data-width="100%">
                <?php
foreach ($positions as $position) {
    ?>
                <option value="<?=$position['position_id'];?>"
                    <?=(!empty($employee) && ($employee->position_id == $position['position_id'])) ? 'selected' : ''?>>
                    <?=$position['position_name'];?>
                </option>
                <?php
}
?>
            </select>
        </div>

        <div class="form-group col-md-2">
            <label for="premium"><strong>Premium</strong></label>
            <input type="number" name="premium" class="form-control" step="any"
                value="<?=(!empty($employee)) ? $employee->premium : '';?>" />
        </div>

        <div class="form-group col-md-2">
            <label for="staff_party"><strong>Staff Party</strong></label>
            <input type="number" name="staff_party" class="form-control" step="any"
                value="<?=(!empty($employee)) ? $employee->staff_party : '';?>" />
        </div>

        <div class="form-group col-md-2">
            <label for="short_term"><strong>Short Term</strong></label>
            <input type="number" name="short_term" value="<?=(!empty($employee)) ? $employee->short_term : '';?>"
                step="any" class="form-control" required />
        </div>
        <div class="form-group col-md-2">
            <label for="long_term"><strong>Long Term (%)</label>
            <input type="number" name="long_term" value="<?=(!empty($employee)) ? $employee->long_term : '';?>"
                step="any" class="form-control" required="" />
        </div>
    </div>


    <div class="row mt-4">
        <div class="form-group col-md-4">
            <input class="btn btn-success btn-block" name="update_employee" type="submit" value="Save Changes" />
        </div>
        <div class="form-group col-md-4">
            <a href="<?=base_url() . 'employees/' . $this->uri->segment(4);?>" class="btn btn-dark btn-block">Cancel</a>

        </div>
    </div>
</form>