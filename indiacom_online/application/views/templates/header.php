<?php
/**
 * Created by PhpStorm.
 * User: Jitin
 * Date: 15/7/14
 * Time: 1:01 PM
 */
?>

<html>
<head lang="en">
    <title>INDIACom 2016</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <link rel="stylesheet" href="/<?php echo PATH ?>assets/css/cosmo-bootstrap.min.css">
    <link rel="stylesheet" href="/<?php echo PATH ?>assets/css/jasny-bootstrap.min.css">
    <link rel="stylesheet" href="/<?php echo PATH ?>assets/css/siteStyle.css">
    <link rel="stylesheet" href="/<?php echo PATH ?>assets/css/textStyle.css">
    <script src="/<?php echo PATH ?>assets/js/jquery.min.js"></script>
    <script src="/<?php echo PATH ?>assets/js/bootstrap.min.js"></script>
    <script src="/<?php echo PATH ?>assets/js/jasny-bootstrap.min.js"></script>
    <script src="/<?php echo PATH ?>assets/js/list.js"></script>
    <script src='https://www.google.com/recaptcha/api.js'></script>
</head>
<body>
<div class="container-fluid">
    <?php

    include(dirname(__FILE__) . "/../pages/loginPage.php");
    include(dirname(__FILE__) . "/../templates/banner.php");
    include(dirname(__FILE__) . "/../templates/navbar.php");
    include(dirname(__FILE__) . "/../templates/quickLinks.php");
    ?>
    <div class="container">