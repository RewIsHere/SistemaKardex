<?php
// DESTRUYE O CIERRA LA SESION
session_start();
session_destroy();
// REDIRECCIONA A LA PAGINA INDEX
header('Location: index.php');
