-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 29-11-2021 a las 00:41:43
-- Versión del servidor: 5.7.33
-- Versión de PHP: 7.4.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `dbescuela`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alumnos`
--

DROP TABLE IF EXISTS `alumnos`;
CREATE TABLE `alumnos` (
  `matricula` varchar(100) NOT NULL,
  `nombre` varchar(250) DEFAULT NULL,
  `genero` varchar(100) DEFAULT NULL,
  `edad` int(3) DEFAULT NULL,
  `semestre` int(3) DEFAULT NULL,
  `cursos_clave` varchar(100) NOT NULL,
  `trabajos_clave` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `alumnos`
--

INSERT INTO `alumnos` (`matricula`, `nombre`, `genero`, `edad`, `semestre`, `cursos_clave`, `trabajos_clave`) VALUES
('152707', 'Jose', 'Hombre', 18, 6, '10', '123a'),
('152708', 'Juan', 'Hombre', 19, 7, '11', '145b');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alumnos_materias`
--

DROP TABLE IF EXISTS `alumnos_materias`;
CREATE TABLE `alumnos_materias` (
  `idalumnos_materias` int(11) NOT NULL,
  `alumnos_matricula` varchar(100) NOT NULL,
  `materias_clave` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `alumnos_materias`
--

INSERT INTO `alumnos_materias` (`idalumnos_materias`, `alumnos_matricula`, `materias_clave`) VALUES
(5, '152707', '1527');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cursos`
--

DROP TABLE IF EXISTS `cursos`;
CREATE TABLE `cursos` (
  `clave` varchar(100) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `duracion` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `cursos`
--

INSERT INTO `cursos` (`clave`, `nombre`, `duracion`) VALUES
('10', 'Curso1', '1 semana'),
('11', 'Curso2', '5 dias');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `materias`
--

DROP TABLE IF EXISTS `materias`;
CREATE TABLE `materias` (
  `clave` varchar(100) NOT NULL,
  `nombre` varchar(250) DEFAULT NULL,
  `creditos` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `materias`
--

INSERT INTO `materias` (`clave`, `nombre`, `creditos`) VALUES
('1527', 'Materia 1', 40),
('1528', 'MAteria 2', 50);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `profesores`
--

DROP TABLE IF EXISTS `profesores`;
CREATE TABLE `profesores` (
  `clave` varchar(100) NOT NULL,
  `nombre` varchar(250) DEFAULT NULL,
  `direccion` text,
  `hora` varchar(250) DEFAULT NULL,
  `telefono` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `profesores`
--

INSERT INTO `profesores` (`clave`, `nombre`, `direccion`, `hora`, `telefono`) VALUES
('1578', 'Pedro', 'col. Centro', '8:00 am a 8:00 pm', '9611555500');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `profesores_alumnos`
--

DROP TABLE IF EXISTS `profesores_alumnos`;
CREATE TABLE `profesores_alumnos` (
  `idprofesores_alumnos` int(11) NOT NULL,
  `profesores_clave` varchar(100) NOT NULL,
  `alumnos_matricula` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `profesores_alumnos`
--

INSERT INTO `profesores_alumnos` (`idprofesores_alumnos`, `profesores_clave`, `alumnos_matricula`) VALUES
(10, '1578', '152707');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `profesores_materias`
--

DROP TABLE IF EXISTS `profesores_materias`;
CREATE TABLE `profesores_materias` (
  `idprofesores_materias` int(11) NOT NULL,
  `profesores_clave` varchar(100) NOT NULL,
  `materias_clave` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `profesores_materias`
--

INSERT INTO `profesores_materias` (`idprofesores_materias`, `profesores_clave`, `materias_clave`) VALUES
(45, '1578', '1527');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `trabajos`
--

DROP TABLE IF EXISTS `trabajos`;
CREATE TABLE `trabajos` (
  `clave` varchar(100) NOT NULL,
  `nombre` varchar(250) DEFAULT NULL,
  `horario` varchar(250) DEFAULT NULL,
  `dias` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `trabajos`
--

INSERT INTO `trabajos` (`clave`, `nombre`, `horario`, `dias`) VALUES
('123a', 'Trabajo 1', '8:00 am a 5:00 pm', '15'),
('145b', 'Trabajo 2', '8:00 am a 5:00 pm', '10');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `alumnos`
--
ALTER TABLE `alumnos`
  ADD PRIMARY KEY (`matricula`,`cursos_clave`,`trabajos_clave`),
  ADD UNIQUE KEY `matricula_UNIQUE` (`matricula`),
  ADD KEY `fk_alumnos_cursos_idx` (`cursos_clave`),
  ADD KEY `fk_alumnos_trabajo1_idx` (`trabajos_clave`);

--
-- Indices de la tabla `alumnos_materias`
--
ALTER TABLE `alumnos_materias`
  ADD PRIMARY KEY (`idalumnos_materias`,`alumnos_matricula`,`materias_clave`),
  ADD KEY `fk_materias_has_alumnos_alumnos1_idx` (`alumnos_matricula`),
  ADD KEY `fk_materias_has_alumnos_materias1_idx` (`materias_clave`);

--
-- Indices de la tabla `cursos`
--
ALTER TABLE `cursos`
  ADD PRIMARY KEY (`clave`),
  ADD UNIQUE KEY `clave_UNIQUE` (`clave`);

--
-- Indices de la tabla `materias`
--
ALTER TABLE `materias`
  ADD PRIMARY KEY (`clave`),
  ADD UNIQUE KEY `clave_UNIQUE` (`clave`);

--
-- Indices de la tabla `profesores`
--
ALTER TABLE `profesores`
  ADD PRIMARY KEY (`clave`),
  ADD UNIQUE KEY `clave_UNIQUE` (`clave`);

--
-- Indices de la tabla `profesores_alumnos`
--
ALTER TABLE `profesores_alumnos`
  ADD PRIMARY KEY (`idprofesores_alumnos`,`profesores_clave`,`alumnos_matricula`),
  ADD KEY `fk_alumnos_has_profesores_profesores1_idx` (`profesores_clave`),
  ADD KEY `fk_alumnos_has_profesores_alumnos1_idx` (`alumnos_matricula`);

--
-- Indices de la tabla `profesores_materias`
--
ALTER TABLE `profesores_materias`
  ADD PRIMARY KEY (`idprofesores_materias`,`profesores_clave`,`materias_clave`),
  ADD KEY `fk_materias_has_profesores_profesores1_idx` (`profesores_clave`),
  ADD KEY `fk_materias_has_profesores_materias1_idx` (`materias_clave`);

--
-- Indices de la tabla `trabajos`
--
ALTER TABLE `trabajos`
  ADD PRIMARY KEY (`clave`),
  ADD UNIQUE KEY `clave_UNIQUE` (`clave`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `alumnos_materias`
--
ALTER TABLE `alumnos_materias`
  MODIFY `idalumnos_materias` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `profesores_alumnos`
--
ALTER TABLE `profesores_alumnos`
  MODIFY `idprofesores_alumnos` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `profesores_materias`
--
ALTER TABLE `profesores_materias`
  MODIFY `idprofesores_materias` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `alumnos`
--
ALTER TABLE `alumnos`
  ADD CONSTRAINT `fk_alumnos_cursos` FOREIGN KEY (`cursos_clave`) REFERENCES `cursos` (`clave`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_alumnos_trabajo1` FOREIGN KEY (`trabajos_clave`) REFERENCES `trabajos` (`clave`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `alumnos_materias`
--
ALTER TABLE `alumnos_materias`
  ADD CONSTRAINT `fk_materias_has_alumnos_alumnos1` FOREIGN KEY (`alumnos_matricula`) REFERENCES `alumnos` (`matricula`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_materias_has_alumnos_materias1` FOREIGN KEY (`materias_clave`) REFERENCES `materias` (`clave`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `profesores_alumnos`
--
ALTER TABLE `profesores_alumnos`
  ADD CONSTRAINT `fk_alumnos_has_profesores_alumnos1` FOREIGN KEY (`alumnos_matricula`) REFERENCES `alumnos` (`matricula`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_alumnos_has_profesores_profesores1` FOREIGN KEY (`profesores_clave`) REFERENCES `profesores` (`clave`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `profesores_materias`
--
ALTER TABLE `profesores_materias`
  ADD CONSTRAINT `fk_materias_has_profesores_materias1` FOREIGN KEY (`materias_clave`) REFERENCES `materias` (`clave`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_materias_has_profesores_profesores1` FOREIGN KEY (`profesores_clave`) REFERENCES `profesores` (`clave`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
