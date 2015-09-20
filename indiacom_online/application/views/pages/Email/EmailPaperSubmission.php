<?php
/**
 * Created by PhpStorm.
 * User: lavishlibra0810
 * Date: 20-04-2015
 * Time: 01:01 PM
 */
?>
<html>
<body>
    <center>INDIACom - 2016: Paper Received</center>
    <p>
        Dear <?php echo $member_name; ?>,
    </p>
    <p>
        Thank you very much for taking interest in INDIACom-2016.
    </p>
    <p>
        We hereby confirm the receipt of your paper having following details:-<br/>
        <table>
            <tr>
                <td>Title</td>
                <td>:</td>
                <td><?php echo $paper_title; ?></td>
            </tr>
            <tr>
                <td>Date of Receipt</td>
                <td>:</td>
                <td><?php echo $receipt_date; ?></td>
            </tr>
            <tr>
                <td>Member ID(s)</td>
                <td>:</td>
                <td>
                    <?php
                    foreach($member_ids as $memberId)
                    {
                        echo "$memberId;";
                    }
                    ?>
                </td>
            </tr>
        </table>
    </p>
    <p>
        <span style="background-color: #b2f4fe;">
            You have successfully submitted your full paper. Your Paper ID is <?php echo $paper_code; ?>. Please remember the same and quote it in all the future correspondences regarding this paper.
        </span>
    </p>
    <p>
        For any further clarification, feel free to mail us at conference@bvicam.ac.in with any questions you have and we will be pleased to help.
    </p>
    <p>
        Regards,
    </p>
    <p>
        <b>The Technical Programme Committee - INDIACom - 2016</b><br/>
        Bharati Vidyapeeth's Institute of Computer Applications and Management (BVICAM),<br/>
        A-4, Paschim Vihar, Rohtak Road, New Delhi - 63 (INDIA).<br/>
        Tel. : +91-11-25275055, Fax. : +91-11-25255056, Mobile : +91-9212022066<br/>
        E-Mails : conference@bvicam.ac.in
    </p>
    <p>
        <span style="background-color: #88cf36;">
            <i>Attachment :- All documents submitted by author</i>
        </span>
    </p>
    <p>
        <span style="background-color: #88cf36;">
            <i>In case of a special session paper, mail to be sent as CC to session chair person</i>
        </span>
    </p>
    <!--Your paper <strong><?php /*echo $paper_title; */?></strong> has been submitted.<br/><br/>
    Paper Code for this paper is <strong><?php /*echo $paper_code; */?></strong><br/><br/>
    You will find a copy of your paper in the attachments.<br/><br/>
    Thank You.-->
</body>
</html>