<!-- Breadcrumbs-->
<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="<?=base_url() . 'users';?>">Payroll</a>
    </li>
    <li class="breadcrumb-item active">Salary List</li>
</ol>

<!-- Page Content -->
<div class="card shadow-sm mb-5">
    <div class="card-body">
        <table id="data-table" class="table table-striped table-hover dt-responsive" style="width:100%">
            <thead>
                <tr>
                    <th>Employee Number</th>
                    <th>Names</th>
                    <th>Designation</th>
                    <th>Base Salary</th>
                    <th>Change Salary</th>
                </tr>
            </thead>
            <tbody>
                <?php
foreach ($salary_list as $salary) {
    ?>
                <tr>
                    <td><?=$salary['emp_number'];?></td>
                    <td><?=$salary['fullname'];?></td>
                    <td><?=$salary['position_name'];?></td>
                    <td><?=_format_money($this, $salary['base_salary'], true);?> </td>
                    <td>
                        <a href="#" class="btn btn-primary btn-sm" data-toggle="modal"
                            data-target="#updateSalaryModal_<?=$salary['emp_id']?>"><i class="fa fa-refresh"></i> Update
                            Salary</a>
                        <!-- Modal -->
                        <div class="modal fade" id="updateSalaryModal_<?=$salary['emp_id']?>" tabindex="-1"
                            role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Update Base Salary for
                                            <?=$salary['fullname'];?></h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form method="POST" action="<?=base_url() . 'payroll/update_base_salary';?>">
                                            <input type="hidden" name="emp_id" value="<?=$salary['emp_id'];?>" />
                                            <div class="form-group">
                                                <label for="base_salary"><strong>New Base Salary</strong></label>
                                                <input type="number" class="form-control" name="base_salary"
                                                    value="<?=$salary['base_salary'];?>" />
                                            </div>
                                            <button type="submit" class="btn btn-primary btn-md">Update</button>
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