
 <script>
  $(".btn").click(function(event)
  {
  	event.preventDefault();
  	//  data 
  	var fieldData = $("form").serialize();
  	// message
  	var style = '<div class="alert alert-danger alert-dismissible" role="alert"> <button type="button" class="close" aria-label="Close" data-dismiss="alert"><span aria-hidden="true"> &times; </span> </button> ';
  	// ajax
  	$.ajax({
  		url : '/install/response.php',
  		type: 'POST',
  		dataType: 'JSON',
  		data: fieldData,
  		success : function (response)
  		{
  			if (response.status == "success") 
  			{
  			$("#error-message").html("");
  			window.location.href = '/panel/login';
  			}
  		else if (response.status == "failure")
  		{
  			$("#error-message").html(style+response.message+"</div>");
  			
  		}
  		else
  		{
  			$.each(response.message, function(key, value)
  			{
  				$("#m-"+key).html(value);
  			})
  		}
  		},
  		error : function()
  		{
  			$("#error-message").html(style+'an error occurred while processing the data');
  		},
  		beforeSend : function()
  		{
  			$("#loader").addClass('fas fa-spin fa-spinner ml-2');
  		},
  		complete : function()
  		{
  			$("#loader").removeClass();
  		}
  	})
  })
 </script>
 
</body>
</html>