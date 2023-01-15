$(document).ready(function() {
	$("#clef").keyup(function() {
		var input=$(this).val()
		if (input !="") {
			$.ajax({
				url:"php/datatable.php",
				method: "POST",
				data:{input:input},
				success:function(data) {
					$("#dataresult").html(data),
					$("#dataresult").css("display","block")
				},
				error:function(XMLHttpRequest,textStatus,errorThrown) {
					alert(textStatus)
				}
				
			})
		}else{
			$("#dataresult").css("display","none")
		}
		
			
	})
	
})



