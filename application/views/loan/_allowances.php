<!-- Breadcrumbs-->
<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="<?= base_url() . 'commission'; ?>">Loan</a>
    </li>
    <li class="breadcrumb-item active">Manage Allowances</li>
</ol>
<div class="row mb-3">
<div class="col-md-10">

</div>
<div class="col-md-2 mr-auto">
    <a href="<?= base_url() . 'loan'?>" class="btn btn-primary btn-block"><i class="fa fa-arrow-left"></i> Back</a>
    </div>
</div>

<div class="card shadow-sm mb-3">
<div class="card-body">
<div class="row">
    <div class="col-md-12">
    <div class="text-right mb-2">
        <a class="btn btn-success btn-sm" href="<?=base_url() . 'loan/new_allowance';?>"><i
                class="fa fa-plus"></i> New Allowance</a>
    </div>
        <table id="data-table" class="table table-striped table-hover dt-responsive" style="width:100%">
            <thead>
                <tr>
                <th>Employee Name</th>
                <th>Allowance Name</th>
                <th>Allowance Amount</th>
                <th>Period in Months</th>
                <th>Outstanding Balance</th>
                <th>Installment</th>
                <th>Allowance Status</th>
                <th>Date </th>
                <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($allowances as $allowance) {
                    ?>
                    <tr>
                    <?php $emp_id = $allowance['emp_id'];?>
                    <?php $emp_name = $this->loan->get_row("SELECT fullname FROM tbl_employees WHERE emp_id = '$emp_id'"); ?>
                        <td><?= $emp_name->fullname; ?></td>
                        <td><?= $allowance['debt_label']; ?></td>
                        <td><?= _format_money($this,$allowance['loan_amount'], true); ?></td>
                        <td><?= $allowance['loan_period']; ?></td>
                        <td><?= _format_money($this,$allowance['outstanding_balance'], true); ?></td>
                        <td><?= _format_money($this,$allowance['loan_installment'], true); ?></td>
                        <td><?php
                            $loan_status = $allowance['loan_status'];
                            if($loan_status==0){
                                echo '<span class="badge badge-info">Active</span>';
                            }else if($loan_status==1){
                                echo '<span class="badge badge-success">Settled</span>';;
                            }else{
                                echo '<span class="badge badge-danger">Undefinied</span>';;
                            }

                        ?></td>
                        <td><?= date('d-m-Y', strtotime($allowance['created'])); ?></td>
                        <td>
                        <a href="#" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteAllowance" data-recordid="<?= $allowance['loan_id'] ?>" title="Delete this Allowance"><i class="fa fa-trash"></i></a>
                        </td>
                    </tr>
                    <?php
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
</div>
</div>

<!---Modals---->
<div class="modal fade" id="deleteAllowance" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-confirm">
        <div class="modal-content">
            <div class="modal-header">
                <div class="icon-box">
                    <i class="fa fa-trash text-danger"></i> Delete Allowance
                </div>				
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this Allowance?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-info" data-dismiss="modal">Cancel</button>
                <a href="#" id="deleteRecord" class="btn btn-danger"><span class="text-white">Delete</span></a> 
            </div>
        </div>
    </div>
</div>