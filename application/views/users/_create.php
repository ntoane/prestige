<!-- Breadcrumbs-->
<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="<?= base_url() . 'users'; ?>">Users</a>
    </li>
    <li class="breadcrumb-item active">Create User</li>
</ol>

<!-- Page Content -->
<div class="card shadow-sm">
<div class="card-body">
<div class="row">
    <div class="col-md-12 mx-auto">

        <form action="<?= base_url() . 'users/create' ?>" method="POST">
            <div class="row">
                <div class="form-group col-md-6">
                    <label for="fullname"><strong>Fullname</strong></label>
                    <input type="text" name="fullname" class="form-control" />
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-6">
                    <label for="email"><strong>Email</strong></label>
                    <input type="email" name="email" class="form-control" />
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-6">
                    <label for="user_type_id"><strong>User Type</strong></label>
                    <select name="user_type_id" class="form-control">
                        <?php
                        foreach ($user_types as $user_type) {
                            echo '<option value="' . $user_type['user_type_id'] . '">' . $user_type['role'] . '</option>';
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="row mt-4">
                <div class="form-group col-md-4">
                    <input class="btn btn-success btn-block" name="submit_user" type="submit" value="Add User" />
                </div>
                <div class="form-group col-md-2">
                    <a href="<?= base_url().'users'; ?>" class="btn btn-dark btn-block">Cancel</a>
                </div>
            </div>
        </form>

    </div>
</div>
</div>
</div>