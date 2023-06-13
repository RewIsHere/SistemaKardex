<?php
// includes/procesarAprobacion.php

// Verifica si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once '../services/ConexionBD.php';

    // Obtiene el número de control del formulario
    $numControl = $_POST["num_control"];

    // Realiza la actualización en la base de datos
    $stmt = $con->prepare('UPDATE alumno SET aprobado = IF(aprobado = 0, 1, 0) WHERE num_control = ?');
    $stmt->bind_param('s', $numControl);
    $stmt->execute();
    $stmt->close();

    // Redirecciona a la página actual
    header("Location: ../aprobaciones-n.php");
    exit;
}
