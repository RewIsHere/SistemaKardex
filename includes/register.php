<?php
require_once '../services/ConexionBD.php';
// PREGUNTAMOS SI ALGUNO DE LOS CAMPOS DEL FORMULARIO DE REGISTRO HA SIDO ESTABLECIDO
if (!isset($_POST['nombre'], $_POST['num_control'], $_POST['contrasena'], $_POST['correo'])) {
    // EN CASO DE ESTAR VACIO ALGUNO, NOS MARCARA ERROR
    exit('Please complete the registration form!');
}
// PREGUNTAMOS SI ALGUN CAMPO ESTA VACIO
if (empty($_POST['nombre']) || empty($_POST['num_control']) || empty($_POST['contrasena']) || empty($_POST['correo'])) {
    // NUEVAMENTE NOS MARCARA ERROR EN CASO DE QUE LO ESTE
    exit('Please complete the registration form');
}

// DEFINIMOS VARIABLES PARA OBTENER LOS CAMPOS DEL FORMULARIO

$nombre = $_POST['nombre'];
$apellido_pat = $_POST['apellido_pat'];
$apellido_mat = $_POST['apellido_mat'];
$num_control = $_POST['num_control'];
$correo = $_POST['correo'];
$contra = $_POST['contrasena'];
$especialidad = $_POST['especialidad'];
$sem_cursado = $_POST['semestre_cursado'];
$fechaActual = date('Y-m-d');

if ($stmt = $con->prepare("call verificarCuenta('$num_control')")) {
    $stmt->execute();
    $stmt->store_result();
    // SI DA MAYOR A 1 SIGNIFICA QUE EL PROCEDIMIENTO ALMACENADO ENCONTRO A UN USUARIO CON ESE NOMBRE
    if ($stmt->num_rows > 0) {
        // SI EXISTE LA CUENTA NOS MARCARA ERROR
        echo "error";
    } else {
        $stmt->close();
        // LA CUENTA NO EXISTE , LLAMAMOS AL PROCEDIMIENTO ALMACENADO PARA CREAR LA CUENTA
        if (isset($_FILES["archivo"])) {
            $nombreArchivo = $_FILES['archivo']['name'];
            $nombreArchivoTemp = $_FILES['archivo']['tmp_name'];
            $error = $_FILES['archivo']['error'];
            if ($error === 0) {
                $archivoExt = pathinfo($nombreArchivo, PATHINFO_EXTENSION);
                $archivoExt_a_ubi = strtolower($archivoExt);



                // COLOCAMOS EN UNA VARIABLE LAS EXTENSIONES DE LOS ARCHIVOS PERMITIDAS

                $extensiones_val = array('png', 'jpeg', 'jpg');
                // PREGUNTA SI LA EXTENSION DE LOS ARCHIVOS SUBIDOS ES IGUAL A LA EXTENSION PERMITIDA

                if (in_array($archivoExt_a_ubi, $extensiones_val)) {
                    // OBTENEMOS DE LA SESION EL NO. DE CONTROL DEL ALUMNO Y LO ALMACENAMOS EN UNA VARIABLE

                    // LE PONEMOS UN NUEVO NOMBRE A CADA ARCHIVO BASANDOSE EN EL NUMERO DE CONTROL Y LE DECIMOS LA RUTA A DONDE LOS PONDRA

                    $nuevo_nombreArchivo = uniqid($num_control, true) . '.' . $archivoExt_a_ubi;
                    $archivo_ubi = '../fotos/' . $nuevo_nombreArchivo;


                    // MOVEMOS LOS ARCHIVOS A LA RUTA ELEGIDA
                    move_uploaded_file($nombreArchivoTemp, $archivo_ubi);
                }
            }
        }
        if ($stmt = $con->prepare("call registar_alumno('$num_control','$nombre','$apellido_pat','$apellido_mat','$nuevo_nombreArchivo','$sem_cursado','$especialidad','$correo','$contra', 0, '$fechaActual')")) {
            $stmt->execute();
            echo "success";
        } else {
            // EN CASO DE ERROR NOS LO MARCARA
            echo "fatal_error";
        }
    }
    // CIERRA EL QUERY

    $stmt->close();
} else {
    // EN CASO DE ERROR NOS LO MARCARA
    echo "fatal_error";
}
// CIERRA LA CONEXION
$con->close();
