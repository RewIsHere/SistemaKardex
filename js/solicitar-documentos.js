$(document).ready(function () {
  $("#form-subir").submit(function (event) {
    event.preventDefault();
    var tipoDoc = $("#tipo_doc").val();

    $.ajax({
      url: "includes/insertar_solicitud.php",
      type: "POST",
      data: {
        tipo_doc: tipoDoc,
      },
      success: function (response) {
        if (response.trim() === "success") {
          Swal.fire({
            icon: "success",
            title: "Solicitud enviada",
            text: "La solicitud se ha enviado correctamente.",
            showConfirmButton: false,
            timer: 2000,
          }).then(function () {
            location.reload();
          });
        } else if (response.trim() === "exceeded") {
          Swal.fire({
            icon: "error",
            title: "Error",
            text: "Ya has superado el limite de 3 solicitudes en este mes.",
            showConfirmButton: false,
            timer: 2000,
          });
        } else {
          Swal.fire({
            icon: "error",
            title: "Error",
            text: "Hubo un error al enviar la solicitud.",
            showConfirmButton: false,
            timer: 2000,
          });
        }
      },
    });
  });
});
