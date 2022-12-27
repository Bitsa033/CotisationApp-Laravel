function data() {
          $.ajax({
            url:"php/datatable_students.php",
            method: "GET",
            success:function(data) {
                $("#dataresult").html(data)
                $("#dataresult").css("display","block")

            },
            error:function(XMLHttpRequest,textStatus,errorThrown) {
                alert(textStatus)
            }
            
        })
        setTimeout(data,1000)
    }

    data()