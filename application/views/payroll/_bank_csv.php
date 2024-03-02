<!-- Breadcrumbs-->
<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="<?=base_url() . 'payroll';?>">Payroll</a>
    </li>
    <li class="breadcrumb-item active">Generate Salaries file</li>
</ol>

<!-- Page Content -->
<div class="row mb-3">
    <div class="col-md-5">
        <h5><strong>Branch: </strong><?=$branch;?></h5>
        <h5><strong>Pay Month: </strong><?=$pay_month;?></h5>
    </div>
    <div class="col-md-6">
        <!-- <a href="<?=base_url() . 'payroll/download_bank_csv/' . $branch_id . '/' . $pay_month?>"><i
                class="fa fa-download mr-1"></i> Download CSV file</a> -->
    </div>
    <div class="col-md-1 mr-auto">
        <a href="<?=base_url() . 'payroll/bank_csv'?>" class="btn btn-primary btn-block"><i
                class="fa fa-arrow-left"></i>
            Back</a>
    </div>
</div>
<div class="card shadow-sm mb-5">
    <div class="card-body">
        <table id="export-table" class="table table-striped table-hover dt-responsive display" style="width:100%">
            <thead>
                <tr>
                    <th>Employee Name</th>
                    <th>Account Number</th>
                    <th>Branch Code</th>
                    <th>Net Pay(M)</th>
                    <th>Reference</th>
                </tr>
            </thead>
            <tbody>
                <?php
foreach ($payment_data as $payment) {
    ?>
                <tr>
                    <td><?=$payment['fullname']?></td>
                    <td><?=$payment['bank_account']?></td>
                    <td><?=$payment['branch_code']?></td>
                    <td><?=round($payment['net_amount'], 2);?></td>
                    <td>
                        <?php
$current_month = date("M");
    $reference = 'Pres Sal ' . $current_month;
    echo $reference;
    ?>
                    </td>
                </tr>
                <?php
}
?>
            </tbody>
        </table>
    </div>
</div>