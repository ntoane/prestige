<!-- Breadcrumbs-->
<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="<?= base_url() . 'policies'; ?>">Settings</a>
    </li>
    <li class="breadcrumb-item active">All Designations</li>
</ol>

<!-- Page Content -->
<div class="card shadow-sm mb-3">
    <div class="card-body">
    <div class="text-right mb-2">
        <a class="btn btn-success btn-sm" href="<?php echo base_url().'designations/create';?> "><i class="fa fa-plus"></i> New Designation</a>
    </div>
        <table id="data-table" class="table table-striped table-hover dt-responsive" style="width:100%">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Designation Name</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $count = 1;
                foreach ($designations as $designation) {
                    ?>
                    <tr>
                        <td><?= $count; ?></td>
                        <td><?= $designation['position_name']; ?></td>
                        <td>
                            <div class="btn-group">
                                <a href="<?= base_url() . 'designations/edit/' . $designation['position_id']; ?>" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Edit this designation"><i class="fa fa-edit"></i></a>
                                <a href="#" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteDesignation" data-recordid="<?= $designation['position_id'] ?>" title="Delete this designation"><i class="fa fa-trash"></i></a>
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
<div class="modal fade" id="deleteDesignation" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-confirm">
        <div class="modal-content">
            <div class="modal-header">
                <div class="icon-box">
                    <i class="fa fa-trash text-danger"></i> Delete Designation
                </div>				
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this Designation?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-info" data-dismiss="modal">Cancel</button>
                <a href="#" id="deleteRecord" class="btn btn-danger"><span class="text-white">Delete</span></a> 
            </div>
        </div>
    </div>
</div>