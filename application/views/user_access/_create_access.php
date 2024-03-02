<!-- Breadcrumbs-->
<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="<?= base_url() . 'commission'; ?>">Users</a>
    </li>
    <li class="breadcrumb-item active">User Type Access</li>
</ol>

<!-- Page Content -->
<div class="card shadow-sm mb-3">
<div class="card-body">
<h5><strong>Access Role: </strong><?= $role; ?></h5>
<hr />
<div class="row">
    <div class="col-md-7">
<table id="data-table" class="table table-striped table-hover dt-responsive" style="width:100%">
    <thead>
        <tr>
            <th>Class Name</th>
            <th>Method Name</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($user_access as $access) {
            ?>
            <tr>
                <td><?= $access['class']; ?></td>
                <td><?= $access['method']; ?></td>
                <td>
                    <div class="btn-group">
                        <!-- <a href="<?= base_url() . 'user_access/delete_access/' . $access['user_type_access_id']; ?>" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Delete Record"><i class="fa fa-trash"></i></a> -->
                        <a href="#" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteAccess" data-recordid="<?= $access['user_type_access_id'] ?>" title="Delete this User Role Class"><i class="fa fa-trash"></i></a>
                    </div>
                </td>
            </tr>
            <?php
        }
        ?>
    </tbody>
</table>
    </div>
    <div class="col-md-5">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Add Class and Methods For: <small><?= $role; ?></small></h5>
                <hr/>
                <form action="<?= base_url() . 'user_access/create_access' ?>" method="POST">
                    <input type="hidden" name="user_type_id" value="<?= $user_type_id; ?>" />
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="class_id"><strong>Class Name</strong></label>
                            <!-- <input type="text" name="class" class="form-control" required/> -->
                            <select name="class" class="form-control">
                              <option value="dashboard">Dashboard</option>
                              <option value="commission">Commission</option>
                              <option value="loan">Loan</option>
                              <option value="payroll">Payroll</option>
                              <option value="branches">Branches</option>
                              <option value="designations">Designations</option>
                              <option value="employees">Employees</option>
                              <option value="provident">Reports</option>
                              <option value="user_access">User Roles</option>
                              <option value="users">Users</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="method_id"><strong>Method Name</strong></label>
                            <input type="text" name="method" class="form-control" value="*" required readonly/>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="form-group col-md-6">
                            <input class="btn btn-success btn-block" name="submit_access" type="submit" value="Save Record" />
                        </div>
                        <div class="form-group col-md-6">
                            <a href="<?= base_url() . 'user_access'; ?>" class="btn btn-dark btn-block">Cancel</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>
</div>

<!---Modals---->
<div class="modal fade" id="deleteAccess" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-confirm">
        <div class="modal-content">
            <div class="modal-header">
                <div class="icon-box">
                    <i class="fa fa-trash text-danger"></i> Delete User Role Class
                </div>				
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this User Role Class?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-info" data-dismiss="modal">Cancel</button>
                <a href="#" id="deleteRecord" class="btn btn-danger"><span class="text-white">Delete</span></a> 
            </div>
        </div>
    </div>
</div>