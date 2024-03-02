<!-- Breadcrumbs-->
<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="<?=base_url() . 'employees';?>">Employees</a>
    </li>
    <li class="breadcrumb-item active">New Sales Advisor</li>
</ol>

<!-- Page Content -->
<div class="card shadow-sm mb-5">
    <div class="card-body">
        <form action="<?=base_url() . 'employees/create_consultant'?>" method="POST">
        <input  type="hidden" name="tab_id" value="<?=$this->uri->segment(4)?>" />
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
                    <label for="created"><strong>Employment Date</label>
                    <input type="date" name="created" class="form-control" />
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-2">
                    <label for="base_salary"><strong>Basic Salary<span class="text-danger">*</span></strong></label>
                    <input type="number" name="base_salary" value="0" class="form-control" onkeypress='validate(event)'
                        required="" />
                </div>
                <div class="form-group col-md-2">
                    <label for="short_term"><strong>Short Term (%)<span class=" text-danger">*</span></strong></label>
                    <input type="number" name="short_term" value="10" step="any" min="0" class="form-control" required />
                </div>
                <div class="form-group col-md-2">
                    <label for="long_term"><strong>Long Term (%)<span class=" text-danger">*</span></strong></label>
                    <input type="number" name="long_term" value="0" step="any" min="0" class="form-control" required />
                </div>
            </div>

            <div class="row mt-4">
                <div class="form-group col-md-4">
                    <input class="btn btn-success btn-block" name="submit_employee" type="submit" value="Save" />
                </div>
                <div class="form-group col-md-4">
                    <a href="<?=base_url() . 'employees';?>" class="btn btn-dark btn-block">Cancel</a>
                </div>
            </div>
        </form>
    </div>
</div>