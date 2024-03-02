<!-- Breadcrumbs-->
<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="<?= base_url() . 'provident/long_term'; ?>">Reports</a>
    </li>
    <li class="breadcrumb-item active">Short Term accumulation</li>
</ol>

<!-- Page Content -->
<div class="row mb-3">
    <div class="col-md-11">
        <h5><?php
            $emp_name = $this->employees->get_fullname($emp_id);
            echo "Short Term Accumulation for <strong>".$emp_name->fullname."</strong";
            ?>
        </h5>
    </div>
    <div class="col-md-1 mr-auto">
        <a href="<?= base_url() . 'provident/long_term'; ?>" class="btn btn-primary btn-block"><i class="fa fa-arrow-left"></i> Back</a>
    </div>
</div>
<div class="card shadow-sm mb-5">
    <div class="card-body">
        <table id="export-table" class="table table-striped table-hover dt-responsive display" style="width:100%">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Payment Month</th>
                    <th>Short Term</th>
                    <th>Total Accumulated</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $total = 0;
                $count = 1;
                foreach ($emp_data as $paye) {
                    ?>
                    <tr>
                        <td><?= $count; ?></td>
                        <td><?= $paye['payment_month']; ?></td>
                        <td><?= _format_money($this, $paye['short_term'],true); ?></td>
                        <?php 
                            if($paye['short_term'] <=0) {
                                $total = 0;
                            }
                        ?>
                        <td><strong><?= _format_money($this,$total += $paye['short_term'],true); ?></strong></td>
                        <?php $count +=1; ?>
                    </tr>
                    <?php
                }
                ?>
            </tbody>
        </table>
    </div>
</div>