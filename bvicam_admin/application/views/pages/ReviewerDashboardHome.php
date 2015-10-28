<div class="col-sm-12 col-md-12 main">
    <h3 class="text-theme">Papers Assigned</h3>
    <div>
        <ul class="nav nav-tabs">
            <?php
            foreach($events as $event)
            {
            ?>
                <li class="<?php if(!isset($flag)) {$flag=true; echo "active"; } ?>">
                    <a href="#event_<?php echo $event->event_id; ?>" data-toggle="tab">
                        <?php echo $event->event_name; ?>
                    </a>
                </li>
            <?php
            }
            ?>
        </ul>

        <div class="tab-content">
            <?php
            unset($flag);
            foreach($events as $event)
            {
            ?>
                <div class="tab-pane fade<?php if(!isset($flag)) {$flag = true; echo " in active"; } ?>" id="event_<?php echo $event->event_id; ?>">
                    <ul class="nav nav-tabs">
                        <li class="active">
                            <a href="#PENDING_<?php echo $event->event_id; ?>" data-toggle="tab">
                                Pending Reviews
                            </a>
                        </li>
                        <li>
                            <a href="#COMPLETED_<?php echo $event->event_id; ?>" data-toggle="tab">
                                Completed Reviews
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <?php
                        $tabs = array("PENDING", "COMPLETED");
                        $tabNo = 0;
                        foreach($tabs as $tab)
                        {
                        ?>
                            <div class="tab-pane fade<?php if($tabNo++ == 0) echo " in active"; ?>" id="<?php echo $tab; ?>_<?php echo $event->event_id; ?>">
                                <ul class="nav nav-tabs">
                                    <?php
                                    $stageNo = 0;
                                    foreach($reviewStages as $reviewStage)
                                    {
                                        ?>
                                        <li <?php if($stageNo++ == 0) echo "class=\"active\""; ?>>
                                            <a href="#<?php echo $tab; ?>_<?php echo $event->event_id; ?>_<?php echo $reviewStage->review_stage_id; ?>" data-toggle="tab">
                                                <?php echo $reviewStage->review_stage_name; ?>
                                            </a>
                                        </li>
                                    <?php
                                    }
                                    ?>
                                </ul>
                                <div class="tab-content">
                                    <?php
                                    $stageNo = 0;
                                    $reviewsArray = $completedReviews;
                                    if($tab == "PENDING")
                                        $reviewsArray = $pendingReviews;
                                    foreach($reviewStages as $reviewStage)
                                    {
                                        ?>
                                        <div class="tab-pane fade<?php if($stageNo++ == 0) echo " in active"; ?>" id="<?php echo $tab; ?>_<?php echo $event->event_id; ?>_<?php echo $reviewStage->review_stage_id; ?>">
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
                                                $noRowsFlag = true;
                                                foreach($reviewsArray[$event->event_id] as $index=>$paper)
                                                {
                                                    if($paper->paper_version_review_stage == $reviewStage->review_stage_id)
                                                    {
                                                        $noRowsFlag = false;
                                                        ?>
                                                        <tr>
                                                            <td><?php echo $index+1; ?></td>
                                                            <td><?php echo $paper->paper_code; ?></td>
                                                            <td><a target="new" href="/<?php echo BASEURL; ?>InitialPaperReviewer/reviewPaperInfo/<?php echo $paper->paper_version_review_id; ?>"><?php echo $paper->paper_title; ?></a></td>
                                                            <td><?php echo $paper->paper_version_number; ?></td>
                                                        </tr>
                                                    <?php
                                                    }
                                                }
                                                if($noRowsFlag)
                                                {
                                                ?>
                                                    <tr>
                                                        <td colspan="4">No reviews</td>
                                                    </tr>
                                                <?php
                                                }
                                                ?>
                                                </tbody>
                                            </table>
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