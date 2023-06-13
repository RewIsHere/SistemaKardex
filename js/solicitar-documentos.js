$(document).ready(function () {
  var tipoDocSelect = document.getElementById("tipo_doc");
  var descripcionDiv = document.getElementById("descripcion");
  var otrosCamposDiv = document.getElementById("otros_campos");
  var textoInput = document.getElementById("texto");
  var fechaInput = document.getElementById("fecha");
  var archivosInput = document.getElementById("archivos");
  var selectedOption = tipoDocSelect.options[tipoDocSelect.selectedIndex].value;

  tipoDocSelect.addEventListener("change", mostrarCamposAdicionales);
  mostrarCamposAdicionales();

  function mostrarCamposAdicionales() {
    selectedOption = tipoDocSelect.options[tipoDocSelect.selectedIndex].value;
    var descripcion = obtenerDescripcion(selectedOption);
    descripcionDiv.textContent = descripcion;
    descripcionDiv.style.display = descripcion ? "block" : "none";

    if (selectedOption === "Justificantes") {
      otrosCamposDiv.style.display = "block";
      textoInput.setAttribute("required", "required");
      fechaInput.setAttribute("required", "required");
      archivosInput.setAttribute("required", "required");
    } else {
      otrosCamposDiv.style.display = "none";
      textoInput.removeAttribute("required");
      fechaInput.removeAttribute("required");
      archivosInput.removeAttribute("required");
    }
  }

  $("#form-subir").submit(function (event) {
    event.preventDefault();
    var tipoDoc = $("#tipo_doc").val();
    var texto = textoInput.value;

    if (selectedOption === "Justificantes" && texto.length > 30) {
      Swal.fire({
        icon: "error",
        title: "Error",
        text: "El campo de texto no puede tener más de 30 caracteres.",
        showConfirmButton: false,
        timer: 2000,
      });
      return;
    }

    var formData = new FormData(this);
    formData.append("tipo_doc", tipoDoc);

    $.ajax({
      url:
        selectedOption === "Justificantes"
          ? "includes/insertar_justificante.php"
          : "includes/insertar_solicitud.php",
      type: "POST",
      data: formData,
      contentType: false,
      processData: false,
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
            text: "Ya has superado el límite de 3 solicitudes en este mes.",
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
