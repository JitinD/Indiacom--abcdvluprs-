<div class="row contentBlock-top">
    <div class="col-lg-2 col-md-2 col-sm-3 col-xs-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <a href="/<?php echo BASEURL; ?>Dashboard/home" style="color: #333">Dashboard</a>
            </div>
            <ul class="list-group">
                <li class="list-group-item"><a href="/<?php echo BASEURL ?>Dashboard/editProfile">Edit Profile</a></li>
                <li class="list-group-item"><a href="/<?php echo BASEURL; ?>Dashboard/submitPaper">Submit Paper</a></li>
                <li class="list-group-item"><a href="/<?php echo BASEURL; ?>Dashboard/payment/1">Payments</a></li>
                <li class="list-group-item"><a href="/<?php echo BASEURL; ?>Dashboard/transaction/transactionHistory">Transaction History</a></li>
                <li class="list-group-item"><a href="/<?php echo BASEURL; ?>Dashboard/changePassword">Change Password</a></li>
                <li class="list-group-item"><a href="/<?php echo BASEURL; ?>Dashboard/special_sessions_list">Special Sessions</a></li>
                <li class="list-group-item"><a href="/<?php echo BASEURL; ?>Dashboard/request_special_session">Request for Special Session</a></li>
                <li class="list-group-item"><a href="/<?php echo BASEURL; ?>Dashboard/my_special_session">My Requested Special Sessions</a></li>


            </ul>
        </div>
        <?php include(dirname(__FILE__) . '/../../pages/static/importantdatesPanel.php');?>
    </div>
    <div class="col-md-9 col-sm-8 col-xs-12">
        <span class="h1 text-theme">Dashboard</span>
        <hr>
        <div class="row">