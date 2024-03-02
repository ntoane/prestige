<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Payroll System</title>

    <!-- Custom fonts for this template-->
    <link href="<?=base_url();?>assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="<?=base_url();?>assets/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <!-- Page level plugin CSS-->
    <link href="<?=base_url();?>assets/vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">
    <link href="<?=base_url();?>assets/vendor/sweetalert/sweetalert.css" rel="stylesheet" type="text/css" />
    <link href="<?=base_url();?>assets/vendor/fullcalendar/css/fullcalendar.min.css" rel="stylesheet" type="text/css" />
    <!-- Custom styles for this template-->
    <link href="<?=base_url();?>assets/css/sb-admin.css" rel="stylesheet">

    <!--<link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" />-->
    <link href="<?php echo base_url(); ?>assets/vendor/gijgo-combined-1.9.13/css/gijgo.min.css" rel="stylesheet"
        type="text/css" />
    <link href="<?php echo base_url(); ?>assets/vendor/bootstrap-select/select.css" rel="stylesheet" type="text/css" />
    <!--Data Table export files-->
    <link href="<?=base_url();?>assets/vendor/datatables/export/jquery.dataTables.min.css" rel="stylesheet">
    <link href="<?=base_url();?>assets/vendor/datatables/export/buttons.dataTables.min.css" rel="stylesheet">

    <script src="<?php echo base_url(); ?>assets/js/angular.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>app/app.js" type="text/javascript"></script>

    <style>
    .navbar {
        background-color: #f1592a;
        color: #ffffff;
        /*box-shadow: 0 0 15px 15px green;*/
        height: 70px;
    }

    .sidebar {
        background-color: #ffffff;
    }

    .sidebar .nav-item {
        border-bottom: 1px solid #f1592a;
    }

    .sidebar .nav-item .nav-link {
        color: #f1592a;
    }

    .sidebar .nav-item .nav-link:hover {
        color: #485683;
    }

    .sidebar .nav-item .active {
        color: #485683;
        border-left: 5px solid #485683;
    }

    .sidebar .dropdown-toggle:focus {
        background-color: rgba(0, 0, 0, 0.2);
    }

    .breadcrumb {
        border-radius: 0px;
        background-color: #f9fbe7;
        border-left: 2px solid #485683;
    }

    .card {
        border-radius: 0px;
        border-top: 3px solid #485683;
    }

    .tabs .nav-item .nav-link {
        color: #f1592a;
    }

    .tabs .nav-item .nav-link:hover {
        color: #485683;
    }

    .tabs .nav-item .active {
        color: #485683;
        border-bottom: 2px solid #485683;
    }

    @media print {
        .noprint {
            display: none;
        }

        .break-page {
            page-break-after: always;
        }
    }

    .clock {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translateX(-50%) translateY(-50%);
        color: #ffffff;
        font-size: 20px;
        font-family: Orbitron;
        letter-spacing: 7px;
    }

    .watermark {
        /* width: 300px;
  height: 100px; */
        display: block;
        position: relative;
    }

    .watermark::after {
        content: "";
        background: url('<?=base_url();?>assets/images/logo.jpeg');
        background-repeat: repeat;
        /* background-attachment: fixed;
        background-position: center;
        background-size: cover; */
        opacity: 0.1;
        top: 0;
        left: 0;
        bottom: 0;
        right: 0;
        position: absolute;
        z-index: -1;
    }

    .btn-primary {
        background-color: #485683;
        border: 1px solid #485683;
    }
    </style>
</head>

<body id="page-top" ng-app="app">

    <nav class="navbar navbar-expand static-top">

        <a class="navbar-brand mr-1 text-white" href="<?=base_url();?>">
            Payroll System
        </a>

        <button class="btn btn-link btn-sm text-white order-1 order-sm-0" id="sidebarToggle" href="#">
            <i class="fa fa-bars"></i>
        </button>

        <!-- Navbar Search -->
        <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">

        </form>

        <!-- Navbar -->
        <ul class="navbar-nav ml-auto ml-md-0">
            <li class="nav-item">
                <div id="MyClockDisplay" class="clock" onload="showTime()"></div>
            </li>
            <li class="nav-item dropdown no-arrow">
                <a class="nav-link dropdown-toggle text-white" href="#" id="userDropdown" role="button"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-user-circle fa-fw"></i> <?=_get_current_fullname($this);?>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#passwordModal">Change
                        Password</a>
                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#activityModal">Activity Log</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">Logout</a>
                </div>
            </li>
        </ul>

    </nav>

    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="sidebar navbar-nav border-right noprint">
            <img src="<?=base_url();?>assets/images/logo.jpeg" alt="" class="p-2" />
            <li class="nav-item">
                <a class="nav-link <?=($this->uri->segment(1) == 'dashboard') ? ' active' : '';?>"
                    href="<?php echo base_url(); ?>dashboard">
                    <i class="fa fa-fw fa-dashboard"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <?php
if (_get_user_type_access1($this, _get_current_user_type_id($this), 'commission', '*')) {
    ?>
            <li class="nav-item dropdown">
                <a class="nav-link <?=($this->uri->segment(1) == 'commission') ? ' active' : '';?>"
                    href="<?=base_url() . 'commission'?>" role="button">
                    <i class="fas fa-money-bill-alt"></i>
                    <span>Commission</span>
                </a>
            </li>

            <?php }?>
            <?php
if (_get_user_type_access1($this, _get_current_user_type_id($this), 'loan', '*')) {
    ?>
            <li class="nav-item dropdown">
                <a class="nav-link <?=($this->uri->segment(1) == 'loan') ? ' active' : '';?>"
                    href="<?=base_url() . 'loan'?>" role="button">
                    <i class="fas fa-landmark"></i>
                    <span>Scheduled Trans</span>
                </a>
            </li>
            <?php }?>
            <?php
if (_get_user_type_access1($this, _get_current_user_type_id($this), 'payroll', '*')) {
    ?>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle <?=($this->uri->segment(1) == 'payroll') || ($this->uri->segment(1) == 'provident') ? ' active' : '';?>"
                    href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false">
                    <i class="fas fa-dollar-sign"></i>
                    <span>Payroll</span>
                </a>
                <div class="dropdown-menu" aria-labelledby="pagesDropdown">
                    <h6 class="dropdown-itemr">Manage Salary</h6>
                    <a class="dropdown-item" href="<?=base_url() . 'payroll/adrequest';?>">Allowances <br />&
                        Deductions</a>
                    <a class="dropdown-item" href="<?=base_url() . 'payroll/overtime_request';?>">Overtime</a>
                    <a class="dropdown-item" href="<?php echo base_url() . 'payroll/salary_list'; ?>">Salary List</a>
                    <a class="dropdown-item" href="<?php echo base_url() . 'payroll/make_payment'; ?>">Make Payment</a>
                    <a class="dropdown-item" href="<?php echo base_url() . 'payroll/approve_payroll_request' ?>">Approve
                        Payment</a>
                    <a class="dropdown-item" href="<?php echo base_url() . 'payroll/bank_csv' ?>">Salaries File</a>
                    <a class="dropdown-item" href=" <?php echo base_url() . 'payroll/salary_payment_file'; ?>">Payment
                        History</a>
                    <a class="dropdown-item" href=" <?php echo base_url() . 'payroll/payroll_activities'; ?>">Payroll
                        Activities</a>
                    <a class="dropdown-item" href=" <?php echo base_url() . 'payroll/generate_payslip'; ?>">Generate
                        Payslip</a>

                    <h6 class="dropdown-itemr">Reports</h6>
                    <a class="dropdown-item" href="<?=base_url() . 'payroll/report_paye';?>">PAYE</a>
                    <?php
if (_get_user_type_access1($this, _get_current_user_type_id($this), 'provident', '*')) {
        ?>
                    <a class="dropdown-item" href="<?=base_url() . 'provident/short_term';?>">Short Term</a>
                    <a class="dropdown-item" href="<?=base_url() . 'provident/long_term';?>">Long Term</a>
                    <h6 class="dropdown-itemr">Short Term Payments</h6>
                    <a class="dropdown-item" href="<?=base_url() . 'provident/make_short_term_payment';?>">Pay Short
                        Term</a>
                    <a class="dropdown-item" href="<?=base_url() . 'provident/approve_short_term_payment';?>">Approve
                        Payment</a>
                    <a class="dropdown-item" href="<?=base_url() . 'provident/st_bank_csv';?>">Short Term
                        File</a>
                    <?php }?>
                </div>
            </li>
            <?php }?>
            <?php
if (_get_user_type_access1($this, _get_current_user_type_id($this), 'employees', '*')) {
    ?>
            <li class="nav-item dropdown">
                <a class="nav-link <?=($this->uri->segment(1) == 'employees') ? ' active' : '';?>"
                    href="<?=base_url() . 'employees'?>" role="button">
                    <i class="fas fa-user-plus"></i>
                    <span>Employees</span>
                </a>
            </li>
            <?php }?>
            <?php
if (_get_user_type_access1($this, _get_current_user_type_id($this), 'users', '*')) {
    ?>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle <?=($this->uri->segment(1) == 'users') ? ' active' : '';?>" href="#"
                    id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-fw fa-users"></i>
                    <span>System Users</span>
                </a>
                <div class="dropdown-menu" aria-labelledby="pagesDropdown">
                    <a class="dropdown-item" href="<?=base_url() . 'users';?>">Users List</a>
                    <a class="dropdown-item" href="<?=base_url() . 'users/create';?>">New User</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="<?=base_url() . 'users/activities';?>">User Activities</a>
                </div>
            </li>
            <?php }?>
            <?php
if (_get_user_type_access1($this, _get_current_user_type_id($this), 'branches', '*')) {
    ?>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle <?=($this->uri->segment(1) == 'branches') ? ' active' : '';?>"
                    href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false">
                    <i class="fas fa-city"></i>
                    <span>Branches</span>
                </a>
                <div class="dropdown-menu" aria-labelledby="pagesDropdown">
                    <a class="dropdown-item" href="<?=base_url() . 'branches';?>">Branches List</a>
                    <a class="dropdown-item" href="<?=base_url() . 'branches/create';?>">New Branch</a>
                </div>
            </li>
            <?php }?>

            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle <?=(($this->uri->segment(1) == 'designations') ||
    ($this->uri->segment(1) == 'user_access')) ? ' active' : '';?>" href="#" id="pagesDropdown" role="button"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-cogs"></i>
                    <span>Settings</span>
                </a>
                <div class="dropdown-menu" aria-labelledby="pagesDropdown">
                    <?php
if (_get_user_type_access1($this, _get_current_user_type_id($this), 'designations', '*')) {
    ?>
                    <h6 class="dropdown-header">Designations</h6>
                    <a class="dropdown-item" href="<?=base_url() . 'designations';?>">Designations List</a>
                    <a class="dropdown-item" href="<?=base_url() . 'designations/create';?>">New Designation</a>
                    <?php }?>
                    <?php
if (_get_user_type_access1($this, _get_current_user_type_id($this), 'user_access', '*')) {
    ?>
                    <h6 class="dropdown-header">User Roles</h6>
                    <a class="dropdown-item" href="<?=base_url() . 'user_access/load_roles';?>">User Roles List</a>
                    <a class="dropdown-item" href="<?=base_url() . 'user_access/create_role';?>">New User Role</a>
                    <a class="dropdown-item" href="<?=base_url() . 'user_access';?>">User Role Access</a>
                    <?php }?>
                </div>
            </li>
        </ul>

        <div id="content-wrapper">

            <div class="container-fluid">

                <?php
$this->load->view($view);
?>

            </div>
            <!-- /.container-fluid -->

            <!-- Sticky Footer -->
            <footer class="sticky-footer">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto noprint">
                        <span>Copyright &copy; <script>
                            document.write(new Date().getFullYear());
                            </script>. Prestige Furnitures Lesotho</span>
                    </div>
                </div>
            </footer>

        </div>
        <!-- /.content-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fa fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="<?=base_url() . 'login/logout';?>">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- password Modal-->
    <div class="modal fade" id="passwordModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Change Password</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="<?=base_url() . 'users/change_password';?>" method="POST">
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="password"><strong>Old Password</strong></label>
                                <input type="password" name="password" class="form-control" required />
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="new_password"><strong>New Password</strong></label>
                                <input type="password" name="new_password" class="form-control" required />
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="confirm_password"><strong>Confirm Password</strong></label>
                                <input type="password" name="confirm_password" class="form-control" required />
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-5">
                                <button type="submit" class="btn btn-success">Change Password</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Logout Modal-->
    <div class="modal fade" id="activityModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Your Activity Log</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table id="activity-table" class="table table-striped table-hover dt-responsive" style="width:100%">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
$activities = $this->users->get_array("SELECT * FROM tbl_user_activities WHERE user_id = " . _get_current_user_id($this) . " ORDER BY activity_id DESC");
foreach ($activities as $activity) {
    ?>
                            <tr>
                                <td><?=$activity['activity_title'];?></td>
                                <td><?=$activity['activity_description'];?></td>
                                <td><?=$activity['created'];?></td>
                            </tr>
                            <?php
}
?>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="<?=base_url();?>assets/vendor/jquery/jquery.min.js"></script>
    <script src="<?=base_url();?>assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="<?=base_url();?>assets/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Page level plugin JavaScript-->
    <script src="<?=base_url();?>assets/vendor/datatables/jquery.dataTables.js"></script>
    <script src="<?=base_url();?>assets/vendor/datatables/dataTables.bootstrap4.js"></script>

    <!-- Data table export plugin-->
    <script src="<?php echo base_url(); ?>assets/vendor/datatables/export/dataTables.buttons.min.js"
        type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/vendor/datatables/export/jszip.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/vendor/datatables/export/pdfmake.min.js" type="text/javascript">
    </script>
    <script src="<?php echo base_url(); ?>assets/vendor/datatables/export/vfs_fonts.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/vendor/datatables/export/buttons.html5.min.js" type="text/javascript">
    </script>
    <script src="<?php echo base_url(); ?>assets/js/demo/datatables-demo.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="<?=base_url();?>assets/js/sb-admin.min.js"></script>
    <script src="<?=base_url();?>assets/js/main.js"></script>

    <script type="text/javascript">
    $(document).ready(function() {
        $('#data-table').DataTable({
            "lengthMenu": [
                [5, 10, 15, 20, -1],
                [5, 10, 15, 20, "All"]
            ],
            "pageLength": 10,
            "ordering": true
        });
        $('#data-table-supervisor').DataTable({
            "lengthMenu": [
                [5, 10, 15, 20, -1],
                [5, 10, 15, 20, "All"]
            ],
            "pageLength": 10,
            "ordering": true
        });
        $('#data-table-manager').DataTable({
            "lengthMenu": [
                [5, 10, 15, 20, -1],
                [5, 10, 15, 20, "All"]
            ],
            "pageLength": 10,
            "ordering": true
        });
        $('#data-table-other').DataTable({
            "lengthMenu": [
                [5, 10, 15, 20, -1],
                [5, 10, 15, 20, "All"]
            ],
            "pageLength": 10,
            "ordering": true
        });
        $('#data-table-inactive').DataTable({
            "lengthMenu": [
                [5, 10, 15, 20, -1],
                [5, 10, 15, 20, "All"]
            ],
            "pageLength": 10,
            "ordering": true
        });

        $('#activity-table').DataTable({
            "lengthMenu": [
                [1, 2, 3, 4],
                [1, 2, 3, 4]
            ],
            "pageLength": 2,
            "ordering": true
        });

        $('#export-table').DataTable({
            dom: 'Bfrtip',
            buttons: [{
                    extend: 'excelHtml5',
                    text: '<button class="btn btn-success btn-sm"><i class="fa fa-file-excel-o"></i></button>',
                    titleAttr: 'Export Data to Excel'
                },
                {
                    extend: 'csvHtml5',
                    text: '<button class="btn btn-primary btn-sm"><i class="fa fa-file-text-o"></i></button>',
                    titleAttr: 'Export Data to CSV'
                },
                {
                    extend: 'pdfHtml5',
                    text: '<button class="btn btn-danger btn-sm"><i class="fa fa-file-pdf-o"></i></button>',
                    titleAttr: 'Export Data to PDF'
                }
            ]
        });

        $('[data-toggle="popover"]').popover();
    });
    </script>
    <script src="<?=base_url();?>assets/vendor/sweetalert/sweetalert.min.js" type="text/javascript"></script>
    <?php
if ($this->session->flashdata('title') || $this->session->flashdata('text') || $this->session->flashdata('type')) {
    ?>
    <script>
    swal("<?=$this->session->flashdata('title');?>", "<?=$this->session->flashdata('text');?>",
        "<?=$this->session->flashdata('type');?>");
    </script>
    <?php
    // Clear the flashdata
    $this->session->set_flashdata('title', null);
    $this->session->set_flashdata('text', null);
    $this->session->set_flashdata('type', null);
}
?>
    <script src="<?=base_url();?>assets/vendor/fullcalendar/js/moment.min.js" type="text/javascript"></script>
    <script src="<?=base_url();?>assets/vendor/fullcalendar/js/fullcalendar.min.js" type="text/javascript"></script>
    <script src="<?=base_url();?>assets/js/calendar.js" type="text/javascript"></script>

    <script type='text/javascript'>
    function setCommissionMonth() {
        $branch_id = $('#branch_id').val();
        $commission_month = $('#commission_month').val();
        if (($branch_id == null) || ($branch_id == "") || ($commission_month == null) || (
                $commission_month == "")) {
            sweetAlert({
                title: "Cannot Proceed",
                text: "Select Branch and Commission Month",
                type: "error",
                timer: 3000
            });
        } else {
            window.location.href = "<?php echo base_url(); ?>commission/" + $branch_id + "/" + $commission_month;
        }
    }

    function setSupervisorCommissionMonth() {
        $branch_id = $('#branch_id').val();
        $commission_month = $('#commission_month').val();
        if (($branch_id == null) || ($branch_id == "") || ($commission_month == null) || (
                $commission_month == "")) {
            sweetAlert({
                title: "Cannot Proceed",
                text: "Select Branch and Commission Month",
                type: "error",
                timer: 3000
            });
        } else {
            window.location.href = "<?php echo base_url(); ?>commission/supervisor/" + $branch_id + "/" +
                $commission_month;
        }
    }

    function setManagerCommissionMonth() {
        $branch_id = $('#branch_id').val();
        $commission_month = $('#commission_month').val();
        if (($branch_id == null) || ($branch_id == "") || ($commission_month == null) || (
                $commission_month == "")) {
            sweetAlert({
                title: "Cannot Proceed",
                text: "Select Branch and Commission Month",
                type: "error",
                timer: 3000
            });
        } else {
            window.location.href = "<?php echo base_url(); ?>commission/manager/" + $branch_id + "/" +
                $commission_month;
        }
    }

    function setPaymentMonth() {
        $branch_id = $('#branch_id').val();
        $payment_month = $('#payment_month').val();
        if (($branch_id == null) || ($branch_id == "") || ($payment_month == null) || (
                $payment_month == "")) {
            sweetAlert({
                title: "Cannot Proceed",
                text: "Select Branch and Pay Month",
                type: "error",
                timer: 3000
            });
        } else {
            window.location.href = "<?php echo base_url(); ?>payroll/make_payment/" + $branch_id + "/" + $payment_month;
        }
    }

    function setPaymentMonthFile() {
        $branch_id = $('#branch_id').val();
        $payment_month = $('#payment_month').val();
        if (($branch_id == null) || ($branch_id == "") || ($payment_month == null) || ($payment_month == "")) {
            sweetAlert({
                title: "Cannot Proceed",
                text: "Select Branch and Pay Month",
                type: "error",
                timer: 3000
            });
        } else {
            window.location.href = "<?php echo base_url(); ?>payroll/salary_payment_file/" + $branch_id + "/" +
                $payment_month;
        }
    }

    function setGeneratePayslip() {
        $branch_id = $('#branch_id').val();
        $payment_month = $('#payment_month').val();
        if (($branch_id == null) || ($branch_id == "") || ($payment_month == null) || (
                $payment_month == "")) {
            sweetAlert({
                title: "Cannot Proceed",
                text: "Select Branch and Pay Month",
                type: "error",
                timer: 3000
            });
        } else {
            window.location.href = "<?php echo base_url(); ?>payroll/generate_payslip/" + $branch_id + "/" +
                $payment_month;
        }
    }

    function requestLongTerm() {
        $emp_id = $('#emp_id').val();
        if (($emp_id == null) || ($emp_id == "") || ($emp_id == 0)) {
            sweetAlert({
                title: "Cannot Proceed",
                text: "Select Employee Name",
                type: "error",
                timer: 3000
            });
        } else {
            window.location.href = "<?php echo base_url(); ?>provident/long_term/" + $emp_id;
        }
    }

    function requestShortTerm() {
        $emp_id = $('#emp_id').val();
        if (($emp_id == null) || ($emp_id == "") || ($emp_id == 0)) {
            sweetAlert({
                title: "Cannot Proceed",
                text: "Select Employee Name",
                type: "error",
                timer: 3000
            });
        } else {
            window.location.href = "<?php echo base_url(); ?>provident/short_term/" + $emp_id;
        }
    }

    function requestAccessRole() {
        $user_type_id = $('#user_type_id').val();
        if (($user_type_id == null) || ($user_type_id == "") || ($user_type_id == 0)) {
            sweetAlert({
                title: "Cannot Proceed",
                text: "Select User Access Role",
                type: "error",
                timer: 3000
            });
        } else {
            window.location.href = "<?php echo base_url(); ?>user_access/load_access/" + $user_type_id;
        }
    }

    function setBranch(url) {
        $branch_id = $('#branch_id').val();
        if (($branch_id == null) || ($branch_id == "")) {
            sweetAlert({
                title: "Cannot Proceed",
                text: "Select Branch",
                type: "error",
                timer: 3000
            });
        } else {
            window.location.href = url + "/" + $branch_id;
        }
    }

    function setBranchMonth(url) {
        $branch_id = $('#branch_id').val();
        $month = $('#month').val();
        if (($branch_id == null) || ($branch_id == "") || ($month == null) || (
                $month == "")) {
            sweetAlert({
                title: "Cannot Proceed",
                text: "Select Branch and Pay Month",
                type: "error",
                timer: 3000
            });
        } else {
            window.location.href = url + "/" + $branch_id + "/" + $month;
        }
    }

    function setSTBranchYear(url) {
        $branch_id = $('#branch_id').val();
        $year = "ST-" + $('#year').val();
        if (($branch_id == null) || ($branch_id == "") || ($year == null) || (
                $year == "")) {
            sweetAlert({
                title: "Cannot Proceed",
                text: "Select Branch and Year",
                type: "error",
                timer: 3000
            });
        } else {
            window.location.href = url + "/" + $branch_id + "/" + $year;
        }
    }
    </script>
    <!--<script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>-->
    <script src="<?php echo base_url(); ?>assets/vendor/gijgo-combined-1.9.13/js/gijgo.min.js" type="text/javascript">
    </script>
    <script>
    $('#commission_month').datepicker({
        uiLibrary: 'bootstrap4',
        format: 'mmm-yyyy'
    });
    $('#month').datepicker({
        uiLibrary: 'bootstrap4',
        format: 'mmm-yyyy'
    });
    $('#payment_month').datepicker({
        uiLibrary: 'bootstrap4',
        format: 'mmm-yyyy'
    });
    $('#year').datepicker({
        uiLibrary: 'bootstrap4',
        format: 'yyyy'
    });
    </script>
    <script src="<?php echo base_url(); ?>assets/vendor/bootstrap-select/select.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>app/controllers/DeductionCtrl.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>app/controllers/AllowanceCtrl.js" type="text/javascript"></script>

    <script>
    function openDeductions() {
        $('#payment_deductionModal').modal('show');
    }

    function openAllowances() {
        $('#payment_allowanceModal').modal('show');
    }

    function closeAllowances(branch_id, pyear, emp_id) {
        var pmonth = $('#apmonth').val();
        if (pmonth < 10) {
            pmonth = '0' + pmonth;
        }
        var month = pmonth + "-" + pyear;
        window.location.href = "<?php echo base_url(); ?>payroll/make_payment_form/" + branch_id + "/" + month + '/' +
            emp_id;
        //                $.ajax({
        //                    url: '<?php echo base_url(); ?>payroll/get_sum_of_allowances/',
        //                    type: 'POST',
        //                    data: {emp_id: id, pay_month: month},
        //                    success: function (response) {
        //                        $("#allowance").val((response));
        //                        var allowance = 0;
        //                        if ($("#allowance").val() === '') {
        //                            allowance = 0;
        //                        } else {
        //                            allowance = parseFloat($("#allowance").val());
        //                        }
        //                        var net_salary = 0;
        //                        if ($("#net_salary_hidden").val() === '') {
        //                            net_salary = 0;
        //                        } else {
        //                            net_salary = parseFloat($("#net_salary_hidden").val()) - parseFloat($("#fine_deduction").val());
        //                        }
        //                        $('#net_salary').val((net_salary + allowance).toFixed(2));
        //                    }
        //                });
        //                $('#payment_allowanceModal').modal('hide');
    }

    function closeDeductions(branch_id, pyear, emp_id) {
        var pmonth = $('#dpmonth').val();
        if (pmonth < 10) {
            pmonth = '0' + pmonth;
        }
        var month = pmonth + "-" + pyear;
        window.location.href = "<?php echo base_url(); ?>payroll/make_payment_form/" + branch_id + "/" + month + '/' +
            emp_id;
        //                // AJAX Request
        //                $.ajax({
        //                    url: '<?php echo base_url(); ?>payroll/get_sum_of_deductions/',
        //                    type: 'POST',
        //                    data: {emp_id: id, pay_month: month},
        //                    success: function (response) {
        //                        //                console.log(response);
        //                        $("#fine_deduction").val((response));
        //                        var net_salary = 0;
        //                        var fine_deduction = 0;
        //                        if ($("#fine_deduction").val() === '') {
        //                            fine_deduction = 0;
        //                        } else {
        //                            fine_deduction = parseFloat($("#fine_deduction").val());
        //                        }
        //
        //                        if ($("#net_salary_hidden").val() === '') {
        //                            net_salary = 0;
        //                        } else {
        //                            net_salary = parseFloat($("#net_salary_hidden").val()) + parseFloat($("#allowance").val());
        //                        }
        //                        $('#net_salary').val((net_salary - fine_deduction).toFixed(2));
        //                    }
        //                });
        //                $('#payment_deductionModal').modal('hide');
    }


    function calculateNetPay(salary, deductions, allowances, loan_installment, position) {
        var pay_amount_1 = (salary + allowances) - deductions;
        var pay_amount_2 = pay_amount_1 - calculateTax(pay_amount_1);
        var pay_amount_3 = 0;
        if (position != 0) {
            pay_amount_3 = pay_amount_2 - calculateLongTerm(pay_amount_2);
        } else {
            pay_amount_3 = pay_amount_2;
        }
        var pay_amount_4 = pay_amount_3 - calculateShortTerm(pay_amount_3);

        var net_pay = pay_amount_4 - loan_installment;
    }

    function calculateTax(salary) {
        return 0.05 * salary;
    }

    function calculateLongTerm(salary) {
        return 0.05 * salary;
    }

    function calculateShortTerm(salary) {
        return 0.1 * salary;
    }
    </script>
    <script>
    function validate(evt) {
        var theEvent = evt || window.event;

        // Handle paste
        if (theEvent.type === 'paste') {
            key = event.clipboardData.getData('text/plain');
        } else {
            // Handle key press
            var key = theEvent.keyCode || theEvent.which;
            key = String.fromCharCode(key);
        }
        var regex = /[0-9]|\./;
        if (!regex.test(key)) {
            theEvent.returnValue = false;
            if (theEvent.preventDefault)
                theEvent.preventDefault();
        }
    }

    function changeAllowanceStatus(branch_id, allowance_id) {
        window.location.href = "<?php echo base_url(); ?>payroll/toggle_allowance/" + branch_id + "/" + allowance_id;
    }

    function changeDeductionStatus(branch_id, deduction_id) {
        window.location.href = "<?php echo base_url(); ?>payroll/toggle_deduction/" + branch_id + "/" + deduction_id;
    }
    </script>

    <!-- Delete through modals -->
    <script>
    $('#deleteDesignation').on('show.bs.modal', function(event) {
        let recordId = $(event.relatedTarget).data('recordid');
        $("#deleteRecord").attr("href", "<?=base_url() . 'designations/delete/'?>" + recordId);
    });

    $('#deleteRole').on('show.bs.modal', function(event) {
        let recordId = $(event.relatedTarget).data('recordid');
        $("#deleteRecord").attr("href", "<?=base_url() . 'user_access/delete_role/'?>" + recordId);
    });

    $('#deleteAccess').on('show.bs.modal', function(event) {
        let recordId = $(event.relatedTarget).data('recordid');
        $("#deleteRecord").attr("href", "<?=base_url() . 'user_access/delete_access/'?>" + recordId);
    });

    $('#deleteBranch').on('show.bs.modal', function(event) {
        let recordId = $(event.relatedTarget).data('recordid');
        $("#deleteRecord").attr("href", "<?=base_url() . 'branches/delete/'?>" + recordId);
    });

    $('#blockUser').on('show.bs.modal', function(event) {
        let recordId = $(event.relatedTarget).data('recordid');
        $(this).find('.modal-body input').val(recordId);
    });

    $('#unblockUser').on('show.bs.modal', function(event) {
        let recordId = $(event.relatedTarget).data('recordid');
        $(this).find('.modal-body input').val(recordId);
    });

    $('#deleteDeduction').on('show.bs.modal', function(event) {
        let recordId = $(event.relatedTarget).data('recordid');
        $("#deleteRecord").attr("href", "<?=base_url() . 'loan/delete_deduction/'?>" + recordId);
    })

    $('#deleteAllowance').on('show.bs.modal', function(event) {
        let recordId = $(event.relatedTarget).data('recordid');
        $("#deleteRecord").attr("href", "<?=base_url() . 'loan/delete_allowance/'?>" + recordId);
    })
    </script>

    <!-- Approve payroll through modals -->
    <script>
    $('#approvePayroll').on('show.bs.modal', function(event) {
        let recordId = $(event.relatedTarget).data('recordid');
        let recordBranch = $(event.relatedTarget).data('recordid1');
        let recordMonth = $(event.relatedTarget).data('recordid2');
        $("#approveRecord").attr("href", "<?=base_url() . 'payroll/approve_payroll/'?>" + recordId + "/" +
            recordBranch + "/" + recordMonth);
    });

    $('#approveAllPayroll').on('show.bs.modal', function(event) {
        let recordId = $(event.relatedTarget).data('recordid');
        let recordMonth = $(event.relatedTarget).data('recordid1');
        $("#branchRecord").attr("href", "<?=base_url() . 'payroll/approve_all_payroll/'?>" + recordId + "/" +
            recordMonth);
    });

    $('#deleteCommission').on('show.bs.modal', function(event) {
        let recordMonth = $(event.relatedTarget).data('recordid');
        $("#monthRecord").attr("href", "<?=base_url() . 'commission/delete_commission_file/'?>" + recordMonth);
    });
    </script>
</body>





</html>