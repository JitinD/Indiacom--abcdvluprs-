<?php
/**
 * Created by PhpStorm.
 * User: Kisholoy
 * Date: 7/27/14
 * Time: 1:58 AM
 */

?>
<html>
<head lang="en">
    <title>INDIACom 2015</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <link rel="stylesheet" href= "/<?php echo PATH ?>assets/css/bootstrap.css">
    <link rel="stylesheet" href="/<?php echo PATH ?>assets/css/siteStyle.css">
    <link rel="stylesheet" href="/<?php echo PATH ?>assets/css/textStyle.css">

    <script src="/<?php echo PATH ?>assets/js/jquery.min.js"></script>
    <script src="/<?php echo PATH ?>assets/js/bootstrap.min.js"></script>
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="row">
                <div class="col-md-3 col-sm-3 col-xs-12">
                    <center><img src="/<?php echo PATH ?>assets/images/bvicamlogo.png" class="img-responsive"></center>
                </div>
                <div class="col-md-9 col-sm-9 col-xs-12">
                    <h4>Bharati Vidyapeeth's Institute of Computer Applications &amp; Management</h4>
                </div>
            </div>
            <div class="row h2">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <?php echo $page_error; ?> <br>
                    <?php
                    if(isset($_GET['mysql_error']))
                        echo $_GET['mysql_error'];
                    ?>
                </div>
            </div>
            <div>
                <?php
                echo $_SESSION[APPID]['dbUserName'];
                ?>
            </div>
        </div>
    </div>
</div>
</body>