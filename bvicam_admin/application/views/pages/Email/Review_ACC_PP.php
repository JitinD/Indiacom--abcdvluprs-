<?php
/**
 * Created by PhpStorm.
 * User: saura_000
 * Date: 10/2/15
 * Time: 2:35 PM
 */
?>
<html>
<body>
    <p>
        Dear <?php echo $member_name; ?>,
    </p>
    <p>
        Congratulations!
    </p>
    <p>
        The reviews of your Paper ID: <span style="color: #ff0000;"><?php echo $paper_code; ?></span> entitled: <span style="color: #ff0000;"><?php echo $paper_title; ?></span> are now complete and it is our pleasure to inform you that the consensual decision of the Technical Programme Committee (TPC) is to accept the above mentioned paper for <span style="color: #ff0000; font-weight: bold;">Poster Session Exhibition</span> in INDIACom – 2016; International Conference on Computing for Sustainable Global Development, scheduled to be held during 16th – 18th March, 2016.
    </p>
    <p>
        <span style="color: #ff0000; font-weight: bold;">This acceptance is subject to completion of the registration formalities of at-least one of the authors upto 01st February, 2016</span>, in the applicable category.
    </p>
    <p>
        You are hereby invited to personally attend the Conference during 16th – 18th March, 2016 and exhibit your paper with the help of appropriate posters in the Poster Session.
    </p>
    <p>
        In case of any difficulty, please contact <b>Mr. Manish Kumar at (+91-11-25275055, +91-882936502, www.mankumar@gmail.com)</b>.
    </p>
    <p>
        Look forward to the pleasure of meeting you and interacting with you during INDIACom - 2016 in New Delhi, the national capital of the country.
    </p>
    <p>
        Thank you for your interest in INDIACom - 2016.
    </p>
    <p>
        With warm personal regards,
    </p>
    <p>
        Yours sincerely,<br/>
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