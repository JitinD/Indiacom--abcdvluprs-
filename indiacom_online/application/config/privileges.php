<?php
/**
 * Created by PhpStorm.
 * User: Kisholoy
 * Date: 7/21/14
 * Time: 11:38 PM
 */

$privilege['Page']['signup'] = array(57,93,94,69);
$privilege['Page']['EnterPassword'] = array(65,95,67);
$privilege['Page']['forgotPassword'] = array(65);

/*dashboardHome=
Select-paper_latest_version-53
Select-submission_master-13
Select-member_master-65
Select-organization_master-57
Select-member_category_master-69
*/
$privilege['Page']['dashboardHome'] = array(53,13,65,57,69);

/*submitPaper=
Select-event_master-73
Insert-paper_master-51
Insert-submission_master-15
Update-submission_master-14
Insert-paper_version_master-47
Select-track_master-9
Select-subject_master-17
Select-paper_master-49
*/
$privilege['Page']['submitpaper']=array(73,51,15,14,47,9,17,49);

/*submitPaperRevision=
Select-paper_master-49
Select-paper_version_master-45
Insert-paper_version_master-47
Select-paper_latest_version-53
Select-event_master-73
Select-subject_master-17
Select-track_master-9
Insert-submission_master-15
Update-submission_master-14
Select-submission_master-13
*/
$privilege['Page']['submitPaperRevision']=array(49,45,47,53,73,17,9,15,14,13);

/*paperInfo=
Select-submission_master-13
Select-paper_master-49
Select-subject_master-17
Select-track_master-9
Select-event_master-73
Select-paper_version_master-45
Select-review_result_master-25

*/
$privilege['Page']['paperInfo']=array(13,49,17,9,73,45,25);

/*submitPaperRevisionList=
Select-paper_latest_version-53
Select-submission_master-13
Select-paper_version_master-45
*/
$privilege['Page']['submitPaperRevisionList']=array(53,13,45);

/*changePassword=
Select-member_master-65
Update-member_master-66
*/
$privilege['Page']['changePassword']=array(65,66);

/*editProfile=
Select-member_master-65
Select-member_category_master-69
Select-organization_master-57
Update-member_master-66
*/
$privilege['Page']['editProfile']=array(65,69,57,66);

$privilege['Page']['news'] = array(89,61);
/*
Select - indiacom_news_master 89
Select - news_master 61
*/
$privilege['Page']['newsitem'] = array(89,61,85);
/*
Select - indiacom_news_master 89
Select - news_master 61
Select - indiacom_news_attachments 85
*/


/*submitRequestForSpecialSession=
Insert-track_master-47
*/

$privilege['Page']['request_special_session'] = array(49,15);
