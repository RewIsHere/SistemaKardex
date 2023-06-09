<?php
require_once '../services/ConexionBD.php';
session_start();

$uname = $_SESSION['no_control'];


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tipoDoc = $_POST["tipo_doc"];

    $uname = $_SESSION['no_control'];
    $selectQuery = "SELECT * FROM Solicitudes_alumno WHERE Id_alumno = '$uname' AND Tipo_documento = '$tipoDoc'";
    $selectSql = $con->query($selectQuery);
    $selectRow = $selectSql->fetch_assoc();

    if ($selectSql) {
        if (mysqli_num_rows($selectSql) > 0) {
            // Actualizar el estado existente
            $updateQuery = "UPDATE Solicitudes_alumno SET Tipo_documento = '$tipoDoc', Url_documento = '' WHERE Id_soli_a = '" . $selectRow["Id_soli_a"] . "' AND ID_alumno = '$uname'";
            $updateSql = $con->query($updateQuery);

            if ($updateSql) {
                echo "success";
            } else {
                echo "error";
            }
        } else {
            // Insertar una nueva solicitud
            $insertQuery = "INSERT INTO Solicitudes_alumno (Id_alumno, Tipo_documento) VALUES ('$uname', '$tipoDoc')";
            $insertSql = $con->query($insertQuery);

            if ($insertSql) {
                echo "success";
            } else {
                echo "error";
            }
        }
    } else {
        echo "error";
    }
}
