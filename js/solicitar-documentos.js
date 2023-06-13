var tipoDocSelect = document.getElementById("tipo_doc");
var descripcionDiv = document.getElementById("descripcion");

tipoDocSelect.addEventListener("change", mostrarDescripcion);

// Ejecutar la función al cargar la página
window.addEventListener("DOMContentLoaded", mostrarDescripcion);

function mostrarDescripcion() {
  var selectedOption = tipoDocSelect.options[tipoDocSelect.selectedIndex].value;
  var descripcion = obtenerDescripcion(selectedOption);
  descripcionDiv.textContent = descripcion;
  descripcionDiv.style.display = descripcion ? "block" : "none";
}

function obtenerDescripcion(tipoDoc) {
  switch (tipoDoc) {
    case "Kardex":
      return "Descripción del Kardex";
    case "Calificaciones":
      return "Descripción de las Calificaciones";
    case "Horario":
      return "Descripción del Horario";
    case "Materias":
      return "Descripción de las Materias";
    case "Expediente":
      return "Descripción del Expediente";
    case "Inscripcion":
      return "Descripción de la Inscripción";
    case "Altas_y_Bajas":
      return "Descripción de Altas y Bajas";
    case "Creditos":
      return "Descripción de los Créditos";
    case "Extra_Curriculares":
      return "Descripción de Actividades Extra Curriculares";
    case "Justificantes":
      return "Descripción de Justificantes";
    case "Proyectos":
      return "Descripción de Proyectos";
    default:
      return "";
  }
}

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
