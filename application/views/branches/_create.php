<!-- Breadcrumbs-->
<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="<?= base_url() . 'branches'; ?>">Branches</a>
    </li>
    <li class="breadcrumb-item active">Create Branch</li>
</ol>

<!-- Page Content -->
<div class="row">
    <div class="col-md-12 mx-auto">

        <form action="<?= base_url() . 'branches/create' ?>" method="POST">
            <div class="row">
                <div class="form-group col-md-6">
                    <label for="branch_name"><strong>Branch Name</strong></label>
                    <input type="text" name="branch_name" class="form-control" />
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-6">
                    <label for="branch_name"><strong>Branch Code</strong></label>
                    <input type="text" name="branch_code" class="form-control" />
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-6">
                    <label for="branch_district"><strong>Branch District</strong></label>
                    <select name="branch_district" class="form-control">
                        <option value="Maseru">Maseru</option>
                        <option value="Berea">Berea</option>
                        <option value="Leribe">Leribe</option>
                        <option value="Botha-Bothe">Botha-Bothe</option> 
                        <option value="Mokhotlong">Mokhotlong</option>
                        <option value="Mafeteng">Mafeteng</option>
                        <option value="Mohales hoek">Mohale's hoek</option>
                        <option value="Thaba-Tseka">Thaba-Tseka</option>
                        <option value="Quthing">Quthing</option>
                        <option value="Qachas neck">Qacha's neck</option>
                    </select>
                </div>
            </div>
            <div class="row mt-4">
                <div class="form-group col-md-4">
                    <input class="btn btn-success btn-block" name="submit_branch" type="submit" value="Add Branch" />
                </div>
                <div class="form-group col-md-2">
                    <a href="<?= base_url() . 'branches'; ?>" class="btn btn-dark btn-block">Cancel</a>
                </div>
            </div>
        </form>

    </div>
</div>