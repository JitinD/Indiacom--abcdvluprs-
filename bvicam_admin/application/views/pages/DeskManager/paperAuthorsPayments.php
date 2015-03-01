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
        <table class="table table-striped table-responsive table-condensed">
                <thead>
                    <tr>
                        <th>Member ID</th>
                        <th>Member Name</th>
                        <th>Is Member Registered</th>
                    </tr>
                </thead>
        <?php

            foreach($paper_authors_payables as $author_id => $paperPayables)
            {
        ?>
                <tbody>
                    <tr>
                        <td class = "member_id" data-member_id = "<?php if(isset($author_id)) echo $author_id; ?>">
                            <?php
                                if(isset($author_id))
                                    echo $author_id;
                            ?>
                        </td>
                        <td>
                            <?php
                                if(isset($member_id_name_array[$author_id]))
                                    echo $member_id_name_array[$author_id];
                            ?>
                        </td>
                        <td>
                            <?php
                            if(isset($isMemberRegistered[$author_id]))
                                echo $isMemberRegistered[$author_id] ? "Yes" : "No";
                            ?>
                        </td>
                        <td>

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
                                        <th>Mark attendance</th>
                                    </tr>
                                </thead>

                                <tbody>

                                <?php
                                    if(empty($papers[$author_id]))
                                    {
                                        ?>
                                        <tr>
                                            <td colspan="9" class="text-center">
                                                <div class="alert alert-danger">No Accepted Papers!</div>
                                            </td>
                                        </tr>
                                    <?php
                                    }
                                    else
                                    {
                                        foreach($papers[$author_id] as $index => $paper)
                                        {
                                            ?>
                                            <tr>
                                                <td class="paper_id" data-paper_id="<?php if(isset($paper -> paper_id)) echo $paper->paper_id; ?>"><?php if(isset($paper -> paper_code)) echo $paper -> paper_code;?></td>
                                                <td>
                                                    <?php
                                                        if(isset($paper -> paper_title))
                                                            echo $paper -> paper_title;
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php
                                                    if(isset($isPaperRegistered[$paper->paper_id]))
                                                    {
                                                        if($isPaperRegistered[$paper->paper_id])
                                                            echo "Yes";
                                                        else
                                                            echo "No";
                                                    }
                                                    else
                                                        echo "-";
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php
                                                    if (isset($paperPayables[$paper->paper_id]['br']) && !isset($paperPayables[$paper->paper_id]['ep']))
                                                        echo $paperPayables[$paper->paper_id]['br'];
                                                    else if (!isset($paperPayables[$paper->paper_id]['br']) && isset($paperPayables[$paper->paper_id]['ep']))
                                                        echo $paperPayables[$paper->paper_id]['ep'];
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php
                                                    if(isset($paperPayables[$paper -> paper_id]['waiveOff']))
                                                        echo $paperPayables[$paper -> paper_id]['waiveOff'];
                                                    else
                                                        echo "0";
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php
                                                    if(isset($paperPayables[$paper -> paper_id]['paid']))
                                                        echo $paperPayables[$paper -> paper_id]['paid'];
                                                    else
                                                        echo "0";
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php
                                                    if(isset($paperPayables[$paper -> paper_id]['pending']))
                                                        echo $paperPayables[$paper -> paper_id]['pending'];
                                                    else
                                                        echo "-";
                                                    ?>
                                                </td>

                                                <td>
                                                    <?php
                                                    if (isset($paperPayables[$paper->paper_id]['br'])) {
                                                        $payableTypes = array();
                                                        if(isset($paperPayables[$paper->paper_id]['paid']))
                                                        {
                                                            if(isset($paperPayables[$paper->paper_id]['discountType']))
                                                            {
                                                                $discountDetails = $paperPayables[$paper->paper_id]['discountType'];
                                                                $typeName = "Basic Registration with {$discountDetails->discount_type_name} Discount";
                                                                $payableTypes[$typeName] = array();
                                                            }
                                                            else
                                                            {
                                                                $typeName = "Basic Registration";
                                                                $payable = $paperPayables[$paper->paper_id]['br'];
                                                                $payableTypes[$typeName] = array("payableAmount"=>$payable);
                                                            }
                                                        }
                                                        else
                                                        {
                                                            if (!empty($globalDiscount)) {
                                                                foreach ($globalDiscount as $discount) {
                                                                    $typeName = "Basic Registration with {$discount->discount_type_name} Discount";
                                                                    $discountAmount = $discount->discount_type_amount * $paperPayables[$paper->paper_id]['br'];
                                                                    $payable = $paperPayables[$paper->paper_id]['br'] - $discountAmount;
                                                                    $discountTypeId = "_{$discount->discount_type_id}";
                                                                    $payableTypes[$typeName] = array("payableAmount"=>$payable, "discountTypeId"=>$discountTypeId, "isGlobal"=>true);
                                                                }
                                                            }
                                                            if (!empty($paperWiseDiscount[$paper->paper_id])) {
                                                                foreach ($paperWiseDiscount[$paper->paper_id] as $paperDiscount) {
                                                                    $typeName = "Basic Registration with {$paperDiscount->discount_type_name} Discount";
                                                                    $discountAmount = $paperDiscount->discount_type_amount * $paperPayables[$paper->paper_id]['br'];
                                                                    $payable = $paperPayables[$paper->paper_id]['br'] - $discountAmount;
                                                                    $discountTypeId = "_{$paperDiscount->discount_type_id}";
                                                                    $payableTypes[$typeName] = array("payableAmount"=>$payable, "discountTypeId"=>$discountTypeId);
                                                                }
                                                            }
                                                            if(empty($globalDiscount) && empty($paperWiseDiscount[$paper->paper_id]))
                                                            {
                                                                $typeName = "Basic Registration";
                                                                $payable = $paperPayables[$paper->paper_id]['br'];
                                                                $payableTypes[$typeName] = array("payableAmount"=>$payable);
                                                            }
                                                        }
                                                        foreach($payableTypes as $type=>$details)
                                                        {
                                                            ?>
                                                            <span>
                                                                    <input type="radio" class="radio"
                                                                           name="<?php echo $paper->submission_id; ?>_payheadAndDiscount" <?php if (!isset($paperPayables[$paper->paper_id]['ep'])) echo "checked"; ?>
                                                                           value="BR<?php if(isset($details['discountTypeId'])) echo $details['discountTypeId']; ?>"
                                                                           isGlobal="<?php echo (isset($details['isGlobal'])) ? "true" : "false"; ?>"
                                                                           class="radio"
                                                                        <?php
                                                                        if (isset($paperPayables[$paper->paper_id]['pending']) && $paperPayables[$paper->paper_id]['pending'] == 0)
                                                                            echo "disabled";
                                                                        ?>>
                                                                <?php echo $type; ?>
                                                                <input type="hidden" value="<?php if(isset($details['payableAmount'])) echo $details["payableAmount"]; ?>">
                                                                </span>
                                                        <?php
                                                        }
                                                    }
                                                    ?>
                                                    <?php
                                                    if (isset($paperPayables[$paper->paper_id]['ep'])) {
                                                        ?>
                                                        <span>
                                                                <input type="radio"
                                                                       name="<?php echo $paper->submission_id; ?>_payheadAndDiscount"
                                                                    <?php if (!isset($paperPayables[$paper->paper_id]['br'])) echo "checked"; ?>
                                                                       value="EP"
                                                                       class="radio"
                                                                    <?php
                                                                    if (isset($paperPayables[$paper->paper_id]['pending']) && $paperPayables[$paper->paper_id]['pending'] == 0)
                                                                        echo "disabled";
                                                                    ?> >
                                                                Extra Paper
                                                                <input type="hidden" value="<?php echo $paperPayables[$paper->paper_id]['ep']; ?>">
                                                            </span>
                                                    <?php
                                                    }
                                                    ?>
                                                </td>
                                                <td>
                                                    <select name = "attendance_on_desk" class="form-control attendance_on_desk"
                                                        <?php
                                                        if(isset($paperPayables[$paper -> paper_id]['pending']) && $paperPayables[$paper -> paper_id]['pending'] != 0)
                                                            echo "disabled";
                                                        ?>
                                                    >
                                                        <?php
                                                        $attendance_on_desk = array("Absent", "Present");

                                                        for($index = 0; $index < 2; $index++)
                                                        {
                                                        ?>
                                                            <option value = "<?php echo $index; ?>"
                                                                <?php
                                                                if (isset($attendance[$paper->submission_id]->is_present_on_desk) && $attendance[$paper->submission_id]->is_present_on_desk == $index)
                                                                    echo "selected"
                                                                ?>>
                                                                <?php echo $attendance_on_desk[$index]; ?>
                                                            </option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                    <div class="bg-info attInfo"></div>
                                                    <div class="bg-danger attError"></div>
                                                </td>
                                            </tr>
                                        <?php
                                        }
                                    }
                                ?>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                </tbody>
        <?php
            }
        ?>
        </table>

    </div>
</div>

<?php
}
else
{
?>
<div class = "Info">
    <?php
    if(!isset($paperId))
    {?>
        <div class="alert alert-danger text-center">Sorry, No Paper Found</div>
    <?php
    }
    }
    ?>

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
            var val = $(this).siblings().first().val()
            var ref = $(this).parent().parent().parent();
            $("td:nth-child(4)", ref).html(val);
            $("td:nth-child(7)", ref).html(val);
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
                                $("#matchingMemberRecords").find('tbody').append($('<tr>').append($('<td  class = "member" style = "cursor: pointer; cursor: hand;">').text(value.member_id)).append($('<td>').text(value.member_name)));

                            });

                        }

                    }
                });
            }
            else {
                $('#searchByForm').submit();
            }
        });


        $("#searchByForm").keypress(function(e) {
            if(e.which == 13)
            {
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





