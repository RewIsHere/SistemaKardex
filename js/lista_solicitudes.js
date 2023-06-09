$(document).ready(function () {
  // Botón para subir documento
  $(".btn-subir").click(function () {
    var solicitudId = $(this).data("id");
    $("#solicitudId").val(solicitudId);
    $("#modalUpload").modal("show");
  });

  // Botón para ver documento
  $(".btn-ver").click(function () {
    var solicitudId = $(this).data("id");
    // Realizar la acción deseada para ver el documento (puede ser una redirección a una página específica)
  });

  // Botón guardar en el modal de subir documento
  $("#btnGuardar").click(function () {
    var formData = new FormData($("#uploadForm")[0]);

    $.ajax({
      url: "includes/lista_solicitudes.php",
      type: "POST",
      data: formData,
      processData: false,
      contentType: false,
      success: function (response) {
        $(document).ready(function () {
          Swal.fire({
            toast: true,
            icon: "success",
            title: "Se ha enviado el documento al alumno correctamente",
            position: "top",
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
              toast.addEventListener("mouseenter", Swal.stopTimer);
              toast.addEventListener("mouseleave", Swal.resumeTimer);
            },
          });
        });
        $("#modalUpload").modal("hide");
        actualizarTablaSolicitudes(); // Llamada a la función para actualizar la tabla
      },
      error: function (xhr, status, error) {
        $(document).ready(function () {
          Swal.fire({
            toast: true,
            icon: "error",
            title: error,
            position: "top",
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
              toast.addEventListener("mouseenter", Swal.stopTimer);
              toast.addEventListener("mouseleave", Swal.resumeTimer);
            },
          });
        });
      },
    });
  });

  // Función para actualizar la tabla de solicitudes
  function actualizarTablaSolicitudes() {
    $.ajax({
      url: "lista_solicitudes.php",
      type: "GET",
      success: function (response) {
        // Actualizar el contenido de la tabla con la nueva lista de solicitudes
        $("#tablaSolicitudes").html(response);
      },
      error: function (xhr, status, error) {
        // Manejar errores en la solicitud AJAX
        console.error(error);
      },
    });
  }
});
