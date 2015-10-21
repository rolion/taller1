-- phpMyAdmin SQL Dump
-- version 4.4.3
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 15, 2015 at 10:30 
-- Server version: 5.6.24
-- PHP Version: 5.6.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `examenpsicotecnico`
--

-- --------------------------------------------------------

--
-- Table structure for table `area`
--

CREATE TABLE IF NOT EXISTS `area` (
  `id` int(11) NOT NULL,
  `nombre` text,
  `eliminado` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `area`
--


-- --------------------------------------------------------

--
-- Table structure for table `baremo`
--

CREATE TABLE IF NOT EXISTS `baremo` (
  `id` int(11) NOT NULL,
  `puntiacion_directa` int(11) DEFAULT NULL,
  `percentil` int(11) DEFAULT NULL,
  `id_area` int(11) DEFAULT NULL,
  `eliminado` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `baremo`
--



-- --------------------------------------------------------

--
-- Table structure for table `colegio`
--

CREATE TABLE IF NOT EXISTS `colegio` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `telefono` varchar(10) DEFAULT NULL,
  `eliminado` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
INSERT INTO `colegio` (`id`, `nombre`, `direccion`,`telefono`, `eliminado`) VALUES
(1, 'Isabel Saavedra', '2do anillo y san aurelio', '79812', 0);
--
-- Dumping data for table `colegio`
--



-- --------------------------------------------------------

--
-- Table structure for table `examen`
--

CREATE TABLE IF NOT EXISTS `examen` (
  `id` int(11) NOT NULL,
  `nombre` text,
  `autor` text,
  `fecha_publicacion` date DEFAULT NULL,
  `eliminado` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `examen`
--



-- --------------------------------------------------------

--
-- Table structure for table `inscripcion_examen`
--

CREATE TABLE IF NOT EXISTS `inscripcion_examen` (
  `id` int(11) NOT NULL,
  `id_alumno` int(11) DEFAULT NULL,
  `id_examen` int(11) DEFAULT NULL,
  `fecha_inscripcion` date DEFAULT NULL,
  `fecha_aplicacion` date DEFAULT NULL,
  `eliminado` tinyint(1) DEFAULT NULL,
  `costo` float(4,2) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `inscripcion_examen`
--


-- --------------------------------------------------------

--
-- Table structure for table `persona`
--

CREATE TABLE IF NOT EXISTS `persona` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `apellido` varchar(255) DEFAULT NULL,
  `telefono` varchar(10) DEFAULT NULL,
  `ci` int(11) DEFAULT NULL,
  `id_tipo` int(11) DEFAULT NULL,
  `id_colegio` int(11) DEFAULT NULL,
  `ciudad` varchar(50) DEFAULT NULL,
  `eliminado` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `persona`
--

INSERT INTO `persona` (`id`, `nombre`, `apellido`, `telefono`, `ci`, `id_tipo`, `id_colegio`, `ciudad`, `eliminado`) VALUES
(1, 'Oscar Rodrigo', 'Leon Mojica', '79812', 6349744, 1, 1, '0', 0),
(2, 'Fernando ', 'Pedriel', '987456', 123456, 1, 1, '0', 0);
-- --------------------------------------------------------

--
-- Table structure for table `pregunta`
--

CREATE TABLE IF NOT EXISTS `pregunta` (
  `id` int(11) NOT NULL,
  `descripcion_pregunta` text,
  `id_examen` int(11) DEFAULT NULL,
  `imagen` text,
  `id_area` int(11) DEFAULT NULL,
  `nro_pregunta` int(11) DEFAULT NULL,
  `eliminado` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pregunta`
--


-- --------------------------------------------------------

--
-- Table structure for table `respuesta_alumno`
--

CREATE TABLE IF NOT EXISTS `respuesta_alumno` (
  `id` int(11) NOT NULL,
  `id_respuesta` int(11) DEFAULT NULL,
  `id_alumno` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `respuesta_examen`
--

CREATE TABLE IF NOT EXISTS `respuesta_examen` (
  `id` int(11) NOT NULL,
  `descripcion_respuesta` text,
  `id_pregunta` int(11) DEFAULT NULL,
  `nombre_opcion` char(1) DEFAULT NULL,
  `imagen` text,
  `puntos_otorgados` int(11) DEFAULT NULL,
  `eliminado` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `respuesta_examen`
--



-- --------------------------------------------------------

--
-- Table structure for table `resultados_examen`
--

CREATE TABLE IF NOT EXISTS `resultados_examen` (
  `id` int(11) NOT NULL,
  `id_examen` int(11) DEFAULT NULL,
  `id_area` int(11) DEFAULT NULL,
  `nota` int(11) DEFAULT NULL,
  `id_alumno` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tipo_persona`
--

CREATE TABLE IF NOT EXISTS `tipo_persona` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `descripcion` text,
  `eliminado` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tipo_persona`
--

INSERT INTO `tipo_persona` (`id`, `nombre`, `descripcion`, `eliminado`) VALUES
(1, 'alumno', 'es un alumno', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `usuario`
--

CREATE TABLE IF NOT EXISTS `usuario` (
  `id` int(11) NOT NULL,
  `usuario` varchar(50) DEFAULT NULL,
  `contrasenha` varchar(8) DEFAULT NULL,
  `id_persona` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `usuario`
--

INSERT INTO `usuario` (`id`, `usuario`, `contrasenha`, `id_persona`) VALUES
(1, 'oscar', 'oscar', 1),
(2, 'fernando', 'fer', 2);;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `area`
--
ALTER TABLE `area`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `baremo`
--
ALTER TABLE `baremo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IXFK_baremo_area` (`id_area`);

--
-- Indexes for table `colegio`
--
ALTER TABLE `colegio`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `examen`
--
ALTER TABLE `examen`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inscripcion_examen`
--
ALTER TABLE `inscripcion_examen`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IXFK_inscripcion_examen_persona` (`id_alumno`),
  ADD KEY `IXFK_inscripcion_examen_examen` (`id_examen`);

--
-- Indexes for table `persona`
--
ALTER TABLE `persona`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IXFK_persona_tipo_persona` (`id_tipo`),
  ADD KEY `IXFK_persona_colegio` (`id_colegio`);

--
-- Indexes for table `pregunta`
--
ALTER TABLE `pregunta`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IXFK_pregunta_examen` (`id_examen`),
  ADD KEY `IXFK_pregunta_area` (`id_area`);

--
-- Indexes for table `respuesta_alumno`
--
ALTER TABLE `respuesta_alumno`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IXFK_respuesta_alumno_persona` (`id_alumno`),
  ADD KEY `IXFK_respuesta_alumno_respuesta_examen` (`id_respuesta`);

--
-- Indexes for table `respuesta_examen`
--
ALTER TABLE `respuesta_examen`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IXFK_respuesta_examen_pregunta` (`id_pregunta`);

--
-- Indexes for table `resultados_examen`
--
ALTER TABLE `resultados_examen`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IXFK_resultados_examen_persona` (`id_alumno`),
  ADD KEY `IXFK_resultados_examen_area` (`id_area`);

--
-- Indexes for table `tipo_persona`
--
ALTER TABLE `tipo_persona`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IXFK_usuario_persona` (`id_persona`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `area`
--
ALTER TABLE `area`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `baremo`
--
ALTER TABLE `baremo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `colegio`
--
ALTER TABLE `colegio`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `examen`
--
ALTER TABLE `examen`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `inscripcion_examen`
--
ALTER TABLE `inscripcion_examen`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT for table `persona`
--
ALTER TABLE `persona`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `pregunta`
--
ALTER TABLE `pregunta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=30;
--
-- AUTO_INCREMENT for table `respuesta_alumno`
--
ALTER TABLE `respuesta_alumno`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `respuesta_examen`
--
ALTER TABLE `respuesta_examen`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=25;
--
-- AUTO_INCREMENT for table `resultados_examen`
--
ALTER TABLE `resultados_examen`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tipo_persona`
--
ALTER TABLE `tipo_persona`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `baremo`
--
ALTER TABLE `baremo`
  ADD CONSTRAINT `FK_baremo_area` FOREIGN KEY (`id_area`) REFERENCES `area` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Constraints for table `inscripcion_examen`
--
ALTER TABLE `inscripcion_examen`
  ADD CONSTRAINT `FK_inscripcion_examen_examen` FOREIGN KEY (`id_examen`) REFERENCES `examen` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_inscripcion_examen_persona` FOREIGN KEY (`id_alumno`) REFERENCES `persona` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Constraints for table `persona`
--
ALTER TABLE `persona`
  ADD CONSTRAINT `FK_persona_colegio` FOREIGN KEY (`id_colegio`) REFERENCES `colegio` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_persona_tipo_persona` FOREIGN KEY (`id_tipo`) REFERENCES `tipo_persona` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Constraints for table `pregunta`
--
ALTER TABLE `pregunta`
  ADD CONSTRAINT `FK_pregunta_area` FOREIGN KEY (`id_area`) REFERENCES `area` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_pregunta_examen` FOREIGN KEY (`id_examen`) REFERENCES `examen` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Constraints for table `respuesta_alumno`
--
ALTER TABLE `respuesta_alumno`
  ADD CONSTRAINT `FK_respuesta_alumno_persona` FOREIGN KEY (`id_alumno`) REFERENCES `persona` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_respuesta_alumno_respuesta_examen` FOREIGN KEY (`id_respuesta`) REFERENCES `respuesta_examen` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Constraints for table `respuesta_examen`
--
ALTER TABLE `respuesta_examen`
  ADD CONSTRAINT `FK_respuesta_examen_pregunta` FOREIGN KEY (`id_pregunta`) REFERENCES `pregunta` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Constraints for table `resultados_examen`
--
ALTER TABLE `resultados_examen`
  ADD CONSTRAINT `FK_resultados_examen_area` FOREIGN KEY (`id_area`) REFERENCES `area` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_resultados_examen_persona` FOREIGN KEY (`id_alumno`) REFERENCES `persona` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Constraints for table `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `FK_usuario_persona` FOREIGN KEY (`id_persona`) REFERENCES `persona` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
