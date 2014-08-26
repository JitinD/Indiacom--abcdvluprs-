<div class="container-fluid">
    <div class="row body-text">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <span class="h3">Submit Paper Revision</span>
            <table class="table table-responsive table-hover">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Paper Title</th>
                    <th>Paper Code</th>
                    <th>Latest Version</th>
                    <th>Upload Revision</th>
                </tr>
                </thead>
                <tbody>
                <?php
                foreach($papers as $index=>$paper)
                {
                    ?>
                    <tr>
                        <td><?php echo $index+1; ?></td>
                        <td><?php echo $paper->paper_title; ?></td>
                        <td><?php echo $paper->paper_code; ?></td>
                        <td><?php echo $paper->latest_paper_version_number; ?></td>
                        <td>
                            <?php
                            if($paperCanRevise[$paper->paper_id])
                            {
                            ?>
                            <a href="<?php echo $methodName . "/" . $paper->paper_id; ?>">Upload</a>
                            <?php
                            }
                            else
                                echo "Under Review<br>(isko red ya kuch karna hai!!)";
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
</div>