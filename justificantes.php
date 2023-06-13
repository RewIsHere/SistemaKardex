<?php
require_once "./services/ConexionBD.php";

session_start();

$query = "SELECT j.Id_justificante, a.Nombre AS Nombre_alumno, a.num_control AS Num_control, a.semestre_cursado AS Semestre, a.especialidad AS Especialidad, j.fecha_justificar, j.fecha_solicitud, j.archivos, j.aprobado, j.Url_justificante, j.razon_justificante
          FROM justificantes j
          INNER JOIN alumno a ON j.Id_alumno = a.num_control";
$result = $con->query($query);

function guardarArchivoPDF($archivo)
{
    $directorio = "archivos/";
    $nombreArchivo = basename($archivo['name']);
    $rutaArchivo = $directorio . $nombreArchivo;
    $tipoArchivo = strtolower(pathinfo($nombreArchivo, PATHINFO_EXTENSION));

    // Verificar si el archivo es un PDF
    if ($tipoArchivo === 'pdf') {
        if (move_uploaded_file($archivo['tmp_name'], $rutaArchivo)) {
            return $nombreArchivo;
        } else {
            return false;
        }
    } else {
        echo '
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
            <script>
                Swal.fire({
                    icon: "error",
                    title: "Error al subir el archivo",
                    text: "El archivo debe ser de tipo PDF.",
                    confirmButtonColor: "#3085d6",
                    confirmButtonText: "Aceptar"
                });
            </script>
        ';
    }
}

// Verificar si se ha enviado un archivo para subir
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_FILES['archivoPDF'])) {
    $archivoSubido = $_FILES['archivoPDF'];

    // Guardar el archivo en la carpeta "archivos"
    $rutaArchivo = guardarArchivoPDF($archivoSubido);

    if ($rutaArchivo) {
        // Insertar la URL del archivo en la columna Url_justificante de la tabla justificantes
        $idJustificante = $_POST['id_justificante'];
        $sql = "UPDATE justificantes SET Url_justificante = '$rutaArchivo' WHERE Id_justificante = '$idJustificante'";
        $con->query($sql);

        echo '
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
            <script>
                Swal.fire({
                    icon: "success",
                    title: "Archivo subido",
                    text: "El archivo se ha subido correctamente.",
                    confirmButtonColor: "#3085d6",
                    confirmButtonText: "Aceptar"
                }).then((result) => {
                    if (result.isConfirmed) {
                        location.reload();
                    }
                });
            </script>
        ';
    } else {
        echo '<script>alert.';
        }
        }
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
                    <a href="registro.php">REGISTRO</a>
                </li>
                <li>
                    <a href="login.php">INICIAR SESION</a>
                </li>
            </ul>
        </div>
    </header>

    <div class="container mt-5">
        <h2 style="color: #000;">Lista de Justificantes</h2>
        <div class="btn-group w-100 mb-2">
            <a href="inicio-d.php" class="btn btn-success">Volver al inicio</a>

        </div>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>NOMBRE ALUMNO</th>
                    <th>NUM. CONTROL</th>
                    <th>SEMESTRE</th>
                    <th>ESPECIALIDAD</th>
                    <th>FECHA A JUSTIFICAR</th>
                    <th>RAZON</th>
                    <th>FECHA DE SOLICITUD</th>
                    <th>ARCHIVOS</th>
                    <th>ACCION</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $idJustificante = $row["Id_justificante"];
                        $archivos = $row["archivos"];

                        // Generar el HTML del modal
                        echo '
                        <div class="modal fade" id="archivosModal-' .
                            $idJustificante .
                            '" tabindex="-1" aria-labelledby="archivosModalLabel-' .
                            $idJustificante .
                            '" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="archivosModalLabel-' .
                            $idJustificante .
                            '">Archivos</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">';
                        $archivosArray = explode(",", $archivos);
                        foreach ($archivosArray as $archivo) {
                            echo '<a href="archivos/' .
                                $archivo .
                                '" target="_blank" class="btn btn-primary" style="margin-bottom: 10px;">ABRIR</a><br>';
                        }
                        echo '
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                    </div>
                                </div>
                            </div>
                        </div>';
                        $idJustificante = $row["Id_justificante"];
                        $nombreAlumno = $row["Nombre_alumno"];
                        $numControl = $row["Num_control"];
                        $semestre = $row["Semestre"];
                        $especialidad = $row["Especialidad"];
                        $fechaJustificar = $row["fecha_justificar"];
                        $razon = $row["razon_justificante"];
                        $fechaSolicitud = $row["fecha_solicitud"];
                        $archivos = $row["archivos"];
                        $aprobado = $row["aprobado"];
                        $url = $row["Url_justificante"];

                        echo "<tr>";
                        echo "<td>" . $idJustificante . "</td>";
                        echo "<td>" . $nombreAlumno . "</td>";
                        echo "<td>" . $numControl . "</td>";
                        echo "<td>" . $semestre . "</td>";
                        echo "<td>" . $especialidad . "</td>";
                        echo "<td>" . $fechaJustificar . "</td>";
                        echo "<td>" . $razon . "</td>";
                        echo "<td>" . $fechaSolicitud . "</td>";
                        echo "<td>";
                        echo '<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#archivosModal-' .
                            $idJustificante .
                            '">Ver Archivos</button>';
                        echo "</td>";
                        echo "<td>";
                        echo '<form action="includes/procesarJusti.php" method="post">';
                        echo '<input type="hidden" name="id_justificante" value="' .
                            $idJustificante .
                            '">';

                        if ($aprobado == 0) {
                            echo '<button type="submit" class="btn btn-success">Aprobar</button>';
                        } else {
                            echo '<button type="submit" class="btn btn-danger">No Aprobar</button>';
                        }

                        echo "</form>";
        if ($url) {
            echo "<a class='btn btn-primary' target='_blank' href='archivos/" . $url ."'>Ver</a>";
        } else {
            echo "<button type='button' class='btn btn-primary' data-bs-toggle='modal' data-bs-target='#subirModal' onclick='asignarIdJustificante($idJustificante)'>Subir</button>";
        }
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo '<tr><td colspan="9">No hay justificantes</td></tr>';
                } ?>  
            </tbody>
        </table>
    </div>


    <div class="modal fade" id="archivosModal-<?php echo $idJustificante; ?>" tabindex="-1" aria-labelledby="archivosModalLabel-<?php echo $idJustificante; ?>" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="archivosModalLabel-<?php echo $idJustificante; ?>">Archivos</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <?php
                    $archivosArray = explode(",", $archivos);
                    foreach ($archivosArray as $archivo) {
                        echo '<a href="archivos/' .
                            $archivo .
                            '" target="_blank" class="btn btn-primary">ABRIR</a><br>';
                    }
                    ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    
        <!-- Modal Subir archivo PDF -->
    <div class="modal fade" id="subirModal" tabindex="-1" aria-labelledby="subirModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="subirModalLabel">Subir archivo PDF</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="archivoPDF" class="form-label">Seleccionar archivo PDF:</label>
                            <input type="file" class="form-control" id="archivoPDF" name="archivoPDF" accept=".pdf" required>
                        </div>
                        <input type="hidden" name="id_justificante" id="idJustificante" value="">
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Subir</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Función para asignar el valor del ID de justificante al campo oculto en el modal de subir archivo
        function asignarIdJustificante(idJustificante) {
            document.getElementById('idJustificante').value = idJustificante;
        }
    </script>
    <footer>
        <!-- Pie de página -->
    </footer>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="js/lista_solicitudes.js"></script>
</body>

</html>