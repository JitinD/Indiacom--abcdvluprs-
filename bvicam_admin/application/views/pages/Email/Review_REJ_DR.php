<?php
/**
 * Created by PhpStorm.
 * User: Saurav
 * Date: 4/21/15
 * Time: 11:37 PM
 */
?>
<html>
<body>
    <center>Rejected After Detailed Review</center>
    <p>
        Dear <?php echo $member_name; ?>,
    </p>
    <p>
        The reviews of your paper ID: <span style="color: #ff0000;"><?php echo $paper_code; ?></span> entitled: <span style="color: #ff0000;"><?php echo $paper_title; ?></span> are now complete and it is regretted to inform you that the above mentioned paper is <span style="color: #ff0000; font-weight: bold;">rejected</span> <b>in its current form</b>. The Technical Programme Committee(TPC) has found the paper unsuitable for publication. Further, there is little chance for the paper to reach the level of rigor required for publication.
    </p>
    <p>
        The consolidated comments, of the TPC, for your paper, are given at the end of this notification. You may find them to be constructive and helpful. You are now, of course, free to submit your paper elsewhere, if you wish to do so.
    </p>
    <p>
        Thank you for considering INDIACom - 2016 for your submission. We hope the outcome of this specific submission will not discourage you from the submission of your papers, in future, for events@BVICAM.
    </p>
    <p>
        Yours sincerely,
    </p>
    <p>
        Regards,
    </p>
    <p>
        <b>The Technical Programme Committee - INDIACom - 2016</b><br/>
        Bharati Vidyapeeth's Institute of Computer Applications and Management (BVICAM),<br/>
        A-4, Paschim Vihar, Rohtak Road, New Delhi - 63 (INDIA).<br/>
        Tel. : +91-11-25275055, Fax. : +91-11-25255056, Mobile : +91-9212022066<br/>
        E-Mails : conference@bvicam.ac.in<br/>
        Visit us at <a href="www.bvicam.ac.in/indiacom">www.bvicam.ac.in/indiacom</a>
    </p>
    <p>
        <b>Review Comments</b><br/>
        The consolidated comments, of the TPC, for your paper, are given hereunder:-
    </p>
    <p>
        <?php echo $comments; ?>
    </p>
</body>
</html>