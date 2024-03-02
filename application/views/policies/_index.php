<!-- Breadcrumbs-->
<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="<?= base_url() . 'policies'; ?>">Settings</a>
    </li>
    <li class="breadcrumb-item active">All Policies</li>
</ol>

<!-- Page Content -->
<div class="card shadow-sm">
    <div class="card-body">
        <table id="data-table" class="table table-striped table-hover dt-responsive" style="width:100%">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Amount</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($policies as $policy) {
                    ?>
                    <tr>
                        <td><?= $policy['policy_name']; ?></td>
                        <td><?= $policy['policy_amount']; ?></td>
                        <td>
                            <div class="btn-group">
                                <a href="<?= base_url() . 'policies/edit/' . $policy['policy_id']; ?>" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Edit Branch"><i class="fa fa-edit"></i></a>
                                <a href="<?= base_url() . 'policies/delete/' . $policy['policy_id']; ?>" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Delete Branch"><i class="fa fa-trash"></i></a>
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