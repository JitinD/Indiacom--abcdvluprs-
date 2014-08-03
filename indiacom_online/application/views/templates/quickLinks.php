<?php
/**
 * Created by PhpStorm.
 * User: lavis_000
 * Date: 10/07/14
 * Time: 10:53
 */
?>

<div class="row border-bottom contentBlock-top bg-dark-blue text-light">
    <div class="col-md-10 col-sm-10 col-xs-12 text-center">
        <ul class="list-inline" style="font-size: 16px;">
            <span class="h4 text-muted">Quick Links &raquo;</span
            <li>
                <a href="/<?php echo INDIACOM; ?>callForPapers" class="text-light">Call For Papers</a>
            </li>
            <li>
                <a href="/<?php echo INDIACOM; ?>importantdates" class="text-light">Important Dates</a>
            </li>
            <li>
                <a href="/<?php echo INDIACOM; ?>reachingBVICAM" class="text-light">Reaching BVICAM</a>
            </li>
            <li>
                <a href="/<?php echo INDIACOM; ?>accomodation" class="text-light">Accomodation</a>
            </li>
            <?php
            if ( !isset($_SESSION['member_id']) )
            {
            ?>
            <li>
                <a href="/<?php echo INDIACOM; ?>d/SignUpController/signUp" class="text-light">Register</a>
            </li>
            <?php
            }
            ?>
        </ul>
    </div>
    <div class="col-md-2 col-sm-2 col-xs-12">
        <form role="search">
            <div class="input-group input-group-sm">
                <input type="text" class="form-control input-sm" placeholder="Search" name="srch-term" id="srch-term">
                <div class="input-group-btn">
                    <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
                </div>
            </div>
        </form>
    </div>
</div>