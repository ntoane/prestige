<!-- Breadcrumbs-->
<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="<?php echo base_url(); ?>Loan">Loan</a>
    </li>
    <li class="breadcrumb-item active">Revolved Loans</li>
</ol>

<div class="card shadow-sm mb-5">
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body">
                    <div class="bs-component">
                        <ul class="nav nav-justified border-bottom tabs">
                            <li class="nav-item border-right">
                                <a class="nav-link" href="<?php echo base_url(); ?>loan/active_loans"><i
                                        class="fa fa-toggle-on"></i> <br /> Active Loans</a>
                            </li>
                            <li class="nav-item border-right">
                                <a class="nav-link" href="<?php echo base_url(); ?>loan/settled_loans"><i
                                        class="fa fa-check-circle"></i> <br /> Settled Loans</a>
                            </li>
                            <li class="nav-item border-right">
                                <a class="nav-link active" href="<?php echo base_url(); ?>loan/revolved_loans"><i
                                        class="fa fa-sync"></i> <br /> Revolved Loans</a>
                            </li>
                            <li class="nav-item border-right">
                                <a class="nav-link" href="<?php echo base_url(); ?>loan/all_loans"><i
                                        class="fa fa-list-alt"></i> <br /> All Loans</a>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active">
                                <br><br>
                                <div class="row pr-2 pl-2 pb-3">
                                    <div class="col-md-12">
                                        <div class="text-right mb-2" style="margin-top: -25px;">
                                            <a class="btn btn-success btn-sm"
                                                href="<?php echo base_url() . 'loan/new_loan'; ?> "><i
                                                    class="fa fa-plus"></i> New Loan</a>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table table-bordered" id="dataTable">
                                                <thead>
                                                    <tr>
                                                        <th>Employee Name</th>
                                                        <th>Loan Amount</th>
                                                        <th>Period in Months</th>
                                                        <th>Outstanding Balance</th>
                                                        <th>Installment</th>
                                                        <th>Settlement Amount</th>
                                                        <th>Date </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php

foreach ($revolved_loans as $loan) {
    ?>
                                                    <tr>
                                                        <?php $emp_id = $loan['emp_id'];?>
                                                        <?php $emp_name = $this->users->get_row("SELECT fullname FROM tbl_employees WHERE emp_id = '$emp_id'");?>
                                                        <td><?=$emp_name->fullname;?></td>
                                                        <td><?=_format_money($this, $loan['loan_amount'], true);?></td>
                                                        <td><?=$loan['loan_period'];?></td>
                                                        <td><?=_format_money($this, $loan['outstanding_balance'], true);?>
                                                        </td>
                                                        <td><?=_format_money($this, $loan['loan_installment'], true);?>
                                                        </td>
                                                        <td><?=_format_money($this, $loan['settlement_amount'], true);?>
                                                        </td>
                                                        <td><?=date('d-m-Y', strtotime($loan['created']));?></td>
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
                </div>
            </div>
        </div>
    </div>
</div>