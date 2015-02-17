<?php
/**
 * Created by PhpStorm.
 * User: Pavithra
 * Date: 2/14/15
 * Time: 10:18 PM
 */
?>
<div style="padding-top: 120px;">
    <form method="post" enctype="multipart/form-data">
        <table class="table">
            <thead>
            <tr>
                <th>Paper Code</th>
                <th>Paper Title</th>
                <th>Attendance on Desk</th>
                <th>Attendance on Track</th>
                <th>Certificate Outward Number</th>
                <th>Certificate Given</th>
            </tr>
            </thead>
            <?php
            foreach ($papers as $paper) {
                ?>
                <tr>
                    <td data-submission_id="<?php echo $paper->submission_id; ?>"
                        class="submission_id"><?php echo $paper->paper_code; ?></td>

                    <td><?php echo $paper->paper_title; ?></td>
                    <?php if (isset($attendance[$paper->paper_id]['is_present_on_desk']) && $attendance[$paper->paper_id]['is_present_on_desk'] == 1) {
                        ?>
                        <td><?php echo "Present" ?></td>
                        <td>
                            <select name="attendance_on_track" class="form-control attendance_on_track">
                                <?php
                                $attendance_on_track = array("Absent", "Present");

                                for ($index = 0; $index < 2; $index++) {
                                    ?>
                                    <option value="<?php echo $index; ?>"
                                        <?php
                                        if (isset($attendance[$paper->paper_id]['is_present_in_hall']) && $attendance[$paper->paper_id]['is_present_in_hall'] == $index)
                                            echo "selected"
                                        ?>>
                                        <?php echo $attendance_on_track[$index]; ?>
                                    </option>
                                <?php
                                }
                                ?>
                            </select>
                            <div class="bg-info attInfo"></div>
                            <div class="bg-danger attError"></div>
                        </td>
                    <?php
                    } else {
                        ?>
                        <td><?php echo "Absent On desk" ?></td>
                        <td><?php echo "Not marked" ?></td>
                    <?php
                    }
                    ?>
                    <td><input type="text" class="certificate_outward_number"
                               value="<?php if (isset($certificate[$paper->paper_id]['certificate_outward_number'])) {
                                   echo $certificate[$paper->paper_id]['certificate_outward_number'];
                               }?>">
                        <div class="bg-info attInfo"></div>
                        <div class="bg-danger attError"></div>
                    <td>
                        <input type="checkbox" class="is_certificate_given"
                            <?php
                            if (!isset($certificate[$paper->paper_id]['certificate_outward_number']) ||
                                $certificate[$paper->paper_id]['certificate_outward_number'] == ''
                            )
                                echo "disabled";

                            if (isset($certificate[$paper->paper_id]['is_certificate_given']) && ($certificate[$paper->paper_id]['is_certificate_given'] == 1))
                                echo "checked";
                            ?>>
                        <div class="bg-info attInfo"></div>
                        <div class="bg-danger attError"></div>
                    </td>
                </tr>

            <?php
            }
            ?>

        </table>
    </form>
    <a href="/<?php echo BASEURL; ?>index.php/TrackManager/MemberDetails">Back</a>
</div>
<script>
    $(document).ready(function () {


        $(".certificate_outward_number").change(function () {
            var ref = $(this).parent().parent();
            var submissionId = $('.submission_id', ref).attr('data-submission_id');
            var outwardNumber = $(this).val();
            $.ajax({
                type: "POST",
                url: "/<?php echo BASEURL; ?>index.php/CertificateManager/markOutwardNumber_AJAX",
                data: "submissionId=" + submissionId + "&certificate_outward_no=" + outwardNumber,
                success: function (msg) {
                    if (msg == "true") {
                        $(".attInfo", ref_td).html("Updated");
                        if (outwardNumber == "") {
                            var certificateGiven = 0;
                            $('.is_certificate_given', ref).attr("disabled", "disabled");
                            $.ajax({
                                type: "POST",
                                url: "/<?php echo BASEURL; ?>index.php/CertificateManager/markCertificateGiven_AJAX",
                                data: "submissionId=" + submissionId + "&is_certificate_given=" + certificateGiven,
                                success: function (msg) {
                                    alert();
                                    if (msg == "true") {
                                        $(".attInfo", ref_td).html("Updated");
                                    }
                                    else {
                                        $(".attInfo", ref_td).html("");
                                        $(".attError", ref_td).html("Could not update");
                                    }
                                }
                            });
                        }
                        else {
                            $('.is_certificate_given', ref).removeAttr("disabled");
                        }
                    }
                    else {
                        $(".attInfo", ref_td).html("");
                        $(".attError", ref_td).html("Could not update");
                    }
                }
            });
        });



        $(".is_certificate_given").click(function () {
            var ref = $(this).parent().parent();
            var submissionId = $('.submission_id', ref).attr('data-submission_id');
            if ($(this).is(":checked")) {
                $(this).val(1);
            }
            else {
                $(this).val(0);
            }
            alert(submissionId + " " + $(this).val());
            var certificateGiven = $(this).val();
            alert(certificateGiven);

            $.ajax({
                type: "POST",
                url: "/<?php echo BASEURL; ?>index.php/CertificateManager/markCertificateGiven_AJAX",
                data: "submissionId=" + submissionId + "&is_certificate_given=" + certificateGiven,
                success: function (msg) {
                    if (msg == "true") {
                        if(certificateGiven==0)
                        {
                            $(this).val(0);
                        }
                        else
                        {
                            $(this).val(1);
                        }
                        $(".attInfo", ref_td).html("Updated");
                    }
                    else {
                        $(".attInfo", ref_td).html("");
                        $(".attError", ref_td).html("Could not update");
                    }
                }
            });
        });


        $(".attendance_on_track").change(function () {
            var ref = $(this).parent().parent();
            var ref_td = $(this).parent();

            var submissionId = $('.submission_id', ref).attr('data-submission_id');
            var isPresent = $(this).val();
            alert(submissionId);
            alert(isPresent);

            //$('.attInfo', ref_td).html("Updating");
            $.ajax({
                type: "POST",
                url: "/<?php echo BASEURL; ?>index.php/AttendanceManager/markTrackAttendance_AJAX",
                data: "submissionId=" + submissionId + "&isPresent=" + isPresent,
                success: function (msg) {
                    if (msg == "true")
                    {
                        $(".attInfo",ref_td).html("Updated");
                        if(isPresent==0)
                        {
                            $('.is_certificate_given', ref).attr("disabled", "disabled");
                        }
                        else
                        {
                            $('.is_certificate_given', ref).removeAttr("disabled");
                        }
                    }

                    else {
                        $(".attInfo",ref_td).html("");
                        $(".attError",ref_td).html("Could not update");
                    }
                }
            });

        });

    });
</script>