function insert(url1) {
    $(document).ready(function () {
        $("#click").click(function (e) {
            e.preventDefault()
            var name = $('#name').val()
            var adresse = $('#adresse').val()
            var old = $('#old').val()
            
            $.ajax({
                url: url1,
                method: "POST",
                data: { nom:name,contact:adresse,age:old },
                success: function (data) {
                    console.log(data);
                    // $('#quickForm')[0].reset()
                    $('.table').load(location.href+' .table')
                    $('#message').html(data.message)
                    if (data.icon=="success") {
                        $('#message').css("color","green")
                    }
                    if (data.icon=="error"){

                        $('#message').css("color","red")
                    }
                    //swal("Good job!", data.message, data.icon)
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    console.log(textStatus)
                }
    
            })
    
        })
    
    })
}