<?php /*print_r($member_payments_record); */?>

<<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">

    <table class="table table-striped table-hover table-responsive">
        <tbody>
            <tr><td><span class = "h4 text-theme">Member ID</span> </td><td><?php echo $member_info['member_id']; ?></td></tr>
            <tr><td><span class = "h4 text-theme">Member Name</span> </td><td><?php echo $member_info['member_name']; ?></td></tr>
            <tr><td><span class = "h4 text-theme">Member Email</span> </td><td><?php echo $member_info['member_email']; ?></td></tr>
        </tbody>
    </table>

    <table class = "table table-responsive table-hover table-striped">
        <thead>
            <tr>
                <th>Paper ID</th>
                <th>Paper Title</th>
                <th>Payable</th>
                <th>Waived off</th>
                <th>Discount amount</th>
                <th>To pay</th>
                <th>Paid amount</th>
                <th>Due amount</th>
                <th>Payment status</th>
            </tr>
        </thead>
        <tbody>
        <?php
            foreach($member_payments_record as $paper_id => $arr)
            {
        ?>
            <tr>
                <td><?php echo $member_payments_record[$paper_id]['PaperID']; ?></td>
                <td><?php echo $member_payments_record[$paper_id]['Title']; ?></td>
                <td><?php echo $member_payments_record[$paper_id]['Payable'];?></td>
                <td><?php echo $member_payments_record[$paper_id]['Waive']; ?></td>
                <td><?php echo $member_payments_record[$paper_id]['Discount'];?></td>
                <td><?php echo $member_payments_record[$paper_id]['Pay']; ?></td>
                <td><?php echo $member_payments_record[$paper_id]['Paid'];?></td>
                <td><?php echo $member_payments_record[$paper_id]['Due']; ?></td>
                <td><?php echo $member_payments_record[$paper_id]['Status']; ?></td>
            </tr>
        <?php
            }
        ?>
        </tbody>
    </table>
</div>

