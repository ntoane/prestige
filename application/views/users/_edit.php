<!-- Breadcrumbs-->
<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="<?= base_url() . 'users'; ?>">Users</a>
    </li>
    <li class="breadcrumb-item active">Edit User</li>
</ol>

<!-- Page Content --> 
<form action="<?= base_url() . 'users/edit' ?>" method="POST">
    <input type="hidden" name="user_id" value="<?= (!empty($user)) ? $user->user_id : ''; ?>" />
    <div class="row">
        <div class="form-group col-md-6">
            <label for="fullname"><strong>Fullname</strong></label>
            <input type="text" name="fullname" class="form-control" value="<?= (!empty($user)) ? $user->fullname : ''; ?>" required />
        </div>
    </div>
    <div class="row">
        <div class="form-group col-md-6">
            <label for="email"><strong>Email</strong></label>
            <input type="email" name="email" class="form-control" value="<?= (!empty($user)) ? $user->email : ''; ?>" required />
        </div>
    </div>
    <div class="row">
        <div class="form-group col-md-6">
            <label for="user_type_id"><strong>User Type</strong></label>
            <select name="user_type_id" class="form-control">
                <?php
                foreach ($user_types as $user_type) {
                    ?>
                    <option value="<?= $user_type['user_type_id'] ?>" <?= (!empty($user) && ($user->user_type_id == $user_type['user_type_id'])) ? 'selected' : '' ?>><?= $user_type['role'] ?></option>
                    <?php
                }
                ?>
            </select>
        </div>
    </div>
    <div class="row mt-4">
        <div class="form-group col-md-4">
            <input class="btn btn-success btn-block" name="update_user" type="submit" value="Save Changes" />
        </div>
        <div class="form-group col-md-2">
            <a href="<?= base_url() . 'users'; ?>" class="btn btn-dark btn-block">Cancel</a>
        </div>
    </div>
</form>