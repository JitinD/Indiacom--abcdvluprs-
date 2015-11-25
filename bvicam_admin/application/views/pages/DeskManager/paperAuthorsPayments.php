<?php /*print_r($attendance); */?>

<div class="col-sm-12 col-md-12">
    <div class="row">
        <div class="col-md-12">
            <h1 class="page-header">Desk Manager</h1>
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
                           value="<?php echo set_value('searchValue'); ?>" id="searchValue" placeholder="Enter Search value">
                    <span class="input-group-btn">
                        <button type="button" id="submitButton" class="btn btn-default"><span
                                class="glyphicon glyphicon-search"></span></button>
                    </span>
                </div>
            </form>
        </div>
    </div>
    <hr>
<?php
    if(isset($paperDetails))
    {
?>
    <div class = "Info">
        <h3 class="text-center">Paper Details</h3>
        <div class="col-md-6">
            <table class="table table-condensed table-hover table-responsive">
                <tr>
                    <td>Paper Code</td>
                    <td>
                        <strong>
                            <?php
                            if(isset($paperDetails->paper_code))
                                echo $paperDetails->paper_code; ?>
                        </strong>
                    </td>
                </tr>
                <tr>
                    <td>Paper Title</td>
                    <td>
                        <strong>
                            <?php
                            if(isset($paperDetails->paper_title))
                                echo $paperDetails->paper_title;
                            ?>
                        </strong>
                    </td>
                </tr>
                <tr>
                    <td>Event</td>
                    <td>
                        <strong>
                            <?php
                            if(isset($eventDetails->event_name))
                                echo $eventDetails->event_name;
                            ?>
                        </strong>
                    </td>
                </tr>
                <tr>
                    <td>Track</td>
                    <td>
                        <strong>
                            Track
                            <?php
                            if(isset($trackDetails->track_number) && isset($trackDetails->track_name))
                                echo $trackDetails->track_number . " : " . $trackDetails->track_name;
                            ?>
                        </strong>
                    </td>
                </tr>
                <tr>
                    <td>Subject</td>
                    <td>
                        <strong>
                            <?php
                            if(isset($subjectDetails->subject_name))
                                echo $subjectDetails->subject_name; ?>
                        </strong>
                    </td>
                </tr>
                <tr>
                    <td>Is Paper Registered</td>
                    <td>
                        <strong>
                            <?php
                            if(isset($PaperRegistered))
                                echo $PaperRegistered ? "Yes" : "No";
                            ?>
                        </strong>
                    </td>
                </tr>

            </table>
        </div>
        <div class="col-md-6">
            <a class="btn btn-lg btn-default" href = "<?php echo "/".BASEURL."index.php/DeliverablesManager/assignPaperDeliverables/".$paperDetails -> paper_id; ?>">Assign Deliverables</a>
        </div>
        <hr>
		<div class="col-md-12">
        <table class="table table-striped table-responsive table-condensed">
                <thead>
                    <tr>
                        <th>Member ID</th>
                        <th>Member Name</th>
                        <!--th>Is Member Registered</th-->
                    </tr>
                </thead>
                <tbody>
                <?php
                if(empty($authorsInfo))
                {
                    ?>
                    <tr>
                        <td colspan="8">No members!</td>
                    </tr>
                <?php
                }
                else
                {
                    foreach ($authorsInfo as $authorInfo)
                    {
                        ?>
                        <tr class = "authors" style = "cursor: pointer; cursor: hand;">
                            <td class = "author"><?php echo $authorInfo['member_id']; ?></td>
                            <td><?php echo $authorInfo['member_name']; ?></td>
                        </tr>
                    <?php
                    }

                }
                ?>
                </tbody>
        <?php
/*
            foreach($paper_authors_payables as $author_id => $paperPayables)
            {
        */?><!--
                <tbody>
                    <tr>
                        <td class = "member_id" data-member_id = "<?php /*if(isset($author_id)) echo $author_id; */?>">
                            <?php
/*                                if(isset($author_id))
                                    echo $author_id;
                            */?>
                        </td>
                        <td>
                            <?php
/*                                if(isset($member_id_name_array[$author_id]))
                                    echo $member_id_name_array[$author_id];
                            */?>
                        </td>
                        <td>
                            <?php
/*                            if(isset($isMemberRegistered[$author_id]))
                                echo $isMemberRegistered[$author_id] ? "Yes" : "No";
                            */?>
                        </td>
                        <td>
                            <?php
/*                            $validDiscounts = array();

                            foreach($discounts[$author_id] as $discount)
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
                            */?>
                            <table class = "table table-responsive">
                                <thead>
                                    <tr>
                                        <th>Paper Code</th>
                                        <th>Paper Title</th>
                                        <th>Is Registered</th>
                                        <th>Payable</th>
                                        <th>Waived off</th>
                                        <th>Paid</th>
                                        <th>Pending</th>
                                        <th>Select Payable</th>
                                        <th></th>
                                        <th>Mark attendance</th>
                                        <th>Track</th>
                                        <th>Session</th>
                                        <th>Subsession</th>
                                        <th>Venue</th>
                                        <th>Start Time</th>
                                        <th>End Time</th>
                                    </tr>
                                </thead>

                                <tbody>

                                <?php
/*                                    if(empty($papers[$author_id]))
                                    {
                                        */?>
                                        <tr>
                                            <td colspan="15" class="text-center">
                                                <div class="alert alert-danger">No Accepted Papers!</div>
                                            </td>
                                        </tr>
                                    <?php
/*                                    }
                                    else
                                    {
                                        foreach($papers[$author_id] as $index => $paper)
                                        {
                                            */?>
                                            <tr>
                                                <td class="paper_id" data-paper_id="<?php /*if(isset($paper -> paper_id)) echo $paper->paper_id; */?>"><?php /*if(isset($paper -> paper_code)) echo $paper -> paper_code;*/?></td>
                                                <td class="paper_title">
                                                    <?php
/*                                                        if(isset($paper -> paper_title))
                                                            echo $paper -> paper_title;
                                                    */?>
                                                </td>
                                                <td>
                                                    <?php
/*                                                    if(isset($isPaperRegistered[$paper->paper_id]))
                                                    {
                                                        if($isPaperRegistered[$paper->paper_id])
                                                            echo "Yes";
                                                        else
                                                            echo "No";
                                                    }
                                                    else
                                                        echo "-";
                                                    */?>
                                                </td>
                                                <?php
/*                                                $payheads = $paperPayables[$paper->paper_id]['payhead'];
                                                $payableClasses = $paperPayables[$paper->paper_id]['payableClass'];
                                                foreach($payheads as $index=>$payhead)
                                                {
                                                    if($payhead->payment_head_name == "BR" || $payhead->payment_head_name == "EP")
                                                    {
                                                        if(isset($paperPayables[$paper->paper_id]['paid']))
                                                        {
                                                            $payable = $paperPayables[$paper->paper_id]['payable'][$index];
                                                            $payheadId = $payhead->payment_head_id;
                                                            $payableClass = $paperPayables[$paper->paper_id]['payableClass'][$index];
                                                            $waiveOffAmount = $paperPayables[$paper->paper_id]['waiveOff'][$index];
                                                            $paidAmount = $paperPayables[$paper->paper_id]['paid'][$index];
                                                            $pendingAmount = $paperPayables[$paper->paper_id]['pending'][$index];
                                                        }
                                                    }
                                                }
                                                */?>
                                                <td class="payable"><?php
/*                                                    if(isset($paperPayables[$paper->paper_id]['paid']))
                                                        echo $payable;
                                                */?></td>
                                                <td class="waive_off">
                                                    <?php
/*                                                    if(isset($paperPayables[$paper->paper_id]['paid']))
                                                        echo $waiveOffAmount;
                                                    else
                                                        echo 0;
                                                    */?>
                                                </td>
                                                <td class="paid">
                                                    <?php
/*                                                    if (isset($paperPayables[$paper->paper_id]['paid']))
                                                        echo $paidAmount;
                                                    else
                                                        echo 0;
                                                    */?>
                                                </td>
                                                <td class="pending">
                                                    <?php
/*                                                    if(isset($paperPayables[$paper->paper_id]['paid']))
                                                        echo $pendingAmount;
                                                    else
                                                        echo "-";
                                                    */?>
                                                </td>

                                                <td class="payhead_discount">
                                                    <?php
/*                                                    if(isset($paperPayables[$paper->paper_id]['payable']))
                                                        $payableAmount = $paperPayables[$paper->paper_id]['payable'];
                                                    $payHeads = $paperPayables[$paper->paper_id]['payhead'];
                                                    $payableClasses = $paperPayables[$paper->paper_id]['payableClass'];
                                                    foreach($payHeads as $index=>$paymentHead)
                                                    {
                                                        if($paymentHead->payment_head_name == "OLPC")
                                                            continue;
                                                        if(
                                                            (
                                                                isset($validDiscounts['paperSpecific'][$paymentHead->payment_head_id][$paper->paper_id])
                                                                || isset($validDiscounts['global'][$paymentHead->payment_head_id])
                                                                || isset($paperPayables[$paper->paper_id]['discountType'])
                                                            ) &&
                                                            (
                                                                !isset($paperPayables[$paper->paper_id]['paid'])
                                                                || isset($paperPayables[$paper->paper_id]['discountType'])
                                                            )

                                                        )
                                                        {
                                                            $discountArray = array();
                                                            if(isset($paperPayables[$paper->paper_id]['discountType']))
                                                                $discountArray[] = $paperPayables[$paper->paper_id]['discountType'];
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
                                                                    if(isset($paperPayables[$paper->paper_id]['paid']))
                                                                    {
                                                                        $payableAmount = $payable;
                                                                        $pendingAmount = $pendingAmount;
                                                                    }
                                                                    else
                                                                    {
                                                                        $payableAmount = $payableClasses[$index]->payable_class_amount - ($discount->discount_type_amount * $payableClasses[$index]->payable_class_amount);
                                                                        $pendingAmount = $payableClasses[$index]->payable_class_amount - ($discount->discount_type_amount * $payableClasses[$index]->payable_class_amount);
                                                                    }
                                                                    */?>
                                                                    <input type="radio" class="radio"
                                                                           name="<?php /*echo $paper->submission_id; */?>_payheadAndDiscount"
                                                                           value="<?php /*echo $paymentHead->payment_head_name."_".$discount->discount_type_id; */?>"
                                                                           data-payable="<?php /*echo $payableAmount; */?>"
                                                                           data-pending="<?php /*echo $pendingAmount; */?>"
                                                                           data-payheadId="<?php /*echo $payableClasses[$index]->payable_class_payhead_id; */?>"
                                                                           data-discountTypeId="<?php /*echo $discount->discount_type_id; */?>"
                                                                        <?php
/*                                                                        if (isset($paperPayables[$paper->paper_id]['paid']) && $pendingAmount <= 0)
                                                                            echo "disabled";
                                                                        if(isset($paperPayables[$paper->paper_id]['paid']))
                                                                            echo " checked";
                                                                        */?>>
                                                                    <?php /*echo $paymentHead->payment_head_name." with ".$discount->discount_type_name; */?>
                                                                <?php
/*                                                                }
                                                            }
                                                        }
                                                        else
                                                        {
                                                            */?>
                                                            <input type="radio" class="radio"
                                                                   name="<?php /*echo $paper->submission_id; */?>_payheadAndDiscount"
                                                                   value="<?php /*echo $paymentHead->payment_head_name */?>"
                                                                   data-payable="<?php
/*                                                                   if(isset($paperPayables[$paper->paper_id]['paid']))
                                                                       echo $payable;
                                                                   else
                                                                       echo $payableClasses[$index]->payable_class_amount;
                                                                   */?>"
                                                                   data-pending="<?php
/*                                                                   if(isset($paperPayables[$paper->paper_id]['paid']))
                                                                       echo $pendingAmount;
                                                                   else
                                                                       echo $payableClasses[$index]->payable_class_amount;
                                                                   */?>"
                                                                   data-payheadId="<?php /*echo $payableClasses[$index]->payable_class_payhead_id; */?>"
                                                                <?php
/*                                                                if (isset($paperPayables[$paper->paper_id]['paid']) && $pendingAmount <= 0)
                                                                    echo "disabled";
                                                                if(isset($paperPayables[$paper->paper_id]['paid']))
                                                                    echo " checked";
                                                                */?>>
                                                            <?php /*echo $paymentHead->payment_head_name; */?>
                                                        <?php
/*                                                        }
                                                    }
                                                    */?>
                                                </td>
                                                <td>
                                                    <button class="btn btn-default waiveOffBut"
                                                            data-memberId="<?php /*echo $author_id; */?>"
                                                            data-paperId="<?php /*echo $paper->paper_id; */?>">
                                                        Waive Off
                                                    </button>
                                                    <div class="bg-info"></div>
                                                    <div class="bg-danger"></div>
                                                </td>
                                                <td>
                                                    <select name = "attendance_on_desk" class="form-control attendance_on_desk"
                                                        <?php
/*                                                        if((!isset($paperPayables[$paper->paper_id]['paid'])) || (isset($paperPayables[$paper->paper_id]['paid']) && $pendingAmount > 0))//(isset($paperPayables[$paper -> paper_id]['pending']) && $paperPayables[$paper -> paper_id]['pending'] != 0)
                                                            echo "disabled";
                                                        */?>
                                                    >
                                                        <?php
/*                                                        $attendance_on_desk = array("Absent", "Present");

                                                        for($index = 0; $index < 2; $index++)
                                                        {
                                                        */?>
                                                            <option value = "<?php /*echo $index; */?>"
                                                                <?php
/*                                                                if (isset($attendance[$paper->submission_id]['is_present_on_desk']) && $attendance[$paper->submission_id]['is_present_on_desk'] == $index)
                                                                    echo "selected"
                                                                */?>>
                                                                <?php /*echo $attendance_on_desk[$index]; */?>
                                                            </option>
                                                        <?php
/*                                                        }
                                                        */?>
                                                    </select>
                                                    <div class="bg-info attInfo"></div>
                                                    <div class="bg-danger attError"></div>
                                                </td>
                                                <td><?php /*echo $paper->track_id; */?></td>
                                                <td><?php /*echo $paper->session_id; */?></td>
                                                <td><?php /*echo $paper->sub_session_id; */?></td>
                                                <td><?php /*echo $paper->venue; */?></td>
                                                <td><?php /*echo $paper->start_time; */?></td>
                                                <td><?php /*echo $paper->end_time; */?></td>
                                            </tr>
                                        <?php
/*                                        }
                                    }
                                */?>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                </tbody>
        --><?php
/*            }
        */?>
        </table>
		</div>
    </div>
</div>

<?php
}
else
{
?>
<div class = "Info">
    <?php
        if(isset($paperId))
        {
    ?>
            <div class="alert alert-danger text-center">Sorry, PaperID Not Found</div>
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

        $('#memberList').hide();

        $(".radio").click(function()
        {
            var payable = $(this).attr("data-payable");
            var pending = $(this).attr("data-pending");
            var payheadId = $(this).attr("data-payheadId");
            $(".payable", $(this).parent().parent()).html(payable);
            $(".payable", $(this).parent().parent()).attr("data-payheadId", payheadId);
            $(".pending", $(this).parent().parent()).html(pending);
        });

        $(".attendance_on_desk").change(function () {

            var ref_member = $(this).parent().parent().parent().parent().parent().parent();
            var ref_paper = $(this).parent().parent();
            var ref_td = $(this).parent();

            var memberId = $('.member_id',ref_member).attr('data-member_id');
            var paperId = $('.paper_id', ref_paper).attr('data-paper_id');
            var isPresent = $(this).val();

            $('.attInfo', ref_td).html("Updating");


            $.ajax({
                type: "POST",
                url: "/<?php echo BASEURL; ?>index.php/AttendanceManager/markDeskAttendance_AJAX",
                data: "memberId=" + memberId + "&paperId=" + paperId + "&isPresent=" + isPresent,
                success: function(msg)
                {
                    if(msg == "true")
                        $(".attInfo", ref_td).html("Updated");
                    else
                    {
                        $(".attInfo", ref_td).html("");
                        $(".attError", ref_td).html("Could not update");
                    }
                }
            });

        });

        $(".waiveOffBut").click(function() {
            var memberId = $(this).attr("data-memberId");
            var paperId = $(this).attr("data-paperId");
            var ref = $(this).parent().parent();
            var butRef = $(this);
            var payheadId = $(".payhead_discount input[type='radio']:checked", ref).attr("data-payheadId");
            var discountTypeId = $(".payhead_discount input[type='radio']:checked", ref).attr("data-discountTypeId");
            var amount = $(".pending", ref).text();
            if(payheadId != null)
            {
                var data = "payheadId=" + payheadId + "&amount=" + amount + "&memberId=" + memberId;
                if(paperId != null)
                    data += "&paperId=" + paperId;
                if(discountTypeId != null)
                    data += "&discountType=" + discountTypeId
                $(".bg-danger", $(butRef).parent()).html("");
                $(".bg-info", $(butRef).parent()).html("Updating...");
                $.ajax({
                    type: "POST",
                    url: "/<?php echo BASEURL; ?>index.php/PaymentsManager/paymentWaiveOff_AJAX",
                    data: data,
                    success: function (msg) {
                        if(msg == "true")
                        {
                            $(".bg-info", $(butRef).parent()).html("Waived Off. Reloading...");
                            location.reload();
                        }
                        else
                        {
                            $(".bg-info", $(butRef).parent()).html("");
                            $(".bg-danger", $(butRef).parent()).html("Waive Off unsuccessful");
                        }
                    }
                });
            }
            else
            {
                $(".bg-danger", $(butRef).parent()).html("Select payable!");
            }
        });

        /*$('#submitButton').click(function()
        {
            url = location.href;
            urlArray = url.split('/');

            lastSegment = urlArray.length - 1;
            urlArray[lastSegment] = $('#searchValue').val();

            url = urlArray.join("/");
            location.href = url;

        });
*/
        $('#submitButton').click(function () {

            if ($("input[name=searchBy]:checked").val() == "MemberName") {

                $.ajax({
                    type: "POST",
                    url: "/<?php echo BASEURL; ?>index.php/DeskManager/home",
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


        $("#searchByForm").keypress(function(event) {
            if(event.which == 13)
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

        $('.authors').click(function () {

            var member_id = $('.author', $(this)).text();

            $('#searchValue').val(member_id);
            $("input:radio[value = MemberID]").prop('checked', 'checked');
            //alert($("input[name=searchBy]:checked").val());
            $('#searchByForm').submit();
        });
    });
</script>





