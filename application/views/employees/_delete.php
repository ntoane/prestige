<!-- Breadcrumbs-->
<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="<?=base_url() . 'employees';?>">Employees</a>
    </li>
    <li class="breadcrumb-item active">Remove Employee</li>
</ol>

<!-- Page Content -->
<div class="card shadow-sm mb-5">
    <div class="card-body">
        <form action="<?=base_url() . 'employees/delete'?>" method="POST">
            <input type="hidden" name="emp_id" value="<?=(!empty($employee)) ? $employee->emp_id : '';?>" />
            <input  type="hidden" name="tab_id" value="<?=$this->uri->segment(4)?>" />
            <div class="row">
                <div class="form-group col-md-4">
                    <label for="inactive_reason"><strong>Reason to delete Employee<span
                                class="text-danger">*</span></strong></label>
                    <textarea name="inactive_reason" class="form-control" required=""></textarea>
                </div>
            </div>
            <div class="row mt-4">
                <div class="form-group col-md-2">
                    <input class="btn btn-danger btn-block" name="delete_employee" type="submit"
                        value="Confirm Delete" />
                </div>
                <div class="form-group col-md-2">
                    <a href="<?=base_url() . 'employees';?>" class="btn btn-dark btn-block">Cancel</a>
                </div>
            </div>
        </form>
    </div>
</div>