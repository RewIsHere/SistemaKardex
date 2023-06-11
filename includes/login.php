<?php
require_once '../services/ConexionBD.php';

// VERIFICA QUE LOS CAMPOS DEL FORMULARIO HAYAN SIDO LLENADOS , EN CASO DE QUE NO SALDRA UN MENSAJE DE ERROR
if (!isset($_POST['num_control'], $_POST['contrasena'])) {
        echo 'alert("Por favor llena ambos campos")';
}
//INICIA EL PROCESO DE SESION
session_start();

// PREPARA EL QUERY QUE SE ENCARGARA DE COMPROBAR QUE EN LA TABLA DE "ALUMNO" EXISTA EL CORREO INTRODUCIDO EN EL FORMULARIO
if ($stmt = $con->prepare('SELECT num_control, nombre, contrasena FROM alumno WHERE num_control = ?')) {
        // REMPLAZA EL SIMBOLO = ? EN EL QUERY DEL IF , ES DECIR WHERE num_control = ?, donde ? = NUMERO DE CONTROL DEL ALUMNO
        $stmt->bind_param('s', $_POST['num_control']);
        $stmt->execute();
        // ALMACENA EL RESULTADO EN CASO DE QUE LA CUENTA EXISTA EN LA BASE DE DATOS
        $stmt->store_result();

        // SE ENCARGA DE COMPROBAR QUE EL QUERY INICIAL (EL DEL PRIMER IF) SEA MAYOR A 1 , EN CASO DE SERLO LA CUENTA EXISTE
        if ($stmt->num_rows > 0) {
                //ESTE METODO GUARDA EN VARIABLES LOS DATOS DE LAS COLUMNAS DE LA TABLA A LA CUAL HEMOS CONSULTADO EN ESTE CASO LA TABLA DOCENTE
                $stmt->bind_result($no_control, $nombre, $contra);
                $stmt->fetch();
                //LA CUENTA EXISTE, AHORA COMPROBAMOS SI LA CONTRASEÑA ES CORRECTA
                if ($_POST['contrasena'] === $contra) {
                        // LA VERIFICACION HA SIDO CORRECTA, EL USUARIO HA INICIADO SESION CORRECTAMENTE

                        /* ESTO BASICAMENTE CREA SESIONES, ESTE METODO SABE CUANDO UN USUARIO SE HA LOGEADO, Y LO GUARDA EN FORMA DE COOKIES, 
                        EL SERVIDOR SE ENCARGA DE RECORDAR EL INICIO DE SESION POR LO CUAL NO ES NECESARIO VOLVER A INICIAR SESION DURANTE CIERTO TIEMPO*/
                        session_regenerate_id();
                        $_SESSION['SesionIniciada'] = TRUE;
                        $_SESSION['nombre'] = $nombre;
                        $_SESSION['no_control'] = $no_control;
                        //REDIRECCIONA A LA PAGINA DE INICIO
                        echo "success";
                } else {
                        // CONTRASEÑA INCORRECTA
                        echo "error-password";
                }
        } else {
                // EL USUARIO NO EXISTE
                echo "error-user";
        }

        // CIERRA LA CONEXION CON LA BASE DE DATOS 
        $stmt->close();
}
