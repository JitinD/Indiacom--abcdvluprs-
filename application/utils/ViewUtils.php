<?php
/**
 * Created by PhpStorm.
 * User: Kisholoy
 * Date: 7/21/14
 * Time: 11:38 PM
 */

function loginModalInit(&$data = array())
{
    $data['isFormError'] = isset($_SESSION['isFormError']) ? $_SESSION['isFormError'] : false;
    $data['usernameError'] = isset($_SESSION['usernameError']) ? $_SESSION['usernameError'] : "";
    $data['passwordError'] = isset($_SESSION['passwordError']) ? $_SESSION['passwordError'] : "";
    unset($_SESSION['isFormError']);
    unset($_SESSION['usernameError']);
    unset($_SESSION['passwordError']);
    return $data;
}

function pageNavbarItem($pageFileName)
{
    switch($pageFileName)
    {
        case "index" :
            return "Home";
        case "aboutIndiacom":
        case "listofspeakers":
        case "sponsors":
            return "About INDIACom";
        case "dashboardHome":
        case "submitpaper":
        case "submitPaperRevisionList":
            return "Dashboard";
        default:
            return "";
    }
}