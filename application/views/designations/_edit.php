<!-- Breadcrumbs-->
<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="<?= base_url() . 'policies'; ?>">Settings</a>
    </li>
    <li class="breadcrumb-item active">Edit Designation</li>
</ol>

<!-- Page Content --> 
<form action="<?= base_url() . 'designations/edit' ?>" method="POST">
    <input type="hidden" name="designation_id" value="<?= (!empty($designation)) ? $designation->position_id : ''; ?>" />
    <div class="row">
        <div class="form-group col-md-6">
            <label for="policy_name"><strong>Designation Name</strong></label>
            <input type="text" name="designation_name" class="form-control" value="<?= (!empty($designation)) ? $designation->position_name : ''; ?>" required />
        </div>
    </div>
    <div class="row mt-4">
        <div class="form-group col-md-4">
            <input class="btn btn-success btn-block" name="update_designation" type="submit" value="Save Changes" />
        </div>
        <div class="form-group col-md-2">
            <a href="<?= base_url() . 'designations'; ?>" class="btn btn-dark btn-block">Cancel</a>
        </div>
    </div>
</form>