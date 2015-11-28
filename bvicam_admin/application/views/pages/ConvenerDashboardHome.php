<div class="col-sm-12 col-md-12 main">
    <!--<h3 class="text-theme">Papers Assigned</h3><br/>-->
    <div>
        <ul class="nav nav-tabs">
            <?php
            $eventNo = 0;
            foreach($events as $event)
            {
            ?>
                <li <?php if($eventNo++ == 0) echo "class=\"active\""; ?>>
                    <a data-toggle="tab" href="#event_<?php echo $event->event_id; ?>">
                        <?php echo $event->event_name; ?>
                    </a>
                </li>
            <?php
            }
            ?>
        </ul>
        <div class="tab-content">
            <?php
            $eventNo = 0;
            foreach($events as $event)
            {
            ?>
                <div id="event_<?php echo $event->event_id; ?>" class="tab-pane fade<?php if($eventNo++ == 0) echo " in active"; ?>">
                    <ul class="nav nav-tabs">
                        <?php
                        $trackNo = 0;
                        if(!isset($tracks[$event->event_id]))
                            $tracks[$event->event_id] = array();
                        foreach($tracks[$event->event_id] as $track)
                        {
                        ?>
                            <li <?php if($trackNo++ ==0) echo "class=\"active\""; ?>>
                                <a href="#track_<?php echo $track->track_id; ?>" data-toggle="tab">
                                    <?php echo "Track {$track->track_number}"; ?>
                                </a>
                            </li>
                        <?php
                        }
                        ?>
                    </ul>
                    <div class="tab-content">
                        <?php
                        if(empty($tracks[$event->event_id]))
                        {
                            echo "No tracks assigned in this event";
                        }
                        ?>
                        <?php
                        $trackNo = 0;
                        foreach($tracks[$event->event_id] as $track)
                        {
                        ?>
                            <div id="<?php echo "track_{$track->track_id}"; ?>" class="tab-pane fade<?php if($trackNo++ == 0) echo " in active"; ?>">
                                <ul class="nav nav-tabs">
                                    <li class="active">
                                        <a href="#NRA_<?php echo $track->track_id; ?>" data-toggle="tab">
                                            No Reviewer Assigned
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#PR_<?php echo $track->track_id; ?>" data-toggle="tab">
                                            Pending Reviews
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#PRR_<?php echo $track->track_id; ?>" data-toggle="tab">
                                            Pending Reviewer Reviews
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#CR_<?php echo $track->track_id; ?>" data-toggle="tab">
                                            Completed Reviews
                                        </a>
                                    </li>
                                </ul>
                                <div class="tab-content">
                                    <!-- No reviewers assigned tab -->
                                    <div id="NRA_<?php echo $track->track_id; ?>" class="tab-pane fade in active">
                                        <table class="table table-hover table-striped body-text">
                                            <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Paper ID</th>
                                                <th>Paper Title</th>
                                                <th>Version</th>
                                                <th>Submission Date</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            if(empty($no_reviewer_papers[$track->track_id]))
                                            {
                                            ?>
                                                <tr>
                                                    <td colspan="5">
                                                        No papers without reviewers assigned.
                                                    </td>
                                                </tr>
                                            <?php
                                            }
                                            else
                                            {
                                                foreach($no_reviewer_papers[$track->track_id] as $index=>$paper)
                                                {
                                                    if($paper->paper_version_review_result_id == null)
                                                    {
                                                    ?>
                                                        <tr>
                                                            <td><?php echo $index+1; ?></td>
                                                            <td><?php echo $paper->paper_code; ?></td>
                                                            <td><a target="new" href="/<?php echo BASEURL; ?>FinalPaperReviewer/paperInfo/<?php echo $paper->paper_version_id; ?>"><?php echo $paper->paper_title; ?></a></td>
                                                            <td><?php echo $paper->paper_version_number; ?></td>
                                                            <td><?php echo $paper->paper_version_date_of_submission; ?></td>
                                                        </tr>
                                                    <?php
                                                    }
                                                }
                                            }
                                            ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- Pending convener reviews tab -->
                                    <div id="PR_<?php echo $track->track_id; ?>" class="tab-pane fade">
                                        <table class="table table-hover table-striped body-text">
                                            <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Paper ID</th>
                                                <th>Title</th>
                                                <th>Version number</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            if(empty($reviewed_papers[$track->track_id]))
                                            {
                                            ?>
                                                <tr>
                                                    <td colspan="5">
                                                        No papers reviewed by reviewers.
                                                    </td>
                                                </tr>
                                            <?php
                                            }
                                            else
                                            {
                                                foreach($reviewed_papers[$track->track_id] as $index=>$paper)
                                                {
                                                ?>
                                                    <tr>
                                                        <td><?php echo $index+1; ?></td>
                                                        <td><?php echo $paper->paper_code; ?></td>
                                                        <td><a target="new" href="/<?php echo BASEURL; ?>FinalPaperReviewer/paperInfo/<?php echo $paper->paper_version_id; ?>"><?php echo $paper->paper_title; ?></a></td>
                                                        <td><?php echo $paper->paper_version_number; ?></td>
                                                    </tr>
                                                <?php
                                                }
                                            }
                                            ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- Pending reviewer reviews tab -->
                                    <div id="PRR_<?php echo $track->track_id; ?>" class="tab-pane fade">
                                        <table class="table table-hover table-striped body-text">
                                            <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Paper ID</th>
                                                <th>Title</th>
                                                <th>Review Stage</th>
                                                <th>Version number</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            if(empty($not_reviewed_papers[$track->track_id]))
                                            {
                                            ?>
                                                <tr>
                                                    <td colspan="5">
                                                        No papers with pending reviewer reviews.
                                                    </td>
                                                </tr>
                                            <?php
                                            }
                                            else
                                            {
                                                foreach($not_reviewed_papers[$track->track_id] as $index=>$paper)
                                                {
                                                ?>
                                                    <tr>
                                                        <td><?php echo $index+1; ?></td>
                                                        <td><?php echo $paper->paper_code; ?></td>
                                                        <td><a target="new" href="/<?php echo BASEURL; ?>FinalPaperReviewer/paperInfo/<?php echo $paper->paper_version_id; ?>"><?php echo $paper->paper_title; ?></a></td>
                                                        <td><?php echo $paper->paper_version_review_stage; ?></td>
                                                        <td><?php echo $paper->paper_version_number; ?></td>
                                                    </tr>
                                                <?php
                                                }
                                            }
                                            ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- Completed reviews tab -->
                                    <div id="CR_<?php echo $track->track_id; ?>" class="tab-pane fade">
                                        <table class="table table-hover table-striped body-text">
                                            <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Paper ID</th>
                                                <th>Title</th>
                                                <th>Version number</th>
                                                <th>Review Status</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            if(empty($convener_reviewed_papers[$track->track_id]))
                                            {
                                            ?>
                                                <tr>
                                                    <td colspan="5">
                                                        No papers with reviews sent to author.
                                                    </td>
                                                </tr>
                                            <?php
                                            }
                                            else
                                            {
                                                foreach($convener_reviewed_papers[$track->track_id] as $index=>$paper)
                                                {
                                                ?>
                                                    <tr>
                                                        <td><?php echo $index+1; ?></td>
                                                        <td><?php echo $paper->paper_code; ?></td>
                                                        <td><a target="new" href="/<?php echo BASEURL; ?>FinalPaperReviewer/paperInfo/<?php echo $paper->paper_version_id; ?>"><?php echo $paper->paper_title; ?></a></td>
                                                        <td><?php echo $paper->paper_version_number; ?></td>
                                                        <td><?php echo $reviewResultTypes[$paper->paper_version_review_result_id]; ?></td>
                                                    </tr>
                                                <?php
                                                }
                                            }
                                            ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                </div>
            <?php
            }
            ?>
        </div>
    </div>
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
