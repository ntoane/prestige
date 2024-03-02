<!-- Breadcrumbs-->
<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="<?=base_url() . 'commission';?>">Commission</a>
    </li>
    <li class="breadcrumb-item active">Sales Advisors Commission</li>
</ol>


<div class="row mb-3">
    <div class="col-md-4">
        <h5><strong>Branch: </strong><?=$branch;?></h5>
        <h5><strong>Pay Month: </strong><?=$pay_month;?></h5>
    </div>
    <div class="col-md-3">
        <a href="<?=base_url() . 'commission/export_csv/' . $branch_id . '/' . $pay_month?>"><i
                class="fa fa-download mr-1"></i> Download Template</a>
    </div>
    <div class="col-md-4">
        <?php
if ($commission_uploaded->total > 0) {
    ?>
        <div class="col-md-2 mr-auto d-inline">
            <a href="#" class="btn btn-danger mb-2" data-toggle="modal" data-target="#deleteCommission"
                data-recordid="<?=$pay_month;?>" title="Click here to deleted all uploaded commissions seen below"><i
                    class="fa fa-trash"></i> Commission File</a>
        </div>
        <?php
} else {
    ?>
        <form enctype="multipart/form-data" action="<?=base_url() . 'commission/import_csv'?>" method="post"
            role="form">
            <input type="hidden" name="branch_id" value="<?=$branch_id;?>">
            <input type="hidden" name="pay_month" value="<?=$pay_month;?>">
            <div class="form-group">
                <label for="exampleInputFile">File Upload</label>
                <input type="file" name="file" id="file" class="" size="150">
                <!-- <p class="help-block">Only Excel/CSV File Import.</p> -->
            </div>
            <button type="submit" class="btn btn-success" name="upload_consultants" value="consultants">Upload</button>
        </form>
        <?php
}
?>
    </div>
    <div class="col-md-1 mr-auto">
        <a href="<?=base_url() . 'commission'?>" class="btn btn-primary btn-block"><i class="fa fa-arrow-left"></i>
            Back</a>
    </div>
</div>

<div class="card shadow-sm mb-3">
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <table id="data-table" class="table table-striped table-hover dt-responsive" style="width:100%">
                    <thead>
                        <tr>
                            <th>Employement Number</th>
                            <th>Sales Advisor</th>
                            <th>Commission</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
foreach ($consultants as $consultant) {
    ?>
                        <tr>
                            <td><?=$consultant['emp_number'];?></td>
                            <td><?=$consultant['fullname'];?></td>
                            <td><?=_format_money($this, $this->commission->get_business_commission($consultant['emp_id'], $pay_month), true);?>
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

<!-- Commission file delete modal-->
<div class="modal fade" id="deleteCommission" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-confirm">
        <div class="modal-content">
            <div class="modal-header">
                <div class="icon-box">
                    <i class="fa fa-trash text-danger"></i> Delete Commission File Data
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete the uploaded commission file data?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-info" data-dismiss="modal">Cancel</button>
                <a href="#" id="monthRecord" class="btn btn-danger"><span class="text-white">Delete</span></a>
            </div>
        </div>
    </div>
</div>