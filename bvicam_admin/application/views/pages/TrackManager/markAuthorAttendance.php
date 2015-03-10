<?php
/**
 * Created by PhpStorm.
 * User: Pavithra
 * Date: 2/28/15
 * Time: 7:53 PM
 */
/*print_r($papersInfo);*/
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
    <?php
    if (isset($memberId) && $memberId)
    {
    ?>
    <h3 class="text-center Info">Member Profile</h3>
    <div class="row Info">

        <div class="col-md-6">
            <table class="table table-condensed">
                <tbody>
                <tr>
                    <td>
                        Member ID
                    </td>
                    <td>
                        <strong><?php echo $memberDetails['member_id']; ?></strong>
                    </td>
                </tr>
                <tr>
                    <td>
                        Member Name
                    </td>
                    <td class="text-capitalize">
                        <strong><?php echo $memberDetails['member_name']; ?></strong>
                    </td>
                </tr>

                </tbody>
            </table>

        </div>

        <form id="attendanceForm" class="form-horizontal" enctype="multipart/form-data" method="post">
            <?php
            $validDiscounts = array();
            foreach($discounts as $discount)
            {
                if(is_array($discount))
                {
                    foreach($discount as $paperId => $paperDiscount)
                    {
                        $validDiscounts['paperSpecific'][$paperDiscount->discount_type_payhead][$paperId][] = $paperDiscount;
                    }
                }
                else
                {
                    $validDiscounts['global'][$discount->discount_type_payhead][] = $discount;
                }
            }
            ?>
            <table class="table table-condensed">
                <?php if (isset($papers)) {
                    ?>
                    <thead>
                    <tr>
                        <th>Member ID</th>
                        <th>Member Name</th>
                        <th>Paper Code</th>
                        <th>Paper Title</th>
                        <th>Attendance on Desk</th>
                        <th>Pending amount</th>
                        <th>Select Payable</th>
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
                            <td colspan="16" class="text-center">
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
                                <td>
                                    <?php echo $paper->member_name; ?>
                                </td>
                                <td data-submission_id="<?php echo $paper->submission_id; ?>"
                                    class="submission_id"><?php echo $paper->paper_code; ?></td>

                                <td><?php echo $paper->paper_title; ?></td>

                                <?php
                                    if(isset($attendance[$paper->paper_id]['is_present_on_desk']) && $attendance[$paper->paper_id]['is_present_on_desk'])
                                    {
                                        $present = 1;
                                ?>
                                        <td class = "deskAttendance" data-value = 1>Present</td>
                                <?php
                                    }
                                    else
                                    {
                                        $present = 0;
                                ?>
                                        <td class = "deskAttendance" data-value = 0>Absent</td>
                                <?php
                                    }
                                ?>
                                <?php
                                $payheads = $papersInfo[$paper->paper_id]['payhead'];
                                $payableClasses = $papersInfo[$paper->paper_id]['payableClass'];
                                foreach($payheads as $index=>$payhead)
                                {
                                    if($payhead->payment_head_name == "BR" || $payhead->payment_head_name == "EP")
                                    {
                                        if(isset($papersInfo[$paper->paper_id]['paid']))
                                        {
                                            $payable = $papersInfo[$paper->paper_id]['payable'][$index];
                                            $payheadId = $payhead->payment_head_id;
                                            $payableClass = $papersInfo[$paper->paper_id]['payableClass'][$index];
                                            $waiveOffAmount = $papersInfo[$paper->paper_id]['waiveOff'][$index];
                                            $paidAmount = $papersInfo[$paper->paper_id]['paid'][$index];
                                            $pendingAmount = $papersInfo[$paper->paper_id]['pending'][$index];
                                        }
                                    }
                                }
                                ?>
                                <td class="pending_amount"
                                    data-pending_amount=" <?php if (isset($papersInfo[$paper->paper_id]['paid'])) echo $pendingAmount; ?>">
                                    <?php
                                    if(isset($papersInfo[$paper->paper_id]['paid']))
                                        echo $pendingAmount;
                                    else
                                        echo "-";
                                    ?>
                                </td>

                                <td>
                                    <?php
                                    if(isset($papersInfo[$paper->paper_id]['payable']))
                                        $payableAmount = $papersInfo[$paper->paper_id]['payable'];
                                    $payHeads = $papersInfo[$paper->paper_id]['payhead'];
                                    $payableClasses = $papersInfo[$paper->paper_id]['payableClass'];
                                    foreach($payHeads as $index=>$paymentHead)
                                    {
                                        if($paymentHead->payment_head_name == "OLPC")
                                            continue;
                                        if(
                                            (
                                                isset($validDiscounts['paperSpecific'][$paymentHead->payment_head_id][$paper->paper_id])
                                                || isset($validDiscounts['global'][$paymentHead->payment_head_id])
                                                || isset($papersInfo[$paper->paper_id]['discountType'])
                                            ) &&
                                            (
                                                !isset($papersInfo[$paper->paper_id]['paid'])
                                                || isset($papersInfo[$paper->paper_id]['discountType'])
                                            )
                                        )
                                        {
                                            $discountArray = array();
                                            if(isset($papersInfo[$paper->paper_id]['discountType']))
                                                $discountArray[] = $papersInfo[$paper->paper_id]['discountType'];
                                            else
                                            {
                                                if(isset($validDiscounts['global'][$paymentHead->payment_head_id]))
                                                {
                                                    $discountArray[] = $validDiscounts['global'][$paymentHead->payment_head_id];
                                                }
                                                if(isset($validDiscounts['paperSpecific'][$paymentHead->payment_head_id][$paper->paper_id]))
                                                {
                                                    $discountArray[] = $validDiscounts['paperSpecific'][$paymentHead->payment_head_id][$paper->paper_id];
                                                }
                                            }
                                            foreach($discountArray as $discounts_)
                                            {
                                                foreach($discounts_ as $discount)
                                                {
                                                    if(isset($papersInfo[$paper->paper_id]['paid']))
                                                    {
                                                        $payableAmount = $payable;
                                                        $pendingAmount = $pendingAmount;
                                                    }
                                                    else
                                                    {
                                                        $payableAmount = $payableClasses[$index]->payable_class_amount - ($discount->discount_type_amount * $payableClasses[$index]->payable_class_amount);
                                                        $pendingAmount = $payableClasses[$index]->payable_class_amount - ($discount->discount_type_amount * $payableClasses[$index]->payable_class_amount);
                                                    }
                                                    ?>
                                                    <input type="radio" class="radio"
                                                           name="<?php echo $paper->submission_id; ?>_payheadAndDiscount"
                                                           value="<?php echo $paymentHead->payment_head_name."_".$discount->discount_type_id; ?>"
                                                           data-payable="<?php echo $payableAmount; ?>"
                                                           data-pending="<?php echo $pendingAmount; ?>"
                                                           data-payheadId="<?php echo $payableClasses[$index]->payable_class_payhead_id; ?>"
                                                        <?php
                                                        if (isset($papersInfo[$paper->paper_id]['paid']) && $pendingAmount <= 0)
                                                            echo "disabled";
                                                        if(isset($papersInfo[$paper->paper_id]['paid']))
                                                            echo " checked";
                                                        ?>>
                                                    <?php echo $paymentHead->payment_head_name." with ".$discount->discount_type_name; ?>
                                                <?php
                                                }
                                            }
                                        }
                                        else
                                        {
                                            ?>
                                            <input type="radio" class="radio"
                                                   name="<?php echo $paper->submission_id; ?>_payheadAndDiscount"
                                                   value="<?php echo $paymentHead->payment_head_name ?>"
                                                   data-payable="<?php
                                                   if(isset($papersInfo[$paper->paper_id]['paid']))
                                                       echo $payable;
                                                   else
                                                       echo $payableClasses[$index]->payable_class_amount;
                                                   ?>"
                                                   data-pending="<?php
                                                   if(isset($papersInfo[$paper->paper_id]['paid']))
                                                       echo $pendingAmount;
                                                   else
                                                       echo $payableClasses[$index]->payable_class_amount;
                                                   ?>"
                                                   data-payheadId="<?php echo $payableClasses[$index]->payable_class_payhead_id; ?>"
                                                <?php
                                                if (isset($papersInfo[$paper->paper_id]['paid']) && $pendingAmount <= 0)
                                                    echo "disabled";
                                                if(isset($papersInfo[$paper->paper_id]['paid']))
                                                    echo " checked";
                                                ?>>
                                            <?php echo $paymentHead->payment_head_name; ?>
                                        <?php
                                        }
                                    }
                                    ?>
                                </td>

                                <td>
                                    <select name="attendance_on_track" class="form-control attendance_on_track">
                                        <?php
                                            $attendance_on_track = array("Absent", "Present");
                                            for ($index = 0; $index < 2; $index++)
                                            {
                                        ?>
                                                <option value="<?php echo $index;?>"
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

                                        if ((!isset($certificate[$paper->paper_id]['certificate_outward_number'])) ||
                                            ($certificate[$paper->paper_id]['certificate_outward_number'] == '') ||
                                            (isset($attendance[$paper->paper_id]['is_present_in_hall']) && $attendance[$paper->paper_id]['is_present_in_hall'] == 0) || (!isset($papersInfo[$paper->paper_id]['paid'])) || (isset($papersInfo[$paper->paper_id]['paid']) && $pendingAmount > 0))
                                            echo "disabled ";

                                        if (isset($certificate[$paper->paper_id]['certificate_outward_number']) &&
                                            ($certificate[$paper->paper_id]['certificate_outward_number'] != '') &&
                                            (isset($attendance[$paper->paper_id]['is_present_in_hall']) && $attendance[$paper->paper_id]['is_present_in_hall'] == 1) &&
                                            (isset($certificate[$paper->paper_id]['is_certificate_given']) && ($certificate[$paper->paper_id]['is_certificate_given'] == 1)) && (isset($papersInfo[$paper->paper_id]['paid']) && $pendingAmount <= 0))
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
            ?>
            </table>

        </form>
    </div>

    <?php
    }
    else
    {
        if (isset($memberId))
        {
    ?>
    <div class="Info">
        <div class="alert alert-danger text-center">
            Sorry, Member ID Not Found
        </div>

    </div>
    <?php
        }
    }
    ?>
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
        $(".radio").click(function () {
            /*var payable = $(this).attr("data-payable");
             var payheadId = $(this).attr("data-payheadId");
             $(".payable", $(this).parent().parent()).html(payable);
             $(".payable", $(this).parent().parent()).attr("data-payheadId", payheadId);
             $(".pending_amount", $(this).parent().parent()).html(payable);
             $(".pay_amount input", $(this).parent().parent()).attr("disabled", false);
             $(".pay_amount input", $(this).parent().parent()).attr("max", payable);
             $(".pay_amount input", $(this).parent().parent()).val(payable);*/
            var payable = $(this).attr("data-payable");
            var pending = $(this).attr("data-pending");
            var payheadId = $(this).attr("data-payheadId");
            $(".payable", $(this).parent().parent()).html(payable);
            $(".payable", $(this).parent().parent()).attr("data-payheadId", payheadId);
            $(".pending_amount", $(this).parent().parent()).html(pending);
        });
        $(".certificate_outward_number").change(function () {
            var ref = $(this).parent().parent();
            var ref_td = $(this).parent();
            var submissionId = $('.submission_id', ref).attr('data-submission_id');
            var outwardNumber = $(this).val();
            var attendance = $('.attendance_not_marked', ref).text();
            var deskAttendance = $('.deskAttendance', ref).attr('data-value');
            var trackAttendance = $(".attendance_on_track", ref).val();
            var pendingAmount = $('.pending_amount', ref).html();
            //alert(pendingAmount);
            $.ajax({
                type: "POST",
                url: "/<?php echo BASEURL; ?>index.php/CertificateManager/markOutwardNumber_AJAX",
                data: "submissionId=" + submissionId + "&certificate_outward_no=" + outwardNumber,
                success: function (msg) {
                    if (msg == "true") {
                        $(".attInfo", ref_td).html("Updated");
                        if (outwardNumber == "")
                        {
                            $('.is_certificate_given', ref).prop('checked', false);
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
                        if (pendingAmount > 0)
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
            var pendingAmount = $('.pending_amount').html();
            var submissionId = $('.submission_id', ref).attr('data-submission_id');
            var isPresent = $(this).val();
            //alert(pendingAmount);
            //$('.attInfo', ref_td).html("Updating");
            $.ajax({
                type: "POST",
                url: "/<?php echo BASEURL; ?>index.php/AttendanceManager/markTrackAttendance_AJAX",
                data: "submissionId=" + submissionId + "&isPresent=" + isPresent,
                success: function (msg) {
                    if (msg == "true") {
                        $(".attInfo", ref_td).html("Updated");
                        if (isPresent == 0 || outwardNumber == "" || pendingAmount > 0) {
                            $('.is_certificate_given', ref).attr("disabled", "disabled");
                            $('.is_certificate_given', ref).prop('checked', false);
                            if($('.is_certificate_given').val())
                            {
                                var certificateGiven = 0;
                                $.ajax({
                                    type: "POST",
                                    url: "/<?php echo BASEURL; ?>index.php/CertificateManager/markCertificateGiven_AJAX",
                                    data: "submissionId=" + submissionId + "&is_certificate_given=" + certificateGiven,
                                    success: function (msg) {}
                                });
                            }
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
								$("#matchingMemberRecords").find('tbody').append($('<tr class = "members" style = "cursor: pointer; cursor: hand;">').append($('<td class = "member">').text(value.member_id)).append($('<td>').text(value.member_name)));
                            });
                        }
                    }
                });
            }
            else {
                $('#searchByForm').submit();
            }
        });
            $("#searchByForm").keypress(function (event) {
                if (event.which == 13) 
				{
                    $("#submitButton").click();
                    //event.preventDefault();
					if(event.preventDefault)
						{ event.preventDefault()}
					else
						{event.stop()};

					event.returnValue = false;
					event.stopPropagation();  
                }
            });
			
        $(document).ajaxSuccess(function () {
            $('.members').click(function () {
                var member_id = $('.member', $(this)).text();
                $('#searchValue').val(member_id);
                $("input:radio[value = MemberID]").prop('checked', 'checked');
                //alert($("input[name=searchBy]:checked").val());
                $('#searchByForm').submit();
            });
        });
    });
</script>