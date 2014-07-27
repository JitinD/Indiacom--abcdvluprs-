<div class="row contentBlock-top">
    <div class="col-lg-2 col-md-3 col-sm-3 col-xs-12">
       <?php include('importantdatesPanel.php'); ?>
    </div>
    <div class="col-lg-9 col-md-8 col-sm-8 col-xs-12">
        <span class="h1 text-theme">News</span>
        <hr>
        <div class="row body-text">
            <div class="col-md-12">
                <table class="table table-hover">

                    <thead>
                    <tr>
                        <th>News</th>
                        <th>Date</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach($results as $data) { ?>
                        <tr>
                            <td>
                                <a href="<?php echo $data->news_description_url?>"><?php echo $data->news_title ?> </a>
                            </td>
                            <td><?php echo $data->news_publish_date ?></td>
                        </tr>
                    <?php
                    }
                    ?>
                    </tbody>
                    </table>
                <?php echo $links ?>
<!--                    <tbody>-->
<!--                    <tr>-->
<!--                        <td>1</td>-->
<!--                        <td><a href="#">Call for Papers: INDIACom-2015</a></td>-->
<!--                        <td>26<sup>th</sup> July, 2014</td>-->
<!---->
<!--                    </tr>-->
<!--                    <tr>-->
<!--                        <td>2</td>-->
<!--                        <td>Plagiarism Policy: INDIACom-2015</td>-->
<!--                        <td>26<sup>th</sup> July, 2014</td>-->
<!--                    </tr>-->
<!--                    <tr>-->
<!--                        <td>3</td>-->
<!--                        <td>Papers presented during INDIACom - 2014, are now available online at IEEE Xplore</td>-->
<!--                        <td>26<sup>th</sup> July, 2014</td>-->
<!--                    </tr>-->
<!--                    </tbody>-->
<!--                </table>-->
<!--            </div>-->
<!--        </div>-->
<!--        <div class="row contentBlock-top">-->
<!--            <div class="col-md-6 col-md-offset-6 col-sm-6 col-sm-offset-6 col-xs-8 col-xs-offset-3">-->
<!--                <div class="btn-toolbar" role="toolbar">-->
<!--                    <div class="btn-group">-->
<!--                        <button type="button" class="btn btn-default">First</button>-->
<!--                        <button type="button" class="btn btn-default">Previous</button>-->
<!--                        <button type="button" class="btn btn-default">Next</button>-->
<!--                        <button type="button" class="btn btn-default">Last</button>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!---->
<!--        </div>-->
<!--    </div>-->
<!---->
<!--</div>-->