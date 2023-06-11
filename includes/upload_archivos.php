<?php include('../services/ConexionBD.php');
session_start();
$uname = $_SESSION['no_control'];

$globalquery = "SELECT * FROM alumno WHERE num_control ='" . $uname . "' ";
$globalsql = $con->query($globalquery);
$row = $globalsql->fetch_assoc();

if (isset($_POST["tipo_doc"])) {
    $nombreArchivo = $_FILES['archivo']['name'];
    $nombreArchivoTemp = $_FILES['archivo']['tmp_name'];
    $error = $_FILES['archivo']['error'];
    if ($error === 0) {
        $archivoExt = pathinfo($nombreArchivo, PATHINFO_EXTENSION);
        $archivoExt_a_ubi = strtolower($archivoExt);



        // COLOCAMOS EN UNA VARIABLE LAS EXTENSIONES DE LOS ARCHIVOS PERMITIDAS

        $extensiones_val = array('pdf');
        // PREGUNTA SI LA EXTENSION DE LOS ARCHIVOS SUBIDOS ES IGUAL A LA EXTENSION PERMITIDA

        if (in_array($archivoExt_a_ubi, $extensiones_val)) {
            // OBTENEMOS DE LA SESION EL NO. DE CONTROL DEL ALUMNO Y LO ALMACENAMOS EN UNA VARIABLE

            // LE PONEMOS UN NUEVO NOMBRE A CADA ARCHIVO BASANDOSE EN EL NUMERO DE CONTROL Y LE DECIMOS LA RUTA A DONDE LOS PONDRA

            $nuevo_nombreArchivo = uniqid($uname, true) . '.' . $archivoExt_a_ubi;
            $archivo_ubi = '../archivos/' . $nuevo_nombreArchivo;


            $tipoarchivo = '"$_POST[tipo_doc"]"';
            $fechaActual = date("Y-m-d");

            // MOVEMOS LOS ARCHIVOS A LA RUTA ELEGIDA
            move_uploaded_file($nombreArchivoTemp, $archivo_ubi);

            switch ($_POST['tipo_doc']) {
                case 'Creditos':
                    $sql = "INSERT INTO docs_alumno(Creditos, Id_alumno, fecha_creditos) VALUES(?,?,?) ON DUPLICATE KEY UPDATE Creditos = ?, Id_alumno= ?, fecha_creditos= ?";
                    $fecha = "fecha_creditos";
                    break;
                case 'Justificantes':
                    $sql = "INSERT INTO docs_alumno(Justificantes, Id_alumno, fecha_justi) VALUES(?,?,?) ON DUPLICATE KEY UPDATE Justificantes = ?, Id_alumno= ?, fecha_justi= ?";
                    $fecha = "fecha_justi";
                    break;
                case 'Altas_y_Bajas':
                    $sql = "INSERT INTO docs_alumno(Altas_y_Bajas, Id_alumno, fecha_altas) VALUES(?,?,?) ON DUPLICATE KEY UPDATE Altas_y_Bajas = ?, Id_alumno= ?, fecha_altas= ?";
                    $fecha = "fecha_altas";
                    break;

                default:
                    $sql = "none";
            }
            $stmt = $con->prepare($sql);
            $stmt->bind_param('ssssss', $nuevo_nombreArchivo, $uname, $fechaActual, $nuevo_nombreArchivo, $uname, $fechaActual);
            $stmt->execute();

            $archivoquery = "SELECT * FROM docs_alumno WHERE Id_alumno ='" . $uname . "' ";
            $archivosql = $con->query($archivoquery);
            $archivorow = $archivosql->fetch_assoc();
            echo '<tr>
<td style="text-align: center;"><span class="badge bg-primary">Archivo enviado</span></td>
<td style="text-align: center;">' . $row["nombre"] . ' ' . $row["apellido_pat"] . ' ' . $row["apellido_mat"] . '</td>
<td style="text-align: center;">' . $archivorow[$fecha] . '</td>
<td style="text-align: center;"><a href="archivos/' . $archivorow[$_POST['tipo_doc']] . '" target="_blank" class="btn btn-warning" role="button">Abrir</a>
</td>
</tr>';
        }
    }
}
