<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <span class="h2 text-theme">Paper Information</span>
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
                        <td>Version History</td>
                        <td>
                            <table class="table table-striped table-responsive">
                                <th>Version Number</th>
                                <th>Date of submission</th>
                                <th>Version review status</th>
                                <th>Download version</th>
                                <?php
                                foreach($allVersionDetails as $version)
                                {
                                ?>
                                    <tr>
                                        <td>v<?php echo $version->paper_version_number; ?></td>
                                        <td><?php echo $version->paper_version_date_of_submission; ?></td>
                                        <td><?php echo  $version->paper_version_review_result_id != null ?
                                                        $reviewTypes[$version->paper_version_review_result_id] :
                                                        "Not yet reviewed"; ?></td>
                                        <td><a href="<?php echo $version->paper_version_document_path; ?>">Download</a></td>
                                    </tr>
                                <?php
                                }
                                ?>
                                <tr>
                                    <td  colspan="4"><a href="/<?php echo INDIACOM; ?>Dashboard/submitPaperRevision/<?php echo $paperDetails->paper_id; ?>">Add new version</a></td>
                                </tr>
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