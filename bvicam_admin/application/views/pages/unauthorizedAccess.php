<html>
<head lang="en">
    <title>INDIACom 2016</title>
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
    <div class="row topBlock">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <center>
				<img src="/<?php echo PATH ?>assets/images/bvicamlogo.png" class="img-responsive">
				<h1 class="page-header">BVICAM Admin System</h1>
				
			</center>
		</div>
		<div class="col-md-12 col-sm-12 col-xs-12 alert alert-danger">
            <?php if(isset($message)) echo "<h4>$message</h4>"; ?>
		    <center>
		    <h1>Sorry, You are not authorized to access this page!</h1>
            <p class="lead">
                Or If you were searching for Meth, Call Heisenberg!
            </p>
            </center>
        </div>
    </div>
</div>
</body>