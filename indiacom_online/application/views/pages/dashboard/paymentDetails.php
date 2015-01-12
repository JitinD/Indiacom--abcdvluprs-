<div class="col-md-12 col-sm-12 col-xs-12">
    <h3 class="text-theme">Payments</h3>
    <hr>
    <div class="row">
        <div class="col-md-10">
            <form class="form-horizontal">
                <div class="form-group">
                    <label class="col-sm-3" for="paymentMode">Select Mode of Payment</label>
                    <div class="col-sm-6">
                        <select id="paymentMode" class="form-control">
                            <option>Cheque</option>
                            <option>Demand Draft</option>
                        </select>
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
                <div class="form-group">
                    <div class="col-sm-offset-3 col-sm-6">
                        <input type="submit" class="btn btn-block btn-success" value="Submit Details for Verification">
                    </div>
                </div>
            </form>
        </div>

    </div>
</div>
<script>
    $(document).ready(function()
    {
        $('tr').on("click", function() {
            if($(this).attr('href') !== undefined){
                document.location = $(this).attr('href');
            }
        });
    });
</script>