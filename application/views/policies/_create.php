<!-- Breadcrumbs-->
<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="<?= base_url() . 'policies'; ?>">Settings</a>
    </li>
    <li class="breadcrumb-item active">Create Policy</li>
</ol>

<!-- Page Content -->
<div class="row">
    <div class="col-md-12 mx-auto">

        <form action="<?= base_url() . 'policies/create' ?>" method="POST">
            <div class="row">
                <div class="form-group col-md-6">
                    <label for="policy_name"><strong>Policy Name</strong></label>
                    <input type="text" name="policy_name" class="form-control" />
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-6">
                    <label for="policy_amount"><strong>Policy Amount</strong></label>
                    <input type="number" name="policy_amount" class="form-control" />
                </div>
            </div>
            <div class="row mt-4">
                <div class="form-group col-md-4">
                    <input class="btn btn-success btn-block" name="submit_policy" type="submit" value="Add Policy" />
                </div>
                <div class="form-group col-md-2">
                    <a href="<?= base_url() . 'policies'; ?>" class="btn btn-dark btn-block">Cancel</a>
                </div>
            </div>
        </form>

    </div>
</div>