$("#formRegistro").on("submit", function (e) {
  e.preventDefault();

  var formData = new FormData();
  let nombre = document.getElementById("nombre").value;
  let apellido_pat = document.getElementById("apellido_pat").value;
  let apellido_mat = document.getElementById("apellido_mat").value;
  let num_control = document.getElementById("num_control").value;
  let correo = document.getElementById("correo").value;
  let contraseña = document.getElementById("contraseña").value;
  let especialidad = document.getElementById("especialidad").value;
  let semestre_cursado = document.getElementById("semestre_cursado").value;

  formData.append("nombre", nombre);
  formData.append("apellido_pat", apellido_pat);
  formData.append("apellido_mat", apellido_mat);
  formData.append("num_control", num_control);
  formData.append("correo", correo);
  formData.append("contraseña", contraseña);
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
      }
    },
  });
});
