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
Dear <?php echo $member_name; ?>,<br/><br/>
A new version of your paper <strong><?php echo $paper_title; ?></strong> having Paper Code <strong><?php echo $paper_code; ?></strong> has been submitted.<br/><br/>
<?php
if($complianceReport)
{
?>
You will find a copy of the new version and the compliance report in the attachments.<br/><br/>
<?php
}
else
{
?>
You will find a copy of the new version in the attachments.<br/><br/>
<?php
}
?>
Thank You.
</body>
</html>