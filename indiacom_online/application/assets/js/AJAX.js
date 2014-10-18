$(document).ready(function(){

    $(document).click(function(){
		$("#ajax_response").fadeOut('slow');
	});
	var width = $(".col-sm-9").width();
    $("#ajax_response").css("width",width);
	$("#keyword").keyup(function(event){
		 var keyword = $("#keyword").val();
		 if(keyword.length)
		 {
			 if(event.keyCode != 40 && event.keyCode != 38 && event.keyCode != 13)
			 {
				 $("#loading").css("visibility","visible");
				 $.ajax({
				   type: "POST",
				   url: "/Indiacom2015/indiacom_online/AJAX/fetchOrganisationNames",
				   data: "data="+keyword,
				   success: function(msg){	
					if(msg != 0)
                    {
                        $("#ajax_response").fadeIn("slow").html(msg);
                    }

					else
					{
					  $("#ajax_response").fadeIn("slow");	
					  $("#ajax_response").html('<div style="text-align:left;">No Matches Found</div>');
					}
					$("#loading").css("visibility","hidden");
				   }
				 });
			 }
			 else
			 {
				switch (event.keyCode)
				{
				 case 40:
				 {
					  found = 0;
					  $("li").each(function(){
						 if($(this).attr("class") == "selected")
							found = 1;
					  });
					  if(found == 1)
					  {
						var sel = $("li[class='selected']");
						sel.next().addClass("selected");
						sel.removeClass("selected");
					  }
					  else
						$("li:first").addClass("selected");
					 }
				 break;
				 case 38:
				 {
					  found = 0;
					  $("li").each(function(){
						 if($(this).attr("class") == "selected")
							found = 1;
					  });
					  if(found == 1)
					  {
						var sel = $("li[class='selected']");
						sel.prev().addClass("selected");
						sel.removeClass("selected");
					  }
					  else
						$("li:last").addClass("selected");
				 }
				 break;
				 case 13:
					$("#ajax_response").fadeOut("slow");
					$("#keyword").val($("li[class='selected'] a").text());
				 break;
				}
			 }
		 }
		 else
			$("#ajax_response").fadeOut("slow");
	});
	$("#ajax_response").mouseover(function(){
		$(this).find("li a:first-child").mouseover(function () {
			  $(this).addClass("selected");
		});
		$(this).find("li a:first-child").mouseout(function () {
			  $(this).removeClass("selected");
		});
		$(this).find("li a:first-child").click(function () {
			  $("#keyword").val($(this).text());
			  $("#ajax_response").fadeOut("slow");
		});
	});

    var categoryValue = function()
    {
        if($("#category").val() == 5 || $("#category").val() == 6)
            $(".category-based").show();
        else
            $(".category-based").hide();
    };

    categoryValue();

    $("#category").on('change', categoryValue);

    var onlyNumericValue = function(e)
    {
        if ((e.keyCode < 48) || (e.keyCode > 57))
            return false;

    }

    $('#pincode, #phoneNumber, #countryCode, #mobileNumber, #fax, #csimembershipno, #ietemembershipno, #experience').on('keypress', onlyNumericValue);

    $('#pincode, #phoneNumber, #countryCode, #mobileNumber, #fax, #csimembershipno, #ietemembershipno, #experience').bind("paste", function(e)
    {
        e.preventDefault();
    });


    $('#name').on('keypress', function(e){

        var regex = /^[a-zA-Z.\s]*$/;

        if(!(regex.test(String.fromCharCode((e.keyCode)))))
            return false;

        return true;

    });

});