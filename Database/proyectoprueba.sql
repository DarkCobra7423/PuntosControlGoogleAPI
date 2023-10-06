-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 05-10-2023 a las 20:59:12
-- Versión del servidor: 5.7.40-log
-- Versión de PHP: 8.1.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `proyectoprueba`
--
CREATE DATABASE proyectoprueba;

USE proyectoprueba;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `coordinate`
--

CREATE TABLE `coordinate` (
  `idCoordinate` int(11) NOT NULL,
  `latitude` varchar(100) DEFAULT NULL,
  `longitude` varchar(100) DEFAULT NULL,
  `time` timestamp NULL DEFAULT NULL,
  `token` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `coordinatedistance`
--

CREATE TABLE `coordinatedistance` (
  `fkCoordinate` int(11) NOT NULL,
  `fkDistance` int(11) NOT NULL,
  `points` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `distance`
--

CREATE TABLE `distance` (
  `idDistance` int(11) NOT NULL,
  `meters` varchar(100) DEFAULT NULL,
  `kilometers` varchar(100) DEFAULT NULL,
  `token` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `coordinate`
--
ALTER TABLE `coordinate`
  ADD PRIMARY KEY (`idCoordinate`);

--
-- Indices de la tabla `coordinatedistance`
--
ALTER TABLE `coordinatedistance`
  ADD PRIMARY KEY (`fkCoordinate`,`fkDistance`),
  ADD KEY `fk_Coordenada_has_Distancia_Distancia1_idx` (`fkDistance`),
  ADD KEY `fk_Coordenada_has_Distancia_Coordenada_idx` (`fkCoordinate`);

--
-- Indices de la tabla `distance`
--
ALTER TABLE `distance`
  ADD PRIMARY KEY (`idDistance`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `coordinate`
--
ALTER TABLE `coordinate`
  MODIFY `idCoordinate` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `distance`
--
ALTER TABLE `distance`
  MODIFY `idDistance` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
