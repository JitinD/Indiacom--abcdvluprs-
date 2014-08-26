<div class="container-fluid">
    <div class="row">
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
            <span class="h2 text-theme">Paper Information</span>
            <div class="row body-text">
                <div class="col-md-12 text-center contentBlock-bottom">
                    <span class="h2">Paper: <?php echo $paperDetails->paper_title; ?></span>
                </div>
                    <table class="table table-striped table-hover table-responsive">
                        <tr>
                            <td>Paper Code</td>
                            <td><?php echo $paperDetails->paper_code; ?></td>
                        </tr>
                        <tr>
                            <td>Paper Title</td>
                            <td><?php echo $paperDetails->paper_title; ?></td>
                        </tr>
                        <tr>
                            <td>Event</td>
                            <td><?php echo $eventDetails->event_name; ?></td>
                        </tr>
                        <tr>
                            <td>Track</td>
                            <td>Track <?php echo $trackDetails->track_number . " : " . $trackDetails->track_name; ?></td>
                        </tr>
                        <tr>
                            <td>Subject</td>
                            <td><?php echo $subjectDetails->subject_name; ?></td>
                        </tr>

                        <tr>
                            <td>Author Member IDs</td>
                            <td>
                                <table>
                                    <?php
                                    foreach($submissions as $submission)
                                    {
                                    ?>
                                        <tr>
                                            <td>
                                                <?php
                                                echo $submission->submission_member_id;
                                                if($paperDetails->paper_contact_author_id == $submission->submission_member_id)
                                                    echo " - Main Author";
                                                ?>
                                            </td>
                                        </tr>

                                    <?php
                                    }
                                    ?>
                                </table>
                            </td>
                        </tr>

                    </table>

                    <div class="col-md-12 contentBlock-bottom">
                        <span class="h2">Reviews </span>
                    </div>

                <table class="table table-hover body-text">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Reviewer ID</th>
                        <th>Reviewer Comments</th>
                        <th>Review Date</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    if(empty($reviews))
                    {
                        ?>
                        <tr>
                            <td colspan="5">
                                No reviewer assigned yet.
                            </td>
                        </tr>
                    <?php
                    }
                    else
                    {
                    ?>
                        <?php

                            $paper_version_reviewers = array();

                        foreach($reviews as $index=>$review)
                        {
                        ?>
                            <tr>
                                <td><?php echo $index+1; ?></td>
                                <td><?php echo $reviewer_id = $review -> paper_version_reviewer_id; ?></td>
                                <td><?php echo $review -> paper_version_review_comments; ?></td>
                                <td><?php echo $review -> paper_version_review_date_of_receipt; ?></td>
                                <td>
                                    <form class="form-horizontal"  method = "post">

                                        <span class="body-text text-danger">
                                        <?php
                                        if(isset($error3))
                                            echo $error3;
                                        ?>
                                    </span>
                                        <button name = "Form3" value = "<?php echo $review -> paper_version_review_id ?>" class="btn btn-danger"><span class="glyphicon glyphicon-minus"></span> Reviewer</button>
                                    </form>
                                </td>
                            </tr>
                        <?php
                            array_push($paper_version_reviewers, $reviewer_id);
                        }
                    }
                        ?>
                    </tbody>
                </table>

                <?php

                    $reviewers = array_map('current', $reviewers);

                    if(isset($paper_version_reviewers))
                        $reviewers = array_diff($reviewers, $paper_version_reviewers);

                    if($reviewers)
                    {
                ?>

                        <div>
                            <form method = "post">

                                <div>
                                    <b>Add reviewers : </b>
                                    <br/>
                                    <span class="text-muted">Hold Ctrl to select more than one reviewer</span>
                                </div>
                                <span>
                                    <select multiple id="selectReviewer" name="selectReviewer[]">
                                    <?php

                                        foreach($reviewers as $reviewer)
                                        {
                                    ?>
                                            <div class="form-group">
                                                <option value = <?php echo $reviewer?>><?php echo $reviewer  ?></option>
                                            </div>

                                    <?php

                                        }
                                    ?>
                                    </select>
                                </span>

                                <span class="body-text text-danger">
                                            <?php
                                            if(isset($error1))
                                                echo $error1;
                                            ?>
                                </span>

                                <button name = "Form1" value = "Form1" class="btn btn-success btn-lg"><span class="glyphicon glyphicon-plus"></span>Add</button>
                            </form>
                        </div>
                <?php
                    }
                    else
                        echo "Reviewers not available.<br/><br/>";
                ?>


                <div>
                    <b>Your comments: </b><br/><br/>
                    <?php

                        foreach($comments as $index => $comment)
                        {
                            if(strcmp($comment -> paper_version_review, 'Not reviewed yet'))
                                echo "<h4>".$comment -> paper_version_review."</h4>";
                            else
                            {
                    ?>
                                <form class="form-horizontal" enctype="multipart/form-data" method = "post">
                                    <textarea name = 'comments'></textarea><br/><br/>

                                    <span class="body-text text-danger">
                                        <?php
                                        if(isset($error2))
                                            echo $error2;
                                        ?>
                                    </span>


                                    <button name = "Form2" value = "Form2" class="btn btn-primary">Send to Author</button>

                                </form>
                    <?php
                            }
                        }
                    ?>

                    <a href = "http://localhost/Indiacom2015/bvicam_admin/ConvenerDashboard" > View papers assigned</a>
                </div>
            </div>
        </div>
    </div>
</div>