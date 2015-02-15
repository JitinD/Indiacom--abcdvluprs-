<?php /*print_r($check); */?>

<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">

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

    <table class = "table table-responsive table-hover table-striped">
        <thead>
            <tr>
                <th>Member ID</th>
                <th>Member Name</th>
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
            foreach($paper_payments_record as $member_id => $arr)
            {
        ?>
                <tr>
                    <td><?php echo $paper_payments_record[$member_id]['MemberID'];?></td>
                    <td><?php echo $paper_payments_record[$member_id]['Name']; ?></td>
                    <td><?php echo $paper_payments_record[$member_id]['Payable'];?></td>
                    <td><?php echo $paper_payments_record[$member_id]['Waive'];?></td>
                    <td><?php echo $paper_payments_record[$member_id]['Discount'];?></td>
                    <td><?php echo $paper_payments_record[$member_id]['Pay'];?></td>
                    <td><?php echo $paper_payments_record[$member_id]['Paid'];?></td>
                    <td><?php echo $paper_payments_record[$member_id]['Due']; ?></td>
                    <td><?php echo $paper_payments_record[$member_id]['Status'];?></td>
                </tr>
        <?php
            }
        ?>
        </tbody>
    </table>
</div>

