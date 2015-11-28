<?php
/**
 * Created by PhpStorm.
 * User: Jitin
 * Date: 1/8/14
 * Time: 11:39 PM
 */

?>


<html>
    <head>
    </head>

    <body>
        <h1> BVICAM welcomes you! </h1>
        <br/>
        Thank you for signing up.

        <br/>
        <br/>

        To confirm your registration please click on the following link.
        <br/>
        <a href = "<?php echo HOST.BASEURL ?>d/Registration/EnterPassword/<?php echo $member_id?>/<?php echo $activation_code ?>">http://<?php echo HOST.BASEURL ?>d/Registration/EnterPassword/<?php echo $member_id?>/<?php echo $activation_code ?></a>
        <br/><br/>
        If you are not able to click on the above link just copy the link and paste it in the address bar of your browser.<br/><br/>
        Thank you
    </body>
</html>