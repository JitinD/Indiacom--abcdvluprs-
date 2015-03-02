<?php
/**
 * Created by PhpStorm.
 * User: Pavithra
 * Date: 2/28/15
 * Time: 7:53 PM
 */
?>
<div class="col-sm-12 col-md-12 main">
    <h1 class="page-header">Track Manager</h1>

    <form id="searchByForm" class="form-inline" enctype="multipart/form-data" method="post">
        <label for="searchBy">Search</label>
        <?php
        $search_parameters = array("MemberID", "PaperID", "MemberName");
        ?>
        <div class="btn-group" data-toggle="buttons">
            <?php
            foreach ($search_parameters as $parameter) {
                ?>
                <label class="btn btn-default
                        <?php
                if (isset($parameter) && $parameter == "MemberID")
                    echo "active";
                ?>"
                    >
                    <input type="radio" class="searchBy" name="searchBy" value="<?php echo $parameter; ?>"
                        <?php
                        if (isset($parameter) && $parameter == "MemberID")
                            echo "checked";
                        ?>
                        >
                    <?php echo $parameter; ?>
                </label>
            <?php
            }
            ?>
        </div>
        <div class="input-group">
            <input type="text" class="searchValue form-control" name="searchValue" maxlength="10"
                   value="<?php echo set_value('searchValue'); ?>" id="searchValue"
                   placeholder="Enter Search value">
                    <span class="input-group-btn">
                        <button type="button" id="submitButton" class="btn btn-default"><span
                                class="glyphicon glyphicon-search"></span></button>
                    </span>
        </div>
    </form>
    <hr>
    <div class="row Info">
        <form id="attendanceForm" class="form-horizontal" enctype="multipart/form-data" method="post">
            <table class="table table-condensed">
                <?php if (isset($papers)) {
                    ?>
                    <thead>
                    <tr>
                        <th>Member ID</th>
                        <th>Paper Code</th>
                        <th>Paper Title</th>
                        <th>Attendance on Desk</th>
                        <th>Attendance on Track</th>
                        <th>Certificate Outward Number</th>
                        <th>Certificate Given</th>
                        <th>Track</th>
                        <th>Session</th>
                        <th>Subsession</th>
                        <th>Venue</th>
                        <th>Start Time</th>
                        <th>End Time</th>
                    </tr>
                    </thead>
                    <?php
                    if (empty($papers)) {
                        ?>
                        <tr>
                            <td colspan="9" class="text-center">
                                <div class="alert alert-danger">No Accepted Papers!</div>
                            </td>
                        </tr>
                    <?php
                    } else {
                        foreach ($papers as $paper) {
                            ?>
                            <tr>
                                <td>
                                    <?php echo $paper->submission_member_id; ?>
                                </td>
                                <td data-submission_id="<?php echo $paper->submission_id; ?>"
                                    class="submission_id"><?php echo $paper->paper_code; ?></td>

                                <td><?php echo $paper->paper_title; ?></td>
                                <?php if (isset($attendance[$paper->paper_id]['is_present_on_desk']) && $attendance[$paper->paper_id]['is_present_on_desk'] == 1) {
                                    ?>
                                    <td class = "deskAttendance" data-value = 1>
                                        <?php
                                            echo "Present";
                                        ?>
                                    </td>
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
                                    <td class="attendance_not_marked deskAttendance" data-value = 0><?php $present = 0;
                                        echo "Not marked" ?>
                                    </td>
                                <?php
                                }
                                ?>
                                <td><input type="text" class="certificate_outward_number form-control"
                                           value="<?php if (isset($certificate[$paper->paper_id]['certificate_outward_number'])) {
                                               echo $certificate[$paper->paper_id]['certificate_outward_number'];
                                           }
                                           ?>">

                                    <div class="bg-info attInfo"></div>
                                    <div class="bg-danger attError"></div>
                                <td>
                                    <input type="checkbox" class="is_certificate_given"
                                        <?php

                                        if (!isset($certificate[$paper->paper_id]['certificate_outward_number']) ||
                                            ($certificate[$paper->paper_id]['certificate_outward_number'] == '') ||
                                            (isset($attendance[$paper->paper_id]['is_present_in_hall']) && $attendance[$paper->paper_id]['is_present_in_hall'] == 0) || (isset($present)) && $present == 0
                                        )
                                            echo "disabled ";

                                        if (isset($certificate[$paper->paper_id]['is_certificate_given']) && ($certificate[$paper->paper_id]['is_certificate_given'] == 1))
                                            echo "checked";
                                        ?>
                                    >

                                    <div class="bg-info attInfo"></div>
                                    <div class="bg-danger attError"></div>
                                </td>
                                <td><?php echo $paper->track_id; ?></td>
                                <td><?php echo $paper->session_id; ?></td>
                                <td><?php echo $paper->sub_session_id; ?></td>
                                <td><?php echo $paper->venue; ?></td>
                                <td><?php echo $paper->start_time; ?></td>
                                <td><?php echo $paper->end_time; ?></td>
                            </tr>

                        <?php
                        }
                    }
                }
                else
                {
                ?>
                <div class="Info">
                    <?php
                    if (!isset($memberId)) {
                        echo "<h1>Sorry no such member Id in our database</h1>";
                    }
                    }
                    ?>

            </table>

        </form>
    </div>
</div>
<div id="memberList">
    <table class="table table-responsive table-hover" id="matchingMemberRecords">
        <thead>
        <tr>
            <th>Member ID</th>
            <th>Member Name</th>
        </tr>
        <tbody>
        </tbody>
        </thead>
    </table>
</div>

<script>

    $(document).ready(function () {
        $("#memberList").hide();

        $(".certificate_outward_number").change(function () {
            var ref = $(this).parent().parent();
            var ref_td = $(this).parent();
            var submissionId = $('.submission_id', ref).attr('data-submission_id');
            var outwardNumber = $(this).val();
            var attendance = $('.attendance_not_marked', ref).text();
            var deskAttendance = $('.deskAttendance', ref).attr('data-value');
            var trackAttendance = $(".attendance_on_track", ref).val();

            $.ajax({
                type: "POST",
                url: "/<?php echo BASEURL; ?>index.php/CertificateManager/markOutwardNumber_AJAX",
                data: "submissionId=" + submissionId + "&certificate_outward_no=" + outwardNumber,
                success: function (msg) {
                    if (msg == "true") {
                        $(".attInfo", ref_td).html("Updated");

                        if (outwardNumber == "")
                        {
                            $.ajax({
                                type: "POST",
                                url: "/<?php echo BASEURL; ?>index.php/CertificateManager/removeCertificateRecord_AJAX",
                                data: "submissionId=" + submissionId,
                                success: function (msg) {

                                    if (msg == "true") {
                                        $(".attInfo", ref_td).html("Updated");
                                        $('.is_certificate_given', ref).prop('disabled',true);
                                    }
                                    else {
                                        $(".attInfo", ref_td).html("");
                                        $(".attError", ref_td).html("Could not update");
                                    }
                                }
                            });
                        }
                        else
                            $('.is_certificate_given', ref).prop('checked', false);

                        if (deskAttendance == 0 || trackAttendance == 0)
                            $('.is_certificate_given', ref).attr("disabled", "disabled");
                        else
                            $('.is_certificate_given', ref).removeAttr("disabled");

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
            var ref_td = $(this).parent();
            var submissionId = $('.submission_id', ref).attr('data-submission_id');
            if ($(this).is(":checked")) {
                $(this).val(1);
            }
            else {
                $(this).val(0);
            }

            var certificateGiven = $(this).val();
            //alert(submissionId+" - "+certificateGiven)
            $.ajax({
                type: "POST",
                url: "/<?php echo BASEURL; ?>index.php/CertificateManager/markCertificateGiven_AJAX",
                data: "submissionId=" + submissionId + "&is_certificate_given=" + certificateGiven,
                success: function (msg) {
                    if (msg == "true") {
                        if (certificateGiven == 0) {
                            $(this).val(0);
                        }
                        else {
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
            var outwardNumber = $('.certificate_outward_number', ref).val();

            var submissionId = $('.submission_id', ref).attr('data-submission_id');
            var isPresent = $(this).val();

            //$('.attInfo', ref_td).html("Updating");
            $.ajax({
                type: "POST",
                url: "/<?php echo BASEURL; ?>index.php/AttendanceManager/markTrackAttendance_AJAX",
                data: "submissionId=" + submissionId + "&isPresent=" + isPresent,
                success: function (msg) {
                    if (msg == "true") {
                        $(".attInfo", ref_td).html("Updated");
                        if (isPresent == 0 || outwardNumber == "") {
                            $('.is_certificate_given', ref).attr("disabled", "disabled");
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
        $('#submitButton').click(function () {

            if ($("input[name=searchBy]:checked").val() == "MemberName") {
                $.ajax({
                    type: "POST",
                    url: "/<?php echo BASEURL; ?>index.php/TrackManager/home",
                    data: "searchBy=MemberName&searchValue=" + $('#searchValue').val(),
                    success: function (records) {
                        if (records != null) {
                            $('.Info').hide();
                            $('#memberList').show();
                            $("#matchingMemberRecords").find('tbody').empty();

                            var obj = jQuery.parseJSON(records);

                            $.each(obj, function (key, value) {
                                $("#matchingMemberRecords").find('tbody').append($('<tr>').append($('<td  class = "member" style = "cursor: pointer; cursor: hand;" >').text(value.member_id)).append($('<td>').text(value.member_name)));

                            });

                        }

                    }
                });
            }
            else {
                $('#searchByForm').submit();
            }
        });

            $("#searchByForm").keypress(function (e) {
                if (e.which == 13) {
                    $("#submitButton").click();
                    event.preventDefault();
                }
            });

        $(document).ajaxSuccess(function () {
            $('.member').click(function () {
                var member_id = $(this).text();

                $('#searchValue').val(member_id);
                $("input:radio[value = MemberID]").prop('checked', 'checked');
                //alert($("input[name=searchBy]:checked").val());
                $('#searchByForm').submit();
            });
        });
    });
</script>