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
    <center>Major Revisions required after Detailed Review</center>
    <p>
        Dear <?php echo $member_name; ?>,
    </p>
    <p>
        Thank you very much for submission of your paper ID: <span style="color: #ff0000;"><?php echo $paper_code; ?></span> entitled: <span style="color: #ff0000;"><?php echo $paper_title; ?></span> for INDIACom - 2016; International Conference on Computing for Sustainable Global Development, technically sponsored by IEEE Delhi Section, scheduled to be held during 16th - 18th March, 2016 at Bharati Vidyapeeth, New Delhi (INDIA).
    </p>
    <p>
        The reviews of your Paper are now complete and the consensual decision of the Technical Programme Committee (TPC) is that <span style="color: #ff0000; font-weight: bold;">the paper is not suitable for acceptance in its current form</span>. <b>Substatntial revisions are required and further reviews are necessary to assess its suitability for presentation and publication in INDIACom - 2016</b>. You are, therefore, informed to substantially revise your paper, in response to the commnets of the TPC, which are given at the end of this notification, and submit the thoroughly revised paper for re-consideration at the earliest but not later than <span style="color: #ff0000; font-weight: bold;">15 days</span>. Upon receipt of the suitably revised paper, it will again be reviewed by the same set of reviewers. It is, therefore, requested to create a master list of revisions/rebuttals, responding to each point raised by the reviewers, in the format attached herewith. If you feel that the reviewers' comment does not warrant a revision, please prepare a reasoned rebuttal to their comment, in the same format.
    </p>
    <p>
        In order to re-submit the revised paper, please login with your member ID and password at <a href="www.bvicam.ac.in/indiacom">www.bvicam.ac.in/indiacom</a>.
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
        The consolidated comments, of the TPC, for your paper, are given hereunder:-
    </p>
    <p>
        <?php echo $comments; ?>
    </p>
</body>
</html>