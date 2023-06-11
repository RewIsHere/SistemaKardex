<?php
// INICIAMOS EL PROCESO DE SESION
require_once 'services/ConexionBD.php';

session_start();
// PREGUNTA SI YA HEMOS INICIADO SESION EN CASO DE QUE NO, NOS REDIRECCIONA AL INDEX
if (!isset($_SESSION['SesionIniciada'])) {
    header('Location: index.php');
    exit;
}



$uname = $_SESSION['no_control'];
$globalquery = "SELECT * FROM alumno WHERE num_control ='" . $uname . "' ";
$globalsql = $con->query($globalquery);
$row = $globalsql->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <title>Home Page</title>
    <link href="css/inicio-styles.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/css/bootstrap.min.css">


</head>

<body class="loggedin">
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
    <nav class="navtop">
        <div>
            <h1>Panel de Alumno</h1>
            <a href="logout.php"><i class="fas fa-sign-out-alt"></i>Cerrar Sesion</a>
        </div>
    </nav>
    <div class="content">
        <h2>Inicio | Panel de Alumno</h2>
        <p style="background-color: #607eff;">Bienvenido de nuevo, <?= $_SESSION['nombre'] ?>!</p>
        <?php
        $aprobadoquery = "SELECT aprobado FROM alumno WHERE num_control ='" . $uname . "' AND aprobado = '1'";
        $aprobadosql = $con->query($aprobadoquery);
        if ($aprobadosql) {
            if (mysqli_num_rows($aprobadosql) > 0) {
                $aprovedTag = '<a href="solicitar_documentos.php" class="btn btn-warning" role="button">SOLICITAR ARCHIVOS</a>
                <a href="enviar_archivos.php" class="btn btn-warning" role="button">ENVIAR ARCHIVOS</a>';
            } else {
                $aprovedTag = '<p><i class="fas fa-exclamation-triangle"></i> TU CUENTA AUN NO HA SIDO APROBADA POR EL JEFE DE CARRERA, POR FAVOR PONTE EN CONTACTO EN CASO DE CUALQUIER DUDA</p>';
            }
        } else {
            echo 'Error';
        } ?>
        <?php echo $aprovedTag ?>
    </div>
</body>

</html>