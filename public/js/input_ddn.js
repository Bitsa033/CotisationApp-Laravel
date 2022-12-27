$(document).ready(function() {
	$("#classe").click(function() {
		var eleve2=document.getElementById("eleve2").value
        var classe=document.getElementById("classe").value
        
        xhr=new XMLHttpRequest()
        xhr.open("POST","php/input_ddn.php",true)
        xhr.setRequestHeader("content-type","application/x-www-form-urlencoded")
        xhr.onreadystatechange=function() {
            if (this.readyState==4 && this.status==200) {
                //document.getElementById('notifs').innerHTML=this.responseText
                document.getElementById("ddn").value=xhr.responseText;
                //document.getElementById("ddn").value="";

            }
        }

        xhr.send("eleve2="+eleve2+"&&classe="+classe)
		
		
			
	})
})



