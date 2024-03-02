<!-- Breadcrumbs-->
<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="<?= base_url() . 'payroll'; ?>">Reports</a>
    </li>
    <li class="breadcrumb-item active">Employees Short Term</li>
</ol>

<!-- Page Content -->
<div class="row mb-3">
    <div class="col-md-10">
        <h5><strong>Branch: </strong><?=$branch;?></h5>
        <h5><strong>Pay Month: </strong><?=$pay_month;?></h5>
    </div>
    <div class="col-md-1 mr-auto">
        <a href="<?=base_url() . 'provident/short_term'?>" class="btn btn-primary btn-block"><i class="fa fa-arrow-left"></i>
            Back</a>
    </div>
</div>
<div class="card shadow-sm mb-5">
    <div class="card-body">
        <table id="export-table" class="table table-striped table-hover dt-responsive display" style="width:100%">
            <thead>
                <tr>
                    <th>Employement Number</th>
                    <th>Employee Name</th>
                    <th>Payment Month</th>
                    <th>Short Term</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($short_term_data as $short) {
                    ?>
                    <tr>
                        <td><?=$short['emp_id']?></td>
                        <td><?=$short['fullname']?></td>
                        <td><?=$short['payment_month']?></td>
                        <td><?=_format_money($this, $short['salary_short_term'], true)?></td>
                        <td>
                            <a href="<?= base_url() . 'provident/individual_short_term/' . $short['emp_id']; ?>" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="View accumulated Long Term"><i class="fa fa-list-alt"></i></a>
                        </td>
                    </tr>
                    <?php
                }
                ?>
            </tbody>
        </table>
    </div>
</div>