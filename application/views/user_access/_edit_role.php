<!-- Breadcrumbs-->
<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="<?= base_url() . 'policies'; ?>">Settings</a>
    </li>
    <li class="breadcrumb-item active">Edit User Role</li>
</ol>

<!-- Page Content --> 
<form action="<?= base_url() . 'user_access/edit_role' ?>" method="POST">
    <input type="hidden" name="user_type_id" value="<?= (!empty($role)) ? $role->user_type_id : ''; ?>" />
    <div class="row">
        <div class="form-group col-md-6">
            <label for="role_name"><strong>User_Type Name</strong></label>
            <input type="text" name="role_name" class="form-control" value="<?= (!empty($role)) ? $role->role : ''; ?>" required />
        </div>
    </div>
    <div class="row mt-4">
        <div class="form-group col-md-4">
            <input class="btn btn-success btn-block" name="update_role" type="submit" value="Save Changes" />
        </div>
        <div class="form-group col-md-2">
            <a href="<?= base_url() . 'user_access/load_roles'; ?>" class="btn btn-dark btn-block">Cancel</a>
        </div>
    </div>
</form>