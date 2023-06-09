$("#form-subir").on("submit", function (e) {
  e.preventDefault();

  var formData = new FormData();
  let tipo_doc = document.getElementById("tipo_doc").value;
  formData.append("tipo_doc", tipo_doc);
  // Attach file
  formData.append("archivo", $("input[type=file]")[0].files[0]);

  var fileInput = document.getElementById("archivo");

  var filePath = fileInput.value;

  // Allowing file type
  var allowedExtensions = /(\.pdf)$/i;

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
    data: formData,
    async: false,
    cache: false,
    processData: false,
    contentType: false,
    url: "includes/upload_archivos.php",
    type: "POST",
    timeout: 10000,
    beforeSend: function () {
      //document.getElementById("resultado_busqueda" ").innerHTML= '<img src=*img/load.gif" style="width:120px,">
    },
    success: function (response) {
      $(document).ready(function () {
        Swal.fire({
          toast: true,
          icon: "success",
          title: "Se ha subido el documento correctamente",
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
      document.getElementById(tipo_doc).innerHTML = response;
    },
    error: function (response, error) {
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
