<!-- Breadcrumbs-->
<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="<?= base_url() . 'commission'; ?>">Users</a>
    </li>
    <li class="breadcrumb-item active">User Type Access</li>
</ol>

<div class="card shadow-sm">
<div class="card-body">
<div class="row">
    <div class="col-md-10 mx-auto">
        <div class="tile">
            <div class="tile-body">
            <br>
                <div class="row">
                    <div class="col-md-4">
                        <label class="text-right"><strong>Select User Access Role</strong></label>
                    </div>
                    <div class="col-md-4">
                        <select id="user_type_id"  class="form-control selectpicker" data-size="<?= count($user_access); ?>" data-live-search="true" data-title="User Access Roles" data-width="100%"> 
                        <?php
                        foreach($user_access as $access) {
                            ?>
                            <option value="<?= $access['user_type_id']; ?>"><?= $access['role']; ?></option>
                            <?php
                        }
                        ?>
                        </select>
                    </div>
                </div>
                <br>
                <br>
                <div class="row">
                    <div class="col-md-4 mx-auto">
                        <button type="button" onclick="requestAccessRole()" class="btn btn-primary btn-block">Go</button>
                    </div>
                </div>
                <br><br>
            </div>
        </div>
    </div>
</div>
</div>
</div>