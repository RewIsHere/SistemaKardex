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


            $fechaActual = date("Y-m-d");

            // MOVEMOS LOS ARCHIVOS A LA RUTA ELEGIDA
            move_uploaded_file($nombreArchivoTemp, $archivo_ubi);

            switch ($_POST['tipo_doc']) {
                case 'Creditos':
                    $tipoarchivo = "Creditos";
                    break;
                case 'Justificantes':
                    $tipoarchivo = "Justificantes";
                    break;
                case 'Altas_y_Bajas':
                    $tipoarchivo = "Altas_y_Bajas";
                    break;

                default:
                    $tipoarchivo = "none";
            }
            
            $sql = "INSERT INTO docs_alumno(Tipo_documento, Url_documento, Id_alumno, fecha_envio) VALUES(?,?,?,?)";
            $stmt = $con->prepare($sql);
            $stmt->bind_param('ssss', $tipoarchivo, $nuevo_nombreArchivo, $uname, $fechaActual);
            $stmt->execute();

            $archivoquery = "SELECT * FROM docs_alumno WHERE Id_alumno ='" . $uname . "' AND Tipo_documento = '" . $tipoarchivo . "'";
            $archivosql = $con->query($archivoquery);
            while($archivorow = $archivosql->fetch_assoc()){
            echo '<tr>
<td style="text-align: center;"><span class="badge bg-primary">Archivo enviado</span></td>
<td style="text-align: center;">' . $row["nombre"] . ' ' . $row["apellido_pat"] . ' ' . $row["apellido_mat"] . '</td>
<td style="text-align: center;">' . $row["num_control"] . '</td>
<td style="text-align: center;">' . $row["semestre_cursado"] . '</td>
<td style="text-align: center;">' . $row["especialidad"] . '</td>
<td style="text-align: center;">' . $archivorow["fecha_envio"] . '</td>
<td style="text-align: center;"><a href="archivos/' . $archivorow["Url_documento"] . '" target="_blank" class="btn btn-warning" role="button">Abrir</a>
</td>
</tr>';
            }
        }
    }
}
