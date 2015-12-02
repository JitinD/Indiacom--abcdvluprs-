<?php
/**
 * Created by PhpStorm.
 * User: saura_000
 * Date: 9/9/15
 * Time: 12:22 PM
 */

$allPrivileges = array();

if(file_exists(dirname(__FILE__).'/../bvicam_admin/application/config/privileges.php'))
{
    $privilege = array();
    require(dirname(__FILE__).'/../bvicam_admin/application/config/privileges.php');
    $allPrivileges["2a"] = $privilege;
}

if(file_exists(dirname(__FILE__).'/../indiacom_online/application/config/privileges.php'))
{
    $privilege = array();
    require(dirname(__FILE__).'/../indiacom_online/application/config/privileges.php');
    $allPrivileges["1a"] = $privilege;
}