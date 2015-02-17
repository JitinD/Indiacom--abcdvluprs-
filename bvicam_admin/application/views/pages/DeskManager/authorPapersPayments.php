<?php /*print_r($papersInfo); */?>

<div class="col-sm-12 col-md-12 main">

    <table class="table table-striped table-hover table-responsive">
        <tbody>
            <tr>
                <td>
                    <span class = "h4 text-theme">Member ID</span>
                </td>
                <td id="member_id" data-member_id="<?php echo $memberDetails['member_id']; ?>">
                    <?php echo $memberDetails['member_id']; ?>
                </td>
            </tr>
            <tr>
                <td>
                    <span class = "h4 text-theme">Member Name</span>
                </td>
                <td>
                    <?php echo $memberDetails['member_name']; ?>
                </td>
            </tr>
            <tr>
                <td>
                    <span class = "h4 text-theme">Member Email</span>
                </td>
                <td>
                    <?php echo $memberDetails['member_email']; ?>
                </td>
            </tr>
            <tr>
                <td>
                    <span class = "h4 text-theme">Is Member registered</span>
                </td>
                <td>
                    <?php if($isMemberRegistered)
                            echo "Yes";
                          else
                            echo "No";
                    ?>
                </td>
            </tr>
        </tbody>
    </table>

    <table class = "table table-responsive table-hover table-striped">
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
            if(empty($papers))
            {
        ?>
             <tr><td colspan="8">No Accepted Papers!</td></tr>
        <?php
            }
            else
            {
                foreach($papers as $index => $paper)
                {
        ?>
                    <tr>
                        <td class="paper_id" data-paper_id="<?php echo $paper->paper_id; ?>"><?php echo $paper -> paper_code;?></td>
                        <td><?php echo $paper -> paper_title; ?></td>
                        <td>
                            <?php
                                if(isset($isPaperRegistered))
                                {
                                    if($isPaperRegistered[$paper -> paper_id])
                                        echo "Yes";
                                    else
                                        echo "No";
                                }
                                else
                                    echo "-";
                            ?>
                        </td>
                        <td><?php
                            if (isset($papersInfo[$paper->paper_id]['br']) && !isset($papersInfo[$paper->paper_id]['ep']))
                                echo $papersInfo[$paper->paper_id]['br'];
                            else if (!isset($papersInfo[$paper->paper_id]['br']) && isset($papersInfo[$paper->paper_id]['ep']))
                                echo $papersInfo[$paper->paper_id]['ep'];
                            ?>
                        </td>
                        <td>
                            <?php
                                if(isset($papersInfo[$paper -> paper_id]['waiveOff']))
                                    echo $papersInfo[$paper -> paper_id]['waiveOff'];
                                else
                                    echo "0";
                            ?>
                        </td>
                        <td>
                            <?php
                                if(isset($papersInfo[$paper -> paper_id]['paid']))
                                    echo $papersInfo[$paper -> paper_id]['paid'];
                                else
                                    echo "0";
                            ?>
                        </td>
                        <td>
                            <?php
                                if(isset($papersInfo[$paper -> paper_id]['pending']))
                                    echo $papersInfo[$paper -> paper_id]['pending'];
                                else
                                    echo "-";
                            ?>
                        </td>

                        <td>
                            <?php
                            if (isset($papersInfo[$paper->paper_id]['br'])) {
                                $payableTypes = array();
                                if(isset($papersInfo[$paper->paper_id]['paid']))
                                {
                                    if(isset($papersInfo[$paper->paper_id]['discountType']))
                                    {
                                        $discountDetails = $papersInfo[$paper->paper_id]['discountType'];
                                        $typeName = "Basic Registration with {$discountDetails->discount_type_name} Discount";
                                        $payableTypes[$typeName] = array();
                                    }
                                    else
                                    {
                                        $typeName = "Basic Registration";
                                        $payable = $papersInfo[$paper->paper_id]['br'];
                                        $payableTypes[$typeName] = array("payableAmount"=>$payable);
                                    }
                                }
                                else
                                 {
                                    if (!empty($globalDiscount)) {
                                        foreach ($globalDiscount as $discount) {
                                            $typeName = "Basic Registration with {$discount->discount_type_name} Discount";
                                            $discountAmount = $discount->discount_type_amount * $papersInfo[$paper->paper_id]['br'];
                                            $payable = $papersInfo[$paper->paper_id]['br'] - $discountAmount;
                                            $discountTypeId = "_{$discount->discount_type_id}";
                                            $payableTypes[$typeName] = array("payableAmount"=>$payable, "discountTypeId"=>$discountTypeId, "isGlobal"=>true);
                                        }
                                    }
                                    if (!empty($paperWiseDiscount[$paper->paper_id])) {
                                        foreach ($paperWiseDiscount[$paper->paper_id] as $paperDiscount) {
                                            $typeName = "Basic Registration with {$paperDiscount->discount_type_name} Discount";
                                            $discountAmount = $paperDiscount->discount_type_amount * $papersInfo[$paper->paper_id]['br'];
                                            $payable = $papersInfo[$paper->paper_id]['br'] - $discountAmount;
                                            $discountTypeId = "_{$paperDiscount->discount_type_id}";
                                            $payableTypes[$typeName] = array("payableAmount"=>$payable, "discountTypeId"=>$discountTypeId);
                                        }
                                    }
                                    if(empty($globalDiscount) && empty($paperWiseDiscount[$paper->paper_id]))
                                    {
                                        $typeName = "Basic Registration";
                                        $payable = $papersInfo[$paper->paper_id]['br'];
                                        $payableTypes[$typeName] = array("payableAmount"=>$payable);
                                    }
                                }
                                foreach($payableTypes as $type=>$details)
                                {
                                    ?>
                                    <span>
                                            <input type="radio" class="radio"
                                                   name="<?php echo $paper->submission_id; ?>_payheadAndDiscount" <?php if (!isset($papersInfo[$paper->paper_id]['ep'])) echo "checked"; ?>
                                                   value="BR<?php if(isset($details['discountTypeId'])) echo $details['discountTypeId']; ?>"
                                                   isGlobal="<?php echo (isset($details['isGlobal'])) ? "true" : "false"; ?>"
                                                   class="radio"
                                                <?php
                                                if (isset($papersInfo[$paper->paper_id]['pending']) && $papersInfo[$paper->paper_id]['pending'] == 0)
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
                            if (isset($papersInfo[$paper->paper_id]['ep'])) {
                                ?>
                                <span>
                                        <input type="radio"
                                               name="<?php echo $paper->submission_id; ?>_payheadAndDiscount"
                                            <?php if (!isset($papersInfo[$paper->paper_id]['br'])) echo "checked"; ?>
                                               value="EP"
                                               class="radio"
                                            <?php
                                            if (isset($papersInfo[$paper->paper_id]['pending']) && $papersInfo[$paper->paper_id]['pending'] == 0)
                                                echo "disabled";
                                            ?> >
                                        Extra Paper
                                        <input type="hidden" value="<?php echo $papersInfo[$paper->paper_id]['ep']; ?>">
                                    </span>
                            <?php
                            }
                            ?>
                        </td>
                        <td>
                            <select name = "attendance_on_desk" class="form-control attendance_on_desk">
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
                            <div class="bg-danger attDanger"></div>
                        </td>
                    </tr>
        <?php
                }
            }
        ?>
        </tbody>
    </table>
</div>

<script>
    $(document).ready(function () {
        $(".radio").click(function()
        {
            var val = $(this).siblings().first().val()
            var ref = $(this).parent().parent().parent();
            $("td:nth-child(4)", ref).html(val);
            $("td:nth-child(7)", ref).html(val);
        });

        $(".attendance_on_desk").change(function () {
            var memberId = $('#member_id').attr('data-member_id');
            var ref = $(this).parent().parent();
            var ref_td = $(this).parent();
            var paperId = $('.paper_id', ref).attr('data-paper_id');
            var isPresent = $(this).val();
            $('.attInfo', ref_td).html("Updating");
            $.ajax({
                type: "POST",
                url: "/<?php echo BASEURL; ?>index.php/AttendanceManager/markDeskAttendance_AJAX",
                data: "memberId=" + memberId + "&paperId=" + paperId + "&isPresent=" + isPresent,
                success: function(msg)
                {
                    if(msg == "true")
                    {
                        $(".attInfo", ref_td).html("Updated");
                    }
                    else
                    {
                        $(".attInfo", ref_td).html("");
                        $(".attError", ref_td).html("Could not update");
                    }
                }
            });
        });
    });
</script>