<?php
require_once 'services/ConexionBD.php';

session_start();
// PREGUNTA SI YA HEMOS INICIADO SESION EN CASO DE QUE NO, NOS REDIRECCIONA AL INDEX
if (!isset($_SESSION['SesionIniciada'])) {
    header('Location: index.php');
    exit;
}

$solicitado = '<span class="badge bg-primary">DOCUMENTADO ENVIADO</span>';
$nosolicitado = '<span class="badge bg-danger">DOCUMENTO NO ENVIADO</span>';
$aprobado = '<span class="badge bg-primary">ACEPTADO</span>';
$noaprobado = '<span class="badge bg-danger">RECHAZADO</span>';

$uname = $_SESSION['no_control'];
$globalquery = "SELECT * FROM alumno WHERE num_control ='" . $uname . "' ";
$globalsql = $con->query($globalquery);
$row = $globalsql->fetch_assoc();
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
        <div class="col-12">
            <div class="row">
                <div class="col-12 grid-margin">
                    <div class="card">
                        <div class="card-body">


                            <div class="col-12 row">

                                <div class="btn-group w-100 mb-2">
                                    <a href="inicio.php" class="btn btn-success">Volver al inicio</a>

                                </div>

                               <div class="container">
<div class="row">
  <div class="col-md-6">
    <form id="form-subir" class="form-subir" method="post" enctype="multipart/form-data">
      <div class="contenedor_1">
        <div class="form-group">
          <label class="pb-2">Tipo de Documento</label>
          <select class="form-control" name="tipo_doc" id="tipo_doc">
            <option value="Kardex">Kardex</option>
            <option value="Calificaciones">Calificaciones</option>
            <option value="Horario">Horario</option>
            <option value="Materias">Materias</option>
            <option value="Expediente">Expediente</option>
            <option value="Inscripcion">Inscripcion</option>
            <option value="Altas_y_Bajas">Altas y Bajas</option>
            <option value="Creditos">Creditos</option>
            <option value="Extra_Curriculares">Extra curriculares</option>
            <option value="Justificantes">Justificantes</option>
            <option value="Proyectos">Proyectos</option>
          </select>
        </div>
        <div id="otros_campos" style="display: none;">
          <div class="form-group">
            <label for="texto">Razon</label>
          <select class="form-control" name="texto" id="texto">
            <option value="Cita_Medica">Cita Medica</option>
            <option value="Motivos_Academicos">Motivos Academicos</option>
            <option value="Enfermedad">Enfermedad</option>
            <option value="Motivos_Familiares_Importantes">Motivos Familiares Importantes</option>
            <option value="Asuntos_Religiosos">Asuntos Religiosos</option>
            <option value="Deberes_Inexcusables">Deberes Inexcusables</option>
            <option value="Fallecimiento_de_un_Familiar">Fallecimiento de un Familiar</option>
            <option value="Enfermedad_de_un_Familiar">Enfermedad de un Familiar</option>
            <option value="Asistencia_a_Pruebas_o_Entrevistas_para_el_Acceso_al_mundo_Laboral">Asistencia a Pruebas o Entrevistas para el Acceso al mundo Laboral</option>
            <option value="Otras_causas_justificadas_tramitacion_de_documentos_oficiales_tales_como_ine,_pasaporte,_residencia,_etc">Otras causas justificadas: tramitacion de documentos oficiales tales como ine, pasaporte, residencia, etc</option>
          </select>
          </div>
          <div class="form-group">
            <label for="fecha">Fecha a Justificar</label>
            <input type="date" class="form-control" id="fecha" name="fecha">
          </div>
          <div class="form-group">
            <label for="archivos">Archivos</label>
            <input type="file" class="form-control" id="archivos" name="archivos[]" multiple>
          </div>
        </div>
        <input type="submit" class="btn btn-primary" value="Solicitar">
      </div>
    </form>
  </div>
  <div class="col-md-6">
    <div class="descripcion_div" id="descripcion_div">
      <h2>DESCRIPCION DEL DOCUMENTO:</h2>
      <div class="descripcion" id="descripcion" style="display: none;"></div>
    </div>
  </div>
</div>
                            </div>
                            <h1 class="archivo-title">Kardex</h1>
 <div class="table-responsive">
    <table class="table">
        <thead>
            <tr style="background-color: #f97c46;color:#FFFFFF;text-align: center;">
                <th>Estado</th>
                <th>Nombre</th>
                <th>Fecha de solicitud</th>
                <th>Accion</th>
                <th>Contactar</th>
            </tr>
        </thead>
        <tbody id="Solicitud_resi">
            <?php
            $archivoquery1 = "SELECT * FROM Solicitudes_alumno WHERE Id_alumno ='" . $row["num_control"] . "' AND Tipo_documento = 'Kardex'";
            $archivosql1 = $con->query($archivoquery1);
            while ($archivorow1 = $archivosql1->fetch_assoc()) {

                if (empty($archivorow1["Url_documento"])) {
                    $col1 = $nosolicitado;
                    $col2 = "NO DISPONIBLE";
                } else {
                    $col1 = $solicitado;
                    
                    $col2 = '<a href="archivos/' . $archivorow1["Url_documento"] . '" class="btn btn-secondary" target="_blank">Ver Documento</a>';
                }
                ?>

                <tr>
                    <td style="text-align: center;"><?php echo $col1; ?></td>
                    <td style="text-align: center;"><?php echo $row["nombre"] . ' ' . $row["apellido_pat"] . ' ' . $row["apellido_mat"]; ?></td>
                    <td style="text-align: center;"><?php echo $archivorow1["fecha_solicitud"]; ?></td>
                    <td style="text-align: center;"><?php echo $col2 ?></td>
                    <td style="text-align: center;"><a href="mailto:joseantonio.garcia@itspozarica.edu.mx" class="btn btn-primary">CONTACTAR VIA CORREO</a></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
                            <h1 class="archivo-title">Calificaciones</h1>
<div class="table-responsive">
    <table class="table">
        <thead>
            <tr style="background-color: #f97c46;color:#FFFFFF;text-align: center;">
                <th>Estado</th>
                <th>Nombre</th>
                <th>Fecha de solicitud</th>
                <th>Accion</th>
                <th>Contactar</th>
            </tr>
        </thead>
        <tbody id="Solicitud_resi">
            <?php
            $archivoquery1 = "SELECT * FROM Solicitudes_alumno WHERE Id_alumno ='" . $row["num_control"] . "' AND Tipo_documento = 'Calificaciones'";
            $archivosql1 = $con->query($archivoquery1);
            while ($archivorow1 = $archivosql1->fetch_assoc()) {

                if (empty($archivorow1["Url_documento"])) {
                    $col1 = $nosolicitado;
                    $col2 = "NO DISPONIBLE";
                } else {
                    $col1 = $solicitado;
                    
                    $col2 = '<a href="archivos/' . $archivorow1["Url_documento"] . '" class="btn btn-secondary" target="_blank">Ver Documento</a>';
                }
                ?>

                <tr>
                    <td style="text-align: center;"><?php echo $col1; ?></td>
                    <td style="text-align: center;"><?php echo $row["nombre"] . ' ' . $row["apellido_pat"] . ' ' . $row["apellido_mat"]; ?></td>
                    <td style="text-align: center;"><?php echo $archivorow1["fecha_solicitud"]; ?></td>
                    <td style="text-align: center;"><?php echo $col2 ?></td>
                    <td style="text-align: center;"><a href="mailto:joseantonio.garcia@itspozarica.edu.mx" class="btn btn-primary">CONTACTAR VIA CORREO</a></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
                            <h1 class="archivo-title">Horario</h1>
<div class="table-responsive">
    <table class="table">
        <thead>
            <tr style="background-color: #f97c46;color:#FFFFFF;text-align: center;">
                <th>Estado</th>
                <th>Nombre</th>
                <th>Fecha de solicitud</th>
                <th>Accion</th>
                <th>Contactar</th>
            </tr>
        </thead>
        <tbody id="Solicitud_resi">
            <?php
            $archivoquery1 = "SELECT * FROM Solicitudes_alumno WHERE Id_alumno ='" . $row["num_control"] . "' AND Tipo_documento = 'Horario'";
            $archivosql1 = $con->query($archivoquery1);
            while ($archivorow1 = $archivosql1->fetch_assoc()) {

                if (empty($archivorow1["Url_documento"])) {
                    $col1 = $nosolicitado;
                    $col2 = "NO DISPONIBLE";
                } else {
                    $col1 = $solicitado;
                    
                    $col2 = '<a href="archivos/' . $archivorow1["Url_documento"] . '" class="btn btn-secondary" target="_blank">Ver Documento</a>';
                }
                ?>

                <tr>
                    <td style="text-align: center;"><?php echo $col1; ?></td>
                    <td style="text-align: center;"><?php echo $row["nombre"] . ' ' . $row["apellido_pat"] . ' ' . $row["apellido_mat"]; ?></td>
                    <td style="text-align: center;"><?php echo $archivorow1["fecha_solicitud"]; ?></td>
                    <td style="text-align: center;"><?php echo $col2 ?></td>
                    <td style="text-align: center;"><a href="mailto:joseantonio.garcia@itspozarica.edu.mx" class="btn btn-primary">CONTACTAR VIA CORREO</a></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
                            <h1 class="archivo-title">Materias</h1>
<div class="table-responsive">
    <table class="table">
        <thead>
            <tr style="background-color: #f97c46;color:#FFFFFF;text-align: center;">
                <th>Estado</th>
                <th>Nombre</th>
                <th>Fecha de solicitud</th>
                <th>Accion</th>
                <th>Contactar</th>
            </tr>
        </thead>
        <tbody id="Solicitud_resi">
            <?php
            $archivoquery1 = "SELECT * FROM Solicitudes_alumno WHERE Id_alumno ='" . $row["num_control"] . "' AND Tipo_documento = 'Materias'";
            $archivosql1 = $con->query($archivoquery1);
            while ($archivorow1 = $archivosql1->fetch_assoc()) {

                if (empty($archivorow1["Url_documento"])) {
                    $col1 = $nosolicitado;
                    $col2 = "NO DISPONIBLE";
                } else {
                    $col1 = $solicitado;
                    
                    $col2 = '<a href="archivos/' . $archivorow1["Url_documento"] . '" class="btn btn-secondary" target="_blank">Ver Documento</a>';
                }
                ?>

                <tr>
                    <td style="text-align: center;"><?php echo $col1; ?></td>
                    <td style="text-align: center;"><?php echo $row["nombre"] . ' ' . $row["apellido_pat"] . ' ' . $row["apellido_mat"]; ?></td>
                    <td style="text-align: center;"><?php echo $archivorow1["fecha_solicitud"]; ?></td>
                    <td style="text-align: center;"><?php echo $col2 ?></td>
                    <td style="text-align: center;"><a href="mailto:joseantonio.garcia@itspozarica.edu.mx" class="btn btn-primary">CONTACTAR VIA CORREO</a></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
                            <h1 class="archivo-title">Expediente</h1>
<div class="table-responsive">
    <table class="table">
        <thead>
            <tr style="background-color: #f97c46;color:#FFFFFF;text-align: center;">
                <th>Estado</th>
                <th>Nombre</th>
                <th>Fecha de solicitud</th>
                <th>Accion</th>
                <th>Contactar</th>
            </tr>
        </thead>
        <tbody id="Solicitud_resi">
            <?php
            $archivoquery1 = "SELECT * FROM Solicitudes_alumno WHERE Id_alumno ='" . $row["num_control"] . "' AND Tipo_documento = 'Expediente'";
            $archivosql1 = $con->query($archivoquery1);
            while ($archivorow1 = $archivosql1->fetch_assoc()) {

                if (empty($archivorow1["Url_documento"])) {
                    $col1 = $nosolicitado;
                    $col2 = "NO DISPONIBLE";
                } else {
                    $col1 = $solicitado;
                    
                    $col2 = '<a href="archivos/' . $archivorow1["Url_documento"] . '" class="btn btn-secondary" target="_blank">Ver Documento</a>';
                }
                ?>

                <tr>
                    <td style="text-align: center;"><?php echo $col1; ?></td>
                    <td style="text-align: center;"><?php echo $row["nombre"] . ' ' . $row["apellido_pat"] . ' ' . $row["apellido_mat"]; ?></td>
                    <td style="text-align: center;"><?php echo $archivorow1["fecha_solicitud"]; ?></td>
                    <td style="text-align: center;"><?php echo $col2 ?></td>
                    <td style="text-align: center;"><a href="mailto:joseantonio.garcia@itspozarica.edu.mx" class="btn btn-primary">CONTACTAR VIA CORREO</a></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
                            <h1 class="archivo-title">Inscripcion</h1>
<div class="table-responsive">
    <table class="table">
        <thead>
            <tr style="background-color: #f97c46;color:#FFFFFF;text-align: center;">
                <th>Estado</th>
                <th>Nombre</th>
                <th>Fecha de solicitud</th>
                <th>Accion</th>
                <th>Contactar</th>
            </tr>
        </thead>
        <tbody id="Solicitud_resi">
            <?php
            $archivoquery1 = "SELECT * FROM Solicitudes_alumno WHERE Id_alumno ='" . $row["num_control"] . "' AND Tipo_documento = 'Inscripcion'";
            $archivosql1 = $con->query($archivoquery1);
            while ($archivorow1 = $archivosql1->fetch_assoc()) {

                if (empty($archivorow1["Url_documento"])) {
                    $col1 = $nosolicitado;
                    $col2 = "NO DISPONIBLE";
                } else {
                    $col1 = $solicitado;
                    
                    $col2 = '<a href="archivos/' . $archivorow1["Url_documento"] . '" class="btn btn-secondary" target="_blank">Ver Documento</a>';
                }
                ?>

                <tr>
                    <td style="text-align: center;"><?php echo $col1; ?></td>
                    <td style="text-align: center;"><?php echo $row["nombre"] . ' ' . $row["apellido_pat"] . ' ' . $row["apellido_mat"]; ?></td>
                    <td style="text-align: center;"><?php echo $archivorow1["fecha_solicitud"]; ?></td>
                    <td style="text-align: center;"><?php echo $col2 ?></td>
                    <td style="text-align: center;"><a href="mailto:joseantonio.garcia@itspozarica.edu.mx" class="btn btn-primary">CONTACTAR VIA CORREO</a></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
                            <h1 class="archivo-title">Altas y Bajas</h1>
<div class="table-responsive">
    <table class="table">
        <thead>
            <tr style="background-color: #f97c46;color:#FFFFFF;text-align: center;">
                <th>Estado</th>
                <th>Nombre</th>
                <th>Fecha de solicitud</th>
                <th>Accion</th>
                <th>Contactar</th>
            </tr>
        </thead>
        <tbody id="Solicitud_resi">
            <?php
            $archivoquery1 = "SELECT * FROM Solicitudes_alumno WHERE Id_alumno ='" . $row["num_control"] . "' AND Tipo_documento = 'Altas_y_Bajas'";
            $archivosql1 = $con->query($archivoquery1);
            while ($archivorow1 = $archivosql1->fetch_assoc()) {

                if (empty($archivorow1["Url_documento"])) {
                    $col1 = $nosolicitado;
                    $col2 = "NO DISPONIBLE";
                } else {
                    $col1 = $solicitado;
                    
                    $col2 = '<a href="archivos/' . $archivorow1["Url_documento"] . '" class="btn btn-secondary" target="_blank">Ver Documento</a>';
                }
                ?>

                <tr>
                    <td style="text-align: center;"><?php echo $col1; ?></td>
                    <td style="text-align: center;"><?php echo $row["nombre"] . ' ' . $row["apellido_pat"] . ' ' . $row["apellido_mat"]; ?></td>
                    <td style="text-align: center;"><?php echo $archivorow1["fecha_solicitud"]; ?></td>
                    <td style="text-align: center;"><?php echo $col2 ?></td>
                    <td style="text-align: center;"><a href="mailto:joseantonio.garcia@itspozarica.edu.mx" class="btn btn-primary">CONTACTAR VIA CORREO</a></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
                            <h1 class="archivo-title">Creditos</h1>
<div class="table-responsive">
    <table class="table">
        <thead>
            <tr style="background-color: #f97c46;color:#FFFFFF;text-align: center;">
                <th>Estado</th>
                <th>Nombre</th>
                <th>Fecha de solicitud</th>
                <th>Accion</th>
                <th>Contactar</th>
            </tr>
        </thead>
        <tbody id="Solicitud_resi">
            <?php
            $archivoquery1 = "SELECT * FROM Solicitudes_alumno WHERE Id_alumno ='" . $row["num_control"] . "' AND Tipo_documento = 'Creditos'";
            $archivosql1 = $con->query($archivoquery1);
            while ($archivorow1 = $archivosql1->fetch_assoc()) {

                if (empty($archivorow1["Url_documento"])) {
                    $col1 = $nosolicitado;
                    $col2 = "NO DISPONIBLE";
                } else {
                    $col1 = $solicitado;
                    
                    $col2 = '<a href="archivos/' . $archivorow1["Url_documento"] . '" class="btn btn-secondary" target="_blank">Ver Documento</a>';
                }
                ?>

                <tr>
                    <td style="text-align: center;"><?php echo $col1; ?></td>
                    <td style="text-align: center;"><?php echo $row["nombre"] . ' ' . $row["apellido_pat"] . ' ' . $row["apellido_mat"]; ?></td>
                    <td style="text-align: center;"><?php echo $archivorow1["fecha_solicitud"]; ?></td>
                    <td style="text-align: center;"><?php echo $col2 ?></td>
                    <td style="text-align: center;"><a href="mailto:joseantonio.garcia@itspozarica.edu.mx" class="btn btn-primary">CONTACTAR VIA CORREO</a></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
                            <h1 class="archivo-title">Extra curriculares</h1>
 <div class="table-responsive">
    <table class="table">
        <thead>
            <tr style="background-color: #f97c46;color:#FFFFFF;text-align: center;">
                <th>Estado</th>
                <th>Nombre</th>
                <th>Fecha de solicitud</th>
                <th>Accion</th>
                <th>Contactar</th>
            </tr>
        </thead>
        <tbody id="Solicitud_resi">
            <?php
            $archivoquery1 = "SELECT * FROM Solicitudes_alumno WHERE Id_alumno ='" . $row["num_control"] . "' AND Tipo_documento = 'Extra_Curriculares'";
            $archivosql1 = $con->query($archivoquery1);
            while ($archivorow1 = $archivosql1->fetch_assoc()) {

                if (empty($archivorow1["Url_documento"])) {
                    $col1 = $nosolicitado;
                    $col2 = "NO DISPONIBLE";
                } else {
                    $col1 = $solicitado;
                    
                    $col2 = '<a href="archivos/' . $archivorow1["Url_documento"] . '" class="btn btn-secondary" target="_blank">Ver Documento</a>';
                }
                ?>

                <tr>
                    <td style="text-align: center;"><?php echo $col1; ?></td>
                    <td style="text-align: center;"><?php echo $row["nombre"] . ' ' . $row["apellido_pat"] . ' ' . $row["apellido_mat"]; ?></td>
                    <td style="text-align: center;"><?php echo $archivorow1["fecha_solicitud"]; ?></td>
                    <td style="text-align: center;"><?php echo $col2 ?></td>
                    <td style="text-align: center;"><a href="mailto:joseantonio.garcia@itspozarica.edu.mx" class="btn btn-primary">CONTACTAR VIA CORREO</a></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
<h1 class="archivo-title">Justificantes</h1>
<div class="table-responsive">
    <table class="table">
        <thead>
            <tr style="background-color: #f97c46;color:#FFFFFF;text-align: center;">
                <th>Nombre</th>
                <th>Fecha de solicitud</th>
                <th>Fecha a Justificar</th>
                <th>Aprobado</th>
                <th>Accion</th>
                <th>Contactar</th>
            </tr>
        </thead>
        <tbody id="Solicitud_resi">
            <?php
            $archivoquery1 = "SELECT * FROM justificantes WHERE Id_alumno ='" . $row["num_control"] . "'";
            $archivosql1 = $con->query($archivoquery1);
            while ($archivorow1 = $archivosql1->fetch_assoc()) {

                if (empty($archivorow1["Url_justificante"])) {
                    $col2 = "NO DISPONIBLE";
                } else {
                    
                    $col2 = '<a href="archivos/' . $archivorow1["Url_justificante"] . '" class="btn btn-secondary" target="_blank">Ver Justificante</a>';
                }
                
                if ($archivorow1["aprobado"] == 0) {
                    $colxd = $noaprobado;
                } else {
                    $colxd = $aprobado;
                                    }
                ?>

                <tr>
                    <td style="text-align: center;"><?php echo $row["nombre"] . ' ' . $row["apellido_pat"] . ' ' . $row["apellido_mat"]; ?></td>
                    <td style="text-align: center;"><?php echo $archivorow1["fecha_solicitud"]; ?></td>
                    <td style="text-align: center;"><?php echo $archivorow1["fecha_justificar"]; ?></td>
                    <td style="text-align: center;"><?php echo $colxd ?></td>
                    <td style="text-align: center;"><?php echo $col2 ?></td>
                    <td style="text-align: center;"><a href="mailto:joseantonio.garcia@itspozarica.edu.mx" class="btn btn-primary">CONTACTAR VIA CORREO</a></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
                            <h1 class="archivo-title">Proyectos</h1>
                            <div class="table-responsive">
    <table class="table">
        <thead>
            <tr style="background-color: #f97c46;color:#FFFFFF;text-align: center;">
                <th>Estado</th>
                <th>Nombre</th>
                <th>Fecha de solicitud</th>
                <th>Accion</th>
                <th>Contactar</th>
            </tr>
        </thead>
        <tbody id="Solicitud_resi">
            <?php
            $archivoquery1 = "SELECT * FROM Solicitudes_alumno WHERE Id_alumno ='" . $row["num_control"] . "' AND Tipo_documento = 'Proyectos'";
            $archivosql1 = $con->query($archivoquery1);
            while ($archivorow1 = $archivosql1->fetch_assoc()) {

                if (empty($archivorow1["Url_documento"])) {
                    $col1 = $nosolicitado;
                    $col2 = "NO DISPONIBLE";
                } else {
                    $col1 = $solicitado;
                    
                    $col2 = '<a href="archivos/' . $archivorow1["Url_documento"] . '" class="btn btn-secondary" target="_blank">Ver Documento</a>';
                }
                ?>

                <tr>
                    <td style="text-align: center;"><?php echo $col1; ?></td>
                    <td style="text-align: center;"><?php echo $row["nombre"] . ' ' . $row["apellido_pat"] . ' ' . $row["apellido_mat"]; ?></td>
                    <td style="text-align: center;"><?php echo $archivorow1["fecha_solicitud"]; ?></td>
                    <td style="text-align: center;"><?php echo $col2 ?></td>
                    <td style="text-align: center;"><a href="mailto:joseantonio.garcia@itspozarica.edu.mx" class="btn btn-primary">CONTACTAR VIA CORREO</a></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
                           </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="js/solicitar-documentos.js"></script>
</body>

</html>