<!-- Breadcrumbs-->
<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="<?= base_url() . 'users'; ?>">Users</a>
    </li>
    <li class="breadcrumb-item active">All Users</li>
</ol>

<!-- Page Content -->
<div class="card shadow-sm mb-3">
    <div class="card-body">
    <div class="text-right mb-2">
        <a class="btn btn-success btn-sm" href="<?php echo base_url().'users/create';?> "><i class="fa fa-plus"></i> New User</a>
    </div>
        <table id="data-table" class="table table-striped table-hover dt-responsive" style="width:100%">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($users as $user) {
                    ?>
                    <tr>
                        <td><?= $user['fullname']; ?></td>
                        <td><?= $user['email']; ?></td>
                        <td><?= $user['role']; ?></td>
                        <td> 
                            <?php 
                            if($user['banned'] == '0') {
                                echo 'Active';
                            }else {
                                echo 'Blocked';
                            }
                            ?>
                        </td>
                        <td>
                            <div class="btn-group">
                                <a href="<?= base_url() . 'users/edit/' . $user['user_id']; ?>" class="btn btn-primary btn-sm mr-1" data-toggle="tooltip" data-placement="top" title="Edit User"><i class="fa fa-edit"></i></a>
                                <a href="<?= base_url() . 'users/send_user_password/' . $user['user_id']; ?>" class="btn btn-danger btn-sm mr-1" data-toggle="tooltip" data-placement="top" title="Send login credentials to user"><i class="fa fa-envelope"></i></a>
                                <?php if($user['banned'] == '0') { ?>
                                    <a href="#" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#blockUser" data-recordid="<?= $user['user_id'] ?>" title="Block this user"><i class="fa fa-ban"></i></a>
                                <?php }else { ?>
                                    <a href="#" class="btn btn-success btn-sm" data-toggle="modal" data-target="#unblockUser" data-recordid="<?= $user['user_id'] ?>" title="Unblock this user"><i class="fa fa-ban"></i></a>
                                <?php } ?>
                            </div>
                        </td>
                    </tr>
                    <?php
                }
                ?>
            </tbody>
        </table>
    </div> 
</div>

<div id="blockUser" class="modal fade">
    <div class="modal-dialog modal-confirm">
        <div class="modal-content">
            <div class="modal-header">
                <div class="icon-box">
                <i class="fa fa-ban text-danger"></i> Block User
                </div>				
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <form class="form-horizontal" action="<?= base_url() . 'users/block' ?>" method="POST">
                <div class="modal-body">
                    <input type="hidden" name="user_id" value="">
                    <div class="row">
                        <div class="col-md-3 text-right">
                            <label><strong>Reason</strong></label>
                        </div>
                        <div class="col-md-9">
                        <textarea class="form-control" name="reason" rows="4" placeholder="Optional"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-info" data-dismiss="modal">Cancel</button>
                    <button type="submit" name="submit_block" value="block" class="btn btn-success">Save</button> 
                </div>
            </form>
        </div>
    </div>
</div>

<div id="unblockUser" class="modal fade">
    <div class="modal-dialog modal-confirm">
        <div class="modal-content">
            <div class="modal-header">
                <div class="icon-box">
                <i class="fa fa-ban text-info"></i> Unblock User
                </div>				
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <form class="form-horizontal" action="<?= base_url() . 'users/unblock' ?>" method="POST">
                <div class="modal-body">
                    <input type="hidden" name="user_id" value="">
                    <div class="row">
                        <div class="col-md-3 text-right">
                            <label><strong>Reason</strong></label>
                        </div>
                        <div class="col-md-9">
                        <textarea class="form-control" name="reason" rows="4" placeholder="Optional"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-info" data-dismiss="modal">Cancel</button>
                    <button type="submit" name="submit_unblock" value="unblock" class="btn btn-success">Save</button> 
                </div>
            </form>
        </div>
    </div>
</div>