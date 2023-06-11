<?php
require_once 'services/ConexionBD.php';

session_start();
// PREGUNTA SI YA HEMOS INICIADO SESION EN CASO DE QUE NO, NOS REDIRECCIONA AL INICIO
$uname = $_SESSION['correo'];

if (isset($_SESSION['SesionIniciada'])) {
    if ($stmt = $con->prepare('SELECT * FROM JefeCarrera WHERE correo = ?')) {
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
    <link rel="stylesheet" href="css/register-styles.css">
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
                    <a href="registro.php" class="active">REGISTRO</a>
                </li>
                <li>
                    <a href="login.php">INICIAR SESION</a>
                </li>
            </ul>
        </div>
    </header>
    <form id="formRegistro" class="form-register" method="post">
        <h1>REGISTRO</h1>
        <div CLASS="contenedor">
            <nav class="switch-cuenta">
                <a href="#">ALUMNO</a>
            </nav>
            <div class="input-contenedor">
                <i class="fa-solid fa-person icon"></i>
                <input type="text" name="nombre" placeholder="Nombre" id="nombre" required>
            </div>

            <div class="input-contenedor">
                <i class="fa-solid fa-person icon"></i>
                <input type="text" name="apellido_pat" placeholder="Apellido Paterno" id="apellido_pat" required>
            </div>

            <div class="input-contenedor">
                <i class="fa-solid fa-person icon"></i>
                <input type="text" name="apellido_mat" placeholder="Apellido Materno" id="apellido_mat" required>
            </div>

            <div class="input-contenedor">
                <i class="fa-solid fa-gamepad icon"></i>
                <input type="text" name="num_control" placeholder="Numero de control" id="num_control" required>
            </div>

            <div class="input-contenedor">
                <i class="fa-solid fa-id-card icon"></i>
                <label for="archivo" class="label-file">Foto de alumno</label>
                <input type="file" name="archivo" id="archivo" class="input-file" required />
            </div>

            <div class="input-contenedor">
                <i class="fa-solid fa-envelope icon"></i>
                <input type="email" name="correo" placeholder="Correo Institucional" id="correo" required>
            </div>
            <div class="input-contenedor">
                <i class="fa-solid fa-gamepad icon"></i>
                <input type="password" name="contrasena" placeholder="Contraseña" id="contrasena" required>
            </div>

            <div class="input-contenedor" style="
    color: #000;
    margin-top: 30px;
    margin-bottom: 30px;
    padding-left: 54px;
">

                <label class="pb-2">Especialidad</label>
                <select class="form-control" name="especialidad" id="especialidad">
                    <option value="NA">No Aplica</option>
                    <option value="Software">Ingeneria de Software</option>
                    <option value="Redes">Redes y Seguridad Informatica</option>
                    <option value="Base">Base de Datos</option>

                </select>
            </div>


            <div class="input-contenedor">
                <i class="fa-solid fa-hashtag icon"></i>
                <input type="number" name="semestre_cursado" placeholder="Semestre Cursado" id="semestre_cursado" required>
            </div>

            <input type="submit" name="REGISTRO" value="Registrar" class="button">
            <br><br>
            <input type="reset" name="LIMPIAR" value="Limpiar" class="bot_reset">

            <p class> ¿YA TIENES UNA CUENTA? <a class="link" href="login.php">Iniciar Sesion</a></p>
        </div>
    </form>
</body>

</html>
<script src="js/registro.js"></script>