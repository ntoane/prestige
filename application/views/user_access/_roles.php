<!-- Breadcrumbs-->
<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="<?= base_url() . 'policies'; ?>">Settings</a>
    </li>
    <li class="breadcrumb-item active">User Roles</li>
</ol>

<!-- Page Content -->
<div class="card shadow-sm mb-3">
    <div class="card-body">
    <div class="text-right mb-2">
        <a class="btn btn-success btn-sm" href="<?php echo base_url().'user_access/create_role';?> "><i class="fa fa-plus"></i> New Role</a>
    </div>
        <table id="data-table" class="table table-striped table-hover dt-responsive" style="width:100%">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Role Name</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $count = 1;
                foreach ($user_roles as $role) {
                    ?>
                    <tr>
                        <td><?= $count; ?></td>
                        <td><?= $role['role']; ?></td>
                        <td>
                            <div class="btn-group">
                                <a href="<?= base_url() . 'user_access/edit_role/' . $role['user_type_id']; ?>" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Edit User Role"><i class="fa fa-edit"></i></a>
                                <a href="#" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteRole" data-recordid="<?= $role['user_type_id'] ?>" title="Delete this User Role"><i class="fa fa-trash"></i></a>
                            </div>
                        </td>
                    </tr>
                    <?php
                    $count +=1;
                }
                ?>
            </tbody>
        </table>
    </div> 
</div>

<!---Modals---->
<div class="modal fade" id="deleteRole" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-confirm">
        <div class="modal-content">
            <div class="modal-header">
                <div class="icon-box">
                    <i class="fa fa-trash text-danger"></i> Delete User Role
                </div>				
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this User Role?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-info" data-dismiss="modal">Cancel</button>
                <a href="#" id="deleteRecord" class="btn btn-danger"><span class="text-white">Delete</span></a> 
            </div>
        </div>
    </div>
</div>