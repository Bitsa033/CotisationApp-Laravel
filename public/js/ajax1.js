
$(function () {
  $.validator.setDefaults({
    submitHandler: function () {
      // var classe = $("#classe").val()
      // var eleve2 = $("#eleve2").val()
      // var ddn = $("#ddn").val()
      // var avi = $("#avi").val()
      var input = $("#input").val()
      $.ajax({
        url: "../src/AjaxEtSymfony.php",
        method: "POST",
        data: { input: input},
        cache: false,
        success: function (response) {

          // $("#eleve2").val("")
          $("#mes").html(response)
          $("#mes").css("display", "block")
          $("#mes").css("background", "green")
          $("#mes").css("color", "white")
          setTimeout(function () {
            $("#mes").css("display", "none")
          }, 9000)
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
          alert(textStatus)
        }

      })
      return false
    }
  });
  $('#quickForm').validate({
    rules: {
      input: {
        required: true
      },

    },
    messages: {
      input: {
        required: "S'il vous plait ce champs est demandé",
        minlength: "ce champs doit avoir minimum 5 lettres"
      },
      
    },
    errorElement: 'span',
    errorPlacement: function (error, element) {
      error.addClass('invalid-feedback');
      element.closest('.form-group').append(error);
    },
    highlight: function (element, errorClass, validClass) {
      $(element).addClass('is-invalid');
    },
    unhighlight: function (element, errorClass, validClass) {
      $(element).removeClass('is-invalid');
    }
  });
});
