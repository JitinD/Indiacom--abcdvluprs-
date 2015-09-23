<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12 text-center">
        <a href="http://www.csi-india.org/" target="_blank"><img src="/<?php echo PATH ?>assets/images/sponsors/csi.jpg"
                                                                 class="sponsorImage"></a>
        <a href="http://isteonline.in/" target="_blank"><img src="/<?php echo PATH ?>assets/images/sponsors/iste.jpg"
                                                             class="sponsorImage"></a>
        <a href="http://www.ipu.ac.in/" target="_blank"><img src="/<?php echo PATH ?>assets/images/sponsors/ipu.jpg"
                                                             class="sponsorImage"></a>
        <a href="http://iete.org/" target="_blank"><img src="/<?php echo PATH ?>assets/images/sponsors/iete.png"
                                                        class="sponsorImage"></a>
        <a href="http://www.theiet.org/" target="_blank"><img src="/<?php echo PATH ?>assets/images/sponsors/iet.jpg"
                                                              class="sponsorImage"
                                                              style="width: 150px; height: 70px;"></a>

    </div>
</div>
<hr>
<div class="row">
    <div class="col-md-4 col-sm-4 col-xs-12 text-center">
        <div id="carousel-example-generic" class="carousel slide" data-ride="carousel" data-interval="2000">
            <!-- Indicators -->
            <ol class="carousel-indicators">
                <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                <li data-target="#carousel-example-generic" data-slide-to="1"></li>
                <li data-target="#carousel-example-generic" data-slide-to="2"></li>
                <li data-target="#carousel-example-generic" data-slide-to="3"></li>
                <li data-target="#carousel-example-generic" data-slide-to="4"></li>
            </ol>
            <!-- Wrapper for slides -->
            <div class="carousel-inner">
                <div class="item active">
                    <img src="/<?php echo PATH ?>assets/images/OldIndiacom/1.jpg" alt="..."
                         class="carousel-image">
                </div>
                <div class="item">
                    <img src="/<?php echo PATH ?>assets/images/OldIndiacom/2.jpg" alt="..."
                         class="carousel-image">
                </div>
                <div class="item">
                    <img src="/<?php echo PATH ?>assets/images/OldIndiacom/3.jpg" alt="..."
                         class="carousel-image">
                </div>
                <div class="item">
                    <img src="/<?php echo PATH ?>assets/images/OldIndiacom/4.jpg" alt="..."
                         class="carousel-image">
                </div>
                <div class="item">
                    <img src="/<?php echo PATH ?>assets/images/OldIndiacom/5.jpg" alt="..."
                         class="carousel-image">
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
    <div class="col-md-5 col-sm-4 col-xs-12 text-justify">
        <p>
            Throughout the world, nations have started recognizing that IT is now acting as a catalyst in speeding up
            the economic activity in efficient governance, citizens' empowerment and in improving the quality of human
            life.
        </p>

        <p>
            Since its inception in the year 2007, <strong>INDIACom</strong> has attracted eminent academicians,
            scientists, researchers,
            industrialists, technocrats, government representatives, social visionaries and experts from all strata of
            society, to explore the new horizons of innovations to identify opportunities and define the path forward.
            This new path is aimed at eliminating isolation, discouraging redundant efforts and promoting scientific
            progress to accelerate nations' economic growth to prominence in the international arena; and also at
            contributing effectively to realize the nations' vision of sustainable inclusive development using
            computing.
        </p>


    </div>
    <div class="col-md-3 col-sm-3 col-xs-12 text-center">
        <ul class="list-group text-left">
            <li class="list-group-item text-center"><strong>News</strong></li>
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
            <a class="btn btn-primary btn-block" href="/<?php echo BASEURL; ?>News/load">All News &raquo;</a>
        </ul>
    </div>
</div>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12 text-justify">
        <p>
            Encouraged by the resounding success met with the prior editions of INDIACom, we, announce <strong>10th
                INDIACom;
                3rd 2016 International Conference as INDIACom-2016</strong>. INDIACom, as always, aims at providing
            an
            effective
            platform to the researchers from all over the world to show-case their original research work, have
            effective exchange of ideas and develop a strategic plan for balanced and inclusive growth of economy
            through IT in critical areas like E-Governance, E-Commerce, Disaster Management, GIS, Geo-spatial
            Technologies, Nano-Technology, Intellectual Property Rights, AI and Expert Systems, Networking, Software
            Engineering, High Performance Computing and other Emerging Technologies.
        </p>

        <p>
            <strong>INDIACom-2016</strong> will be held at <strong>Bharati Vidyapeeth, New Delhi (INDIA).</strong>
            The
            conference will provide a platform
            for technical exchanges within the research community and will encompass regular paper presentation
            sessions, invited talks, key note addresses, panel discussions and poster exhibitions. In addition, the
            participants will be treated to a series of cultural activities, receptions and networking to establish
            new
            connections and foster everlasting friendship among fellow counterparts. The conference will also
            provide
            opportunity to the participants to visit some of the world's famous tourist places in Delhi like Qutub
            Minar, Red Forte, Akshardham Temple, Lotus Temple, Jantar Mantar and Taj Mahal at Agra (around 200 KM
            from
            Delhi).
        </p>

        <p>
            <strong>INDIACom-2016</strong> will be an amalgamation of four different Tracks organized parallel to
            each
            other, in addition
            to few theme based Special Sessions, as listed below:-
        </p>
        <table class="table table-responsive table-bordered">
            <b>
                <tr class="text-success">
                    <td>Track # 1:</td>
                    <td>Sustainable Computing</td>
                </tr>
                <tr class="text-danger">
                    <td>Track # 2:</td>
                    <td>High Performance Computing</td>
                </tr>
                <tr>
                    <td>Track # 3:</td>
                    <td>High Speed Networking and Information Security</td>
                </tr>
                <tr class="text-primary">
                    <td>Track # 4:</td>
                    <td>Software Engineering and Emerging Technologies</td>
                </tr>
                <tr class="text-warning">
                    <td>Track # 5:</td>
                    <td>Theme Based Special Sessions</td>
                </tr>
            </b>
        </table>
        <h2>Important Dates</h2>
        <table class="table table-responsive table-bordered">
            <tr>
                <td class="text-theme">Submission of Full Length Paper</td>
                <td>10<sup>th</sup> November, 2015</td>
            </tr>
            <tr>
                <td class="text-theme">Paper Acceptance Notification</td>
                <td>12<sup>th</sup> January, 2016</td>
            </tr>
            <tr>
                <td class="text-theme">Submission of CRC</td>
                <td>25<sup>th</sup> January, 2016</td>
            </tr>
            <tr>
                <td class="text-theme">Registration Deadline(for inclusion of Paper in Proceedings)</td>
                <td>1<sup>st</sup> February, 2016</td>
            </tr>
        </table>
        <p>
            <strong><em>INDIACom-2016&nbsp;</em></strong>is approved by&nbsp;<strong>IEEE's Conference Publication
                Program (IEEE CPP)</strong>. This means that the Conference proceedings of accepted papers (for oral
            presentations), <strong>which will be presented in the conference</strong>, will be submitted to IEEE
            Xplore, which is indexed with world&rsquo;s leading <strong>Abstracting &amp; Indexing
                (A&amp;I)</strong>
            databases, including <font color="#FF0000"><strong>ISI, SCOPUS, DBLP, EI-Compendex,</strong></font>
            etc.</span></font></p>
        </p>
    </div>
</div>
