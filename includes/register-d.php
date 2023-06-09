<?php
require_once '../services/ConexionBD.php';
// PREGUNTAMOS SI ALGUNO DE LOS CAMPOS DEL FORMULARIO DE REGISTRO HA SIDO ESTABLECIDO
if (!isset($_POST['nombre'], $_POST['contraseña'], $_POST['correo'])) {
    // EN CASO DE ESTAR VACIO ALGUNO, NOS MARCARA ERROR
    exit('fatal-error');
}
// PREGUNTAMOS SI ALGUN CAMPO ESTA VACIO
if (empty($_POST['nombre']) || empty($_POST['contraseña']) || empty($_POST['correo'])) {
    // NUEVAMENTE NOS MARCARA ERROR EN CASO DE QUE LO ESTE
    exit('fatal-error');
}

// DEFINIMOS VARIABLES PARA OBTENER LOS CAMPOS DEL FORMULARIO
$nombre = $_POST['nombre'];
$apellido_pat = $_POST['apellido_pat'];
$apellido_mat = $_POST['apellido_mat'];
$correo = $_POST['correo'];
$contra = $_POST['contraseña'];
$tel = $_POST['tel'];

// LLAMAMOS A UN PROCEDIMIENTO ALMACENADO PARA VERIFICAR SI LA CUENTA EXISTE
if ($stmt = $con->prepare("call verificarCuentaJefe('$correo')")) {
    $stmt->execute();
    $stmt->store_result();
    // SI DA MAYOR A 1 SIGNIFICA QUE EL PROCEDIMIENTO ALMACENADO ENCONTRO A UN USUARIO CON ESE NOMBRE
    if ($stmt->num_rows > 0) {
        // SI EXISTE LA CUENTA NOS MARCARA ERROR
        echo "error";
    } else {
        $stmt->close();
        // LA CUENTA NO EXISTE , LLAMAMOS AL PROCEDIMIENTO ALMACENADO PARA CREAR LA CUENTA
        if ($stmt = $con->prepare("call registar_jefe('$nombre','$apellido_pat','$apellido_mat','$tel','$correo','$contra')")) {
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
