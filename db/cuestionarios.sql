-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 11-07-2020 a las 07:19:37
-- Versión del servidor: 10.4.10-MariaDB
-- Versión de PHP: 7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `cuestionarios`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cuestionarios`
--

DROP TABLE IF EXISTS `cuestionarios`;
CREATE TABLE IF NOT EXISTS `cuestionarios` (
  `id_cues` int(8) NOT NULL AUTO_INCREMENT,
  `mat_user1` int(5) NOT NULL,
  `nom_cues` varchar(100) NOT NULL,
  PRIMARY KEY (`id_cues`),
  KEY `mat_user1_fk` (`mat_user1`)
) ENGINE=InnoDB AUTO_INCREMENT=89 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `preguntas`
--

DROP TABLE IF EXISTS `preguntas`;
CREATE TABLE IF NOT EXISTS `preguntas` (
  `id_pre` int(10) NOT NULL AUTO_INCREMENT,
  `id_cues1` int(8) NOT NULL,
  `id_sel1` int(1) NOT NULL,
  `pre_pre` varchar(140) NOT NULL,
  PRIMARY KEY (`id_pre`),
  KEY `id_sel1_fk` (`id_sel1`),
  KEY `id_cues1_fk` (`id_cues1`)
) ENGINE=InnoDB AUTO_INCREMENT=145 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `respuestas`
--

DROP TABLE IF EXISTS `respuestas`;
CREATE TABLE IF NOT EXISTS `respuestas` (
  `id_res` int(11) NOT NULL AUTO_INCREMENT,
  `id_pre1` int(10) NOT NULL,
  `res_res` varchar(140) NOT NULL,
  `cont_res` int(7) NOT NULL,
  PRIMARY KEY (`id_res`),
  KEY `id_pre1_fk` (`id_pre1`)
) ENGINE=InnoDB AUTO_INCREMENT=505 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `seleccion`
--

DROP TABLE IF EXISTS `seleccion`;
CREATE TABLE IF NOT EXISTS `seleccion` (
  `id_sel` int(1) NOT NULL,
  `selec_sel` varchar(9) NOT NULL,
  PRIMARY KEY (`id_sel`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `seleccion`
--

INSERT INTO `seleccion` (`id_sel`, `selec_sel`) VALUES
(1, 'Simple'),
(2, 'Multiple');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE IF NOT EXISTS `usuarios` (
  `mat_user` int(5) NOT NULL,
  `user_user` varchar(20) NOT NULL,
  `pass_user` varchar(80) NOT NULL,
  `mail_user` varchar(50) NOT NULL,
  PRIMARY KEY (`mat_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `cuestionarios`
--
ALTER TABLE `cuestionarios`
  ADD CONSTRAINT `mat_user1_fk` FOREIGN KEY (`mat_user1`) REFERENCES `usuarios` (`mat_user`);

--
-- Filtros para la tabla `preguntas`
--
ALTER TABLE `preguntas`
  ADD CONSTRAINT `id_cues1_fk` FOREIGN KEY (`id_cues1`) REFERENCES `cuestionarios` (`id_cues`) ON DELETE CASCADE,
  ADD CONSTRAINT `id_sel1_fk` FOREIGN KEY (`id_sel1`) REFERENCES `seleccion` (`id_sel`);

--
-- Filtros para la tabla `respuestas`
--
ALTER TABLE `respuestas`
  ADD CONSTRAINT `id_pre1_fk` FOREIGN KEY (`id_pre1`) REFERENCES `preguntas` (`id_pre`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
