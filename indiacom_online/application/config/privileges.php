<?php
/**
 * Created by PhpStorm.
 * User: Kisholoy
 * Date: 7/21/14
 * Time: 11:38 PM
 */

$privilege['Page']['Registration']['validate_captcha'] = array('R0');
$privilege['Page']['Registration']['validate_mobileNumber'] = array('R1');
$privilege['Page']['Registration']['validate_confirm_password'] = array('R2');
$privilege['Page']['Registration']['formFilledCheck'] = array('R3');
$privilege['Page']['Registration']['forgotPassword'] = array('R4');
$privilege['Page']['Registration']['signUp'] = array('R5');
$privilege['Page']['Registration']['EnterPassword'] = array('R6');
$privilege['Page']['Registration']['forgotLoginCredentials'] = array('R7');

$privilege['Page']['MainController']['viewPage'] = array('MC0');
$privilege['Page']['MainController']['index'] = array('MC1');

$privilege['Page']['Login']['index'] = array('L0');
$privilege['Page']['Login']['usernameCheck'] = array('L1');
$privilege['Page']['Login']['passwordCheck'] = array('L2');
$privilege['Page']['Login']['logout'] = array('L3');

$privilege['Page']['AJAX']['fetchOrganisationNames'] = array('A0');
$privilege['Page']['AJAX']['tracks'] = array('A1');
$privilege['Page']['AJAX']['subjects'] = array('A2');

$privilege['Page']['Dashboard']['home'] = array('D0');
$privilege['Page']['Dashboard']['uploadBiodata'] = array('D1');
$privilege['Page']['Dashboard']['submitPaper'] = array('D2');
$privilege['Page']['Dashboard']['authorsCheck'] = array('D3');
$privilege['Page']['Dashboard']['paperTitleCheck'] = array('D4');
$privilege['Page']['Dashboard']['submitPaperRevision'] = array('D5');
$privilege['Page']['Dashboard']['paperInfo'] = array('D6');
$privilege['Page']['Dashboard']['changePassword'] = array('D7');
$privilege['Page']['Dashboard']['resetPassword'] = array('D8');
$privilege['Page']['Dashboard']['validateCurrentPassword'] = array('D9');
$privilege['Page']['Dashboard']['validateConfirmPassword'] = array('D10');
$privilege['Page']['Dashboard']['downloadBiodata'] = array('D11');
$privilege['Page']['Dashboard']['editProfile'] = array('D12');
$privilege['Page']['Dashboard']['payment'] = array('D13');
$privilege['Page']['Dashboard']['transaction'] = array('D14');
$privilege['Page']['Dashboard']['payablesChart'] = array('D15');
$privilege['Page']['Dashboard']['request_special_session'] = array('D16');
$privilege['Page']['Dashboard']['special_sessions_list'] = array('D17');
$privilege['Page']['Dashboard']['my_special_session'] = array('D18');
$privilege['Page']['Dashboard']['special_session'] = array('D19');
$privilege['Page']['Dashboard']['special_session_details'] = array('D20');
$privilege['Page']['Dashboard']['edit_session_Chairperson'] = array('D21');
$privilege['Page']['Dashboard']['add_aoc'] = array('D22');
$privilege['Page']['Dashboard']['add_tpc'] = array('D23');

$privilege['Page']['News']['load'] = array('N0');
$privilege['Page']['News']['viewNews'] = array('N1');