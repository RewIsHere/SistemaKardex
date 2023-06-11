<?php
require_once 'services/ConexionBD.php';

session_start();
$uname = $_SESSION['correo'];

if (isset($_SESSION['SesionIniciada'])) {
    if ($stmt = $con->prepare('SELECT * FROM docente WHERE correo = ?')) {
        $stmt->bind_param('s', $uname);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows == 0) {
            header('Location: inicio.php');
        } else {
            header('Location: inicio-d.php');
        }

        // CIERRA LA CONEXION CON LA BASE DE DATOS 
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta>
    <script src="https://kit.fontawesome.com/ba719609d3.js" crossorigin="anonymous"></script>
    <title>SISTEMA KARDEX</title>
    <link rel="stylesheet" href="css/login-styles.css">
    <link rel="shortcut icon" href="assets/LOGO_ITSPR.jpg" type="image/x-icon">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>

</head>

<body>
    <header>
        <div class="tira-header">
            <img class="tira-header__img" src="assets/Tira_logo.jpg">
        </div>
        <div id="nav-sup" class="navegacion">
            <ul class="navegacion__navegacion-list navegacion__menu">
                <li>
                    <a href="index.php">INICIO</a>
                </li>
                <li>
                    <a href="registro.php">REGISTRO</a>
                </li>
                <li>
                    <a href="login.php" class="active">INICIAR SESION</a>
                </li>
            </ul>
        </div>
    </header>
    <form id="formLogin" class="form-login" method="post">
        <h1>INICIA SESION</h1>
        <div class="contenedor1">
            <nav class="switch-cuenta">
                <a href="login.php">ALUMNO</a>
                <a href="#">JEFE DE CARRERA</a>
            </nav>
            <div class="input-contenedor1">
                <i class="fa-solid fa-person icon"></i>
                <input type="text" name="correo" placeholder="CORREO INSTITUCIONAL" required>
            </div>

            <div class="input-contenedor1">
                <i class="fa-solid fa-person icon"></i>
                <input type="password" name="contrasena" placeholder="CONTRASEÑA" required>
            </div>

            <input type="submit" value="Logear">
        </div>
    </form>
</body>

</html>
<script src="js/login-d.js"></script>