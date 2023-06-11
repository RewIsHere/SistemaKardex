<?php
require_once 'services/ConexionBD.php';

// INICIAMOS EL PROCESO DE SESION
session_start();
// PREGUNTA SI YA HEMOS INICIADO SESION EN CASO DE QUE NO, NOS REDIRECCIONA AL INDEX
if (!isset($_SESSION['SesionIniciada'])) {
    header('Location: index.php');
    exit;
}

$uname = $_SESSION['correo'];

// HACE UN QUERY PARA SABER SI EL USUARIO QUE HA INICIADO SESION ES UN DOCENTE
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
            <h1>Panel de Jefe de Carrera</h1>
            <a href="logout.php"><i class="fas fa-sign-out-alt"></i>Cerrar Sesion</a>
        </div>
    </nav>
    <div class="content">
        <h2>Inicio | Panel de Administrativo</h2>
        <p style="background-color: #607eff;">Bienvenido de nuevo, <?= $_SESSION['nombre'] ?>!</p>
        <p>VER LISTA DE ALUMNOS, <a class="btn btn-primary" href="aprobaciones.php">CLICK AQUI </a></p>
        <p>VER LISTA DE SOLICITUDES DE DOCUMENTOS, <a class="btn btn-primary" href="lista_solicitudes.php">CLICK AQUI </a></p>
        <p>VER LISTA DE DOCUMENTOS ENVIADOS, <a class="btn btn-primary" href="archivos.php">CLICK AQUI </a></p>
    </div>
</body>

</html>