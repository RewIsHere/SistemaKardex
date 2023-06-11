<?php
define('DB_HOST', 'sql9.freemysqlhosting.net');
define('DB_USUARIO', 'sql9624972');
define('DB_PASSSWORD', 'ljsn9hpFG3');
define('DB_NOMBRE', 'sql9624972');
$con = mysqli_connect(DB_HOST, DB_USUARIO, DB_PASSSWORD, DB_NOMBRE);
// Check connection
if (mysqli_connect_errno()) {
    echo "Ha ocurrido un fallo al conectar con MySQL: " . mysqli_connect_error();
}