<?php
// includes/procesarAprobacion.php

// Verifica si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once '../services/ConexionBD.php';

    // Obtiene el número de control del formulario
    $idJusti = $_POST["id_justificante"];

    // Realiza la actualización en la base de datos
    $stmt = $con->prepare('UPDATE justificantes SET aprobado = IF(aprobado = 0, 1, 0) WHERE Id_justificante = ?');
    $stmt->bind_param('s', $idJusti);
    $stmt->execute();
    $stmt->close();

    // Redirecciona a la página actual
    header("Location: ../justificantes.php");
    exit;
}
