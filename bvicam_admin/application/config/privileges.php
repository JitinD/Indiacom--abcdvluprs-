<?php
/**
 * Created by PhpStorm.
 * User: Kisholoy
 * Date: 7/21/14
 * Time: 11:38 PM
 */

/*
 * application_master select
 * news_master select
 *
 */
$privilege['Page']['NewsManager']['allNews'] = array(81, 61);

/*
 * event_master select
 * application_master select
 * news_master insert
 * indiacom_news_master insert
 * indiacom_news_attachments insert
 */
$privilege['Page']['NewsManager_IndiacomOnlineSystem']['addNews'] = array(73, 81, 63, 91, 87);

/*
 * news_master update
 * indiacom_news_master update
 */
$privilege['Page']['NewsManager_IndiacomOnlineSystem']['disableNews'] = array(62, 90);

/*
 * news_master update
 * indiacom_news_master update
 */
$privilege['Page']['NewsManager_IndiacomOnlineSystem']['enableNews'] = array(62, 90);

/*
 * indiacom_news_attachments select
 * indiacom_news_attachments delete
 * indiacom_news_master delete
 * news_master delete
*/
$privilege['Page']['NewsManager_IndiacomOnlineSystem']['deleteNews'] = array(85, 88, 92, 64);

/*
 * index-
 * role_master-Select-21
 */
$privilege['Page']['RoleManager']['index']=array(21);

/*newRole
application_master-Select-81
role_master-Insert-23
role_master-Select-21
privilege_master-Insert-39
privilege_master-Select-37
privilege_roll_mapper-insert-35*/
$privilege['Page']['RoleManager']['newRole']=array(81,23,21,39,37,35);

/*viewRole
role_master-Select-21
privilege_role_mapper-select-33
privilege_role_mapper-insert-35
privilege_master-select-37
privilege_master-insert-39*/
$privilege['Page']['RoleManager']['viewRole']=array(21,33,35,37,39);

/*
enableRolePrivilege
privilege_role_mapper-update-34
 */
$privilege['Page']['RoleManager']['enableRolePrivilege']=array(34);

/*
 * disableRolePrivilege
 privilege_role_mapper-update-34
 */
$privilege['Page']['RoleManager']['disableRolePrivilege']=array(34);

/*
 * deleteRolePrivilege
 * privilege_role_mapper-delete-36
 */
$privilege['Page']['RoleManager']['deleteRolePrivilege']=array(36);

/*
 * disableRole
 * role_master-update-22
 */
$privilege['Page']['RoleManager']['disableRole']=array(22);

/*
 * enableRole
 * role_master-update-22
 */
$privilege['Page']['RoleManager']['enableRole']=array(22);

/*
 *deleteRole-
 * privilege_role_mapper-delete-36
 * role_master-select-21
 * role_master-delete-24
 * user_event_role_mapper-delete-8
 */
$privilege['Page']['RoleManager']['deleteRole']=array(36,21,24,8);

$privilege['Page']['UserManager']['index'] = array(1);
/*
Select - User_Master - 1
*/

$privilege['Page']['UserManager']['newUser'] = array(81,3,1,21,7);
/*
select - application_master - 81
Select - user_master - 1
insert - user_master - 3
select - role_master - 21
Insert - user_event_role_mapper - 7
*/

$privilege['Page']['UserManager']['viewUser'] = array(81,5,7,21,1);
/*
Select - application_master - 81
Select - user_event_role_mapper - 5
Insert - user_event_role_mapper - 7
Select - user_master -
Select - role_master - 21
*/

$privilege['Page']['UserManager']['enableUser'] = array(2);
/*
Update - user_master - 2
*/

$privilege['Page']['UserManager']['disableUser'] = array(2);
/*
Update - user_master - 2
*/

$privilege['Page']['UserManager']['deleteUser'] = array(8,4);
/*
Delete - user_event_role_mapper - 8
Delete - user_master - 4
*/

$privilege['Page']['UserManager']['enableUserRole'] = array(6);
/*
Update - user_event_role_mapper - 6
*/

$privilege['Page']['UserManager']['disableUserRole'] = array(6);
/*
Update - user_event_role_mapper - 6
*/

$privilege['Page']['UserManager']['deleteUserRole'] = array(8);
/*
Delete - user_event_role_mapper - 8
*/

//	INITIAL PAPER REVIEWER

/*	index	-	paper_master 			select
                paper_version_master 	select
                paper_version_review 	select

*/

$privilege['Page']['InitialPaperReviewer']['ReviewerDashboardHome'] = array(49, 45, 41);

/*	reviewPaperInfo	-	paper_master 			select
                        subject_master 			select
                        track_master 			select
                        event_master 			select
                        submission_master 		select
                        paper_version_review 	select, update
                        paper_version_master 	select

*/

$privilege['Page']['InitialPaperReviewer']['reviewPaperInfo'] = array(49, 17, 9, 73, 13, 41, 42, 45);


//	FINAL PAPER REVIEWER

/*	index	-	paper_master 			select
                paper_version_master 	select

*/

$privilege['Page']['FinalPaperReviewer']['ConvenerDashboardHome'] = array(49,45);

/*	setReviewerAssigned	-	paper_version_master 	update		*/

$privilege['Page']['FinalPaperReviewer']['setReviewerAssigned'] = array(46);

/*	paperInfo	-	paper_master 			select
                    subject_master 			select
                    track_master 			select
                    event_master 			select
                    submission_master 		select
                    paper_version_master 	select, update
                    paper_version_review 	insert, delete, select
                    review_result_master 	select
                    reviewer_master 		select
                    user_master 			select

*/

$privilege['Page']['FinalPaperReviewer']['paperInfo'] = array(49, 17, 9, 73, 13, 45, 46, 43, 44, 41, 25, 29, 1);

/*$privilege['Page']['PaymentsManager']['viewPayments'] = array(112,13,120,124,116,104,65,21,33,49);
$privilege['Page']['PaymentsManager']['newPayment'] = array(120,112,65,148,173,69,53,13,49,17,9,96,100,116,104,108,124,21,33,126);
$privilege['Page']['PaymentsManager']['viewPaymentBreakup'] = array(112,104,120,115,65,148,173,69,53,13,49,17,9,96,100,116,108,124,21,33);
$privilege['Page']['PaymentsManager']['changePayableClass'] = array(69,108,124,104,115,21,33);
$privilege['Page']['PaymentsManager']['changeDiscountType'] = array(115,112,116,104,21,33);
$privilege['Page']['PaymentsManager']['spotPayment'] = array(124,116,21,33,53,13,49,17,9,96,100,122,113,124,65,112,120,104,108);*/
$privilege['Page']['PaymentsManager'][] = array(45435);

$privilege['Page']['TransactionManager'][] = array(45435);

$privilege['Page']['ReportManager'][] = array(435435);

$privilege['Page']['DeskManager']['paperAuthorsPayments'] = array(49,17,9,112,104,13,116,120,65,53,96,100,128,108,124,21,33,73);
$privilege['Page']['DeskManager']['authorPapersPayments'] = array(124,65,69,53,13,49,17,9,96,100,112,104,116,120,128,108,21,33);

$privilege['Page']['TrackManager']['markAuthorAttendance'] = array(53,13,49,17,9,96,100,65,128,132);
$privilege['Page']['TrackManager']['markPaperAttendance'] = array(53,13,49,17,9,96,100,65,128,132);

$privilege['Page']['DeliverablesManager']['assignMemberDeliverables'] = array(124,112,120,13,104,116,136,21,33);
$privilege['Page']['DeliverablesManager']['assignPaperDeliverables'] = array(124,112,120,13,104,116,136,21,33);

$privilege['Page']['Page']['home'] = array(21,33);
$privilege['Page']['SpecialSessionRequests']['session_details']=array(21);
$privilege['Page']['SpecialSessionRequests']['add_sessions']=array(21);
$privilege['Page']['SpecialSessionRequests']['view_sessions']=array(21);
$privilege['Page']['SpecialSessionRequests']['verify_sessions_tracks']=array(21);
$privilege['Page']['SpecialSessionRequests']['view_request_fail']=array(21);
$privilege['Page']['SpecialSessionRequests']['view_request_success']=array(21);