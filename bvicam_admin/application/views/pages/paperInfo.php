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
                        <tr>
                            <td>
                                Paper
                            </td>
                            <td>
                                <a class="btn btn-sm btn-primary" href="/<?php echo $paperVersionDetails->paper_version_document_path; ?>">
                                    <span class="glyphicon glyphicon-cloud-download"></span> Download
                                </a>
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
                        <th>Reviewer Name</th>
                        <th>Review Status</th>
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
                                <td>
                                    <?php
                                        if($reviewers)
                                            echo $reviewers[$reviewer_id];
                                    ?>
                                </td>
                                <td>
                                    <?php
                                        if($review -> paper_version_review_date_of_receipt)
                                           echo "Reviewed";
                                        else
                                            echo "Not reviewed";
                                    ?>
                                </td>
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
                                        <button name = "Form3" value = "<?php echo $review -> paper_version_review_id ?>" class="btn btn-sm btn-danger"><span class="glyphicon glyphicon-minus"></span> Remove</button>
                                    </form>
                                </td>
                                <td>
                                    <?php
                                    if($review->paper_version_review_comments_file_path != null)
                                    {
                                    ?>
                                    <a href="/<?php echo $review->paper_version_review_comments_file_path; ?>" class="btn btn-sm btn-primary">
                                        <span class="glyphicon glyphicon-cloud-download"></span>
                                        Download Comments
                                    </a>
                                    <?php
                                    }
                                    ?>
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

                    /*$reviewers = array_map('current', $reviewers);

                    if(isset($paper_version_reviewers))
                        $reviewers = array_diff($reviewers, $paper_version_reviewers);*/
                    if($reviewers)
                    {

                ?>
                        <div>
                            <form method = "post" class="form-horizontal">
                                <div>
                                    <span class="h3">Add reviewers</span>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-8">
                                        <select multiple id="selectReviewer" name="selectReviewer[]" class="form-control">
                                            <?php
                                            $noReviewer = true;
                                            foreach($reviewers as $reviewer_id=>$reviewer_name)
                                            {
                                            ?>
                                                <?php
                                                if(!in_array($reviewer_id, $paper_version_reviewers))
                                                {
                                                    $noReviewer = false;
                                                ?>
                                                    <div class="form-group">
                                                        <option value = <?php echo $reviewer_id ;?>><?php echo $reviewer_id." - ".$reviewer_name;  ?></option>
                                                    </div>
                                                <?php
                                                }
                                                ?>
                                            <?php
                                            }
                                            if($noReviewer)
                                            {
                                            ?>
                                                <option disabled>No reviewers available</option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                        <span class="help-block">Hold Ctrl to select more than one reviewer</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <span class="body-text text-danger">
                                                <?php
                                                if(isset($error1))
                                                    echo $error1;
                                                ?>
                                    </span>
                                </div>
                                <button name = "Form1" value = "Form1" class="btn btn-success"><span class="glyphicon glyphicon-plus"></span>Add</button>
                            </form>
                        </div>
                <?php
                    }
                    else
                        echo "Reviewers not available";
                ?>


                <div>
                    <div class="h2">
                        Your comments
                    </div>
                    <?php

                        foreach($comments as $index => $comment)
                        {
                            if($comment -> paper_version_review)
                                echo "<h4>".$comment -> paper_version_review."</h4>";
                            else
                            {
                    ?>
                                <form class="form-horizontal" enctype="multipart/form-data" method = "post">
                                    <div class="form-group">
                                        <label for="comments" class="col-sm-2 control-label">Upload Comments file(.doc,.docx,pdf)</label>
                                        <div class="col-sm-9">
                                            <input type="file" name = "comments" class="form-control" id="comments" placeholder="Choose File">
                                        </div>
                                        <div class="col-sm-8 col-sm-offset-4 text-danger h5" id="errorText">
                                            <?php
                                            echo form_error('comments');
                                            if(isset($uploadError)) echo $uploadError;
                                            ?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="comments" class="col-sm-2 control-label">Comments</label>
                                        <div class="col-sm-8">
                                            <textarea name = 'comments' id="comments" rows="5" class="form-control"></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="reviewResult" class="col-sm-2 control-label">Review Result</label>
                                        <div class="col-sm-8">
                                            <select id="salutation" name="review_result" class="form-control">
                                            <?php
                                                foreach($review_results as $review_result)
                                                {
                                            ?>

                                            <option value = "<?php echo $review_result -> review_result_id ?>"><?php echo $review_result -> review_result_type_name ?></option>

                                            <?php
                                                }
                                            ?>


                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-offset-2 col-sm-10">
                                            <button name = "Form2" value = "Form2" class="btn btn-primary">Send to Author</button>
                                        </div>
                                    </div>


                                    <span class="body-text text-danger">
                                        <?php
                                        if(isset($error2))
                                            echo $error2;
                                        ?>
                                    </span>
                                </form>
                    <?php
                            }
                        }
                    ?>

                    <a href = "/<?php echo BASEURL; ?>index.php/FinalPaperReviewer" > View papers assigned</a>
                </div>
            </div>
        </div>
    </div>
</div>