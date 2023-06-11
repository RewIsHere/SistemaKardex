<?php
// We need to use sessions, so you should always start sessions using the below code.

require_once 'services/ConexionBD.php';

session_start();
// PREGUNTA SI YA HEMOS INICIADO SESION EN CASO DE QUE NO, NOS REDIRECCIONA AL INDEX
if (!isset($_SESSION['SesionIniciada'])) {
    header('Location: index.php');
    exit;
}
$uname = $_SESSION['correo'];

// PREGUNTA SI EL USUARIO QUE HA INICIADO SESION ES UN DOCENTE

if ($stmt = $con->prepare('SELECT * FROM JefeCarrera WHERE correo = ?')) {
    $stmt->bind_param('s', $uname);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows == 0) {
        header('Location: inicio.php');
    }

    // CIERRA LA CONEXION CON LA BASE DE DATOS 
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="Description" content="Enter your description here" />
    <link href="css/archivos-styles.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <title>Title</title>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.2/umd/popper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/js/bootstrap.min.js"></script>
</body>

</html>


<?php

require_once 'services/ConexionBD.php';



// PREGUNTA SI HEMOS APLICADO ALGUN FILTRO 
if (!isset($_POST['buscadepartamento'])) {
    $_POST['buscadepartamento'] = '';
}


?>




<div class="container mt-5">
    <div class="col-12">



        <div class="row">
            <div class="col-12 grid-margin">
                <div class="card">
                    <div class="card-body">

                        <div class="btn-group w-100 mb-2">
                            <a href="inicio-d.php" class="btn btn-success">Volver al inicio</a>

                        </div>
                        <h4 class="card-title">Buscador</h4>

                        <form id="form2" name="form2" method="POST" action="archivos.php">
                            <div class="col-12 row">



                                <h4 class="card-title">Filtro de búsqueda</h4>

                                <div class="col-11">

                                    <table class="table">
                                        <thead>
                                            <tr class="filters">
                                                <th>
                                                    Tipo de Documento
                                                    <select id="assigned-tutor-filter" id="buscadepartamento" name="buscadepartamento" class="form-control mt-2" style="border: #bababa 1px solid; color:#000000;">
                                                        <?php if ($_POST["buscadepartamento"] != '') { ?>
                                                            <option value="<?php echo $_POST["buscadepartamento"]; ?>">
                                                                <?php
                                                                // ESTABLECE EL TEXTO DEPENDIENDO DE LA OPCION QUE TENGAMOS SELECCIONADA
                                                                if ($_POST["buscadepartamento"] == 'Creditos') {
                                                                    echo 'Solicitud Residencia';
                                                                }
                                                                if ($_POST["buscadepartamento"] == 'Justificantes') {
                                                                    echo 'Carta de Aceptacion';
                                                                }
                                                                if ($_POST["buscadepartamento"] == 'Altas_y_Bajas') {
                                                                    echo 'Reporte preliminar';
                                                                }
                                                                ?>
                                                            </option>

                                                        <?php } ?>
                                                        <option value="">Todos</option>
                                                        <option value="Creditos">Liberacion de Creditos</option>
                                                        <option value="Justificantes">Justificantes</option>
                                                        <option value="Altas_y_Bajas">Altas y Bajas</option>
                                                    </select>
                                                </th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                                <div class="col-1">
                                    <input type="submit" class="btn " value="Ver" style="margin-top: 38px; background-color: purple; color: white;">
                                </div>
                            </div>


                            <?php
                            /*FILTRO de busqueda////////////////////////////////////////////*/


                            // SI NO HAY NINGUN FILTRO ESTABLECIDO LISTARA LOS ALUMNOS CON TODOS SUS ARCHIVOS
                            if ($_POST['buscadepartamento'] == '') {
                                $query = "SELECT alumno.num_control  AS alum_nc, alumno.nombre  AS alum_nom, alumno.apellido_pat  AS alum_app, alumno.apellido_mat  AS 
                                alum_apm,alumno.semestre_cursado AS alum_sem, alumno.especialidad AS alum_espe, docs_alumno.Id_alumno AS docs_idalum FROM alumno INNER JOIN docs_alumno ON alumno.num_control = docs_alumno.Id_alumno";
                            } else {



                                // SI EL FILTRO ES DIFERENTE DE NULO LISTARA EN BASE AL FILTRO SELECCIONADO
                                if ($_POST["buscadepartamento"] != '') {
                                    $query = "SELECT alumno.num_control  AS alum_nc, alumno.nombre  AS alum_nom, alumno.apellido_pat  AS alum_app, alumno.apellido_mat  AS 
                                alum_apm,alumno.semestre_cursado AS alum_sem, alumno.especialidad AS alum_espe, docs_alumno.Id_alumno AS docs_idalum FROM alumno INNER JOIN docs_alumno ON alumno.num_control = docs_alumno.Id_alumno";
                                }
                            }

                            // EJECUTAMOS EL QUERY

                            $sql = $con->query($query);

                            $numeroSql = mysqli_num_rows($sql);

                            ?>
                            <p style="font-weight: bold; color:purple;"><i class="mdi mdi-file-document"></i> <?php echo $numeroSql; ?> Resultados encontrados</p>
                        </form>


                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr style="background-color:purple; color:#FFFFFF;">
                                        <th>Num. Control</th>
                                        <th>Nombre</th>
                                        <th>Semestre</th>
                                        <th>Especialidad</th>
                                        <th>Accion</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    // HACEMOS UN BUCLE PARA RELLENAR LA TABLA EN BASE AL QUERY ANTERIOR
                                    while ($rowSql = $sql->fetch_assoc()) {   ?>

                                        <tr>
                                            <td style="text-align: center;"><?php echo $rowSql["alum_nc"]; ?></td>
                                            <td style="text-align: center;"><?php echo $rowSql["alum_nom"]; ?></td>
                                            <td style="text-align: center;"><?php echo $rowSql["alum_sem"]; ?></td>
                                            <td style="text-align: center;"><?php echo $rowSql["alum_espe"]; ?></td>
                                            <?php
                                            if ($_POST["buscadepartamento"] != '') {
                                                $archivoquery = "SELECT * FROM docs_alumno WHERE Id_alumno ='" . $rowSql["alum_nc"] . "' ";
                                                $archivosql = $con->query($archivoquery);
                                                $archivorow = $archivosql->fetch_assoc();
                                                if ($archivorow[$_POST["buscadepartamento"]] == null) {
                                                    $tab4 = 'NO SE HA SUBIDO AUN';
                                                } else {
                                                    $tab4 = '<a href="archivos/' . $archivorow[$_POST["buscadepartamento"]] . '" class="btn btn-info" role="button">Abrir</a>                                                ';
                                                }
                                            } else {
                                                $tab4 = "<button type='button' class='btn btn-warning' data-bs-toggle='modal' data-bs-target='#edit" . $rowSql['alum_nc'] .  "'>Ver </button>";
                                            } ?>
                                            <td style="text-align: center;"><?php echo $tab4 ?>
                                                <?php include('includes/verArchivos.php'); ?>
                                            </td>
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


</body>

</html>