<?php
require_once 'services/ConexionBD.php';

session_start();
// PREGUNTA SI YA HEMOS INICIADO SESION EN CASO DE QUE NO, NOS REDIRECCIONA AL INDEX
if (!isset($_SESSION['SesionIniciada'])) {
    header('Location: index.php');
    exit;
}

$subido = '<span class="badge bg-primary">Archivo enviado</span>';
$nosubido = '<span class="badge bg-danger">No se ha enviado nada aun</span>';

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
    <META NAME="AUTHOR" CONTENT="Omar Nayef Pineda Blanco">
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
        <div class="col-12">



            <div class="row">
                <div class="col-12 grid-margin">
                    <div class="card">
                        <div class="card-body">


                            <div class="col-12 row">


                                <form id="form-subir" class="form-subir" method="post" enctype="multipart/form-data">
                                    <div class="contenedor_1">
                                        <div class="form-group col-3">
                                            <label class="pb-2">Tipo de Documento</label>
                                            <select class="form-control" name="tipo_doc" id="tipo_doc">
                                                <option value="Creditos">Liberacion de Creditos</option>
                                                <option value="Justificantes">Justifcantes</option>
                                                <option value="Altas_y_Bajas">Altas y Bajas</option>
                                            </select>
                                        </div>
                                        <input type="file" name="archivo" id="archivo" class="input-cont1" />
                                        <div class="col-1">
                                            <input type="submit" class="btn " value="Ver" style="margin-top: 38px; background-color: purple; color: white;">
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <h1 class="archivo-title">Liberacion de Creditos</h1>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr style="background-color: #f97c46;color:#FFFFFF;text-align: center;">
                                            <th>Subido</th>
                                            <th>Nombre</th>
                                            <th>Accion</th>
                                        </tr>
                                    </thead>
                                    <tbody id="Creditos">
                                        <?php

                                        $archivoquery1 = "SELECT Creditos FROM docs_alumno WHERE Id_alumno ='" . $row["num_control"] . "' AND Creditos != ''";
                                        $archivosql1 = $con->query($archivoquery1);
                                        if ($archivosql1) {
                                            if (mysqli_num_rows($archivosql1) > 0) {
                                                $archivorow1 = $archivosql1->fetch_assoc();
                                                $col1 = $subido;
                                                $col2 = '<a href="archivos/' . $archivorow1["Creditos"] . '" target="_blank"  class="btn btn-warning" role="button">Abrir</a>';
                                            } else {
                                                $col1 = $nosubido;
                                                $col2 = 'NO DISPONIBLE';
                                            }
                                        } else {
                                            echo 'Error';
                                        }



                                        ?>

                                        <tr>
                                            <td style="text-align: center;"><?php echo $col1; ?></td>
                                            <td style="text-align: center;"><?php echo $row["nombre"] . ' ' . $row["apellido_pat"] . ' ' . $row["apellido_mat"]; ?></td>
                                            <td style="text-align: center;"><?php echo $col2 ?></td>
                                        </tr>

                                        <?php //} 
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                            <h1 class="archivo-title">Justificantes</h1>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr style="background-color: #f97c46;color:#FFFFFF;text-align: center;">
                                            <th>Subido</th>
                                            <th>Nombre</th>
                                            <th>Accion</th>
                                        </tr>
                                    </thead>
                                    <tbody id="Justificantes">
                                        <?php

                                        $archivoquery2 = "SELECT Justificantes FROM docs_alumno WHERE Id_alumno ='" . $row["num_control"] . "' AND Justificantes != ''";
                                        $archivosql2 = $con->query($archivoquery2);
                                        if ($archivosql2) {
                                            if (mysqli_num_rows($archivosql2) > 0) {
                                                $archivorow2 = $archivosql2->fetch_assoc();
                                                $col3 = $subido;
                                                $col4 = '<a href="archivos/' . $archivorow2["Justificantes"] . '" target="_blank" class="btn btn-warning" role="button">Abrir</a>';
                                            } else {
                                                $col3 = $nosubido;
                                                $col4 = 'NO DISPONIBLE';
                                            }
                                        } else {
                                            echo 'Error';
                                        }

                                        ?>

                                        <tr>
                                            <td style="text-align: center;"><?php echo $col3;  ?></td>
                                            <td style="text-align: center;"><?php echo $row["nombre"] . ' ' . $row["apellido_pat"] . ' ' . $row["apellido_mat"]; ?></td>
                                            <td style="text-align: center;"><?php echo $col4 ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <h1 class="archivo-title">Altas y Bajas</h1>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr style="background-color: #f97c46;color:#FFFFFF;text-align: center;">
                                            <th>Subido</th>
                                            <th>Nombre</th>
                                            <th>Accion</th>
                                        </tr>
                                    </thead>
                                    <tbody id="Altas_y_Bajas">
                                        <?php

                                        $archivoquery3 = "SELECT Altas_y_Bajas FROM docs_alumno WHERE Id_alumno ='" . $row["num_control"] . "' AND Altas_y_Bajas != ''";
                                        $archivosql3 = $con->query($archivoquery3);
                                        if ($archivosql3) {
                                            if (mysqli_num_rows($archivosql3) > 0) {
                                                $archivorow3 = $archivosql3->fetch_assoc();
                                                $col5 = $subido;
                                                $col6 = '<a href="archivos/' . $archivorow3["Altas_y_Bajas"] . '" target="_blank" class="btn btn-warning" role="button">Abrir</a>';
                                            } else {
                                                $col5 = $nosubido;
                                                $col6 = 'NO DISPONIBLE';
                                            }
                                        } else {
                                            echo 'Error';
                                        }

                                        ?>

                                        <tr>
                                            <td style="text-align: center;"><?php echo $col5;  ?></td>
                                            <td style="text-align: center;"><?php echo $row["nombre"] . ' ' . $row["apellido_pat"] . ' ' . $row["apellido_mat"]; ?></td>
                                            <td style="text-align: center;"><?php echo $col6 ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>



                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="js/upload-archivos.js"></script>
</body>

</html>