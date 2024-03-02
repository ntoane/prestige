<!-- Breadcrumbs-->
<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="<?= base_url() . 'users'; ?>">Payroll</a>
    </li>
    <li class="breadcrumb-item active">Payroll Activities</li>
</ol>

<!-- Page Content -->
<div class="card shadow-sm mb-3">
<div class="card-body">
<table id="data-table" class="table table-hover dt-responsive" style="width:100%">
    <thead>
        <tr>
            <th>Activity Title</th>
            <th>Activity</th>
            <th>Date</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($payroll_activities as $activity) {
            ?>
            <tr>
                <td><?= $activity['activity_title']; ?></td>
                <td><?php echo "<strong>" .$activity['fullname'] . "</strong> - " .$activity['activity_description']; ?></td>
                <td><?= $activity['created']; ?></td>
            </tr>
            <?php
        }
        ?>
    </tbody>
</table>
</div>
</div