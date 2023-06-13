<?php
require_once "../services/ConexionBD.php";
session_start();

$uname = $_SESSION["no_control"];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tipoDoc = $_POST["tipo_doc"];
    $fechaActual = date("Y-m-d");
    $uname = $_SESSION["no_control"];
    $selectQuery = "SELECT * FROM Solicitudes_alumno WHERE Id_alumno = '$uname' AND Tipo_documento = '$tipoDoc'";
    $selectSql = $con->query($selectQuery);
    $selectRow = $selectSql->fetch_assoc();

    if ($selectSql) {
        // Insertar una nueva solicitud
        $insertQuery = "INSERT INTO Solicitudes_alumno (Id_alumno, Tipo_documento, fecha_solicitud) VALUES ('$uname', '$tipoDoc', '$fechaActual')";
        $insertSql = $con->query($insertQuery);

        if ($insertSql) {
            echo "success";
        } else {
            echo "error";
        }
    } else {
        echo "error";
    }
}
