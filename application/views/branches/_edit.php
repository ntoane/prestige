<!-- Breadcrumbs-->
<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="<?= base_url() . 'branches'; ?>">Branches</a>
    </li>
    <li class="breadcrumb-item active">Edit Branch</li>
</ol>

<!-- Page Content --> 
<form action="<?= base_url() . 'branches/edit' ?>" method="POST">
    <input type="hidden" name="branch_id" value="<?= (!empty($branch)) ? $branch->branch_id : ''; ?>" />
    <div class="row">
        <div class="form-group col-md-6">
            <label for="branch_name"><strong>Banch Name</strong></label>
            <input type="text" name="branch_name" class="form-control" value="<?= (!empty($branch)) ? $branch->branch_name : ''; ?>" required />
        </div>
    </div>
    <div class="row">
        <div class="form-group col-md-6">
            <label for="branch_name"><strong>Banch Code</strong></label>
            <input type="text" name="branch_code" class="form-control" value="<?= (!empty($branch)) ? $branch->branch_code : ''; ?>" required />
        </div>
    </div>
    <div class="row">
        <div class="form-group col-md-6">
            <label for="branch_district"><strong>Branch District</strong></label>
            <select name="branch_district" class="form-control">
                <option value="Maseru" <?= (!empty($branch) && ($branch->branch_district == 'Maseru')) ? 'selected' : '' ?>>Maseru</option>
                <option value="Berea" <?= (!empty($branch) && ($branch->branch_district == 'Berea')) ? 'selected' : '' ?>>Berea</option>
                <option value="Leribe" <?= (!empty($branch) && ($branch->branch_district == 'Leribe')) ? 'selected' : '' ?>>Leribe</option>
                <option value="Botha-Bothe" <?= (!empty($branch) && ($branch->branch_district == 'Botha-Bothe')) ? 'selected' : '' ?>>Botha-Bothe</option> 
                <option value="Mokhotlong" <?= (!empty($branch) && ($branch->branch_district == 'Mokhotlong')) ? 'selected' : '' ?>>Mokhotlong</option>
                <option value="Mafeteng" <?= (!empty($branch) && ($branch->branch_district == 'Mafeteng')) ? 'selected' : '' ?>>Mafeteng</option>
                <option value="Mohales hoek" <?= (!empty($branch) && ($branch->branch_district == 'Mohales hoek')) ? 'selected' : '' ?>>Mohale's hoek</option>
                <option value="Thaba-Tseka" <?= (!empty($branch) && ($branch->branch_district == 'Thaba-Tseka')) ? 'selected' : '' ?>>Thaba-Tseka</option>
                <option value="Quthing" <?= (!empty($branch) && ($branch->branch_district == 'Quthing')) ? 'selected' : '' ?>>Quthing</option>
                <option value="Qachas neck" <?= (!empty($branch) && ($branch->branch_district == 'Qachas neck')) ? 'selected' : '' ?>>Qacha's neck</option>
            </select>
        </div>
    </div>
    <div class="row mt-4">
        <div class="form-group col-md-4">
            <input class="btn btn-success btn-block" name="update_branch" type="submit" value="Save Changes" />
        </div>
        <div class="form-group col-md-2">
            <a href="<?= base_url() . 'branches'; ?>" class="btn btn-dark btn-block">Cancel</a>
        </div>
    </div>
</form>