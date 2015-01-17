<div class="col-md-12 col-sm-12 col-xs-12">
    <h3 class="text-theme">Payments</h3>
    <hr>
    <div class="row">
        <div class="col-md-10">
            <form class="form-horizontal">

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