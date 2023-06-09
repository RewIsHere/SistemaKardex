<?php
require_once '../services/ConexionBD.php';

$solicitudId = $_POST['solicitudId'];

// Verificar si se ha subido un archivo
if (isset($_FILES['archivo']) && $_FILES['archivo']['error'] === UPLOAD_ERR_OK) {
    $nombreArchivo = $_FILES['archivo']['name'];
    $tipoArchivo = $_FILES['archivo']['type'];
    $rutaArchivo = '../archivos/' . $nombreArchivo;

    // Mover el archivo subido a la carpeta deseada
    if (move_uploaded_file($_FILES['archivo']['tmp_name'], $rutaArchivo)) {
        // Verificar si ya existe un documento asociado a la solicitud
        $query = "SELECT * FROM Solicitudes_alumno WHERE Id_soli_a = '$solicitudId'";
        $result = $con->query($query);

        if ($result->num_rows > 0) {
            // Actualizar el archivo existente
            $query = "UPDATE Solicitudes_alumno SET Url_documento = '$nombreArchivo' WHERE Id_soli_a = '$solicitudId'";
            if ($con->query($query) === TRUE) {
                echo 'El documento ha sido actualizado correctamente.';
            } else {
                echo 'Error al actualizar el documento: ' . $con->error;
            }
        } else {
            // Insertar un nuevo documento
            $query = "INSERT INTO Solicitudes_alumno (Id_soli_a, Url_documento) VALUES ('$solicitudId', '$nombreArchivo')";
            if ($con->query($query) === TRUE) {
                echo 'El documento ha sido guardado correctamente.';
                header("Location: ../lista_solicitudes.php");
            } else {
                echo 'Error al guardar el documento: ' . $con->error;
            }
        }
    } else {
        echo 'Error al mover el archivo subido.';
    }
} else {
    echo 'No se ha subido ningún archivo o se ha producido un error en la subida.';
}
