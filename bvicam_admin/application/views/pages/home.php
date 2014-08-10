<div class="container-fluid contentBlock-top">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <hr>
                <h2>
                    Welcome, <span class="abcdvluprs">@abcdvluprs</span>
                </h2>
            <hr>
            <div class="row">

                <?php
                for($i=0;$i<12;$i++)
                {
                    ?>
                    <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12 text-center">
                        <a href="#">
                            <div class="panel text-muted">
                                    <h3>
                                        Thumbnail
                                        <br/>
                                        <?php
                                        echo $i
                                        ?>
                                    </h3>
                            </div>
                        </a>
                    </div>
                <?php
                }
                ?>
            </div>
        </div>
    </div>
</div>