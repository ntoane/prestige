<!-- Breadcrumbs-->
<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="<?= base_url() . 'policies'; ?>">Settings</a>
    </li>
    <li class="breadcrumb-item active">Edit Branch</li>
</ol>

<!-- Page Content --> 
<form action="<?= base_url() . 'policies/edit' ?>" method="POST">
    <input type="hidden" name="policy_id" value="<?= (!empty($policy)) ? $policy->policy_id : ''; ?>" />
    <div class="row">
        <div class="form-group col-md-6">
            <label for="policy_name"><strong>Policy Name</strong></label>
            <input type="text" name="policy_name" class="form-control" value="<?= (!empty($policy)) ? $policy->policy_name : ''; ?>" required />
        </div>
    </div>
    <div class="row">
        <div class="form-group col-md-6">
            <label for="policy_amount"><strong>Policy Amount</strong></label>
            <input type="number" name="policy_amount" class="form-control" value="<?= (!empty($policy)) ? $policy->policy_amount : ''; ?>" required />
        </div>
    </div>
    <div class="row mt-4">
        <div class="form-group col-md-4">
            <input class="btn btn-success btn-block" name="update_policy" type="submit" value="Save Changes" />
        </div>
        <div class="form-group col-md-2">
            <a href="<?= base_url() . 'policies'; ?>" class="btn btn-dark btn-block">Cancel</a>
        </div>
    </div>
</form>