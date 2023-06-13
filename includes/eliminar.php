<?php
// includes/procesarAprobacion.php

// Verifica si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once '../services/ConexionBD.php';

    // Obtiene el número de control del formulario
    $numControl = $_POST["num_control2"];

    // Realiza la actualización en la base de datos

   $stmt = $con->prepare('DELETE FROM justificantes WHERE Id_alumno = ?');
    $stmt->bind_param('s', $numControl);
    $stmt->execute();
    $stmt->close();

    $stmt = $con->prepare('DELETE FROM Solicitudes_alumno WHERE Id_alumno = ?');
    $stmt->bind_param('s', $numControl);
    $stmt->execute();
    $stmt->close();



    $stmt = $con->prepare('DELETE FROM docs_alumno WHERE Id_alumno = ?');
    $stmt->bind_param('s', $numControl);
    $stmt->execute();
    $stmt->close();


    $stmt = $con->prepare('DELETE FROM alumno WHERE num_control = ?');
    $stmt->bind_param('s', $numControl);
    $stmt->execute();
    $stmt->close();

    // Redirecciona a la página actual
    header("Location: ../aprobaciones.php");
    exit;
}
