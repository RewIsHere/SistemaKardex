$("#formRegistro").on("submit", function (e) {
  e.preventDefault();

  var archivo = $("input[type=file]")[0].files[0];
  if (archivo && archivo.size > 2020000) {
    // 1 megabyte = 1048576 bytes
    $(document).ready(function () {
      Swal.fire({
        toast: true,
        icon: "error",
        title: "El archivo excede el tamaño máximo permitido (1MB).",
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
    return;
  }

  var formData = new FormData();
  let nombre = document.getElementById("nombre").value;
  let apellido_pat = document.getElementById("apellido_pat").value;
  let apellido_mat = document.getElementById("apellido_mat").value;
  let num_control = document.getElementById("num_control").value;
  let correo = document.getElementById("correo").value;
  let contrasena = document.getElementById("contrasena").value;
  let especialidad = document.getElementById("especialidad").value;
  let semestre_cursado = document.getElementById("semestre_cursado").value;

  formData.append("nombre", nombre);
  formData.append("apellido_pat", apellido_pat);
  formData.append("apellido_mat", apellido_mat);
  formData.append("num_control", num_control);
  formData.append("correo", correo);
  formData.append("contrasena", contrasena);
  formData.append("especialidad", especialidad);
  formData.append("semestre_cursado", semestre_cursado);
  // Attach file
  formData.append("archivo", $("input[type=file]")[0].files[0]);

  var fileInput = document.getElementById("archivo");

  var filePath = fileInput.value;

  // Allowing file type
  var allowedExtensions = /(\.png|\.jpg|\.jpeg)$/i;

  if (!allowedExtensions.exec(filePath)) {
    $(document).ready(function () {
      Swal.fire({
        toast: true,
        icon: "error",
        title: "No se pueden subir archivos con otras extensiones",
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
    fileInput.value = "";
    return false;
  }
  $.ajax({
    type: "POST",
    url: "includes/register.php",
    data: formData,
    async: false,
    cache: false,
    processData: false,
    contentType: false,
    success: function (response) {
      if (response == "success") {
        window.location.href = "login.php";
        console.log("CORRECTO");
      } else if (response == "error") {
        $(document).ready(function () {
          Swal.fire({
            toast: true,
            icon: "error",
            title: "Este numero de control ya existe",
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
        console.log("ERROR NUM CONTROL");
      } else if (response == "fatal_error") {
        $(document).ready(function () {
          Swal.fire({
            toast: true,
            icon: "error",
            title: "Ha ocurrido un error inesperado",
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
        console.log("ERROR");
      }
    },
  });
});
