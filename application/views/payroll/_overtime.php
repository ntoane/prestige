<!-- Breadcrumbs-->
<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="<?=base_url() . 'payroll';?>">Payroll</a>
    </li>
    <li class="breadcrumb-item active">Overtime</li>
</ol>

<div class="row mb-3">
    <div class="col-md-10">
        <h5><strong>Branch: </strong><?=$branch;?></h5>
        <h5><strong>Pay Month: </strong><?=$pay_month;?></h5>
    </div>
    <div class="col-md-2 mr-auto">
        <a href="<?=base_url() . 'payroll/overtime_request'?>" class="btn btn-primary btn-block"><i
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
                            <th>Overtime</th>
                            <th>Sunday Pay</th>
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
                                            <th>Number of Days</th>
                                            <th>Amount</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
$overtimes = $this->payroll->get_overtimes($emp['emp_id'], $pay_month);
    foreach ($overtimes as $overtime) {
        ?>
                                        <tr>
                                            <td><?=$overtime['num_days'];?></td>
                                            <td><?=_format_money($this, $overtime['amount'], true);?></td>
                                            <td>
                                                <a href="#" class="btn btn-danger" role="button" data-toggle="modal"
                                                    data-target="#deleteAllowanceModal_<?=$overtime['overtime_id']?>"><i
                                                        class="fa fa-times"></i></a>

                                                <!-- Modal -->
                                                <div class="modal fade"
                                                    id="deleteAllowanceModal_<?=$overtime['overtime_id']?>"
                                                    tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLabel">Delete
                                                                    Overtime
                                                                    for
                                                                    <?=$emp['fullname'];?></h5>
                                                                <button type="button" class="close" data-dismiss="modal"
                                                                    aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form method="POST"
                                                                    action="<?=base_url() . 'payroll/delete_overtime';?>">
                                                                    <input type="hidden" name="emp_id"
                                                                        value="<?=$emp['emp_id'];?>" />
                                                                    <input type="hidden" name="pay_month"
                                                                        value="<?=$pay_month;?>" />
                                                                    <input type="hidden" name="branch_id"
                                                                        value="<?=$branch_id;?>" />
                                                                    <input type="hidden" name="overtime_id"
                                                                        value="<?=$overtime['overtime_id'];?>" />
                                                                    <div class="row">
                                                                        <div class="col-md-12">
                                                                            <h4>Are you sure to delete this overtime?
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
                                    Overtime</a>

                                <!-- Modal -->
                                <div class="modal fade" id="addAllowanceModal_<?=$emp['emp_id']?>" tabindex="-1"
                                    role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Overtime for
                                                    <?=$emp['fullname'];?></h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form method="POST" action="<?=base_url() . 'payroll/add_overtime';?>">
                                                    <input type="hidden" name="emp_id" value="<?=$emp['emp_id'];?>" />
                                                    <input type="hidden" name="pay_month" value="<?=$pay_month;?>" />
                                                    <input type="hidden" name="branch_id" value="<?=$branch_id;?>" />
                                                    <div class="row">
                                                        <div class="form-group col-md-12">
                                                            <label for="allowance_label">Number of Days</label>
                                                            <input type="number" name="num_days" class="form-control"
                                                               value="1" required />
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
                                            <th>Number of Sundays</th>
                                            <th>Amount</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
$sundaypays = $this->payroll->get_sundaypays($emp['emp_id'], $pay_month);
    foreach ($sundaypays as $sunday) {
        ?>
                                        <tr>
                                            <td><?=$sunday['num_days'];?></td>
                                            <td><?=_format_money($this, $sunday['amount'], true);?></td>
                                            <td>
                                                <a href="#" class="btn btn-danger" role="button" data-toggle="modal"
                                                    data-target="#deleteSundayPay_<?=$sunday['overtime_id']?>"><i
                                                        class="fa fa-times"></i></a>

                                                <!-- Modal -->
                                                <div class="modal fade"
                                                    id="deleteSundayPay_<?=$sunday['overtime_id']?>"
                                                    tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLabel">Delete
                                                                    Sunday Pay for
                                                                    <?=$emp['fullname'];?></h5>
                                                                <button type="button" class="close" data-dismiss="modal"
                                                                    aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form method="POST"
                                                                    action="<?=base_url() . 'payroll/delete_sundaypay';?>">
                                                                    <input type="hidden" name="emp_id"
                                                                        value="<?=$emp['emp_id'];?>" />
                                                                    <input type="hidden" name="pay_month"
                                                                        value="<?=$pay_month;?>" />
                                                                    <input type="hidden" name="branch_id"
                                                                        value="<?=$branch_id;?>" />
                                                                    <input type="hidden" name="overtime_id"
                                                                        value="<?=$sunday['overtime_id'];?>" />
                                                                    <div class="row">
                                                                        <div class="col-md-12">
                                                                            <h4>Are you sure to delete this Sunday Pay?
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
                                    data-target="#addSundayPay_<?=$emp['emp_id']?>"><i class="fa fa-plus mr-1"></i>
                                    SundayPay</a>

                                <!-- Modal -->
                                <div class="modal fade" id="addSundayPay_<?=$emp['emp_id']?>" tabindex="-1"
                                    role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Sunday Pay for
                                                    <?=$emp['fullname'];?></h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form method="POST" action="<?=base_url() . 'payroll/add_sundaypay';?>">
                                                    <input type="hidden" name="emp_id" value="<?=$emp['emp_id'];?>" />
                                                    <input type="hidden" name="pay_month" value="<?=$pay_month;?>" />
                                                    <input type="hidden" name="branch_id" value="<?=$branch_id;?>" />
                                                    <div class="row">
                                                        <div class="form-group col-md-12">
                                                            <label for="allowance_label">Number of Days</label>
                                                            <input type="number" name="num_days" class="form-control"
                                                                value="1" required />
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