<?php
/**
 * Created by PhpStorm.
 * User: Jitin
 * Date: 1/8/14
 * Time: 11:39 PM
 */

?>
<html>
<body>
    <p>
        A password reset request was created. Click on the below link to reset your password.
    </p>
    <p>
        Reset password link<br/>
        <a href = "<?php echo HOST.BASEURL; ?>Dashboard/ResetPassword/<?php echo $member_id?>/<?php echo $activation_code ?>">http://<?php echo HOST.BASEURL; ?>Dashboard/ResetPassword/<?php echo $member_id?>/<?php echo $activation_code ?></a>
    </p>
    <p>
        If you did not request to reset your password then ignore this mail and do not click on the Reset password link.
    </p>
</body>
</html>