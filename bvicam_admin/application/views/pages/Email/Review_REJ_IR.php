<?php
/**
 * Created by PhpStorm.
 * User: Saurav
 * Date: 4/21/15
 * Time: 11:36 PM
 */
?>
<html>
<body>
    <center>Rejected after Initial Review</center>
    <p>
        Dear <?php echo $member_name; ?>,
    </p>
    <p>
        Thank you very much for submission of your paper ID: <span style="color: #ff0000;"><?php echo $paper_code; ?></span> entitled: <span style="color: #ff0000;"><?php echo $paper_title; ?></span> for INDIACom - 2016; International Conference on Computing for Sustainable Global Development, technically sponsored by IEEE Delhi Section, scheduled to be held during 16th - 18th March, 2016 at Bharati Vidyapeeth, New Delhi (INDIA).
    </p>
    <p>
        The reviews of your paper are now complete and it is regretted to inform you that the above mentioned paper is <span style="color: #ff0000; font-weight: bold">rejected in its current form</span>.
    </p>
    <p>
        You may revise your paper in response to the comments of the Technical Programme Committee, which are given at the end of this notification, and submit the thoroughly revised paper for re-consideration, if you wish to do so. In order to re-submit the revised paper, please login with your member ID and password at <a href="<?php echo HOST.BASEURL; ?>"><?php echo HOST.BASEURL; ?></a>. It is therefore requested to create a master list of revisions/rebuttal, corresponding to each point raised by the reviewer, in the format attached herewith. If you feel that the review comment doesn't warrant a review, please prepare a rebuttal to the comment(s) in the same format.
    </p>
    <p>
        Thank you for your interest in INDIACom - 2016.
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
        The consolidated comments, of the Technical Programme Committee (TPC), for your paper, are given hereunder:-
    </p>
    <p>
        <?php echo $comments; ?>
    </p>
</body>
</html>