<?php
define('DB_HOST', 'localhost');
define('DB_USUARIO', 'root');
define('DB_PASSSWORD', 'titospass');
define('DB_NOMBRE', 'Kardex');

// Ruta al archivo de certificado SSL
define('DB_SSL_CERT', '../DigiCertGlobalRootG2.crt.pem');

$con = mysqli_init();

// Establecer opciones de conexión SSL
mysqli_ssl_set($con, NULL, NULL, DB_SSL_CERT, NULL, NULL);

// Realizar la conexión utilizando SSL
$con->real_connect(DB_HOST, DB_USUARIO, DB_PASSSWORD, DB_NOMBRE, 3306, NULL, MYSQLI_CLIENT_SSL);

// Verificar la conexión
if ($con->connect_errno) {
    echo "Ha ocurrido un fallo al conectar con MySQL: " . $con->connect_error;
}
