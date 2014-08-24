<div class="container-fluid">
    <div class="row">
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
            <span class="h2 text-theme">Paper Information</span>
            <div class="row body-text">
                <div class="col-md-12 text-center contentBlock-bottom">
                    <span class="h2" style="text-decoration: underline;">Paper: <?php echo $paperDetails->paper_title; ?></span>
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

                <div class="col-md-12 text-center contentBlock-bottom">
                    <span class="h2" style="text-decoration: underline;">Review: </span>
                </div>

                <div>
                    <b>Your comments: </b><br/><br/>
                    <?php

                    foreach($reviews as $index => $review)
                    {
                        if(strcmp($review -> paper_version_review_comments, 'Not reviewed yet'))
                            echo "<h4>".$review -> paper_version_review_comments."</h4>";
                        else
                        {
                            ?>
                            <form class="form-horizontal"  method = "post">
                                <textarea name = 'comments'></textarea><br/><br/>

                                    <span class="body-text text-danger">
                                        <?php
                                        if(isset($error2))
                                            echo $error2;
                                        ?>
                                    </span>


                                <button name = "Form2" value = "Form2" class="btn btn-primary">Send to Convener</button>
                            </form>
                        <?php
                        }
                    }
                    ?>

                    <a href = "http://localhost/Indiacom2015/bvicam_admin/ReviewerDashboard" > View papers assigned</a>
                </div>
            </div>
        </div>
    </div>
</div>