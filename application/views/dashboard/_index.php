<!-- Breadcrumbs-->
<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="<?=base_url() . 'dashboard';?>">Dashboard</a>
    </li>
    <li class="breadcrumb-item active">Blank Page</li>
</ol>

<!-- Page Content -->
<div class="row mb-5">
    <div class="col-md-10">
        <div id='calendar'></div>
    </div>
    <div class="col-md-2">
        <h3>Short Cuts</h3>
        <hr />
        <?php 
            if (_get_user_type_access1($this, _get_current_user_type_id($this), 'payroll', '*')) {
        ?>
        <a href="<?=base_url() . 'payroll';?>" class="btn btn-lg btn-success btn-block">Payroll</a>
        <hr />
        <?php } ?>
        <?php 
            if (_get_user_type_access1($this, _get_current_user_type_id($this), 'user_access', '*')) {
        ?>
        <a href="<?=base_url() . 'user_access/load_roles';?>" class="btn btn-lg btn-primary btn-block">User Roles</a>
        <hr />
        <?php } ?>
        <?php 
            if (_get_user_type_access1($this, _get_current_user_type_id($this), 'designations', '*')) {
        ?>
        <a href="<?=base_url() . 'designations';?>" class="btn btn-lg btn-info btn-block">Designations</a>
        <?php } ?>
    </div>
</div>