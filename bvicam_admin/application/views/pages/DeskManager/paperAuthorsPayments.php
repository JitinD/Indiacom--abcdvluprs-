<?php /*print_r($check); */?>

<div class="col-sm-12 col-md-12 main">

    <table class="table table-striped table-hover table-responsive">
        <tr>
            <td>Paper Code</td>
            <td><?php echo $paperDetails->paper_code; ?></td>
        </tr>
        <tr>
            <td>Paper Title</td>
            <td><?php echo $paperDetails->paper_title; ?></td>
        </tr>
        <tr>
            <td>Event</td>
            <td><?php echo $eventDetails->event_name; ?></td>
        </tr>
        <tr>
            <td>Track</td>
            <td>Track <?php echo $trackDetails->track_number . " : " . $trackDetails->track_name; ?></td>
        </tr>
        <tr>
            <td>Subject</td>
            <td><?php echo $subjectDetails->subject_name; ?></td>
        </tr>


    </table>

    <table class="table table-striped table-hover table-responsive">
            <thead>
                <tr>
                    <th>Member ID</th>
                    <th>Member Name</th>
                </tr>
            </thead>
    <?php

        foreach($paper_authors_payables as $author_id => $paperPayables)
        {
    ?>
            <tbody>
                <tr>
                    <td>
                        <?php echo $author_id; ?>
                    </td>
                    <td>
                        <?php echo $member_id_name_array[$author_id]; ?>
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
                                            <td><?php echo $paper -> paper_code;?></td>
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
                                                <select name = "attendance_on_desk" class="form-control" id="attendance_on_desk" >
                                                    <?php
                                                    $attendance_on_desk = array("Absent", "Present");

                                                    for($index = 0; $attendance_on_desk[$index]; $index++)
                                                    {
                                                        ?>
                                                        <option value = "<?php echo $value = $index ?>"><?php echo $attendance_on_desk[$index]?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
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


<script>
    $(document).ready(function () {
        $(".radio").click(function()
        {
            var val = $(this).siblings().first().val()
            var ref = $(this).parent().parent().parent();
            $("td:nth-child(4)", ref).html(val);
            $("td:nth-child(7)", ref).html(val);
        });
    });
</script>





