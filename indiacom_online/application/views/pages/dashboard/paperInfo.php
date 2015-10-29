<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <span class="h2 text-theme">Paper Information</span>
            <?php
            if(isset($_SESSION[APPID]['messages']))
            {
                foreach($_SESSION[APPID]['messages'] as $key=>$message)
                {
                ?>
                    <div class="alert alert-success alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <?php
                        echo $message;
                        unset($_SESSION[APPID]['messages'][$key]);
                        ?>
                    </div>
                <?php
                }
            }
            ?>
            <div class="row body-text">
                <div class="col-md-12 text-center contentBlock-bottom">
                    <span class="h2" style="text-decoration: underline;">Paper: <?php echo $paperDetails->paper_title; ?></span>
                </div>
                <?php
                if(!isset($invalidAuthorAccess))
                {
                ?>
                <table class="table table-striped table-hover table-responsive">
                    <tr>
                        <td>Paper ID</td>
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
                        <td>Version History</td>
                        <td>
                            <table class="table table-striped table-responsive">
                                <th>Version Number</th>
                                <th>Date of submission</th>
                                <th>Review Status</th>
                                <th>Download Reviewer Comments</th>
                                <th>Download version</th>
                                <th>Compliance report</th>
                                <?php
                                foreach($allVersionDetails as $version)
                                {
                                ?>
                                    <tr>
                                        <td>v<?php echo $version->paper_version_number; ?></td>
                                        <td><?php echo $version->paper_version_date_of_submission; ?></td>
                                        <td>
                                            <?php
                                            if($version->paper_version_review_result_id != null)
                                                echo $reviewTypes[$version->paper_version_review_result_id];
                                            else
                                            {
                                                if(!$canSubmitRevision)
                                                    echo "Under Review";
                                                else
                                                    echo "Yet to be reviewed";
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                            if($version->paper_version_review_date != null)
                                            {
                                            ?>
                                                <a class="btn btn-primary" href="<?php echo "../downloadReviewerComments/{$version->paper_version_id}/{$eventDetails->event_id}"; ?>" target="new">
                                                    <span class="glyphicon glyphicon-cloud-download"></span>
                                                </a>
                                            <?php
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <a class="btn btn-primary" href="<?php echo "../downloadPaperVersion/{$version->paper_version_id}/{$eventDetails->event_id}"; ?>" target="new">
                                                <span class="glyphicon glyphicon-cloud-download"></span>
                                            </a>
                                        </td>
                                        <td>
                                            <?php
                                            if($version->paper_version_compliance_report_path != null)
                                            {
                                            ?>
                                                <a class="btn btn-primary" href="<?php echo "../downloadComplianceReport/{$version->paper_version_id}/{$eventDetails->event_id}"; ?>" target="new">
                                                    <span class="glyphicon glyphicon-cloud-download"></span>
                                                </a>
                                            <?php
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                    <?php
                                    if($version->paper_version_review_date != null)
                                    {
                                    ?>
                                    <tr>
                                        <td></td>
                                        <td>
                                            Comments
                                        </td>
                                        <td colspan="10">
                                            <select multiple class="form-control">
                                                <option disabled>
                                                    <?php echo $version->paper_version_review; ?>
                                                </option>
                                            </select>
                                        </td>
                                    </tr>
                                    <?php
                                    }
                                    ?>
                                <?php
                                }
                                ?>
                                <?php
                                if($canSubmitRevision)
                                {
                                ?>
                                    <tr>
                                        <td  colspan="10">
                                            <a href="/<?php echo BASEURL; ?>Dashboard/submitPaperRevision/<?php echo $paperDetails->paper_id; ?>">Add new version</a>
                                        </td>
                                    </tr>
                                <?php
                                }
                                ?>
                            </table>
                        </td>
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
                            Presentation
                        </td>
                        <td>
                            <a href="">Upload</a>
                            <a href="">Download</a>
                        </td>
                    </tr>


                </table>
                <?php
                }
                else
                {
                ?>
                Unknown Paper Id!
                <?php
                }
                ?>
            </div>
        </div>
    </div>
</div>