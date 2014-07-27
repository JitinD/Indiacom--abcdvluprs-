<div class="col-md-9 col-sm-9 col-xs-12">
    <h3 class="text-theme">Paper Status</h3>
    <table class="table table-hover table-striped body-text">
        <thead>
        <tr>
            <th>#</th>
            <th>Code</th>
            <th>Title</th>
            <th>Latest Version</th>
            <th>Version Status</th>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach($papers as $index=>$paper)
        {
        ?>
            <tr>
                <td><?php echo $index+1; ?></td>
                <td><?php echo $paper->paper_code; ?></td>
                <td><?php echo $paper->paper_title; ?></td>
                <td><?php echo $paper->latest_paper_version_number; ?></td>
                <td><?php echo $paper->review_result_type_name==""?"Not yet reviewed":$paper->review_result_type_name; ?></td>
            </tr>
        <?php
        }
        ?>
        </tbody>
    </table>
</div>
<div class="col-md-3 col-sm-3 col-xs-12">
    <h3 class="text-theme">Profile
    <button class="btn btn-sm btn-success"><span class="glyphicon glyphicon-pencil"></span></button>
        </h3>
    <table class="table table-hover table-responsive table-striped body-text">
        <tbody>
        <tr>
            <td>Name</td>
            <td><?php echo $_SESSION['member_name'] ?></td>
        </tr>
        <tr>
            <td>Member ID</td>
            <td><?php echo $_SESSION['member_id'] ?></td>
        </tr>
        <tr>
            <td>Organisation</td>
            <td><?php echo $miniProfile['organization_name'] ?></td>
        </tr>
        <tr>
            <td>Category</td>
            <td><?php echo $miniProfile['member_category_name'] ?></td>
        </tr>

        </tbody>
    </table>
</div>