<?php
require_once 'services/ConexionBD.php';

session_start();
// PREGUNTA SI YA HEMOS INICIADO SESION EN CASO DE QUE NO, NOS REDIRECCIONA AL INDEX
if (!isset($_SESSION['SesionIniciada'])) {
    header('Location: index.php');
    exit;
}

$solicitado = '<span class="badge bg-primary">DOCUMENTADO SOLICITADO</span>';
$nosolicitado = '<span class="badge bg-danger">DOCUMENTO NO SOLICITADO</span>';

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
          <input type="submit" class="btn btn-primary" value="Solicitar">
        </div>
      </form>
    </div>
    <div class="col-md-6">
      <div class="descripcion_div" id="descripcion_div">
      <h2>DESCRIPCION DEL DOCUMENTO:</h2>
<div class="descripcion" id="descripcion" style="display: none;">
      </div>      </div>
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
                                        $archivorow1 = $archivosql1->fetch_assoc();
                                        if ($archivosql1) {
                                            if (mysqli_num_rows($archivosql1) > 0) {
                                                $col1 = $solicitado;
                                                $fechaSoli = $archivorow1["fecha_solicitud"];
                                            } else {
                                                $col1 = $nosolicitado;
                                                $fechaSoli = 'NO DISPONIBLE';
                                            }
                                        } else {
                                            echo 'Error';
                                        }

                                        $archivoquery2 = "SELECT * FROM Solicitudes_alumno WHERE Id_alumno ='" . $row["num_control"] . "' AND Tipo_documento = 'Kardex' AND Url_documento != ''";
                                        $archivosql2 = $con->query($archivoquery2);
                                        if ($archivosql2) {
                                            if (mysqli_num_rows($archivosql2) > 0) {
                                                $archivorow2 = $archivosql2->fetch_assoc();
                                                $col2 = '<a href="archivos/' . $archivorow2["Url_documento"] . '" class="btn btn-secondary" target="_blank">Ver Documento</a>';
                                            } else {
                                                $col2 = "NO DISPONIBLE";
                                            }
                                        } else {
                                            echo 'Error';
                                        }
                                        ?>

                                        <tr>
                                            <td style="text-align: center;"><?php echo $col1; ?></td>
                                            <td style="text-align: center;"><?php echo $row["nombre"] . ' ' . $row["apellido_pat"] . ' ' . $row["apellido_mat"]; ?></td>
                                            <td style="text-align: center;"><?php echo  $fechaSoli?></td>
                                            <td style="text-align: center;"><?php echo $col2 ?></td>
                                            <td style="text-align: center;"><a href="mailto:joseantonio.garcia@itspozarica.edu.mx" class="btn btn-primary">CONTACTAR VIA CORREO</a></td>
                                        </tr>
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
                                        $archivorow1 = $archivosql1->fetch_assoc();
                                        if ($archivosql1) {
                                            if (mysqli_num_rows($archivosql1) > 0) {
                                                $col1 = $solicitado;
                                                $fechaSoli = $archivorow1["fecha_solicitud"];
                                            } else {
                                                $col1 = $nosolicitado;
                                                $fechaSoli = "NO DISPONIBLE";
                                            }
                                        } else {
                                            echo 'Error';
                                        }

                                        $archivoquery2 = "SELECT * FROM Solicitudes_alumno WHERE Id_alumno ='" . $row["num_control"] . "' AND Tipo_documento = 'Calificaciones' AND Url_documento != ''";
                                        $archivosql2 = $con->query($archivoquery2);
                                        if ($archivosql2) {
                                            if (mysqli_num_rows($archivosql2) > 0) {
                                                $archivorow2 = $archivosql2->fetch_assoc();
                                                $col2 = '<a href="archivos/' . $archivorow2["Url_documento"] . '" class="btn btn-secondary" target="_blank">Ver Documento</a>';
                                            } else {
                                                $col2 = "NO DISPONIBLE";
                                            }
                                        } else {
                                            echo 'Error';
                                        }
                                        ?>

                                        <tr>
                                            <td style="text-align: center;"><?php echo $col1; ?></td>
                                            <td style="text-align: center;"><?php echo $row["nombre"] . ' ' . $row["apellido_pat"] . ' ' . $row["apellido_mat"]; ?></td>
                                            <td style="text-align: center;"><?php echo  $fechaSoli?></td>
                                            <td style="text-align: center;"><?php echo $col2 ?></td>
                                            <td style="text-align: center;"><a href="mailto:joseantonio.garcia@itspozarica.edu.mx" class="btn btn-primary">CONTACTAR VIA CORREO</a></td>
                                        </tr>
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
                                        $archivorow1 = $archivosql1->fetch_assoc();
                                        if ($archivosql1) {
                                            if (mysqli_num_rows($archivosql1) > 0) {
                                                $col1 = $solicitado;
                                                $fechaSoli = $archivorow1["fecha_solicitud"];
                                            } else {
                                                $col1 = $nosolicitado;
                                                $fechaSoli = "NO DISPONIBLE";
                                            }
                                        } else {
                                            echo 'Error';
                                        }

                                        $archivoquery2 = "SELECT * FROM Solicitudes_alumno WHERE Id_alumno ='" . $row["num_control"] . "' AND Tipo_documento = 'Horario' AND Url_documento != ''";
                                        $archivosql2 = $con->query($archivoquery2);
                                        if ($archivosql2) {
                                            if (mysqli_num_rows($archivosql2) > 0) {
                                                $archivorow2 = $archivosql2->fetch_assoc();
                                                $col2 = '<a href="archivos/' . $archivorow2["Url_documento"] . '" class="btn btn-secondary" target="_blank">Ver Documento</a>';
                                            } else {
                                                $col2 = "NO DISPONIBLE";
                                            }
                                        } else {
                                            echo 'Error';
                                        }
                                        ?>

                                        <tr>
                                            <td style="text-align: center;"><?php echo $col1; ?></td>
                                            <td style="text-align: center;"><?php echo $row["nombre"] . ' ' . $row["apellido_pat"] . ' ' . $row["apellido_mat"]; ?></td>
                                            <td style="text-align: center;"><?php echo  $fechaSoli?></td>
                                            <td style="text-align: center;"><?php echo $col2 ?></td>
                                            <td style="text-align: center;"><a href="mailto:joseantonio.garcia@itspozarica.edu.mx" class="btn btn-primary">CONTACTAR VIA CORREO</a></td>
                                        </tr>
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
                                        $archivorow1 = $archivosql1->fetch_assoc();
                                        if ($archivosql1) {
                                            if (mysqli_num_rows($archivosql1) > 0) {
                                                $col1 = $solicitado;
                                                $fechaSoli = $archivorow1["fecha_solicitud"];
                                            } else {
                                                $col1 = $nosolicitado;
                                                $fechaSoli = "NO DISPONIBLE";
                                            }
                                        } else {
                                            echo 'Error';
                                        }

                                        $archivoquery2 = "SELECT * FROM Solicitudes_alumno WHERE Id_alumno ='" . $row["num_control"] . "' AND Tipo_documento = 'Materias' AND Url_documento != ''";
                                        $archivosql2 = $con->query($archivoquery2);
                                        if ($archivosql2) {
                                            if (mysqli_num_rows($archivosql2) > 0) {
                                                $archivorow2 = $archivosql2->fetch_assoc();
                                                $col2 = '<a href="archivos/' . $archivorow2["Url_documento"] . '" class="btn btn-secondary" target="_blank">Ver Documento</a>';
                                            } else {
                                                $col2 = "NO DISPONIBLE";
                                            }
                                        } else {
                                            echo 'Error';
                                        }
                                        ?>

                                        <tr>
                                            <td style="text-align: center;"><?php echo $col1; ?></td>
                                            <td style="text-align: center;"><?php echo $row["nombre"] . ' ' . $row["apellido_pat"] . ' ' . $row["apellido_mat"]; ?></td>
                                            <td style="text-align: center;"><?php echo  $fechaSoli?></td>
                                            <td style="text-align: center;"><?php echo $col2 ?></td>
                                            <td style="text-align: center;"><a href="mailto:joseantonio.garcia@itspozarica.edu.mx" class="btn btn-primary">CONTACTAR VIA CORREO</a></td>
                                        </tr>
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
                                        $archivorow1 = $archivosql1->fetch_assoc();
                                        if ($archivosql1) {
                                            if (mysqli_num_rows($archivosql1) > 0) {
                                                $col1 = $solicitado;
                                                $fechaSoli = $archivorow1["fecha_solicitud"];
                                            } else {
                                                $col1 = $nosolicitado;
                                                $fechaSoli = "NO DISPONIBLE";
                                            }
                                        } else {
                                            echo 'Error';
                                        }

                                        $archivoquery2 = "SELECT * FROM Solicitudes_alumno WHERE Id_alumno ='" . $row["num_control"] . "' AND Tipo_documento = 'Expediente' AND Url_documento != ''";
                                        $archivosql2 = $con->query($archivoquery2);
                                        if ($archivosql2) {
                                            if (mysqli_num_rows($archivosql2) > 0) {
                                                $archivorow2 = $archivosql2->fetch_assoc();
                                                $col2 = '<a href="archivos/' . $archivorow2["Url_documento"] . '" class="btn btn-secondary" target="_blank">Ver Documento</a>';
                                            } else {
                                                $col2 = "NO DISPONIBLE";
                                            }
                                        } else {
                                            echo 'Error';
                                        }
                                        ?>

                                        <tr>
                                            <td style="text-align: center;"><?php echo $col1; ?></td>
                                            <td style="text-align: center;"><?php echo $row["nombre"] . ' ' . $row["apellido_pat"] . ' ' . $row["apellido_mat"]; ?></td>
                                            <td style="text-align: center;"><?php echo  $fechaSoli?></td>
                                            <td style="text-align: center;"><?php echo $col2 ?></td>
                                            <td style="text-align: center;"><a href="mailto:joseantonio.garcia@itspozarica.edu.mx" class="btn btn-primary">CONTACTAR VIA CORREO</a></td>
                                        </tr>
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
                                        $archivorow1 = $archivosql1->fetch_assoc();
                                        if ($archivosql1) {
                                            if (mysqli_num_rows($archivosql1) > 0) {
                                                $col1 = $solicitado;
                                                $fechaSoli = $archivorow1["fecha_solicitud"];
                                            } else {
                                                $col1 = $nosolicitado;
                                                $fechaSoli = "NO DISPONIBLE";
                                            }
                                        } else {
                                            echo 'Error';
                                        }

                                        $archivoquery2 = "SELECT * FROM Solicitudes_alumno WHERE Id_alumno ='" . $row["num_control"] . "' AND Tipo_documento = 'Inscripcion' AND Url_documento != ''";
                                        $archivosql2 = $con->query($archivoquery2);
                                        if ($archivosql2) {
                                            if (mysqli_num_rows($archivosql2) > 0) {
                                                $archivorow2 = $archivosql2->fetch_assoc();
                                                $col2 = '<a href="archivos/' . $archivorow2["Url_documento"] . '" class="btn btn-secondary" target="_blank">Ver Documento</a>';
                                            } else {
                                                $col2 = "NO DISPONIBLE";
                                            }
                                        } else {
                                            echo 'Error';
                                        }
                                        ?>

                                        <tr>
                                            <td style="text-align: center;"><?php echo $col1; ?></td>
                                            <td style="text-align: center;"><?php echo $row["nombre"] . ' ' . $row["apellido_pat"] . ' ' . $row["apellido_mat"]; ?></td>
                                            <td style="text-align: center;"><?php echo  $fechaSoli?></td>
                                            <td style="text-align: center;"><?php echo $col2 ?></td>
                                            <td style="text-align: center;"><a href="mailto:joseantonio.garcia@itspozarica.edu.mx" class="btn btn-primary">CONTACTAR VIA CORREO</a></td>
                                        </tr>
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
                                        $archivorow1 = $archivosql1->fetch_assoc();
                                        if ($archivosql1) {
                                            if (mysqli_num_rows($archivosql1) > 0) {
                                                $col1 = $solicitado;
                                                $fechaSoli = $archivorow1["fecha_solicitud"];
                                            } else {
                                                $col1 = $nosolicitado;
                                                $fechaSoli = "NO DISPONIBLE";
                                            }
                                        } else {
                                            echo 'Error';
                                        }

                                        $archivoquery2 = "SELECT * FROM Solicitudes_alumno WHERE Id_alumno ='" . $row["num_control"] . "' AND Tipo_documento = 'Altas_y_Bajas' AND Url_documento != ''";
                                        $archivosql2 = $con->query($archivoquery2);
                                        if ($archivosql2) {
                                            if (mysqli_num_rows($archivosql2) > 0) {
                                                $archivorow2 = $archivosql2->fetch_assoc();
                                                $col2 = '<a href="archivos/' . $archivorow2["Url_documento"] . '" class="btn btn-secondary" target="_blank">Ver Documento</a>';
                                            } else {
                                                $col2 = "NO DISPONIBLE";
                                            }
                                        } else {
                                            echo 'Error';
                                        }
                                        ?>

                                        <tr>
                                            <td style="text-align: center;"><?php echo $col1; ?></td>
                                            <td style="text-align: center;"><?php echo $row["nombre"] . ' ' . $row["apellido_pat"] . ' ' . $row["apellido_mat"]; ?></td>
                                            <td style="text-align: center;"><?php echo  $fechaSoli?></td>
                                            <td style="text-align: center;"><?php echo $col2 ?></td>
                                            <td style="text-align: center;"><a href="mailto:joseantonio.garcia@itspozarica.edu.mx" class="btn btn-primary">CONTACTAR VIA CORREO</a></td>
                                        </tr>
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
                                        $archivorow1 = $archivosql1->fetch_assoc();
                                        if ($archivosql1) {
                                            if (mysqli_num_rows($archivosql1) > 0) {
                                                $col1 = $solicitado;
                                                $fechaSoli = $archivorow1["fecha_solicitud"];
                                            } else {
                                                $col1 = $nosolicitado;
                                                $fechaSoli = "NO DISPONIBLE";
                                            }
                                        } else {
                                            echo 'Error';
                                        }

                                        $archivoquery2 = "SELECT * FROM Solicitudes_alumno WHERE Id_alumno ='" . $row["num_control"] . "' AND Tipo_documento = 'Creditos' AND Url_documento != ''";
                                        $archivosql2 = $con->query($archivoquery2);
                                        if ($archivosql2) {
                                            if (mysqli_num_rows($archivosql2) > 0) {
                                                $archivorow2 = $archivosql2->fetch_assoc();
                                                $col2 = '<a href="archivos/' . $archivorow2["Url_documento"] . '" class="btn btn-secondary" target="_blank">Ver Documento</a>';
                                            } else {
                                                $col2 = "NO DISPONIBLE";
                                            }
                                        } else {
                                            echo 'Error';
                                        }
                                        ?>

                                        <tr>
                                            <td style="text-align: center;"><?php echo $col1; ?></td>
                                            <td style="text-align: center;"><?php echo $row["nombre"] . ' ' . $row["apellido_pat"] . ' ' . $row["apellido_mat"]; ?></td>
                                            <td style="text-align: center;"><?php echo  $fechaSoli?></td>
                                            <td style="text-align: center;"><?php echo $col2 ?></td>
                                            <td style="text-align: center;"><a href="mailto:joseantonio.garcia@itspozarica.edu.mx" class="btn btn-primary">CONTACTAR VIA CORREO</a></td>
                                        </tr>
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
                                        $archivorow1 = $archivosql1->fetch_assoc();
                                        if ($archivosql1) {
                                            if (mysqli_num_rows($archivosql1) > 0) {
                                                $col1 = $solicitado;
                                                $fechaSoli = $archivorow1["fecha_solicitud"];
                                            } else {
                                                $col1 = $nosolicitado;
                                                $fechaSoli = "NO DISPONIBLE";
                                            }
                                        } else {
                                            echo 'Error';
                                        }

                                        $archivoquery2 = "SELECT * FROM Solicitudes_alumno WHERE Id_alumno ='" . $row["num_control"] . "' AND Tipo_documento = 'Extra_Curriculares' AND Url_documento != ''";
                                        $archivosql2 = $con->query($archivoquery2);
                                        if ($archivosql2) {
                                            if (mysqli_num_rows($archivosql2) > 0) {
                                                $archivorow2 = $archivosql2->fetch_assoc();
                                                $col2 = '<a href="archivos/' . $archivorow2["Url_documento"] . '" class="btn btn-secondary" target="_blank">Ver Documento</a>';
                                            } else {
                                                $col2 = "NO DISPONIBLE";
                                            }
                                        } else {
                                            echo 'Error';
                                        }
                                        ?>

                                        <tr>
                                            <td style="text-align: center;"><?php echo $col1; ?></td>
                                            <td style="text-align: center;"><?php echo $row["nombre"] . ' ' . $row["apellido_pat"] . ' ' . $row["apellido_mat"]; ?></td>
                                            <td style="text-align: center;"><?php echo  $fechaSoli?></td>
                                            <td style="text-align: center;"><?php echo $col2 ?></td>
                                            <td style="text-align: center;"><a href="mailto:joseantonio.garcia@itspozarica.edu.mx" class="btn btn-primary">CONTACTAR VIA CORREO</a></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <h1 class="archivo-title">Justificantes</h1>
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

                                        $archivoquery1 = "SELECT * FROM Solicitudes_alumno WHERE Id_alumno ='" . $row["num_control"] . "' AND Tipo_documento = 'Justificantes'";
                                        $archivosql1 = $con->query($archivoquery1);
                                        $archivorow1 = $archivosql1->fetch_assoc();
                                        if ($archivosql1) {
                                            if (mysqli_num_rows($archivosql1) > 0) {
                                                $col1 = $solicitado;
                                                $fechaSoli = $archivorow1["fecha_solicitud"];
                                            } else {
                                                $col1 = $nosolicitado;
                                                $fechaSoli = "NO DISPONIBLE";
                                            }
                                        } else {
                                            echo 'Error';
                                        }

                                        $archivoquery2 = "SELECT * FROM Solicitudes_alumno WHERE Id_alumno ='" . $row["num_control"] . "' AND Tipo_documento = 'Justificantes' AND Url_documento != ''";
                                        $archivosql2 = $con->query($archivoquery2);
                                        if ($archivosql2) {
                                            if (mysqli_num_rows($archivosql2) > 0) {
                                                $archivorow2 = $archivosql2->fetch_assoc();
                                                $col2 = '<a href="archivos/' . $archivorow2["Url_documento"] . '" class="btn btn-secondary" target="_blank">Ver Documento</a>';
                                            } else {
                                                $col2 = "NO DISPONIBLE";
                                            }
                                        } else {
                                            echo 'Error';
                                        }
                                        ?>

                                        <tr>
                                            <td style="text-align: center;"><?php echo $col1; ?></td>
                                            <td style="text-align: center;"><?php echo $row["nombre"] . ' ' . $row["apellido_pat"] . ' ' . $row["apellido_mat"]; ?></td>
                                            <td style="text-align: center;"><?php echo  $fechaSoli?></td>
                                            <td style="text-align: center;"><?php echo $col2 ?></td>
                                            <td style="text-align: center;"><a href="mailto:joseantonio.garcia@itspozarica.edu.mx" class="btn btn-primary">CONTACTAR VIA CORREO</a></td>
                                        </tr>
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
                                        $archivorow1 = $archivosql1->fetch_assoc();
                                        if ($archivosql1) {
                                            if (mysqli_num_rows($archivosql1) > 0) {
                                                $col1 = $solicitado;
                                                $fechaSoli = $archivorow1["fecha_solicitud"];
                                            } else {
                                                $col1 = $nosolicitado;
                                                $fechaSoli = "NO DISPONIBLE";
                                            }
                                        } else {
                                            echo 'Error';
                                        }

                                        $archivoquery2 = "SELECT * FROM Solicitudes_alumno WHERE Id_alumno ='" . $row["num_control"] . "' AND Tipo_documento = 'Proyectos' AND Url_documento != ''";
                                        $archivosql2 = $con->query($archivoquery2);
                                        if ($archivosql2) {
                                            if (mysqli_num_rows($archivosql2) > 0) {
                                                $archivorow2 = $archivosql2->fetch_assoc();
                                                $col2 = '<a href="archivos/' . $archivorow2["Url_documento"] . '" class="btn btn-secondary" target="_blank">Ver Documento</a>';
                                            } else {
                                                $col2 = "NO DISPONIBLE";
                                            }
                                        } else {
                                            echo 'Error';
                                        }
                                        ?>


                                        <tr>
                                            <td style="text-align: center;"><?php echo $col1; ?></td>
                                            <td style="text-align: center;"><?php echo $row["nombre"] . ' ' . $row["apellido_pat"] . ' ' . $row["apellido_mat"]; ?></td>
                                            <td style="text-align: center;"><?php echo  $fechaSoli?></td>
                                            <td style="text-align: center;"><?php echo $col2 ?></td>
                                            <td style="text-align: center;"><a href="mailto:joseantonio.garcia@itspozarica.edu.mx" class="btn btn-primary">CONTACTAR VIA CORREO</a></td>
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

    <script src="js/solicitar-documentos.js"></script>
</body>

</html>