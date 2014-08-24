<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
    <h3 class="text-theme">Papers Assigned</h3>
    <table class="table table-hover table-striped body-text">
        <thead>
        <tr>
            <th>#</th>
            <th>Code</th>
            <th>Title</th>
            <th>Version number</th>
        </tr>
        </thead>
        <tbody>
        <?php
            if(empty($papers))
            {
                ?>
                <tr>
                    <td colspan="5">
                        No papers assigned yet.
                    </td>
                </tr>
            <?php
            }
            else
            {
            ?>
            <?php
                foreach($papers as $index=>$paper)
                {
                    ?>
                    <tr>
                        <td><?php echo $index+1; ?></td>
                        <td><?php echo $paper->paper_code; ?></td>
                        <td><a href="/<?php echo BASEURL; ?>ConvenerDashboard/paperInfo/<?php echo $paper->paper_id."/".$paper->paper_version_id; ?>"><?php echo $paper->paper_title; ?></a></td>
                        <td ><?php echo $paper->paper_version_number; ?></td>
                    </tr>
            <?php

                }
            }
            ?>
        </tbody>
    </table>
</div>

<script>
    $(document).ready(function()
    {
        $('tr').on("click", function() {
            if($(this).attr('href') !== undefined){
                document.location = $(this).attr('href');
            }
        });
    });
</script>