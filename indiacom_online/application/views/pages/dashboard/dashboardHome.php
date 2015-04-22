<div class="col-lg-10 col-md-9 col-sm-9 col-xs-12">
    <h3 class="text-theme">Paper Status</h3>
    <hr>
<!--    <table class="table table-striped">-->
<!--        --><?php
//        if (empty($events)) {
//            ?>
<!--            <tr>-->
<!--                <td colspan="2">-->
<!--                    No active events!-->
<!--                </td>-->
<!--            </tr>-->
<!--        --><?php
//        }
//        foreach ($events as $event) {
//            ?>
<!--            <thead>-->
<!--            <tr>-->
<!--                <th>Event</th>-->
<!--                <th>Submitted Papers</th>-->
<!--            </tr>-->
<!--            </thead>-->
<!--            <tbody>-->
<!--            <tr>-->
<!--                <td>--><?php //echo $event->event_name; ?><!--</td>-->
<!--                <td>-->
<!--                    <table class="table table-hover table-striped">-->
<!--                        <thead>-->
<!--                        <tr>-->
<!--                            <th>#</th>-->
<!--                            <th>Paper Code</th>-->
<!--                            <th>Title</th>-->
<!--                            <th>Latest Version</th>-->
<!--                            <th>Version Status</th>-->
<!--                        </tr>-->
<!--                        </thead>-->
<!--                        <tbody>-->
<!--                        --><?php
//                        if (empty($papers[$event->event_id])) {
//                            ?>
<!--                            <tr>-->
<!--                                <td colspan="5">-->
<!--                                    You haven't submitted any papers yet. <a-->
<!--                                        href="/--><?php //echo BASEURL; ?><!--Dashboard/submitPaper">Click here</a> to submit a-->
<!--                                    new paper.-->
<!--                                </td>-->
<!--                            </tr>-->
<!--                        --><?php
//                        }
//                        ?>
<!--                        --><?php
//                        foreach ($papers[$event->event_id] as $index => $paper) {
//                            ?>
<!--                            <tr style="cursor: pointer;"-->
<!--                                href="/--><?php //echo BASEURL; ?><!--Dashboard/paperInfo/--><?php //echo $paper->paper_id; ?><!--">-->
<!--                                <td>--><?php //echo $index + 1; ?><!--</td>-->
<!--                                <td>--><?php //echo $paper->paper_code; ?><!--</td>-->
<!--                                <td>--><?php //echo $paper->paper_title; ?><!--</td>-->
<!--                                <td>--><?php //echo $paper->latest_paper_version_number; ?><!--</td>-->
<!--                                <td>-->
<!--                                    --><?php
//                                    if ($paper->review_result_type_name == null) {
//                                        if ($paper->paper_version_is_reviewer_assigned == '0') {
//                                            echo "Not yet reviewed";
//                                        } else if ($paper->paper_version_review_date == null) {
//                                            echo "Under Review";
//                                        }
//                                    } else
//                                        echo $paper->review_result_type_name;
//                                    ?>
<!--                                </td>-->
<!--                            </tr>-->
<!--                        --><?php
//                        }
//                        ?>
<!--                        </tbody>-->
<!--                    </table>-->
<!--                </td>-->
<!--            </tr>-->
<!--            </tbody>-->
<!--        --><?php
//        }
//        ?>
<!--    </table>-->
    <div class="col-md-12">
        <?php
        if (empty($events)) {
            ?>
            No active events!
        <?php
        }
        foreach ($events as $event) {
            ?>

            <h4><?php echo $event->event_name; ?></h4>
            <table class="table table-hover table-striped">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Paper Code</th>
                    <th>Title</th>
                    <th>Latest Version</th>
                    <th>Version Status</th>
                </tr>
                </thead>
                <tbody>
                <?php
                if (empty($papers[$event->event_id])) {
                    ?>
                    <tr>
                        <td colspan="5">
                            You haven't submitted any papers yet. <a
                                href="/<?php echo BASEURL; ?>Dashboard/submitPaper">Click
                                here</a> to submit a new paper.
                        </td>
                    </tr>
                <?php
                }
                ?>
                <?php
                foreach ($papers[$event->event_id] as $index => $paper) {
                    ?>
                    <tr style="cursor: pointer;"
                        href="/<?php echo BASEURL; ?>Dashboard/paperInfo/<?php echo $paper->paper_id; ?>">
                        <td><?php echo $index + 1; ?></td>
                        <td><?php echo $paper->paper_code; ?></td>
                        <td><?php echo $paper->paper_title; ?></td>
                        <td><?php echo $paper->latest_paper_version_number; ?></td>
                        <td>
                            <?php
                            if ($paper->review_result_type_name == null) {
                                if ($paper->paper_version_is_reviewer_assigned == '0') {
                                    echo "Not yet reviewed";
                                } else if ($paper->paper_version_review_date == null) {
                                    echo "Under Review";
                                }
                            } else
                                echo $paper->review_result_type_name;
                            ?>
                        </td>
                    </tr>
                <?php
                }
                ?>
                </tbody>
            </table>
            <hr>
        <?php
        }
        ?>
    </div>
</div>
<div class="col-lg-2 col-md-3 col-sm-3 col-xs-12">
    <h3 class="text-theme">Profile
        <a href="/<?php echo BASEURL; ?>Dashboard/editProfile" class="btn btn-sm btn-success"><span
                class="glyphicon glyphicon-pencil"></span></a>
    </h3>
    <table class="table table-hover table-responsive table-striped">
        <tbody>
        <tr>
            <td>Name</td>
            <td><?php echo $miniProfile['member_salutation'] . "." . $miniProfile['member_name'] ?></td>
        </tr>
        <tr>
            <td>Member ID</td>
            <td><?php echo $_SESSION[APPID]['member_id'] ?></td>
        </tr>
        <tr>
            <td>Organisation</td>
            <td><?php echo $miniProfile['organization_name'] ?></td>
        </tr>
        <tr>
            <td>Category</td>
            <td><?php echo $miniProfile['member_category_name'] ?></td>
        </tr>

        </tbody>
    </table>
</div>
<script>
    $(document).ready(function () {
        $('tr').on("click", function () {
            if ($(this).attr('href') !== undefined) {
                document.location = $(this).attr('href');
            }
        });
    });
</script>