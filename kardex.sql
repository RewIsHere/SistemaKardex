-- --------------------------------------------------------
--
-- Estructura de tabla para la tabla `alumno`
--
-- --------------------------------------------------------

CREATE TABLE `alumno` (
  `num_control` varchar(15) PRIMARY KEY NOT NULL,
  `nombre` varchar(40) NOT NULL,
  `apellido_pat` varchar(40) NOT NULL,
  `apellido_mat` varchar(40) NOT NULL,
  `foto` varchar(60) NOT NULL,
  `semestre_cursado` int(11) NOT NULL,
  `especialidad` varchar(40) NOT NULL,
  `correo` varchar(60) NOT NULL,
  `contraseña` varchar(20) NOT NULL,
  `aprobado` int(1) NOT NULL 
);


-- --------------------------------------------------------
--
-- Estructura de tabla para la tabla `jefe de carrera`
--
-- --------------------------------------------------------
CREATE TABLE `JefeCarrera` (
  `Id_jefe` int(11) PRIMARY KEY AUTO_INCREMENT NOT NULL,
  `nombre` varchar(40) NOT NULL,
  `apellido_pat` varchar(40) NOT NULL,
  `apellido_mat` varchar(40) NOT NULL,
  `tel` int(11) NOT NULL,
  `correo` varchar(60) NOT NULL UNIQUE,
  `contraseña` varchar(20) NOT NULL
);

-- --------------------------------------------------------
--
-- Estructura de tabla para la tabla `docs_alumno`
--
-- --------------------------------------------------------

CREATE TABLE `Solicitudes_alumno` (
  `Id_soli_a` int(11) PRIMARY KEY AUTO_INCREMENT NOT NULL,
  `Tipo_documento` varchar(200),
  `Url_documento` varchar(200),
  `Id_alumno` varchar(15) NOT NULL UNIQUE,
  FOREIGN KEY (`Id_alumno`)
  REFERENCES `alumno`(`num_control`) 
);

CREATE TABLE `docs_alumno` (
  `Id_docs_a` int(11) PRIMARY KEY AUTO_INCREMENT NOT NULL,
  `Creditos` varchar(200),
  `Justificantes` varchar(200),
  `Altas_y_Bajas` varchar(200),
  `Id_alumno` varchar(15) NOT NULL UNIQUE,
  FOREIGN KEY (`Id_alumno`)
  REFERENCES `alumno`(`num_control`) 
);

-- PROCEDIMIENTO ALMACENADO PARA REGISTRAR A ALUMNOS
DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `registar_alumno`(
num_control varchar(15),
nombre varchar(40),
apellido_pat varchar(40),
apellido_mat varchar(40),
foto varchar(60),
semestre_cursado int(11),
especialidad varchar(40),
correo varchar(60),
contraseña varchar(20),
aprobado int(1)
)
BEGIN
insert into `alumno`(`num_control`, `nombre`, `apellido_pat`, `apellido_mat`, `foto`, `semestre_cursado`, `especialidad`, `correo`, `contraseña`, `aprobado`) value(num_control, nombre, apellido_pat, apellido_mat, foto, semestre_cursado, especialidad, correo, contraseña, aprobado);
END$$
DELIMITER ;

-- PROCEDIMIENTO ALMACENADO PARA VERIFICAR SI LA CUENTA DEL ALUMNO EXISTE
DELIMITER $
CREATE DEFINER=`root`@`localhost` PROCEDURE `verificarCuenta`(IN `nocontrol` VARCHAR(255))
    NO SQL
SELECT num_control FROM alumno  WHERE num_control=nocontrol$
DELIMITER ;

-- PROCEDIMIENTO ALMACENADO PARA VERIFICAR SI LA CUENTA DEL JEFE DE CARRERA EXISTE
DELIMITER $
CREATE DEFINER=`root`@`localhost` PROCEDURE `verificarCuentaJefe`(IN `email` VARCHAR(255))
    NO SQL
SELECT correo FROM JefeCarrera  WHERE correo=email$
DELIMITER ;