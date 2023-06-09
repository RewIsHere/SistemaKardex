$("#formLogin").on('submit', function (e) {
    e.preventDefault();

    $.ajax({
        method: 'POST',
        url: 'includes/login.php',
        data: $('#formLogin').serialize(),
        success: function (response) {
            if (response == "success") {
                window.location.href = "inicio.php";
            } else if (response == "error-password") {

                $(document).ready(function () {
                    Swal.fire({
                        toast: true,
                        icon: 'error',
                        title: 'La contraseña es incorrecta',
                        position: 'top',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.addEventListener('mouseenter', Swal.stopTimer)
                            toast.addEventListener('mouseleave', Swal.resumeTimer)
                        }
                    })
                });
            } else if (response == "error-user") {

                $(document).ready(function () {
                    Swal.fire({
                        toast: true,
                        icon: 'error',
                        title: 'Este usuario no esta registrado',
                        position: 'top',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.addEventListener('mouseenter', Swal.stopTimer)
                            toast.addEventListener('mouseleave', Swal.resumeTimer)
                        }
                    })
                });
            }
        }
    });
})