<div class="col-md-12 col-sm-12 col-xs-12" xmlns="http://www.w3.org/1999/html" xmlns="http://www.w3.org/1999/html">
    <h3 class="text-theme">Payments</h3>

    <hr>

    <form class="form-horizontal" method="post">
        <div id="step1">

            <span class="h3 text-primary">
                Your Outstanding Amount : #Calculate
            </span>
            <span class="h5 center-block text-success">
                Registration Category
                <span class="bg-primary">
                    <?php
                    foreach($registrationCategories as $category)
                    {
                        if($category['member_category_id'] == $registrationCat->member_category_id)
                        {
                            echo $category['member_category_name'];
                        }
                    }
                    ?>
                </span>
            </span>
            <span class="h5 center-block text-success">
                Currency
                <?php
                foreach($currencies as $currency)
                {
                    if($currency->currency_id == $selectedCurrency)
                    {
                ?>
                        <span class="bg-primary"><?php echo $currency->currency_name; ?></span>
                <?php
                    }
                    else
                    {
                ?>
                        <a href="<?php echo $currency->currency_id; ?>"><?php echo $currency->currency_name; ?></a>
                <?php
                    }
                }
                ?>
            </span>
            <span class="h5 center-block text-success">
                Professional Body Member
                <span class="bg-primary">
                    <?php
                    if($isProfBodyMember)
                        echo "Yes";
                    else
                        echo "No";
                    ?>
                </span>
            </span>
            <table class="table table-responsive table-striped table-hover">
                <thead>
                <tr>
                    <th>Paper ID</th>
                    <th>Paper Title</th>
                    <th>Discount</th>
                    <th>Payable</th>
                    <th>Waive Off</th>
                    <th>Paid</th>
                    <th>Pending</th>
                    <th>Pay Amount</th>
                    <th>Type</th>
                    <th>Remarks</th>
                </tr>
                </thead>
                <tbody>

                    <?php

                    if(empty($papers))
                    {
                        ?>
                        <tr>
                            <td colspan="6">
                                No Accepted Papers!
                            </td>
                        </tr>
                    <?php
                    }
                    else
                    {
                        foreach($papers as $paper)
                        {
                            ?>
                            <tr>
                                <td><?php echo $paper->paper_id; ?></td>
                                <td><?php echo $paper->paper_title; ?></td>
                                <td>
                                    <!--<span id = "BR" hidden = ""><?php /*echo $payable[$paper->paper_id]["BR"]; */?></span>
                                    <span id = "EP" hidden = ""><?php /*echo $payable[$paper->paper_id]["EP"]; */?></span>-->
                                </td>
                                <td>
                                    <span class="BR" <?php if(!isset($papersInfo[$paper->paper_id]['paid'])) {?> style="display: none;" <?php } ?>>
                                        <?php
                                        if(isset($papersInfo[$paper->paper_id]['br']))
                                            echo $papersInfo[$paper->paper_id]['br'];
                                        ?>
                                    </span>
                                    <span class="EP" <?php if(!isset($papersInfo[$paper->paper_id]['paid'])) {?> style="display: none;" <?php } ?>>
                                        <?php
                                        if(isset($papersInfo[$paper->paper_id]['ep']))
                                            echo $papersInfo[$paper->paper_id]['ep'];
                                        ?>
                                    </span>
                                </td>
                                <td>
                                    <span>
                                        <?php
                                        if(isset($papersInfo[$paper->paper_id]['waiveOff']))
                                            echo $papersInfo[$paper->paper_id]['waiveOff'];
                                        ?>
                                    </span>
                                </td>
                                <td>
                                    <span>
                                        <?php
                                        if(isset($papersInfo[$paper->paper_id]['paid']))
                                            echo $papersInfo[$paper->paper_id]['paid'];
                                        ?>
                                    </span>
                                </td>
                                <td>
                                    <span>
                                        <?php
                                        if(isset($papersInfo[$paper->paper_id]['pending']))
                                            echo $papersInfo[$paper->paper_id]['pending'];
                                        ?>
                                    </span>
                                </td>
                                <td>
                                    <input type="number" value="<?php if(isset($papersInfo[$paper->paper_id]['pending'])) echo $papersInfo[$paper->paper_id]['pending']; ?>"
                                           max="<?php if(isset($papersInfo[$paper->paper_id]['pending'])) echo $papersInfo[$paper->paper_id]['pending']; ?>" min="0">
                                </td>
                                <td>
                                    <?php
                                    if(isset($papersInfo[$paper->paper_id]['br']))
                                    {
                                    ?>
                                        <input type="radio" name="<?php echo $paper->paper_id; ?>_paytype" value="br" class="radio"> Basic Registration
                                        <input type="hidden" class="discount_br">
                                        <input type="hidden" class="payable_br"
                                               value="<?php echo $papersInfo[$paper->paper_id]['br']; ?>">
                                        <input type="hidden" class="paid_br">
                                        <input type="hidden" class="pending_br">
                                    <?php
                                    }
                                    if(isset($papersInfo[$paper->paper_id]['ep']))
                                    {
                                    ?>
                                        <input type="radio" name="<?php echo $paper->paper_id; ?>_paytype" value="ep" class="radio"> Extra Paper
                                        <input type="hidden" class="discount_ep">
                                        <input type="hidden" class="payable_ep"
                                               value="<?php echo $papersInfo[$paper->paper_id]['ep']; ?>">
                                        <input type="hidden" class="paid_ep">
                                        <input type="hidden" class="pending_ep">
                                        <?php
                                    }
                                    ?>
                                </td>
                                <td></td>
                            </tr>
                        <?php
                        }
                    }
                    ?>

                </tbody>
            </table>
            <div id="addMoreAuthors">
            </div>
            <hr>
            <div class="contentBlock-top">
                <button type="button" class="btn btn-success" id="button_addMoreAuthors">
                    Pay for Another Author &nbsp;<span class="glyphicon glyphicon-plus"></span>
                </button>
            </div>
            <hr>
        <span class="h2 text-danger">
            Amount in the selection: #Calculate
        </span>
        </div>
        <div id="step2">
            <div class="form-group">
                <label class="col-sm-3" for="paymentMode">Add Mode of Payment</label>
                <div class="col-sm-6">
                    <select id="paymentMode" class="form-control" required>
                        <option>Cheque</option>
                        <option>Demand Draft</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3" for="transno">Amount</label>
                <div class="col-sm-6">
                    <input id="transno" type="text" class="form-control" required>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3" for="transno">Bank Name (N/A for Cash)</label>
                <div class="col-sm-6">
                    <input id="transno" type="text" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3" for="transno">Cheque No / DD No / Wired Trans ID</label>
                <div class="col-sm-6">
                    <input id="transno" type="text" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3" for="transdate">Cheque Date / DD Date / Wired Trans Date</label>
                <div class="col-sm-6">
                    <input id="transdate" type="date" class="form-control">
                </div>
            </div>
            <div class="contentBlock-top" id="addMoreModes"></div>
            <hr>
            <div class="form-group col-sm-6">
                <button type="button" class="btn btn-success" id="button_addMoreModes">
                    Add More Payment Details <span class="glyphicon glyphicon-plus"></span>
                </button>
            </div>
            <div class="form-group contentBlock-top">
                <div class="col-sm-9">
                    <input type="submit" class="btn btn-block btn-success" value="Submit Details for Verification">
                </div>
            </div>
        </div>
    </form>
    <div class="contentBlock-top">
        <button class="btn btn-primary" id="showStep1">
            Previous <span class="glyphicon glyphicon-chevron-left"></span>
        </button>
        <button class="btn btn-primary" id="showStep2">
            Next <span class="glyphicon glyphicon-chevron-right"></span>
        </button>
    </div>
</div>
<script>
    $(document).ready(function () {
        $("#step1").show();
        $("#step2").hide();
        $("#showStep1").hide();

        $("#showStep1").click(function () {
            $("#step1").show(500);
            $("#step2").hide(500);
            $("#showStep1").hide();
            $("#showStep2").show();
        });

        $("#showStep2").click(function () {
            $("#step2").show(500);
            $("#step1").hide(500);
            $("#showStep1").show();
            $("#showStep2").hide();
        });

        $("#addAuthor").click(function () {

        });
        $("#button_addMoreAuthors").click(function(){
            var html1=
                "<hr>"+
            "<span class=\"h3 text-primary\">"+
            "Outstanding Amount for Member ID XY : xyz"+
            "</span>";

            var html2=
            "<div class=\"contentBlock-top\">"+
            "<table class=\"table table-responsive table-striped table-hover\">"+
            "<thead>"+
            "<tr>"+
            "<th>Paper ID</th>"+
            "<th>Paper Title</th>"+
            "<th>Pending Amount</th>"+
            "<th>Type</th>"+
            "<th></th>"+
            "</tr>"+
            "</thead>"+
            "<tbody>"+
            "<tr>"+
            "<td></td>"+
            "<td></td>"+
            "<td></td>"+
            "<td>"+
            "<div class=\"btn-group\">"+
            "<label class=\"btn btn-info\">"+
            "<input type=\"checkbox\" autocomplete=\"off\"> Basic Registration"+
            "</label>"+
            "</div>"+
            "</td>"+
            "</tr>"+
            "</tbody>"+
            "</table>"+
            "</div>";
            var html = html1+html2;

            $("#addMoreAuthors").append(html);
        });

        $("#button_addMoreModes").click(function(){
            var html1=
                "<hr>"+
                "<span class=\"h3\">"+
                "Add Details for Another Payment"+
                "</span>";

            var html2=
                "<div class=\"form-group contentBlock-top\">"+
                "<label class=\"col-sm-3\" for=\"paymentMode\">Add Mode of Payment</label>"+
                "<div class=\"col-sm-6\">"+
                "<select id=\"paymentMode\" class=\"form-control\">"+
                "<option>Cheque</option>"+
                "<option>Demand Draft</option>"+
                "</select>"+
                "</div>"+
                "</div>"+
                "<div class=\"form-group\">"+
                "<label class=\"col-sm-3\" for=\"transno\">Amount</label>"+
                "<div class=\"col-sm-6\">"+
                "<input id=\"transno\" type=\"text\" class=\"form-control\" required>"+
                "</div>"+
                "</div>"+
                "<div class=\"form-group\">"+
                "<label class=\"col-sm-3\" for=\"transno\">Bank Name (N/A for Cash)</label>"+
                "<div class=\"col-sm-6\">"+
                "<input id=\"transno\" type=\"text\" class=\"form-control\">"+
                "</div>"+
                "</div>"+
                "<div class=\"form-group\">"+
                "<label class=\"col-sm-3\" for=\"transno\">Cheque No / DD No / Wired Trans ID</label>"+
                "<div class=\"col-sm-6\">"+
                "<input id=\"transno\" type=\"text\" class=\"form-control\">"+
                "</div>"+
                "</div>"+
                "<div class=\"form-group\">"+
                "<label class=\"col-sm-3\" for=\"transdate\">Cheque Date / DD Date / Wired Trans Date</label>"+
                "<div class=\"col-sm-6\">"+
                "<input id=\"transdate\" type=\"date\" class=\"form-control\">"+
                "</div>"+
                "</div>";

            var html = html1+html2;

            $("#addMoreModes").append(html);
        });

        $(".radio_BR").click(function()
            {
                var TD = $(this).closest('tr').children().eq(2);
                var SPAN = TD.children();

                SPAN.eq(0).show();
                SPAN.eq(1).hide();
            }
        );

        $(".radio_EP").click(function()
            {
                var TD = $(this).closest('tr').children().eq(2);
                var SPAN = TD.children();

                SPAN.eq(0).hide();
                SPAN.eq(1).show();
            }
        );

        $(".radio").click(function()
        {
            var ref = $(this).parent().parent();
            if($(this).val() == "br")
            {
                $("td:nth-child(4) .br" ,ref).attr("style", "display: block;");
                $("td:nth-child(4) .ep" ,ref).attr("style", "display: none;");
            }
            else if($(this).val() == "ep")
            {
                $("td:nth-child(4) .br" ,ref).attr("style", "display: none;");
                $("td:nth-child(4) .ep" ,ref).attr("style", "display: block;");
            }
        });
    });
</script>