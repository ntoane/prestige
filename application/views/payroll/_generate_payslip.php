<!-- Breadcrumbs-->
<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="<?= base_url() . 'payroll'; ?>">Payroll</a>
    </li>
    <li class="breadcrumb-item active">Generate Payslip</li>
</ol>

<!-- Page Content -->
<div class="row mb-3">
<div class="col-md-10 ml-auto">
    <h6><strong>Branch: </strong><?= $branch; ?></h6>
    <h6><strong>Month: </strong><?= $pay_month; ?></h6>
</div>
    <div class="col-md-2 mr-auto">
    <?php 
        $all_approved = true;
        foreach($payment_data as $p) {
            if($p['approve'] == '0' || $p['approve'] == '2') {
                $all_approved = false;
            }
        }

    if($all_approved) {
    ?>
    <form action="<?=base_url() . 'payroll/print_all_payslip'?>" method="POST">
        <input type="hidden" name="branch_id" value="<?=$branch_id;?>" />
        <input type="hidden" name="payment_month" value="<?=$pay_month;?>" />

        <button type="submit" name="submit_payslip" class="btn btn-success btn-md">Generate All Payslip</button>
    </form>
    <?php
        }
    ?>
    </div>
</div>
<div class="card shadow-sm mb-5">
    <div class="card-body">
        <table id="data-table" class="table table-striped table-hover dt-responsive" style="width:100%">
            <thead>
                <tr>
                    <th>Employment Number</th>
                    <th>Employee Name</th>
                    <th>Net Pay</th>
                    <th>Payment Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($payment_data as $payment) {
                    ?>
                    <tr>
                        <td><?= $this->employees->get_emp_number($payment['emp_id']) ?></td>
                        <td><?php
                            $emp_name = $this->employees->get_fullname($payment['emp_id']);
                            echo $emp_name->fullname;
                            ?>
                        </td>
                        <td><?= _format_money($this,$payment['net_amount'],true); ?></td>
                        <td>
                            <?php
                            if ($this->payroll->is_payment_approved($payment['emp_id'], $pay_month)) {
                                echo "<span class='badge badge-success'>Paid</span>";
                            } else {
                                echo "<span class='badge badge-warning'>Pending Approval</span>";
                            }
                            ?>
                        </td>
                        <td>
                            <?php
                            if ($this->payroll->is_payment_approved($payment['emp_id'], $pay_month)) {
                                ?>
                                <a href="<?php echo base_url(); ?>payroll/print_payslip/<?= $payment['emp_id'] . '/' . $pay_month ?>" class="btn btn-success btn-sm">Generate Payslip</a>
                                <?php
                            }
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