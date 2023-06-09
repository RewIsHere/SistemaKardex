<?php
require_once './services/ConexionBD.php';

session_start();
// Verificar si el usuario tiene permisos de administrador
/*if (!isset($_SESSION['SesionIniciada']) || $_SESSION['tipo_usuario'] !== 'admin') {
    header('Location: index.php');
    exit;
}*/

// Obtener la lista de solicitudes de documentos de la tabla Solicitudes_alumno
$query = "SELECT sa.Id_soli_a, a.Nombre, a.num_control, a.semestre_cursado, a.especialidad, sa.Tipo_documento, sa.Url_documento
          FROM Solicitudes_alumno sa
          INNER JOIN alumno a ON sa.Id_alumno = a.num_control";
$result = $con->query($query);

?>

<!DOCTYPE html>
<html>

<head>
    <meta name="description" content="BITACORA  RESIDENCIAS ITSPR">
    <meta name="key" content="BITACORA, REDICENCIAS, ITSPR, INSTITUTO TECNOLOGICO SUPERIOR DE POZA RICA">
    <META NAME="AUTHOR" CONTENT="None">
    <title>BITACORA ITSPR</title>
    <link rel="stylesheet" href="css/pruebas.css">
    <link rel="shortcut icon" href="assets/LOGO_ITSPR.jpg" type="image/x-icon">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.2/umd/popper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/js/bootstrap.min.js"></script>
</head>

<body>
    <header>
        <div class="tira-header">
            <img class="tira-header__img" src="assets/Tira_logo.jpg">
        </div>
        <div id="nav-sup" class="navegacion">
            <ul class="navegacion__navegacion-list navegacion__menu">
                <li>
                    <a href="index.php" class="active">INICIO</a>
                </li>
                <li>
                    <a href="registro.php">REGISTRARSE</a>
                </li>
                <li>
                    <a href="login.php">INICIAR SESION</a>
                </li>
            </ul>
        </div>
    </header>

    <div class="container mt-5">
        <h2 style="color: #000;">Lista de Solicitudes de Documentos</h2>
        <div class="btn-group w-100 mb-2">
            <a href="inicio-d.php" class="btn btn-success">Volver al inicio</a>

        </div>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>NOMBRE ALUMNO</th>
                    <th>NUM. CONTROL</th>
                    <th>SEMESTRE</th>
                    <th>ESPECIALIDAD</th>
                    <th>TIPO DOCUMENTO</th>
                    <th>ACCION</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $idSolicitud = $row['Id_soli_a'];
                        $nombreAlumno = $row['Nombre'];
                        $numControl = $row['num_control'];
                        $semestre = $row['semestre_cursado'];
                        $especialidad = $row['especialidad'];
                        $tipoDocumento = $row['Tipo_documento'];
                        $urlDocumento = $row['Url_documento'];

                        echo '<tr>';
                        echo '<td>' . $nombreAlumno . '</td>';
                        echo '<td>' . $numControl . '</td>';
                        echo '<td>' . $semestre . '</td>';
                        echo '<td>' . $especialidad . '</td>';
                        echo '<td>' . ($tipoDocumento ? $tipoDocumento : '-') . '</td>';
                        echo '<td>';
                        if ($urlDocumento) {
                            echo '<a href="archivos/' . $urlDocumento . '" target="_blank" class="btn btn-secondary" target="_blank">Ver Documento</a>';
                        } else {
                            echo '<button type="button" class="btn btn-primary btn-subir" data-id="' . $idSolicitud . '">Subir Documento</button>';
                        }
                        echo '</td>';
                        echo '</tr>';
                    }
                } else {
                    echo '<tr><td colspan="5">No hay solicitudes de documentos</td></tr>';
                }
                ?>
            </tbody>
        </table>
    </div>

    <footer>
        <!-- Pie de página -->
    </footer>

    <!-- Modal Box para subir el documento -->
    <div class="modal fade" id="modalUpload" tabindex="-1" role="dialog" aria-labelledby="modalUploadLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalUploadLabel">Subir Documento</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="uploadForm" enctype="multipart/form-data">
                        <input type="hidden" id="solicitudId" name="solicitudId" value="">
                        <div class="form-group">
                            <label for="archivo">Seleccionar archivo PDF:</label>
                            <input type="file" id="archivo" name="archivo" required>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" id="btnGuardar">Guardar</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="js/lista_solicitudes.js"></script>
</body>

</html>