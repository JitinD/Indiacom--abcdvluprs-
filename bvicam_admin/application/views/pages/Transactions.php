<div class="container-fluid">
    <div class="row">
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
            <span class="h2 text-theme">Transactions</span><br/>

            <?php
                if(isset($message))
                {
                    echo "<h3> $message </h3>";
                }
            ?>

            <table class="table table-hover table-striped body-text">

                <thead>
                    <tr>
                        <th>#</th>
                        <th>Member</th>
                        <th>Bank</th>
                        <th>Type</th>
                        <th>Number</th>
                        <th>Amount</th>
                        <th>EQINR</th>
                        <th>Date</th>
                        <th>Drop Down</th>
                        <th>Remarks</th>
                    </tr>
                </thead>

                <tbody>
                <?php

                if(empty($transactions))
                {
                    ?>
                    <tr>
                        <td colspan="11">
                            No transaction yet!
                        </td>
                    </tr>
                <?php
                }
                else
                {
                    foreach($transactions as $index=>$transaction)
                    {
                        ?>
                        <tr>
                            <td><?php echo $index+1; ?></td>
                            <td><?php echo $transaction -> member_name ?></td>
                            <td><?php echo $transaction -> transaction_bank; ?></td>
                            <td><?php echo $transaction -> transaction_mode_name; ?></td>
                            <td><?php echo $transaction -> transaction_number; ?></td>
                            <td>
                                <?php
                                    if($transaction -> transaction_currency == 1)
                                        echo "Rs ";
                                    else
                                        echo "$";

                                    echo $transaction -> transaction_amount;
                                ?>
                            </td>
                            <td><?php echo "Rs ".$transaction -> transaction_EQINR; ?></td>
                            <td><?php echo $transaction -> transaction_date; ?></td>
                            <td>
                                <form class="form-horizontal" enctype="multipart/form-data" method = "post">

                                    <input name = "trans_id" type = "hidden" value = "<?php echo $transaction -> transaction_id; ?>" />

                                    <select name = "verification_category" class="form-control" id="category" >
                                        <?php
                                            $verification_category = array("Not verified", "Accepted", "Rejected");

                                            for($v_index = 0; $verification_category[$v_index]; $v_index++)
                                            {
                                        ?>
                                                <option value = "<?php echo $value = $v_index ?>" <?php if($value == $transaction -> is_verified) echo "selected"; ?>><?php echo $verification_category[$value]?></option>
                                        <?php
                                            }
                                        ?>
                                    </select>
                            </td>
                            <td>
                                    <div class="col-sm-8">
                                        <textarea name = 'remarks' id="remarks" rows="2" cols = "15" class="form-control" ><?php echo $transaction -> transaction_remarks; ?></textarea>
                                    </div>

                                    <button type = "submit" name = "trans_verify" class="btn btn-primary">Done</button>
                                </form>
                            </td>

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