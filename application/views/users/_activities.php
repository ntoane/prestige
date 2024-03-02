<!-- Breadcrumbs-->
<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="<?= base_url() . 'users'; ?>">Users</a>
    </li>
    <li class="breadcrumb-item active">User Activities</li>
</ol>

<!-- Page Content -->
<div class="card shadow-sm mb-3">
<div class="card-body">
<table id="data-table" class="table table-striped table-hover dt-responsive" style="width:100%">
    <thead>
        <tr>
            <th>Title</th>
            <th>Description</th>
            <th>Performed By</th>
            <th>Date</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($user_activities as $user_activity) {
            ?>
            <tr>
                <td><?= $user_activity['activity_title']; ?></td>
                <td><?= $user_activity['activity_description']; ?></td>
                <td><?= $user_activity['fullname']; ?></td>
                <td><?= $user_activity['created']; ?></td>
            </tr>
            <?php
        }
        ?>
    </tbody>
</table>
</div>
</div>