<?php
/**
 * Created by PhpStorm.
 * User: Kisholoy
 * Date: 7/21/14
 * Time: 11:38 PM
 */

$privilege['Page']['NewsManager']['load'] = array('NM0');

$privilege['Page']['NewsManager_IndiacomOnlineSystem']['addNews'] = array('NM_IOS0');
$privilege['Page']['NewsManager_IndiacomOnlineSystem']['disableNews'] = array('NM_IOS1');
$privilege['Page']['NewsManager_IndiacomOnlineSystem']['enableNews'] = array('NM_IOS2');
$privilege['Page']['NewsManager_IndiacomOnlineSystem']['deleteNews'] = array('NM_IOS3');

$privilege['Page']['RoleManager']['load']=array('RM0');
$privilege['Page']['RoleManager']['newRole']=array('RM1');
$privilege['Page']['RoleManager']['viewRole']=array('RM2');
$privilege['Page']['RoleManager']['enableRolePrivilege_AJAX']=array('RM3');
$privilege['Page']['RoleManager']['disableRolePrivilege_AJAX']=array('RM4');
$privilege['Page']['RoleManager']['addRolePrivilege_AJAX']=array('RM5');
$privilege['Page']['RoleManager']['deleteRolePrivilege_AJAX']=array('RM6');
$privilege['Page']['RoleManager']['disableRole_AJAX']=array('RM7');
$privilege['Page']['RoleManager']['enableRole_AJAX']=array('RM8');
$privilege['Page']['RoleManager']['deleteRole_AJAX']=array('RM9');

$privilege['Page']['UserManager']['load'] = array('UM0');
$privilege['Page']['UserManager']['newUser'] = array('UM1');
$privilege['Page']['UserManager']['viewUser'] = array('UM2');
$privilege['Page']['UserManager']['enableUser'] = array('UM3');
$privilege['Page']['UserManager']['disableUser'] = array('UM4');
$privilege['Page']['UserManager']['deleteUser'] = array('UM5');
$privilege['Page']['UserManager']['enableUserRole'] = array('UM6');
$privilege['Page']['UserManager']['disableUserRole'] = array('UM7');
$privilege['Page']['UserManager']['deleteUserRole'] = array('UM8');

$privilege['Page']['InitialPaperReviewer']['load'] = array('IPR0');
$privilege['Page']['InitialPaperReviewer']['reviewPaperInfo'] = array('IPR1');
$privilege['Page']['InitialPaperReviewer']['downloadPaperVersion'] = array('IPR2');

$privilege['Page']['FinalPaperReviewer']['loadAllPapers'] = array('FPR0');
$privilege['Page']['FinalPaperReviewer']['setReviewerAssigned'] = array('FPR1');
$privilege['Page']['FinalPaperReviewer']['paperInfo'] = array('FPR2');
$privilege['Page']['FinalPaperReviewer']['loadTrackPapers'] = array('FPR3');
$privilege['Page']['FinalPaperReviewer']['downloadPaperVersion'] = array('FPR4');
$privilege['Page']['FinalPaperReviewer']['downloadComplianceReport'] = array('FPR4');
$privilege['Page']['FinalPaperReviewer']['downloadConvenerReviewComments'] = array('FPR4');
$privilege['Page']['FinalPaperReviewer']['downloadReviewerComments'] = array('FPR4');

$privilege['Page']['PaymentsManager']['load'] = array('PM0');
$privilege['Page']['PaymentsManager']['viewPaymentsMemberWise'] = array('PM1');
$privilege['Page']['PaymentsManager']['viewPaymentsPaperWise'] = array('PM2');
$privilege['Page']['PaymentsManager']['newPayment'] = array('PM3');
$privilege['Page']['PaymentsManager']['paymentBreakup'] = array('PM4');
$privilege['Page']['PaymentsManager']['changePayableClass'] = array('PM5');
$privilege['Page']['PaymentsManager']['changeDiscountType'] = array('PM6');
$privilege['Page']['PaymentsManager']['paymentWaiveOff_AJAX'] = array('PM7');
$privilege['Page']['PaymentsManager']['spotPayments'] = array('PM8');

$privilege['Page']['TransactionManager']['newTransaction'] = array('TM0');
$privilege['Page']['TransactionManager']['loadUnusedTransactions'] = array('TM1');
$privilege['Page']['TransactionManager']['load'] = array('TM2');
$privilege['Page']['TransactionManager']['viewTransaction'] = array('TM3');
$privilege['Page']['TransactionManager']['setTransactionVerificationStatus_AJAX'] = array('TM4');

$privilege['Page']['ReportManager']['downloadReport'] = array('ReM0');
$privilege['Page']['ReportManager']['getReport'] = array('ReM1');
$privilege['Page']['ReportManager']['home'] = array('ReM2');
$privilege['Page']['ReportManager']['paymentsReport'] = array('ReM3');

$privilege['Page']['DeskManager']['home'] = array('DM0');
$privilege['Page']['DeskManager']['viewPaperAuthorsPayments'] = array('DM1');
$privilege['Page']['DeskManager']['viewAuthorPapersPayments'] = array('DM2');

$privilege['Page']['TrackManager']['home'] = array('TraM0');
$privilege['Page']['TrackManager']['markAuthorAttendance'] = array('TraM1');
$privilege['Page']['TrackManager']['markPaperAttendance'] = array('TraM2');

$privilege['Page']['DeliverablesManager']['assignDeliverables_AJAX'] = array('DeM0');
$privilege['Page']['DeliverablesManager']['assignMemberDeliverables'] = array('DeM1');
$privilege['Page']['DeliverablesManager']['assignPaperDeliverables'] = array('DeM2');

$privilege['Page']['CertificateManager']['markOutwardNumber_AJAX'] = array('CM0');
$privilege['Page']['CertificateManager']['markCertificateGiven_AJAX'] = array('CM1');
$privilege['Page']['CertificateManager']['removeCertificateRecord_AJAX'] = array('CM2');

$privilege['Page']['AttendanceManager']['markDeskAttendance_AJAX'] = array('AM0');
$privilege['Page']['AttendanceManager']['markTrackAttendance_AJAX'] = array('AM1');

$privilege['Page']['Page']['home'] = array('P0');

$privilege['Page']['SpecialSessionRequests']['session_details'] = array('SSR0');
$privilege['Page']['SpecialSessionRequests']['add_sessions'] = array('SSR1');
$privilege['Page']['SpecialSessionRequests']['view_sessions'] = array('SSR2');
$privilege['Page']['SpecialSessionRequests']['verify_sessions_tracks'] = array('SSR3');
$privilege['Page']['SpecialSessionRequests']['view_request_fail'] = array('SSR4');
$privilege['Page']['SpecialSessionRequests']['view_request_success'] = array('SSR5');

$privilege['Page']['EventManager']['load'] = array('EM0');
$privilege['Page']['EventManager']['newEvent'] = array('EM1');
$privilege['Page']['EventManager']['viewEvent'] = array('EM2');
$privilege['Page']['EventManager']['enableEvent_AJAX'] = array('EM3');
$privilege['Page']['EventManager']['disableEvent_AJAX'] = array('EM4');

$privilege['Page']['CoConvenerManager']['load'] = array('CCM0');
$privilege['Page']['CoConvenerManager']['setTrackCoConvener_AJAX'] = array('CCM1');