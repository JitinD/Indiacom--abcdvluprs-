<div class="container-fluid">
    <div class="row body-text">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <span class="h3">Submit Paper Revision</span>
            <table class="table table-responsive">
                <?php
                foreach($events as $event)
                {
                ?>
                    <thead>
                    <tr>
                        <th>Event</th>
                        <th>Papers Submitted</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td><?php echo $event->event_name; ?></td>
                        <td>
                            <table class="table table-responsive table-hover">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Paper Title</th>
                                    <th>Paper Code</th>
                                    <th>Latest Version</th>
                                    <th>Version Status</th>
                                    <th>Upload Revision</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                if(empty($papers[$event->event_id]))
                                {
                                    ?>
                                    <tr>
                                        <td colspan="5">
                                            You haven't submitted any papers yet. <a href="/<?php echo INDIACOM; ?>Dashboard/submitPaper">Click here</a> to submit a new paper.
                                        </td>
                                    </tr>
                                <?php
                                }
                                ?>
                                <?php
                                foreach($papers[$event->event_id] as $index=>$paper)
                                {
                                    ?>
                                    <tr>
                                        <td><?php echo $index+1; ?></td>
                                        <td><?php echo $paper->paper_title; ?></td>
                                        <td><?php echo $paper->paper_code; ?></td>
                                        <td><?php echo $paper->latest_paper_version_number; ?></td>
                                        <td>
                                            <?php
                                                if($paper->review_result_type_name == null)
                                                {
                                                    if($paper->paper_version_is_reviewer_assigned == '0')
                                                    {
                                                        echo "Not yet reviewed";
                                                    }
                                                    else if($paper->paper_version_review_date == null)
                                                    {
                                                        echo "Under Review";
                                                    }
                                                }
                                                else
                                                    echo $paper->review_result_type_name;
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                            if($paperCanRevise[$paper->paper_id])
                                            {
                                                ?>
                                                <a href="<?php echo $methodName . "/" . $paper->paper_id; ?>">Upload</a>
                                            <?php
                                            }
                                            else
                                            {
                                                ?>
                                                <span class="text-danger">Under Review</span>
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
                        </td>
                    </tr>
                    </tbody>
                <?php
                }
                ?>
            </table>
        </div>
    </div>
</div>