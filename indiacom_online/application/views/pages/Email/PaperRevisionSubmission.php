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
    <center>Revised Documents for Paper ID <?php echo $paper_code; ?> received</center>
    <p>
        Dear <?php echo $member_name; ?>,
    </p>
    <p>
        The status of documents sent by you so far, against <b>Paper ID <?php echo $paper_code; ?></b>, submitted for <b>INDIACom - 2016</b>, is listed hereunder:-
    </p>
    <p>
        <table>
            <tr>
                <td style="text-decoration: underline">Document</td>
                <td></td>
                <td style="text-decoration: underline">Status</td>
            </tr>
            <tr>
                <td>Paper</td>
                <td>:</td>
                <td>Version <?php echo $paper_version; ?></td>
            </tr>
            <tr>
                <td>Presentation</td>
                <td>:</td>
                <td>Version 0</td><?php //TODO: add version number of presentation ?>
            </tr>
        </table>
    </p>
    <p>
        Here, the term <b>Version</b>, is related to the number of times you successfully submitted a particular document, against a particular paper ID.
    </p>
    <p>
        <b>Version 1</b> implies the specified document has been submitted once. <b>Version 2</b> implies it has been submitted twice (i.e. you have submitted a revised document once) and so on...
    </p>
    <p>
        If status of a particular document is set to <span style="color: red; font-weight: bold">Version 0</span> it implies you haven't submitted that document for the specified paper. Kindly note that in such a case you must send us the document in question on or before the last date, as given on the <a href="<?php echo HOST.BASEURL; ?>importantdates">Important Dates</a> page.
    </p>
    <p>
        For any further clarification, feel free to mail us at conference@bvicam.ac.in
    </p>
    <p></p>
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
</body>
</html>