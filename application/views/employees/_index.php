<!-- Breadcrumbs-->
<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="<?=base_url() . 'employees';?>">Employees</a>
    </li>
    <li class="breadcrumb-item active">All Employees</li>
</ol>

<!-- Page Content -->
<div class="card shadow-sm mb-5">
    <div class="card-body">
        <div class="row mb-5">
            <div class="col-md-12">
                <ul class="nav nav-justified border-bottom tabs" id="nav-tab">
                    <li class="nav-item border-right">
                        <a class="nav-link <?=$active == 1 ? 'active' : '';?> tab-link"
                            href="<?=base_url() . 'employees/1';?>"><i class="fa fa-users"></i> <br /> Sales
                            Advisors</a>
                    </li>
                    <li class="nav-item border-right">
                        <a class="nav-link <?=$active == 2 ? 'active' : '';?> tab-link"
                            href="<?=base_url() . 'employees/2';?>"><i class="fa fa-users"></i> <br /> Sales
                            Supervisors</a>
                    </li>
                    <li class="nav-item border-right">
                        <a class="nav-link <?=$active == 3 ? 'active' : '';?> tab-link"
                            href="<?=base_url() . 'employees/3';?>"><i class="fa fa-users"></i> <br /> Sales
                            Managers</a>
                    </li>
                    <li class="nav-item border-right">
                        <a class="nav-link <?=$active == 4 ? 'active' : '';?> tab-link"
                            href="<?=base_url() . 'employees/4';?>"><i class="fa fa-user-secret"></i> <br /> Other
                            Designations</a>
                    </li>
                    <li class="nav-item border-right">
                        <a class="nav-link <?=$active == 5 ? 'active' : '';?> tab-link"
                            href="<?=base_url() . 'employees/5';?>"><i class="fa fa-user-secret"></i> <br /> In
                            active</a>
                    </li>
                    <!-- <li class="nav-item">
                        <a class="nav-link" href="<?=base_url() . 'employees/create';?>"><i class="fa fa-user-plus"></i> <br /> New Employee</a>
                    </li> -->
                </ul>

            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade <?=$active == 1 ? 'show active' : '';?>" id="consultants">
                        <div class="text-right mb-2" style="margin-top: -25px;">
                            <a class="btn btn-success btn-sm" href="<?=base_url() . 'employees/create_consultant';?>"><i
                                    class="fa fa-user-plus"></i> New Sales Advisor</a>
                        </div>
                        <table id="data-table" class="table table-striped table-hover dt-responsive" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Employment #</th>
                                    <th>Name</th>
                                    <th>Designation</th>
                                    <th>Branch</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
foreach ($allconsultants as $consultant) {
    ?>
                                <tr>
                                    <td>
                                        <?=$consultant['emp_number']?>
                                    </td>
                                    <!--<td><?=$consultant['national_id'];?></td>-->
                                    <td><?=$consultant['fullname'];?></td>
                                    <td>
                                        <?=$consultant['position_name']?>
                                    </td>
                                    <td>
                                        <?php
$branch = $this->employees->get_row("SELECT branch_name FROM tbl_branches WHERE branch_id = " . $consultant['branch_id']);
    echo $branch->branch_name;
    ?>
                                    </td>

                                    <td>
                                        <div class="btn-group">
                                            <a href="<?=base_url() . 'employees/edit_consultant/' . $consultant['emp_id'];?>"
                                                class="btn btn-primary btn-sm" data-toggle="tooltip"
                                                data-placement="top" title="Edit Employee"><i
                                                    class="fa fa-edit"></i></a>
                                            <a href="<?=base_url() . 'employees/delete/' . $consultant['emp_id'];?>"
                                                class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top"
                                                title="Delete Employee"><i class="fa fa-trash"></i></a>
                                        </div>
                                    </td>
                                </tr>
                                <?php
}
?>
                            </tbody>
                        </table>
                    </div>
                    <div class="tab-pane fade <?=$active == 2 ? 'show active' : '';?>" id="supervisors">
                        <div class="text-right mb-2" style="margin-top: -25px;">
                            <a class="btn btn-success btn-sm" href="<?=base_url() . 'employees/create/2';?>"><i
                                    class="fa fa-user-plus"></i> New Supervisor</a>
                        </div>
                        <table id="data-table-supervisor" class="table table-striped table-hover dt-responsive"
                            style="width:100%">
                            <thead>
                                <tr>
                                    <th>Employment #</th>
                                    <!--<th>ID/Passport</th> -->
                                    <th>Name</th>
                                    <th>Designation</th>
                                    <th>Branch</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
foreach ($allsupervisors as $supervisor) {
    ?>
                                <tr>
                                    <td>
                                        <?=$supervisor['emp_number']?>
                                    </td>
                                    <td><?=$supervisor['fullname'];?></td>
                                    <td>
                                        <?=$supervisor['position_name'];?>
                                    </td>
                                    <td>
                                        <?php
$branch = $this->employees->get_row("SELECT branch_name FROM tbl_branches WHERE branch_id = " . $supervisor['branch_id']);
    echo $branch->branch_name;
    ?>
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="<?=base_url() . 'employees/edit/' . $supervisor['emp_id']. '/2';?>"
                                                class="btn btn-primary btn-sm" data-toggle="tooltip"
                                                data-placement="top" title="Edit Employee"><i
                                                    class="fa fa-edit"></i></a>
                                            <a href="<?=base_url() . 'employees/delete/' . $supervisor['emp_id']. '/2';?>"
                                                class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top"
                                                title="Delete Employee"><i class="fa fa-trash"></i></a>
                                        </div>
                                    </td>
                                </tr>
                                <?php
}
?>
                            </tbody>
                        </table>
                    </div>
                    <div class="tab-pane fade <?=$active == 3 ? 'show active' : '';?>" id="managers">
                        <div class="text-right mb-2" style="margin-top: -25px;">
                            <a class="btn btn-success btn-sm" href="<?=base_url() . 'employees/create/3';?>"><i
                                    class="fa fa-user-plus"></i> New Manager</a>
                        </div>
                        <table id="data-table-manager" class="table table-striped table-hover dt-responsive"
                            style="width:100%">
                            <thead>
                                <tr>
                                    <th>Employment #</th>
                                    <!--<th>ID/Passport</th>-->
                                    <th>Name</th>
                                    <th>Designation</th>
                                    <th>Branch</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
foreach ($allmanagers as $manager) {
    ?>
                                <tr>
                                    <td><?=$manager['emp_number']?></td>
                                    <td><?=$manager['fullname'];?></td>
                                    <td>
                                        <?=$manager['position_name'];?>
                                    </td>
                                    <td>
                                        <?php
$branch = $this->employees->get_row("SELECT branch_name FROM tbl_branches WHERE branch_id = " . $manager['branch_id']);
    echo $branch->branch_name;
    ?>
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="<?=base_url() . 'employees/edit/' . $manager['emp_id']. '/3';?>"
                                                class="btn btn-primary btn-sm" data-toggle="tooltip"
                                                data-placement="top" title="Edit Employee"><i
                                                    class="fa fa-edit"></i></a>
                                            <a href="<?=base_url() . 'employees/delete/' . $manager['emp_id']. '/3';?>"
                                                class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top"
                                                title="Delete Employee"><i class="fa fa-trash"></i></a>
                                        </div>
                                    </td>
                                </tr>
                                <?php
}
?>
                            </tbody>
                        </table>
                    </div>
                    <div class="tab-pane fade <?=$active == 4 ? 'show active' : '';?>" id="others">
                        <div class="text-right mb-2" style="margin-top: -25px;">
                            <a class="btn btn-success btn-sm" href="<?=base_url() . 'employees/create/4';?>"><i
                                    class="fa fa-user-plus"></i> New Employee</a>
                        </div>
                        <table id="data-table-other" class="table table-striped table-hover dt-responsive"
                            style="width:100%">
                            <thead>
                                <tr>
                                    <th>Employment #</th>
                                    <!--<th>ID/Passport</th>-->
                                    <th>Name</th>
                                    <th>Designation</th>
                                    <th>Branch</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
foreach ($allothers as $other) {
    ?>
                                <tr>
                                    <td>
                                        <?=$other['emp_number']?>
                                    </td>
                                    <td><?=$other['fullname'];?></td>
                                    <td>
                                        <?=$other['position_name'];?>
                                    </td>
                                    <td>
                                        <?php
$branch = $this->employees->get_row("SELECT branch_name FROM tbl_branches WHERE branch_id = " . $other['branch_id']);
    echo $branch->branch_name;
    ?>
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="<?=base_url() . 'employees/edit/' . $other['emp_id'] . '/4';?>"
                                                class="btn btn-primary btn-sm" data-toggle="tooltip"
                                                data-placement="top" title="Edit Employee"><i
                                                    class="fa fa-edit"></i></a>
                                            <a href="<?=base_url() . 'employees/delete/' . $other['emp_id'] . '/4';?>"
                                                class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top"
                                                title="Delete Employee"><i class="fa fa-trash"></i></a>
                                        </div>
                                    </td>
                                </tr>
                                <?php
}
?>
                            </tbody>
                        </table>
                    </div>
                    <div class="tab-pane fade <?=$active == 5 ? 'show active' : '';?>" id="inactive">
                        <table id="data-table-inactive" class="table table-striped table-hover dt-responsive"
                            style="width:100%">
                            <thead>
                                <tr>
                                    <th>Employment #</th>
                                    <th>Name</th>
                                    <th>Designation</th>
                                    <th>Branch</th>
                                    <th>Reason</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
foreach ($allinactive as $inactive) {
    ?>
                                <tr>
                                    <td>
                                        <?=$inactive['emp_number']?>
                                    </td>
                                    <td><?=$inactive['fullname'];?></td>
                                    <td>
                                        <?=$inactive['position_name'];?>
                                    </td>
                                    <td>
                                        <?php
$branch = $this->employees->get_row("SELECT branch_name FROM tbl_branches WHERE branch_id = " . $inactive['branch_id']);
    echo $branch->branch_name;
    ?>
                                    </td>
                                    <td>
                                        <?=$inactive['inactive_reason'];?>
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="<?=base_url() . 'employees/edit/' . $inactive['emp_id']. '/5';?>"
                                                class="btn btn-primary btn-sm" data-toggle="tooltip"
                                                data-placement="top" title="Activate Employee">Activate
                                            </a>
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
    </div>
</div>