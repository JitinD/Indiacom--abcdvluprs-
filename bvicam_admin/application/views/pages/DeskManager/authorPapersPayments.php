<?php /*print_r($papersInfo); */ ?>

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
                           value="<?php echo set_value('searchValue'); ?>" id="searchValue"
                           placeholder="Enter Search value">
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
    if (isset($memberDetails))
    {
    ?>
    <h3 class="text-center Info">Member Profile</h3>
    <div class="Info">
        <div class="col-md-6">
            <table class="table table-condensed">
                <tbody>
                <tr>
                    <td>
                        Member ID
                    </td>
                    <td id="member_id" data-member_id="<?php echo $memberDetails['member_id']; ?>">
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
                <tr>
                    <td>
                        Member Email
                    </td>
                    <td>
                        <strong><?php echo $memberDetails['member_email']; ?></strong>
                    </td>
                </tr>
                <tr>
                    <td>
                        Is Member registered?
                    </td>
                    <td>
                        <strong>
                            <?php
                            if ($isMemberRegistered) {
                                ?>
                                <span class="alert-success"><?php echo "Yes"; ?></span>
                            <?php
                            } else {
                                ?>
                                <span class="alert-danger"><?php echo "No"; ?></span>
                            <?php
                            }
                            ?>
                        </strong>
                    </td>
                </tr>
                </tbody>
            </table>

        </div>
        <div class="col-md-6">
            <a class="btn btn-default btn-lg"
               href="<?php echo "/" . BASEURL . "index.php/DeliverablesManager/assignMemberDeliverables/" . $memberDetails['member_id']; ?>">Assign
                Member Deliverables</a>
        </div>
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
		<div class="col-md-12">
		
        <table class="table table-responsive table-condensed table-hover table-striped">
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
            if (empty($papers)) {
                ?>
                <tr>
                    <td colspan="9" class="text-center">
                        <div class="alert alert-danger">No Accepted Papers!</div>
                    </td>
                </tr>
            <?php
            } else {
                foreach ($papers as $index => $paper) {
                    ?>
                    <tr>
                        <td class="paper_id"
                            data-paper_id="<?php if (isset($paper->paper_id)) echo $paper->paper_id; ?>">
                            <?php if (isset($paper->paper_code))
                                echo $paper->paper_code;
                            ?>
                        </td>

                        <td class="paper_title">
                            <?php if (isset($paper->paper_title))
                                echo $paper->paper_title;
                            ?>
                        </td>
                        <td>
                            <?php
                            if (isset($isPaperRegistered)) {
                                if ($isPaperRegistered[$paper->paper_id])
                                    echo "Yes";
                                else
                                    echo "No";
                            } else
                                echo "-";
                            ?>
                        </td>
                        <td class="payable"><?php
                            if(isset($papersInfo[$paper->paper_id]['payable']))
                                echo $papersInfo[$paper->paper_id]['payable'];
                            ?>
                        </td>
                        <td class="waive_off"><?php
                            if (isset($papersInfo[$paper->paper_id]['waiveOff']))
                                echo $papersInfo[$paper->paper_id]['waiveOff'];
                            else
                                echo 0;
                        ?></td>
                        <td>
                            <?php
                            if (isset($papersInfo[$paper->paper_id]['paid']))
                                echo $papersInfo[$paper->paper_id]['paid'];
                            else
                                echo "0";
                            ?>
                        </td>
                        <td class="pending_amount"
                            data-pending_amount=" <?php if (isset($papersInfo[$paper->paper_id]['pending'])) echo $papersInfo[$paper->paper_id]['pending']; ?>">
                            <?php
                            if (isset($papersInfo[$paper->paper_id]['pending']))
                                echo $papersInfo[$paper->paper_id]['pending'];
                            else
                                echo "-";
                            ?>
                        </td>

                        <td>
                            <?php
                            if(isset($papersInfo[$paper->paper_id]['payable']))
                                $payableAmount = $papersInfo[$paper->paper_id]['payable'];
                            $payHeads = (is_array($papersInfo[$paper->paper_id]['payhead'])) ? $papersInfo[$paper->paper_id]['payhead'] : array($papersInfo[$paper->paper_id]['payhead']);
                            $payableClasses = (is_array($papersInfo[$paper->paper_id]['payableClass'])) ? $papersInfo[$paper->paper_id]['payableClass'] : array($papersInfo[$paper->paper_id]['payableClass']);
                            foreach($payHeads as $index=>$paymentHead)
                            {
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
                                        $discountArray[] = array($papersInfo[$paper->paper_id]['discountType']);
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
                                            if(isset($papersInfo[$paper->paper_id]['payable']))
                                            {
                                                $payableAmount = $papersInfo[$paper->paper_id]['payable'];
                                                $pendingAmount = $papersInfo[$paper->paper_id]['pending'];
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
                                                if (isset($papersInfo[$paper->paper_id]['pending']) && $papersInfo[$paper->paper_id]['pending'] <= 0)
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
                                           if(isset($papersInfo[$paper->paper_id]['payable']))
                                               echo $papersInfo[$paper->paper_id]['payable'];
                                           else
                                               echo $payableClasses[$index]->payable_class_amount;
                                           ?>"
                                           data-pending="<?php
                                           if(isset($papersInfo[$paper->paper_id]['pending']))
                                               echo $papersInfo[$paper->paper_id]['pending'];
                                           else
                                               echo $payableClasses[$index]->payable_class_amount;
                                           ?>"
                                           data-payheadId="<?php echo $payableClasses[$index]->payable_class_payhead_id; ?>"
                                        <?php
                                        if (isset($papersInfo[$paper->paper_id]['pending']) && $papersInfo[$paper->paper_id]['pending'] <= 0)
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
                            <select name="attendance_on_desk" class="form-control attendance_on_desk"
                                <?php
                                if ( !isset($papersInfo[$paper->paper_id]['pending']) || (isset($papersInfo[$paper->paper_id]['pending']) && $papersInfo[$paper->paper_id]['pending'] != 0))
                                    echo "disabled";
                                ?>
                                >
                                <?php
                                $attendance_on_desk = array("Absent", "Present");

                                for ($index = 0; $index < 2; $index++) {
                                    ?>
                                    <option value="<?php echo $index; ?>"
                                        <?php
                                        if (isset($attendance[$paper->submission_id]['is_present_on_desk']) && $attendance[$paper->submission_id]['is_present_on_desk'] == $index)
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
            ?>
            </tbody>
        </table>
		</div>
    </div>
</div>



<?php
}
else
{
?>
<div class="Info">
    <?php
    if (!isset($memberId)) {?>
        <div class="alert alert-danger text-center">
            Sorry, Member ID Not Found
        </div>
    <?php }
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

        $(".radio").click(function () {
            var payable = $(this).attr("data-payable");
            var pending = $(this).attr("data-pending");
            var payheadId = $(this).attr("data-payheadId");
            $(".payable", $(this).parent().parent()).html(payable);
            $(".payable", $(this).parent().parent()).attr("data-payheadId", payheadId);
            $(".pending", $(this).parent().parent()).html(pending);
        });

        $(".attendance_on_desk").change(function () {
            var memberId = $('#member_id').attr('data-member_id');
            var ref = $(this).parent().parent();
            var ref_td = $(this).parent();
            var paperId = $('.paper_id', ref).attr('data-paper_id');
            var isPresent = $(this).val();
            //a lert(memberId+"-"+paperId+";"+isPresent);
            $('.attInfo', ref_td).html("Updating");
            $.ajax({
                type: "POST",
                url: "/<?php echo BASEURL; ?>index.php/AttendanceManager/markDeskAttendance_AJAX",
                data: "memberId=" + memberId + "&paperId=" + paperId + "&isPresent=" + isPresent,
                success: function (msg) {
                    if (msg == "true") {
                        $(".attInfo", ref_td).html("Updated");
                    }
                    else {
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
         });*/

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