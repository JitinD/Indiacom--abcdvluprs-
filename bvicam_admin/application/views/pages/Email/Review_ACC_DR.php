<?php
/**
 * Created by PhpStorm.
 * User: Saurav
 * Date: 4/21/15
 * Time: 11:38 PM
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
        The reviews of your Paper ID: <span style="color: #ff0000;"><?php echo $paper_code; ?></span> entitled: <span style="color: #ff0000;"><?php echo $paper_title; ?></span> are now complete and it is our pleasure to inform you that the consensual decision of the Technical Programme Committee (TPC) is to accept the above mentioned paper for presentation in INDIACom – 2016; International Conference on Computing for Sustainable Global Development, technically sponsored by IEEE Delhi Section, scheduled to be held during 16th – 18th March, 2016 at Bharati Vidyapeeth, New Delhi (INDIA) and publication in the Pre - Conference Proceedings having ISSN 0973 – 7529 and ISBN 978-93-80544-19-9 serials.
    </p>
    <p>
        <span style="color: #ff0000; font-weight: bold;">This acceptance is subject to completion of the registration formalities of at-least one of the authors upto 01st February, 2016</span>, in the applicable category along with uploading of the <b>Camera Ready Copy (CRC)</b> in <b>.doc / .docx</b> format, of your paper, as per the Authors'’ guidelines available at <a href=""></a> and the working template available at <a href=""></a>, the signed copy of the Copyright Transfer Form available at <a href=""></a> and the Certificate of Originality and Confirmation to Attend the Conference available at <a href=""></a>. Registration Form and other details can be downloaded from <a href=""></a> and the payment modes can be viewed at <a href=""></a>.
    </p>
    <p>
        You are hereby invited to personally attend the Conference during 16th – 18th March, 2016 and present the paper as per the presentation schedule. <span style="color: #ff0000; font-weight: bold;">Please note that only those papers, which are presented during the conference, will be submitted to IEEE Xplore for publication and indexing. Out of the papers being presented during INDIACom – 2016, extended version of best papers, from each track having scored 04 or more points on a 05 points scale, shall be considered for publication in the Half Yearly BIJIT - BVICAM's International Journal of Information Technology (BIJIT) having ISSN 0973 – 5658, details of which are available at <a href="http://www.bvicam.ac.in/bijit">http://www.bvicam.ac.in/bijit</a>.
    </p>
    <p>
        Please feel free to contact us for any clarification, if required. Looking forward to meet you during the Conference.
    </p>
    <p style="color: #ff0000;">
        Important:- Kindly note that the maximum allowable length of your manuscript is six pages. <b>In case the length of the CRC of your manuscript exceeds six pages after initial formatting (as per the template of INDIACom - 2016 (<a href="">available here for download and reference</a>), extra page charges will be applicable for each additional page.</b>
    </p>
    <p>
        With warm personal regards,
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