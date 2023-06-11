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


                        <h4 class="card-title">Lista de alumnos</h4>

                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr style="background-color:purple; color:#FFFFFF;">
                                        <th>Num. Control</th>
                                        <th>Nombre</th>
                                        <th>Fecha de registro</th>
                                        <th>Foto</th>
                                        <th>Accion</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    // HACEMOS UN BUCLE PARA RELLENAR LA TABLA EN BASE AL QUERY ANTERIOR
                                    $query = "SELECT * FROM alumno";
                                    $sql = $con->query($query);
                                    while ($rowSql = $sql->fetch_assoc()) {   ?>

                                        <tr>
                                            <td style="text-align: center;"><?php echo $rowSql["num_control"]; ?></td>
                                            <td style="text-align: center;"><?php echo $rowSql["nombre"]; ?></td>
                                            <td style="text-align: center;"><?php echo $rowSql["fecha_registro"]; ?></td>
                                            <td style="text-align: center;"><?php echo ('<a href="fotos/' . $rowSql["foto"] . '" class="btn btn-info" role="button" target="_blank">Ver foto</a>'); ?></td>
                                            <td style="text-align: center;">
                                                <?php
                                                if ($rowSql["aprobado"] == '0') {
                                                    $buttonText = 'APROBAR';
                                                } else {
                                                    $buttonText = 'NO APROBAR';
                                                }
                                                ?>

                                                <form action="includes/procesarAprobacion.php" method="post">
                                                    <input type="hidden" name="num_control" value="<?php echo $rowSql['num_control']; ?>">
                                                    <button type="submit" class="btn btn-warning"><?php echo $buttonText; ?></button>
                                                </form>
                                                <form action="includes/eliminar.php" method="post">
                                                    <input type="hidden" name="num_control2" value="<?php echo $rowSql['num_control']; ?>">
                                                    <button type="submit" class="btn btn-danger">ELIMINAR</button>
                                                </form>
                                                    <a href="historial.php?num_control=<?php echo $rowSql['num_control']; ?>" class="btn btn-info" role="button">Historial</a>

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