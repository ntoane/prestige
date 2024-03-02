<!-- Breadcrumbs-->
<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="<?= base_url() . 'policies'; ?>">Settings</a>
    </li>
    <li class="breadcrumb-item active">Create User Role</li>
</ol>

<!-- Page Content -->
<div class="row">
    <div class="col-md-12 mx-auto">

        <form action="<?= base_url() . 'user_access/create_role' ?>" method="POST">
            <div class="row">
                <div class="form-group col-md-6">
                    <label for="role_name"><strong>User Role Name</strong></label>
                    <input type="text" name="role_name" class="form-control" />
                </div>
            </div>
            <div class="row mt-4">
                <div class="form-group col-md-4">
                    <input class="btn btn-success btn-block" name="submit_role" type="submit" value="Add Role" />
                </div>
                <div class="form-group col-md-2">
                    <a href="<?= base_url() . 'user_access/load_roles'; ?>" class="btn btn-dark btn-block">Cancel</a>
                </div>
            </div>
        </form>

    </div>
</div>