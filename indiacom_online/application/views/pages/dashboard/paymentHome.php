<div class="col-md-12 col-sm-12 col-xs-12">
    <h3 class="text-theme">Payments</h3>
    <hr>
    <div>
        <span class="h3 text-primary">
            Your Outstanding Amount : #Calculate
        </span>
    </div>
    <form class="form-horizontal">
        <div class="contentBlock-top">
            <table class="table table-responsive table-striped table-hover">
                <thead>
                <tr>
                    <th>Paper ID</th>
                    <th>Paper Title</th>
                    <th>Pending Amount</th>
                    <th>Type</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>
                            <div class="btn-group">
                                <label class="btn btn-info">
                                    <input type="checkbox" autocomplete="off"> Basic Registration
                                </label>
                            </div>
                            <div class="btn-group">
                                <label class="btn btn-info">
                                    <input type="checkbox" autocomplete="off"> Extra Paper
                                </label>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div>
            <button class="btn btn-success">
                Pay for Co-Authors &nbsp;<span class="glyphicon glyphicon-plus"></span>
            </button>
        </div>
        <div class="form-group row">
            <label>
                Member ID
                <select class="form-control">
                    <option>21</option>
                    <option>22</option>
                </select>

            </label>
        </div>
        <div class="contentBlock-top">
            <span class="h3 text-primary">
                Outstanding Amount for Member ID XY : xyz
            </span>
            <div class="contentBlock-top">
                <table class="table table-responsive table-striped table-hover">
                    <thead>
                    <tr>
                        <th>Paper ID</th>
                        <th>Paper Title</th>
                        <th>Pending Amount</th>
                        <th>Type</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>
                            <div class="btn-group">
                                <label class="btn btn-info">
                                    <input type="checkbox" autocomplete="off"> Basic Registration
                                </label>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <hr>
        <span class="h2 text-danger">
            Total amount in the selection: #Calculate
        </span>
        <div class="contentBlock-top">
            <button class="btn btn-lg btn-primary">
                Proceed <span class="glyphicon glyphicon-chevron-right"></span>
            </button>
        </div>
    </form>

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