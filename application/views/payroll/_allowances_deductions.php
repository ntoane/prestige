<style>
.switch {
    position: relative;
    display: inline-block;
    width: 60px;
    height: 34px;
}

.switch input {
    opacity: 0;
    width: 0;
    height: 0;
}

.slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #ccc;
    -webkit-transition: .4s;
    transition: .4s;
}

.slider:before {
    position: absolute;
    content: "";
    height: 26px;
    width: 26px;
    left: 4px;
    bottom: 4px;
    background-color: white;
    -webkit-transition: .4s;
    transition: .4s;
}

input:checked+.slider {
    background-color: #2196F3;
}

input:focus+.slider {
    box-shadow: 0 0 1px #2196F3;
}

input:checked+.slider:before {
    -webkit-transform: translateX(26px);
    -ms-transform: translateX(26px);
    transform: translateX(26px);
}

/* Rounded sliders */
.slider.round {
    border-radius: 34px;
}

.slider.round:before {
    border-radius: 50%;
}

.btn-group-xs > .btn, .btn-xs {
  padding: .25rem .4rem;
  font-size: .875rem;
  line-height: .5;
  border-radius: .2rem;
}
</style>
<!-- Breadcrumbs-->
<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="<?=base_url() . 'payroll';?>">Payroll</a>
    </li>
    <li class="breadcrumb-item active">Allowances & Deductions</li>
</ol>

<div class="row mb-3">
    <div class="col-md-10">
        <h5><strong>Branch: </strong><?=$branch;?></h5>
    </div>
    <div class="col-md-2 mr-auto">
        <a href="<?=base_url() . 'payroll/adrequest'?>" class="btn btn-primary btn-block"><i
                class="fa fa-arrow-left"></i> Back</a>
    </div>
</div>

<div class="card shadow-sm mb-3">
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <table id="export-table" class="table table-striped table-hover dt-responsive" style="width:100%">
                    <thead>
                        <tr>
                            <th>Employeement Number</th>
                            <th>Fullname</th>
                            <th>Allowance</th>
                            <th>Deductions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
foreach ($employees as $emp) {
    ?>
                        <tr>
                            <td><?=$emp['emp_number'];?></td>
                            <td><?=$emp['fullname'];?></td>
                            <td>
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Allowance</th>
                                            <th>Amount</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
$allowances = $this->payroll->get_salary_allowances($emp['emp_id']);
    foreach ($allowances as $allowance) {
        ?>
                                        <tr>
                                            <td><?=$allowance['allowance_label'];?></td>
                                            <td><?=_format_money($this, $allowance['allowance_value'], true);?></td>
                                            <td>
                                                <label class="switch">
                                                    <input type="checkbox"
                                                        <?=($allowance['allowance_status'] == 1) ? 'checked' : ''?>
                                                        onclick="changeAllowanceStatus(<?=$branch_id . ',' . $allowance['allowance_id']?>)">
                                                    <span class="slider"></span>
                                                </label>
                                                <a href="#" class="btn btn-danger btn-xs float-right" role="button" data-toggle="modal"
                                                    data-target="#deleteAllowanceModal_<?=$allowance['allowance_id']?>"><i
                                                        class="fa fa-times"></i>
                                                </a>

                                                <!-- Modal -->
                                                <div class="modal fade"
                                                    id="deleteAllowanceModal_<?=$allowance['allowance_id']?>"
                                                    tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLabel">Delete
                                                                    Allowance
                                                                    for
                                                                    <?=$emp['fullname'];?></h5>
                                                                <button type="button" class="close" data-dismiss="modal"
                                                                    aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form method="POST"
                                                                    action="<?=base_url() . 'payroll/delete_allowance';?>">
                                                                    <input type="hidden" name="emp_id"
                                                                        value="<?=$emp['emp_id'];?>" />
                                                                    <input type="hidden" name="branch_id"
                                                                        value="<?=$branch_id;?>" />
                                                                    <input type="hidden" name="allowance_id"
                                                                        value="<?=$allowance['allowance_id'];?>" />
                                                                    <div class="row">
                                                                        <div class="col-md-12">
                                                                            <h4>Are you sure to delete this allowance?
                                                                            </h4>
                                                                        </div>

                                                                    </div>

                                                                    <button type="submit"
                                                                        class="btn btn-danger btn-md float-right"><i
                                                                            class="fa fa-trash mr-1"></i>Yes, I
                                                                        confirm</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php
}
    ?>
                                    </tbody>
                                </table>
                                <a href="#" class="btn btn-info" role="button" data-toggle="modal"
                                    data-target="#addAllowanceModal_<?=$emp['emp_id']?>"><i class="fa fa-plus mr-1"></i>
                                    Allowance</a>

                                <!-- Modal -->
                                <div class="modal fade" id="addAllowanceModal_<?=$emp['emp_id']?>" tabindex="-1"
                                    role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Allowance for
                                                    <?=$emp['fullname'];?></h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form method="POST" action="<?=base_url() . 'payroll/add_allowance';?>">
                                                    <input type="hidden" name="emp_id" value="<?=$emp['emp_id'];?>" />
                                                    <input type="hidden" name="branch_id" value="<?=$branch_id;?>" />
                                                    <div class="row">
                                                        <div class="form-group col-md-6">
                                                            <label for="allowance_label">Name / Title</label>
                                                            <input type="text" name="allowance_label"
                                                                class="form-control" required />
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <label for="allowance_value">Amount</label>
                                                            <input type="text" name="allowance_value"
                                                                class="form-control" required />
                                                        </div>
                                                    </div>

                                                    <button type="submit" class="btn btn-primary btn-md float-right"><i
                                                            class="fa fa-save mr-1"></i>Save</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Deduction</th>
                                            <th>Amount</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
$deductions = $this->payroll->get_salary_deductions($emp['emp_id']);
    foreach ($deductions as $deduction) {
        ?>
                                        <tr>
                                            <td><?=$deduction['deduction_label'];?></td>
                                            <td><?=_format_money($this, $deduction['deduction_value'], true);?></td>
                                            <td>

                                                <label class="switch">
                                                    <input type="checkbox"
                                                        <?=($deduction['deduction_status'] == 1) ? 'checked' : ''?>
                                                        onclick="changeDeductionStatus(<?=$branch_id . ',' . $deduction['deduction_id']?>)">
                                                    <span class="slider"></span>
                                                </label>
                                                <a href="#" class="btn btn-danger btn-xs float-right" role="button" data-toggle="modal"
                                                    data-target="#deleteDeductionModal_<?=$deduction['deduction_id']?>"><i
                                                        class="fa fa-times"></i>
                                                </a>

                                                <!-- Modal -->
                                                <div class="modal fade"
                                                    id="deleteDeductionModal_<?=$deduction['deduction_id']?>"
                                                    tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLabel">Delete
                                                                    Deduction
                                                                    for
                                                                    <?=$emp['fullname'];?></h5>
                                                                <button type="button" class="close" data-dismiss="modal"
                                                                    aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form method="POST"
                                                                    action="<?=base_url() . 'payroll/delete_deduction';?>">
                                                                    <input type="hidden" name="emp_id"
                                                                        value="<?=$emp['emp_id'];?>" />
                                                                    <input type="hidden" name="branch_id"
                                                                        value="<?=$branch_id;?>" />
                                                                    <input type="hidden" name="deduction_id"
                                                                        value="<?=$deduction['deduction_id'];?>" />
                                                                    <div class="row">
                                                                        <div class="col-md-12">
                                                                            <h4>Are you sure to delete this deduction?
                                                                            </h4>
                                                                        </div>

                                                                    </div>

                                                                    <button type="submit"
                                                                        class="btn btn-danger btn-md float-right"><i
                                                                            class="fa fa-trash mr-1"></i>Yes, I
                                                                        confirm</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php
}
    ?>
                                    </tbody>
                                </table>
                                <a href="#" class="btn btn-info" role="button" data-toggle="modal"
                                    data-target="#addDeductionModal_<?=$emp['emp_id']?>"><i class="fa fa-plus mr-1">
                                        Deduction</i></a>

                                <!-- Modal -->
                                <div class="modal fade" id="addDeductionModal_<?=$emp['emp_id']?>" tabindex="-1"
                                    role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Deduction for
                                                    <?=$emp['fullname'];?></h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form method="POST" action="<?=base_url() . 'payroll/add_deduction';?>">
                                                    <input type="hidden" name="emp_id" value="<?=$emp['emp_id'];?>" />
                                                    <input type="hidden" name="branch_id" value="<?=$branch_id;?>" />
                                                    <div class="row">
                                                        <div class="form-group col-md-6">
                                                            <label for="deduction_label">Name / Title</label>
                                                            <input type="text" name="deduction_label"
                                                                class="form-control" required />
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <label for="deduction_value">Amount</label>
                                                            <input type="text" name="deduction_value"
                                                                class="form-control" required />
                                                        </div>
                                                    </div>

                                                    <button type="submit" class="btn btn-primary btn-md float-right"><i
                                                            class="fa fa-save mr-1"></i>Save</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
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
    </div>
</div>