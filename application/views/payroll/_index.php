<!-- Breadcrumbs-->
<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="<?=base_url() . 'payroll';?>">Payroll</a>
    </li>
    <li class="breadcrumb-item active">Menu</li>
</ol>

<div class="card shadow-sm">
    <div class="card-body">
        <h4>Manage Salary</h4>
        <hr />
        <div class="row mt-3">
            <div class="col-md-3 text-center bg-primary p-5 shadow">
                <a href="<?=base_url() . 'payroll/adrequest';?>" class="text-white">

                    <h5 class="my-3">Allowances & Deductions</h5>
                </a>
            </div>
            <div class="col-md-3 text-center bg-info p-5 shadow">
                <a href="<?=base_url() . 'payroll/salary_list';?>" class="text-white">

                    <h5 class="my-3">Salary List</h5>
                </a>
            </div>
            <div class="col-md-3 text-center bg-success p-5 shadow">
                <a href="<?=base_url() . 'payroll/make_payment';?>" class="text-white">

                    <h5 class="my-3">Make Payment</h5>
                </a>
            </div>
            <div class="col-md-3 text-center bg-dark p-5 shadow">
                <a href="<?=base_url() . 'payroll/approve_payroll_request';?>" class="text-white">

                    <h5 class="my-3">Approve Payment</h5>
                </a>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-3 text-center bg-dark p-5 shadow">
                <a href="<?=base_url() . 'payroll/bank_csv';?>" class="text-white">

                    <h5 class="my-3">Salaries File</h5>
                </a>
            </div>
            <div class="col-md-3 text-center bg-success p-5 shadow">
                <a href="<?=base_url() . 'payroll/salary_payment_file';?>" class="text-white">

                    <h5 class="my-3">Payment History</h5>
                </a>
            </div>
            <div class="col-md-3 text-center bg-info p-5 shadow">
                <a href="<?=base_url() . 'payroll/payroll_activities';?>" class="text-white">

                    <h5 class="my-3">Payroll Activities</h5>
                </a>
            </div>
            <div class="col-md-3 text-center bg-primary p-5 shadow">
                <a href="<?=base_url() . 'payroll/generate_payslip';?>" class="text-white">

                    <h5 class="my-3">Generate Payslip</h5>
                </a>
            </div>
        </div>
        <br />
        <h4>Reports</h4>
        <hr />
        <div class="row my-3">
            <div class="col-md-4 text-center bg-warning p-5 shadow">
                <a href="<?=base_url() . 'payroll/report_paye';?>" class="text-white">
                    <h5 class="my-3">Pay As You Earn (PAYE)</h5>
                </a>
            </div>
            <div class="col-md-4 text-center bg-success p-5 shadow">
                <a href="<?=base_url() . 'provident/short_term';?>" class="text-white">
                    <h5 class="my-3">Short Term</h5>
                </a>
            </div>
            <div class="col-md-4 text-center bg-info p-5 shadow">
                <a href="<?=base_url() . 'provident/long_term';?>" class="text-white">
                    <h5 class="my-3">Long Term</h5>
                </a>
            </div>
        </div>
        <h4>Short Term Payment</h4>
        <hr />
        <div class="row my-3">
            <div class="col-md-4 text-center bg-primary p-5 shadow">
                <a href="<?=base_url() . 'provident/make_short_term_payment';?>" class="text-white">
                    <h5 class="my-3">Pay Short Term</h5>
                </a>
            </div>
            <div class="col-md-4 text-center bg-success p-5 shadow">
                <a href="<?=base_url() . 'provident/approve_short_term_payment';?>" class="text-white">
                    <h5 class="my-3">Approve Short Term Payment</h5>
                </a>
            </div>
            <div class="col-md-4 text-center bg-info p-5 shadow">
                <a href="<?=base_url() . 'provident/st_bank_csv';?>" class="text-white">

                    <h5 class="my-3">Short Term File</h5>
                </a>
            </div>
        </div>
    </div>
</div>
