-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 28-12-2023 a las 12:07:27
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `partes`
--

CREATE DATABASE IF NOT EXISTS `partes` DEFAULT CHARACTER SET utf8 COLLATE utf8_spanish_ci;
USE `partes`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alumnos`
--

DROP TABLE IF EXISTS `alumnos`;
CREATE TABLE `alumnos` (
  `dni_a` varchar(9) NOT NULL,
  `nombre` varchar(40) NOT NULL,
  `apellidos` varchar(40) NOT NULL,
  `direccion` varchar(40) NOT NULL,
  `telf` int(11) NOT NULL,
  `id_curso` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `alumnos`
--

INSERT INTO `alumnos` (`dni_a`, `nombre`, `apellidos`, `direccion`, `telf`, `id_curso`) VALUES
('11111111a', 'Pepe', 'López', 'C/ Centro, 3', 111111111, 1),
('22222222b', 'María', 'Carpio', 'C/ Este, 6', 222222222, 2),
('33333333c', 'Antonio', 'Camargo', 'C/ Sur, 2', 333333333, 1),
('44444444d', 'Rosa', 'Santiago', 'C/ Oeste, 4', 444444444, 1),
('55555555e', 'Cristian', 'Millán', 'C/ Centro, 10', 555555555, 2),
('66666666f', 'Paqui', 'Rodríguez', 'C/ Sur, 25', 666666666, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `curso`
--

DROP TABLE IF EXISTS `curso`;
CREATE TABLE `curso` (
  `id_curso` int(11) NOT NULL,
  `descripcion` varchar(30) NOT NULL,
  `totalpartes` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `curso`
--

INSERT INTO `curso` (`id_curso`, `descripcion`, `totalpartes`) VALUES
(1, '1ºESO', 3),
(2, '2ªESO', 0),
(3, '3ºESO', 0),
(4, '4ºESO', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `partes`
--

DROP TABLE IF EXISTS `partes`;
CREATE TABLE `partes` (
  `id` int(11) NOT NULL,
  `dni_p` varchar(9) NOT NULL,
  `dni_a` varchar(9) NOT NULL,
  `motivo` varchar(100) NOT NULL,
  `time` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `partes`
--

INSERT INTO `partes` (`id`, `dni_p`, `dni_a`, `motivo`, `time`) VALUES
(12, '12345678A', '33333333c', 'El alumno no trae el material a clase', 1703761520),
(13, '87654321B', '33333333c', 'El alumno insulta a otro compañero', 1703761540),
(14, '12345678A', '33333333c', 'El alumno falta al respeto al profesor.', 1703761574);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `profesores`
--

DROP TABLE IF EXISTS `profesores`;
CREATE TABLE `profesores` (
  `dni_p` varchar(9) NOT NULL,
  `nombre` varchar(30) NOT NULL,
  `apellidos` varchar(40) NOT NULL,
  `pass` varchar(128) NOT NULL,
  `bloqueado` tinyint(1) NOT NULL,
  `hora_bloqueo` bigint(20) NOT NULL,
  `intentos` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `profesores`
--

INSERT INTO `profesores` (`dni_p`, `nombre`, `apellidos`, `pass`, `bloqueado`, `hora_bloqueo`, `intentos`) VALUES
('12345678A', 'Antonio', 'de la Rosa', 'bcc67d8524948bbd873e4df12c89b182', 0, 0, 0),
('87654321B', 'Alejandro', 'Paniego', '8985fbc49b427e2902bbf03ae4ccac8d', 0, 0, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `prof_curso`
--

DROP TABLE IF EXISTS `prof_curso`;
CREATE TABLE `prof_curso` (
  `dni_p` varchar(9) NOT NULL,
  `id_curso` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `prof_curso`
--

INSERT INTO `prof_curso` (`dni_p`, `id_curso`) VALUES
('12345678A', 1),
('12345678A', 2),
('12345678A', 3),
('12345678A', 4),
('87654321B', 1),
('87654321B', 2);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `alumnos`
--
ALTER TABLE `alumnos`
  ADD PRIMARY KEY (`dni_a`),
  ADD KEY `alumnos_ibfk_1` (`id_curso`);

--
-- Indices de la tabla `curso`
--
ALTER TABLE `curso`
  ADD PRIMARY KEY (`id_curso`);

--
-- Indices de la tabla `partes`
--
ALTER TABLE `partes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `dni_p` (`dni_p`),
  ADD KEY `partes_ibfk_2` (`dni_a`);

--
-- Indices de la tabla `profesores`
--
ALTER TABLE `profesores`
  ADD PRIMARY KEY (`dni_p`);

--
-- Indices de la tabla `prof_curso`
--
ALTER TABLE `prof_curso`
  ADD KEY `prof_curso_ibfk_1` (`dni_p`),
  ADD KEY `id_curso` (`id_curso`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `partes`
--
ALTER TABLE `partes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `alumnos`
--
ALTER TABLE `alumnos`
  ADD CONSTRAINT `alumnos_ibfk_1` FOREIGN KEY (`id_curso`) REFERENCES `curso` (`id_curso`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `partes`
--
ALTER TABLE `partes`
  ADD CONSTRAINT `partes_ibfk_1` FOREIGN KEY (`dni_p`) REFERENCES `profesores` (`dni_p`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `partes_ibfk_2` FOREIGN KEY (`dni_a`) REFERENCES `alumnos` (`dni_a`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `prof_curso`
--
ALTER TABLE `prof_curso`
  ADD CONSTRAINT `prof_curso_ibfk_1` FOREIGN KEY (`dni_p`) REFERENCES `profesores` (`dni_p`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `prof_curso_ibfk_2` FOREIGN KEY (`id_curso`) REFERENCES `curso` (`id_curso`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
