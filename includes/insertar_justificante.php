<?php
require_once "../services/ConexionBD.php";
session_start();

$uname = $_SESSION["no_control"];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $razon = $_POST["texto"];
    $archivos = $_FILES["archivos"];
    $fechaInput = $_POST["fecha"]; // Obtener el valor del input de fecha

    // Convertir el formato de fecha
    $fechaMySQL = date("Y-m-d", strtotime($fechaInput));

    // Obtiene la fecha actual
    $fechaActual = date("Y-m-d");

    // Define la fecha de inicio y fin del mes actual
    $fechaInicioMes = date("Y-m-01");
    $fechaFinMes = date("Y-m-t");

    // Verificar si se ha alcanzado el límite de solicitudes
    $query =
        "SELECT COUNT(*) AS total FROM justificantes WHERE Id_alumno = ? AND fecha_solicitud BETWEEN ? AND ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("sss", $uname, $fechaInicioMes, $fechaFinMes);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $totalSolicitudes = $row["total"];
    $stmt->close();

    if ($totalSolicitudes >= 3) {
        // Mostrar mensaje de error
        echo "exceeded";
    } else {
        // Crear un array para almacenar los nombres de archivo
        $nombresArchivo = [];

        // Iterar sobre los archivos subidos
        foreach ($archivos["name"] as $key => $nombre) {
            // Obtener la información del archivo
            $nombreArchivo =
                $uname . "_" . uniqid() . "_" . $archivos["name"][$key];
            $rutaTemporal = $archivos["tmp_name"][$key];

            // Mover el archivo a una ubicación permanente
            $directorioDestino = "../archivos/";
            $rutaDestino = $directorioDestino . $nombreArchivo;
            move_uploaded_file($rutaTemporal, $rutaDestino);

            // Agregar el nombre de archivo al array
            $nombresArchivo[] = $nombreArchivo;
        }

        // Convertir el array de nombres de archivo a una cadena separada por comas
        $nombresArchivoString = implode(",", $nombresArchivo);
        // Insertar la solicitud en la tabla Solicitudes_alumno
        $insertQuery =
            "INSERT INTO justificantes (Id_alumno, razon_justificante, fecha_justificar, fecha_solicitud, archivos, aprobado) VALUES (?, ?, ?, ?, ?, ?)";
        $stmtInsert = $con->prepare($insertQuery);
        
        $aprobado = 0; // Asigna el valor a una variable

        $stmtInsert->bind_param("sssssi", $uname, $razon, $fechaMySQL, $fechaActual, $nombresArchivoString, $aprobado);
        $insertResult = $stmtInsert->execute();
        $stmtInsert->close();

        if ($insertResult) {
            echo "success";
        } else {
            echo "error";
        }
    }
}
