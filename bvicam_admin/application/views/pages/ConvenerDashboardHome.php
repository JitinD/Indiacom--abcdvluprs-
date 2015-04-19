<div class="col-sm-12 col-md-12 main">
    <!--<h3 class="text-theme">Papers Assigned</h3><br/>-->
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
                            <a href="#NRA_<?php echo $event->event_id; ?>" data-toggle="tab">
                                No Reviewer Assigned
                            </a>
                        </li>

                        <li>
                            <a href="#PR_<?php echo $event->event_id; ?>" data-toggle="tab">
                                Pending Reviews
                            </a>
                        </li>

                        <li>
                            <a href="#PNR_<?php echo $event->event_id; ?>" data-toggle="tab">
                                Pending Reviewer Reviews
                            </a>
                        </li>
                        <li>
                            <a href="#RS_<?php echo $event->event_id; ?>" data-toggle="tab">
                                Completed Reviews
                            </a>
                        </li>
                    </ul><br/>
                    <div class="tab-content">
                        <div class="tab-pane fade in active" id="NRA_<?php echo $event->event_id; ?>">
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
                                if(empty($no_reviewer_papers[$event->event_id]))
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
                                    foreach($no_reviewer_papers[$event->event_id] as $index=>$paper)
                                    {
                                        ?>
                                        <tr>
                                            <td><?php echo $index+1; ?></td>
                                            <td><?php echo $paper->paper_code; ?></td>
                                            <td><a href="/<?php echo BASEURL; ?>FinalPaperReviewer/paperInfo/<?php echo $paper->paper_version_id; ?>"><?php echo $paper->paper_title; ?></a></td>
                                            <td><?php echo $paper->paper_version_number; ?></td>
                                        </tr>
                                    <?php
                                    }
                                }
                                ?>
                                </tbody>
                            </table>
                        </div>

                        <div class="tab-pane fade" id="PR_<?php echo $event->event_id; ?>">

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

                                if(empty($reviewed_papers[$event->event_id]))
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
                                    foreach($reviewed_papers[$event->event_id] as $index=>$paper)
                                    {
                                        ?>
                                        <tr>
                                            <td><?php echo $index+1; ?></td>
                                            <td><?php echo $paper->paper_code; ?></td>
                                            <td><a href="/<?php echo BASEURL; ?>FinalPaperReviewer/paperInfo/<?php echo $paper->paper_version_id; ?>"><?php echo $paper->paper_title; ?></a></td>
                                            <td><?php echo $paper->paper_version_number; ?></td>
                                        </tr>
                                    <?php

                                    }
                                }
                                ?>
                                </tbody>

                            </table>


                        </div>

                        <div class="tab-pane fade" id="PNR_<?php echo $event->event_id; ?>">
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
                                if(empty($not_reviewed_papers[$event->event_id]))
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
                                    foreach($not_reviewed_papers[$event->event_id] as $index=>$paper)
                                    {
                                        ?>
                                        <tr>
                                            <td><?php echo $index+1; ?></td>
                                            <td><?php echo $paper->paper_code; ?></td>
                                            <td><a href="/<?php echo BASEURL; ?>FinalPaperReviewer/paperInfo/<?php echo $paper->paper_version_id; ?>"><?php echo $paper->paper_title; ?></a></td>
                                            <td><?php echo $paper->paper_version_number; ?></td>
                                        </tr>
                                    <?php

                                    }
                                }
                                ?>
                                </tbody>
                            </table>
                        </div>

                        <div class="tab-pane fade" id="RS_<?php echo $event->event_id; ?>">
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
                                if(empty($convener_reviewed_papers[$event->event_id]))
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
                                    foreach($convener_reviewed_papers[$event->event_id] as $index=>$paper)
                                    {
                                        ?>
                                        <tr>
                                            <td><?php echo $index+1; ?></td>
                                            <td><?php echo $paper->paper_code; ?></td>
                                            <td><a href="/<?php echo BASEURL; ?>FinalPaperReviewer/paperInfo/<?php echo $paper->paper_version_id; ?>"><?php echo $paper->paper_title; ?></a></td>
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
