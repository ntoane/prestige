<!-- Breadcrumbs-->
<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="<?= base_url() . 'commission'; ?>">Loan</a>
    </li>
    <li class="breadcrumb-item active">Schedule payments request</li>
</ol>

<div class="card shadow-sm">
<div class="card-body">
<div class="row">
    <div class="col-md-10 mx-auto">
        <div class="tile">
            <div class="tile-body">
            <form action="<?=base_url() . 'loan'?>" method="POST">
                <div class="row">
                    <div class="col-md-4">
                        <label class="text-right"><strong>Select Loan Category</strong></label>
                    </div>
                    <div class="col-md-4">
                        <select id="loan_type" name="loan_type" class="form-control"> 
                        <option value="1">Loan Management</option>
                        <option value="2">Deductions Management</option>
                        <option value="3">Allowances Management</option>
                        </select>
                    </div>
                </div>
                <br>
                <br>
                <div class="row">
                    <div class="col-md-4 mx-auto">
                        <input type="submit" name="submit_loan" value="Go" class="btn btn-primary btn-block"></button>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>
</div>