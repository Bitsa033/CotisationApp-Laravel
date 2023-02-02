function insert(url1,url2) {
    $(document).ready(function () {
        $("#insert").click(function (e) {
            e.preventDefault()
            var name = $('#name').val()
            var adresse = $('#adresse').val()
            
            $.ajax({
                url: url1,
                method: "POST",
                data: { nom:name,contact:adresse},
                success: function (data) {
                    //console.log(data);
                    // $('#quickForm')[0].reset()
                    $('.table').load(location.href+' .table-bordered')
                    $('#message').html(data.message)
                    // location.href=url2
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

function update(url1,url2) {
    $(document).ready(function () {
        $("#update").click(function (e) {
            e.preventDefault()
            var id = $('#idc').val()
            var name = $('#nom').val()
            var adresse = $('#contact').val()
            
            $.ajax({
                url: url1,
                method: "POST",
                data: {id:id, nom:name,contact:adresse },
                success: function (data) {
                    //console.log(data);
                    // $('#quickForm')[0].reset()
                    $('.message').html(data.message)
                    $('.table').load(location.href+' .table-bordered')
                    // location.href=url2
                    if (data.icon=="success") {
                        $('.message').css("color","green")
                    }
                    if (data.icon=="error"){

                        $('.message').css("color","red")
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

function remove(url1,url2) {
    $(document).ready(function () {
        $("#remove").click(function (e) {
            e.preventDefault()
            $.ajax({
                url: url1,
                method: "POST",
                success: function (data) {
                    //console.log(data);
                    // $('#quickForm')[0].reset()
                    $('.table').load(location.href+' .table-bordered')
                    alert(data.message)
                    //swal("Good job!", data.message, data.icon)
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    console.log(textStatus)
                }
    
            })
    
        })

        $(".removeOne").click(function (e) {
            e.preventDefault()
            link=$(this).attr("href")
            $.ajax({
                url: link,
                method: "GET",
                success: function (data) {
                    //console.log(data);
                    // $('#quickForm')[0].reset()
                    $('.table').load(location.href+' .table-bordered')
                    alert(data.message)
                    location.href=url2
                    
                    //swal("Good job!", data.message, data.icon)
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    console.log(textStatus)
                }
    
            })
    
        })
    
    })
}

function showClient() {
    $(document).ready(function () {
        $(".btn_update_client").click(function (e) {
            e.preventDefault()
            link=$(this).attr("href")
            console.log(id);
            $.ajax({
                url: link,
                method: "GET",
                success: function (data) {
                    $('#exampleModalLong').modal()
                    $('.modal-title').html('Mise à jour du client n°'+data.id)
                    $('#idc').val(data.id)
                    $('#nom').val(data.nom)
                    $('#contact').val(data.contact)
                    //swal("Good job!", data.message, data.icon)
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    console.log(textStatus)
                }
    
            })
    
        })

        $(".btn_show_client").click(function (e) {
            e.preventDefault()
            link=$(this).attr("href")
            console.log(id);
            $.ajax({
                url: link,
                method: "GET",
                success: function (data) {
                    //console.log(data.id);
                    $('#exampleModalCenter').modal()
                    $('.modal-title').html('Client n°'+data.id)
                    // $('.idc').html(data.id)
                    // $('.nom').html(data.nom)
                    // $('.contact').html(data.contact)
                    //swal("Good job!", data.message, data.icon)
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    console.log(textStatus)
                }
    
            })
    
        })

    
    })
}