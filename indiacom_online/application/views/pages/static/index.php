<div class="row contentBlock-top">
    <div class="col-md-4 col-sm-12 col-xs-12 text-center">
        <span class="text-theme h2">Sponsors</span>
        <br>
        <img src="/<?php echo PATH ?>assets/images/sponsors/csi-gjlogo.jpg" class="sponsorImage">
        <img src="/<?php echo PATH ?>assets/images/sponsors/csi.jpg" class="sponsorImage">
        <img src="/<?php echo PATH ?>assets/images/sponsors/iste.jpg" class="sponsorImage">
        <img src="/<?php echo PATH ?>assets/images/sponsors/ipu.jpg" class="sponsorImage">
        <img src="/<?php echo PATH ?>assets/images/sponsors/iete.png" class="sponsorImage">
        <img src="/<?php echo PATH ?>assets/images/sponsors/iet.jpg" class="sponsorImage"
             style="width: 150px; height: 70px;">

    </div>
    <div class="col-md-5 col-sm-6 col-xs-12">
        <div id="carousel-example-generic" class="carousel slide" data-ride="carousel" data-interval="2000">
            <!-- Indicators -->
            <ol class="carousel-indicators">
                <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                <li data-target="#carousel-example-generic" data-slide-to="1"></li>
                <li data-target="#carousel-example-generic" data-slide-to="2"></li>
                <li data-target="#carousel-example-generic" data-slide-to="3"></li>
                <li data-target="#carousel-example-generic" data-slide-to="4"></li>
                <li data-target="#carousel-example-generic" data-slide-to="5"></li>
            </ol>
            <!-- Wrapper for slides -->
            <div class="carousel-inner">
                <div class="item active">
                    <img src="/<?php echo PATH ?>assets/images/OldIndiacom/INDIACom2007.jpg" alt="..."
                         class="carousel-image">

                    <div class="carousel-caption h1">
                        INDIACom 2007
                    </div>
                </div>
                <div class="item">
                    <img src="/<?php echo PATH ?>assets/images/OldIndiacom/INDIACom2008.jpg" alt="..."
                         class="carousel-image">

                    <div class="carousel-caption h1">
                        INDIACom 2008
                    </div>
                </div>
                <div class="item">
                    <img src="/<?php echo PATH ?>assets/images/OldIndiacom/INDIACom2009.jpg" alt="..."
                         class="carousel-image">

                    <div class="carousel-caption h1">
                        INDIACom 2009
                    </div>
                </div>
                <div class="item">
                    <img src="/<?php echo PATH ?>assets/images/OldIndiacom/INDIACom2010.jpg" alt="..."
                         class="carousel-image">

                    <div class="carousel-caption h1">
                        INDIACom 2010
                    </div>
                </div>
                <div class="item">
                    <img src="/<?php echo PATH ?>assets/images/OldIndiacom/INDIACom2011.jpg" alt="..."
                         class="carousel-image">

                    <div class="carousel-caption h1">
                        INDIACom 2011
                    </div>
                </div>
                <div class="item">
                    <img src="/<?php echo PATH ?>assets/images/OldIndiacom/INDIACom2012.jpg" alt="..."
                         class="carousel-image">

                    <div class="carousel-caption h1">
                        INDIACom 2012
                    </div>
                </div>
            </div>

            <!-- Controls -->
            <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
                <span class="glyphicon glyphicon-chevron-left"></span>
            </a>
            <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
                <span class="glyphicon glyphicon-chevron-right"></span>
            </a>
        </div>
    </div>
    <div class="col-md-3 col-sm-6 col-xs-12 text-center">
        <span class="text-theme h2">News</span>
        <br>
        <ul class="list-group text-left h5">
            <?php
            foreach ($stickyNews as $news) {
                ?>
                <li class="list-group-item"><a
                        href="/<?php echo BASEURL; ?>News/viewNews/<?php echo $news->news_id; ?>"><?php echo $news->news_title . "<br>"; ?></a>
                </li>
            <?php
            }
            ?>
            <?php
            foreach ($nonStickyNews as $news) {
                ?>
                <li class="list-group-item"><a
                        href="/<?php echo BASEURL; ?>News/viewNews/<?php echo $news->news_id; ?>"><?php echo $news->news_title . "<br>"; ?></a>
                </li>
            <?php
            }
            ?>
            <a class="btn btn-default btn-block" href="/<?php echo INDIACOM; ?>News/load">All News &raquo;</a>
        </ul>
    </div>


</div>
