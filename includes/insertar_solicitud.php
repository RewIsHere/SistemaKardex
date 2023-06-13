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

    if ($tipoDoc == "Justificantes") {
        // Obtiene la fecha actual
        $fechaActual = date("Y-m-d");

        // Define la fecha de inicio y fin del mes actual
        $fechaInicioMes = date("Y-m-01");
        $fechaFinMes = date("Y-m-t");

        // Verificar si se ha alcanzado el límite de solicitudes
        $query =
            "SELECT COUNT(*) AS total FROM conteo WHERE Id_alumno = ? AND Tipo_documento = ? AND Fecha_conteo BETWEEN ? AND ?";
        $stmt = $con->prepare($query);
        $stmt->bind_param(
            "ssss",
            $uname,
            $tipoDoc,
            $fechaInicioMes,
            $fechaFinMes
        );
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $totalSolicitudes = $row["total"];
        $stmt->close();

        if ($totalSolicitudes >= 3) {
            // Mostrar mensaje de error
            echo "exceeded";
        } else {
            // Insertar la solicitud en la tabla Solicitudes_alumno
            $insertQuery = "INSERT INTO Solicitudes_alumno (Id_alumno, Tipo_documento, fecha_solicitud) VALUES (?, ?, ?)";
            $stmtInsert = $con->prepare($insertQuery);
            $stmtInsert->bind_param("sss", $uname, $tipoDoc, $fechaActual);
            $insertResult = $stmtInsert->execute();
            $stmtInsert->close();

            // Insertar o actualizar el conteo en la tabla conteo
            $conteoQuery = "INSERT INTO conteo (Id_alumno, Tipo_documento, Fecha_conteo, cantidad) VALUES (?, ?, ?, 1) ON DUPLICATE KEY UPDATE cantidad = cantidad + 1";
            $stmtConteo = $con->prepare($conteoQuery);
            $stmtConteo->bind_param("ssi", $uname, $tipoDoc, $fechaActual);
            $conteoResult = $stmtConteo->execute();
            $stmtConteo->close();

            if ($insertResult && $conteoResult) {
                echo "success";
            } else {
                echo "error";
            }
        }
    } else {
        if ($selectSql) {
            if (mysqli_num_rows($selectSql) > 0) {
                // Actualizar el estado existente
                $updateQuery =
                    "UPDATE Solicitudes_alumno SET Tipo_documento = '$tipoDoc', Url_documento = '', fecha_solicitud = '$fechaActual' WHERE Id_soli_a = '" .
                    $selectRow["Id_soli_a"] .
                    "' AND ID_alumno = '$uname'";
                $updateSql = $con->query($updateQuery);
                if ($updateSql) {
                    echo "success";
                } else {
                    echo "error";
                }
            } else {
                // Insertar una nueva solicitud
                $insertQuery = "INSERT INTO Solicitudes_alumno (Id_alumno, Tipo_documento, fecha_solicitud) VALUES ('$uname', '$tipoDoc', '$fechaActual')";
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
}
