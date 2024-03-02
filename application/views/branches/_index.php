<!-- Breadcrumbs-->
<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="<?= base_url() . 'branches'; ?>">Branches</a>
    </li>
    <li class="breadcrumb-item active">All Branches</li>
</ol>

<!-- Page Content -->
<div class="card shadow-sm mb-3">
    <div class="card-body">
    <div class="text-right mb-2">
        <a class="btn btn-success btn-sm" href="<?php echo base_url().'branches/create';?> "><i class="fa fa-plus"></i> New Branch</a>
    </div>
        <table id="data-table" class="table table-striped table-hover dt-responsive" style="width:100%">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Code</th>
                    <th>District</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($branches as $branch) {
                    ?>
                    <tr>
                        <td><?= $branch['branch_name']; ?></td>
                        <td><?= $branch['branch_code']; ?></td>
                        <td><?= $branch['branch_district']; ?></td>
                        <td>
                            <div class="btn-group">
                                <a href="<?= base_url() . 'branches/edit/' . $branch['branch_id']; ?>" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Edit Branch"><i class="fa fa-edit"></i></a>
                                <a href="#" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteBranch" data-recordid="<?= $branch['branch_id'] ?>" title="Delete this Branch"><i class="fa fa-trash"></i></a>
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

<!---Modals---->
<div class="modal fade" id="deleteBranch" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-confirm">
        <div class="modal-content">
            <div class="modal-header">
                <div class="icon-box">
                    <i class="fa fa-trash text-danger"></i> Delete Branch
                </div>				
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this Branch?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-info" data-dismiss="modal">Cancel</button>
                <a href="#" id="deleteRecord" class="btn btn-danger"><span class="text-white">Delete</span></a> 
            </div>
        </div>
    </div>
</div>