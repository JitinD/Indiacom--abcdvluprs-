<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12 col-md-12">
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
                    <span class="h2">Review: </span>
                </div>

                <div>
                    <?php
                        if($review->paper_version_review_comments != null)
                        {
                        ?>
                            <b>Your comments: </b><?php echo $review->paper_version_review_comments; ?>
                            <b><a href="/<?php echo $review->paper_version_review_comments_file_path; ?>">Comments File</a></b>
                        <?php
                        }
                        else
                        {
                            ?>
                            <form class="form-horizontal" enctype="multipart/form-data" method = "post">
                                <div class="form-group">
                                    <label for="comments" class="col-sm-2 control-label">Upload Comments file(.doc,.docx,pdf)</label>
                                    <div class="col-sm-9">
                                        <input type="file" name="commentsFile" class="form-control" id="commentsFile" placeholder="Choose File">
                                    </div>
                                    <div class="col-sm-8 col-sm-offset-4 text-danger h5" id="errorText">
                                        <?php
                                        echo form_error('commentsFile');
                                        if(isset($uploadError)) echo $uploadError;
                                        ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="comments" class="col-sm-2 control-label">Comments</label>
                                    <div class="col-sm-8">
                                        <textarea name='comments' id="comments" rows="5" class="form-control"></textarea>
                                    </div>
                                    <div class="col-sm-8 col-sm-offset-4 text-danger h5" id="errorText">
                                        <?php
                                        echo form_error('comments');
                                        ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-10">
                                        <button name = "Form2" value = "Form2" class="btn btn-primary">Send to Convener</button>
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
                    ?>
                    <a href = "/<?php echo BASEURL; ?>InitialPaperReviewer" > View papers assigned</a>
                </div>
            </div>
        </div>
    </div>
</div>