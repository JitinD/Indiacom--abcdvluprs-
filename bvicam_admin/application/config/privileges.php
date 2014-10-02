<?php
/**
 * Created by PhpStorm.
 * User: Kisholoy
 * Date: 7/21/14
 * Time: 11:38 PM
 */

//$privilege['Page']['ConvenerDashboardHome'] = array(73);
//$privilege['Page']['RoleManager']['index'] = array(30);

/*
 * New Role -   application_master  select
 *              role_master         insert, select
 *              privilege_master    insert, select
 *              privilege_role_mapper   insert
 *              database_user       insert
 * Edit Role -  role_master         select
 *              privilege_master    insert, select
 *              privilege_role_mapper   insert
 * Enable Role -    role_master     update
 * Disable Role -   role_master     update
 * Delete Role -    privilege_role_mapper   delete
 *                  role_master             select, delete
 *                  database_user           delete
 *                  user_role_mapper        delete
 * Refresh Db User -    role_master         select
 *                      privilege_role_mapper   select
 */
$privilege['Component']['Role Manager']['New Role'] = array(23, 21, 39, 37, 35, 79);
$privilege['Component']['Role Manager']['Edit Role'] = array(21, 39, 37, 35);
$privilege['Component']['Role Manager']['Enable Role'] = array(22);
$privilege['Component']['Role Manager']['Disable Role'] = array(22);
$privilege['Component']['Role Manager']['Delete Role'] = array(36, 21, 24, 80, 8);
$privilege['Component']['Role Manager']['Refresh Db User'] = array(21, 33);

/*
 * New User -   application_master  select
 *              role_master         select
 *              user_master         insert, select
 *              user_role_mapper    insert
 * Edit User -  application_master  select
 *              user_role_mapper    insert
 *              user_master         select
 *              role_master         select
 * Enable User -    user_master     update
 * Disable User -   user_master     update
 * Delete User -    user_role_mapper    delete
 *                  user_master         delete
 */
$privilege['Component']['User Manager']['New User'] = array(21, 3, 1, 7);
$privilege['Component']['User Manager']['Edit User'] = array(7, 1, 21);
$privilege['Component']['User Manager']['Enable User'] = array(2);
$privilege['Component']['User Manager']['Disable User'] = array(2);
$privilege['Component']['User Manager']['Delete User'] = array(8, 4);

$privilege['Component']['Initial Paper Reviewer']['Sample'] = array();

$privilege['Component']['Final Paper Reviewer']['Sample'] = array();

$privilege['Component']['News Maker']['Sample'] = array();