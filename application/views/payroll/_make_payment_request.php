<!-- Breadcrumbs-->
<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="<?=base_url() . 'payroll';?>">Payroll</a>
    </li>
    <li class="breadcrumb-item active">Make Payment</li>
</ol>

<div class="row">
    <div class="col-md-12 mx-auto">
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 text-right">
                        <label><strong>Select Branch</strong></label>
                    </div>
                    <div class="col-md-4">
                        <select id="branch_id" class="form-control selectpicker" data-size="<?=count($branches);?>"
                            data-live-search="true" data-title="Branches" data-width="100%">
                            <option value="0">All Branches</option>
                            <?php
foreach ($branches as $branch) {
    ?>
                            <option value="<?=$branch['branch_id'];?>"><?=$branch['branch_name'];?></option>
                            <?php
}
?>
                        </select>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-4 text-right">
                        <label><strong>Select Month</strong></label>
                    </div>
                    <div class="col-md-4">
                        <input type="text" class="form-control" id="payment_month" placeholder="Select Month" />
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-4 mx-auto">
                        <button type="button" onclick="setPaymentMonth()" class="btn btn-primary btn-block">Go</button>
                    </div>
                </div>
                <br><br>
            </div>
        </div>
        </ div>
    </div>
