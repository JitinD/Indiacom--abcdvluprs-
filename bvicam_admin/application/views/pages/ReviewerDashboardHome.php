<div class="col-sm-12 col-md-12 main">
    <h3 class="text-theme">Papers Assigned</h3>
    <div role="tabpanel">
        <ul class="nav nav-tabs" role="tablist">
            <?php
            foreach($events as $event)
            {
                ?>
                <li class="<?php if(!isset($flag)) {$flag=true; echo "active"; } ?>"
                    role="presentation">
                    <a href="#<?php echo $event->event_id; ?>"
                       data-toggle="tab"
                       role="tab"
                       aria-controls="<?php echo $event->event_id; ?>"
                        >
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
                <div role="tabpanel" class="tab-pane fade<?php if(!isset($flag)) {$flag = true; echo " in active"; } ?>" id="<?php echo $event->event_id; ?>">
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
                    </ul><br/>
                    <div class="tab-content">
                        <div class="tab-pane fade in active" id="PENDING_<?php echo $event->event_id; ?>">
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
                                if(empty($pendingReviews[$event->event_id]))
                                {
                                    ?>
                                    <tr>
                                        <td colspan="5">
                                            No pending reviews.
                                        </td>
                                    </tr>
                                <?php
                                }
                                else
                                {
                                    foreach($pendingReviews[$event->event_id] as $index=>$paper)
                                    {
                                        ?>
                                        <tr>
                                            <td><?php echo $index+1; ?></td>
                                            <td><?php echo $paper->paper_code; ?></td>
                                            <td><a href="/<?php echo BASEURL; ?>InitialPaperReviewer/reviewPaperInfo/<?php echo $paper->paper_version_review_id; ?>"><?php echo $paper->paper_title; ?></a></td>
                                            <td><?php echo $paper->paper_version_number; ?></td>
                                        </tr>
                                    <?php
                                    }
                                }
                                ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane fade" id="COMPLETED_<?php echo $event->event_id; ?>">
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
                                if(empty($completedReviews[$event->event_id]))
                                {
                                    ?>
                                    <tr>
                                        <td colspan="5">
                                            No completed reviews.
                                        </td>
                                    </tr>
                                <?php
                                }
                                else
                                {
                                    foreach($completedReviews[$event->event_id] as $index=>$paper)
                                    {
                                        ?>
                                        <tr>
                                            <td><?php echo $index+1; ?></td>
                                            <td><?php echo $paper->paper_code; ?></td>
                                            <td><a href="/<?php echo BASEURL; ?>InitialPaperReviewer/reviewPaperInfo/<?php echo $paper->paper_version_review_id; ?>"><?php echo $paper->paper_title; ?></a></td>
                                            <td><?php echo $paper->paper_version_number; ?></td>
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
    <!--<table class="table table-hover table-striped body-text">
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
/*        if(empty($papers))
        {
            */?>
            <tr>
                <td colspan="5">
                    No papers assigned yet.
                </td>
            </tr>
        <?php
/*        }
        else
        {
            */?>
            <?php
/*            foreach($papers as $index=>$paper)
            {
                */?>
                <tr>
                    <td><?php /*echo $index+1; */?></td>
                    <td><?php /*echo $paper->paper_code; */?></td>
                    <td><a href="/<?php /*echo BASEURL; */?>InitialPaperReviewer/reviewPaperInfo/<?php /*echo $paper->paper_id."/".$paper->paper_version_review_id; */?>"><?php /*echo $paper->paper_title; */?></a></td>
                    <td ><?php /*echo $paper->paper_version_number; */?></td>
                </tr>
            <?php
/*
            }
        }
        */?>
        </tbody>
    </table>-->
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