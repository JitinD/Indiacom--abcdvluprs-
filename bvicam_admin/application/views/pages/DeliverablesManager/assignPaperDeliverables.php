<div class="col-sm-12 col-md-12 main">
    <table class="table table-striped table-hover table-responsive">

        <thead>
            <tr>
                <th>MID</th>
                <th>Deliverables</th>
            </tr>
        </thead>

        <tbody>
            <?php
            if(!(isset($deliverablesPayments)))
               {
            ?>
                    <tr>
                        <td colspan = "3">No records available</td>
                    </tr>
            <?php
                }
            else
            {
                foreach($deliverablesPayments as $author_id => $memberPaymentRecords)
                {
            ?>
                    <tr>
                        <td class = "member_id" data-member_id = "<?php echo $author_id; ?>"><?php echo $author_id; ?></td>
                        <td>
                            <table class = "table table-responsive">
                                <thead>
                                    <tr>
                                        <th>PID</th>
                                        <th>Deliverables Status</th>
                                        <th>Deliverables</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach($memberPaymentRecords as $index => $payment)
                                    {
                                        //foreach($payments_array as $index => $payments)
                                        {
                                    ?>
                                            <tr>
                                                <td class = "submission_id" data-submission_id = "<?php echo $payment -> payment_submission_id; ?>">
                                                    <?php
                                                    if(isset($payment -> submission_paper_id))
                                                        echo $payment -> submission_paper_id;

                                                    ?>
                                                </td>
                                                <td>
                                                    <select name = "deliverables_status" class="form-control deliverables_status">
                                                        <?php
                                                        $deliverable_status = array("Not assigned", "Assigned");

                                                        for($arr_index = 0; $arr_index < 2; $arr_index++)
                                                        {
                                                            ?>
                                                            <option value = "<?php echo $arr_index; ?>"
                                                                <?php
                                                                //if(isset($deliverablesStatus[$payments -> submission_member_id][$payments -> payment_submission_id]['status']) && $deliverablesStatus[$payments -> submission_member_id][$payments -> payment_submission_id]['status'] == $arr_index)
                                                                if($deliverablesStatus[$author_id][$index]['status'] == $arr_index)
                                                                    echo "selected";
                                                                ?>>
                                                                <?php echo $deliverable_status[$arr_index]; ?>
                                                            </option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                    <div class="bg-info attInfo"></div>
                                                    <div class="bg-danger attError"></div>
                                                </td>
                                                <td>
                                                    <?php
                                                    $deliverables = array("Object A", "Object B");

                                                    for($arr_index = 0; $arr_index < 2; $arr_index++)
                                                    {
                                                        ?>
                                                        <input type = "checkbox" class = "deliverables" value = "<?php echo $arr_index + 1; ?>"
                                                            <?php
                                                            if(($deliverablesStatus[$author_id][$index]['status'] == 1) && ($deliverablesStatus[$author_id][$index]['deliverables_id'] == ($arr_index + 1) || $deliverablesStatus[$author_id][$index]['deliverables_id'] == 3))
                                                                echo "checked";
                                                            ?>
                                                            >
                                                        <?php echo $deliverables[$arr_index]; ?><br/>
                                                    <?php
                                                    }
                                                    ?>
                                                </td>
                                            </tr>
                                        <?php
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
            <?php
                }
            }
            ?>
        </tbody>
    </table>
</div>

<script>
    $(document).ready(function () {

        var deliverables_id = null;

        $(".deliverables_status").change(function () {
            var ref_member = $(this).parent().parent().parent().parent().parent().parent();
            var ref = $(this).parent().parent();
            var ref_td = $(this).parent();

            var memberId = $('.member_id', ref_member).attr('data-member_id');
            var submissionId = $('.submission_id', ref).attr('data-submission_id');

            if($(this).val() == 0)
                $('.deliverables:checked', ref).prop('checked', false);

            if ($('.deliverables:checked', ref).length == 0)
                $(this).val(0);

            var isDeliverablesAssigned = $(this).val();

            $('.attInfo', ref_td).html("Updating");
            $.ajax({
                type: "POST",
                url: "/<?php echo BASEURL; ?>index.php/DeliverablesManager/assignDeliverables_AJAX",
                data: "memberId=" + memberId + "&submissionId=" + submissionId + "&isDeliverablesAssigned=" + isDeliverablesAssigned + "&deliverables_id="+deliverables_id,
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

            $(".deliverables").change(function()
            {
                var ref = $(this).parent().parent();

                if ($('.deliverables:checked', ref).length == 2)
                    deliverables_id = 3;
                else if ($('.deliverables:checked', ref).length == 0)
                    deliverables_id = null;
                else if($('.deliverables:checked', ref).val())
                    deliverables_id = $('.deliverables:checked', ref).val();

                if($(".deliverables_status", ref).val() == 1)
                    $(".deliverables_status", ref).change();

            });
        });
    });
</script>