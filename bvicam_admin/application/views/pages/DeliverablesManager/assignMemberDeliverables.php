<?php /*print_r($deliverablesPayments); */?>

<div class="col-sm-12 col-md-12 main">

    <table class="table table-striped table-hover table-responsive">
        <thead>
            <tr>
                <th>MID</th>
                <th>PID</th>
                <th>Status</th>
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
                foreach($deliverablesPayments as $payheadId => $payments_array)
                {
                    foreach($payments_array as $index => $payments)
                    {
            ?>
                        <tr>
                            <td class ="member_id" data-member_id="<?php echo $payments -> submission_member_id; ?>">
                                <?php echo $payments -> submission_member_id; ?>
                            </td>
                            <td  class="submission_id" data-submission_id = "<?php echo $payments->payment_submission_id; ?>">
                                <?php
                                    if(isset($payments -> submission_paper_id))
                                        echo $payments -> submission_paper_id;

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
                                                if(isset($deliverablesStatus[$payments -> submission_member_id][$payments -> payment_submission_id]['status']) && $deliverablesStatus[$payments -> submission_member_id][$payments -> payment_submission_id]['status'] == $arr_index)
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

        $(".deliverables_status").change(function () {
            var memberId = $('.member_id').attr('data-member_id');
            var ref = $(this).parent().parent();
            var ref_td = $(this).parent();
            var submissionId = $('.submission_id', ref).attr('data-submission_id');
            var isDeliverablesAssigned = $(this).val();

            $('.attInfo', ref_td).html("Updating");
            $.ajax({
                type: "POST",
                url: "/<?php echo BASEURL; ?>index.php/DeliverablesManager/assignDeliverables_AJAX",
                data: "memberId=" + memberId + "&submissionId=" + submissionId + "&isDeliverablesAssigned=" + isDeliverablesAssigned,
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