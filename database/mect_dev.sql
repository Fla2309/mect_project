-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 23-01-2024 a las 01:56:47
-- Versión del servidor: 10.4.27-MariaDB
-- Versión de PHP: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `mect_dev`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clases`
--

CREATE TABLE `clases` (
  `id_clase` int(11) NOT NULL,
  `id_coach` int(11) DEFAULT NULL,
  `id_grupo` int(11) DEFAULT NULL,
  `fecha_inicio` varchar(45) DEFAULT NULL,
  `id_modulo` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `clases`
--

INSERT INTO `clases` (`id_clase`, `id_coach`, `id_grupo`, `fecha_inicio`, `id_modulo`) VALUES
(1, 1, 1, '12-21-2022', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `coaching`
--

CREATE TABLE `coaching` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `fecha_subida` date DEFAULT current_timestamp(),
  `adjunto` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `coaching`
--

INSERT INTO `coaching` (`id`, `id_usuario`, `fecha_subida`, `adjunto`) VALUES
(1, 1, '2022-08-29', 'Bitacora_de_coaching_mect_elisa_1.docx'),
(2, 1, '2022-11-08', 'Bitacora_de_coaching_mect_elisa_2.docx');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `coaching_usuarios`
--

CREATE TABLE `coaching_usuarios` (
  `id` int(11) NOT NULL,
  `nombre_coaching` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `nombre_coachee` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `lugar` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT '',
  `fecha` date DEFAULT current_timestamp(),
  `tiempo_interaccion` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT '',
  `descripcion_lugar` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT '',
  `quiebre_declarado` longtext CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT '',
  `quiebre_trabajado` longtext CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT '',
  `proceso_indagacion` longtext CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT '',
  `interpretacion_quiebre` longtext CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT '',
  `emocion_interaccion` longtext CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT '',
  `corporalidad` longtext CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT '',
  `nuevas_acciones` longtext CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT '',
  `emociones_vividas` longtext CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT '',
  `areas_aprendizaje` longtext CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT '',
  `nuevas_preguntas` longtext CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `coaching_usuarios`
--

INSERT INTO `coaching_usuarios` (`id`, `nombre_coaching`, `id_usuario`, `nombre_coachee`, `lugar`, `fecha`, `tiempo_interaccion`, `descripcion_lugar`, `quiebre_declarado`, `quiebre_trabajado`, `proceso_indagacion`, `interpretacion_quiebre`, `emocion_interaccion`, `corporalidad`, `nuevas_acciones`, `emociones_vividas`, `areas_aprendizaje`, `nuevas_preguntas`) VALUES
(2, 'Sesión 2', 1, 'Debug update', 'Debug update', '2024-01-18', 'Debug update', 'Debug update', 'Texto de prueba descripción', 'Texto de prueba descripción', 'Texto de prueba descripción', 'Texto de prueba descripción', 'Texto de prueba descripción', 'Texto de prueba descripción', 'Texto de prueba descripción', 'Texto de prueba descripción', 'Texto de prueba descripción', 'Texto de prueba descripción'),
(9, 'Prueba Insert 5', 1, 'mucho texto', 'mucho texto', '2024-01-20', 'mucho texto', 'mucho texto', 'mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto ', 'mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto ', 'mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto ', 'mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto ', 'mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto ', 'mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto ', 'mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto ', 'mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto ', 'mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto ', 'mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto '),
(10, 'Prueba refrescar página', 1, 'mucho texto', 'mucho texto', '2024-01-20', 'mucho texto', 'mucho texto', 'mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto ', 'mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto ', 'mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto ', 'mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto ', 'mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto ', 'mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto ', 'mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto ', 'mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto ', 'mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto ', 'mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto mucho texto '),
(14, 'Pruebas muchas', 1, 'Textoteeeeeeeee', 'Textote', '2024-01-20', 'Textote', 'Textote', 'textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba ', 'textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba ', 'textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba ', 'textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba ', 'textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba ', 'textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba ', 'textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba ', 'textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba ', 'textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba ', 'textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba textos muchos de prueba '),
(15, 'última prueba', 1, 'Textote', 'Textote', '2024-01-20', 'Debug update', 'tex', 'muchotototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototote texto', 'muchotototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototote texto', 'muchotototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototote texto', 'muchotototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototote texto', 'muchotototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototote texto', 'muchotototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototote texto', 'muchotototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototote texto', 'muchotototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototote texto', 'muchotototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototote texto', 'muchotototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototototote texto'),
(16, 'Coaching con Nora', 1, 'Flavio Almanza', 'Lugar', '2024-01-21', 'mucho tiempo', 'Descripción', 'Mucho texto Mucho texto Mucho texto Mucho texto Mucho texto Mucho texto Mucho texto Mucho texto Mucho texto Mucho texto Mucho texto Mucho texto Mucho texto Mucho texto Mucho texto Mucho texto Mucho texto Mucho texto Mucho texto Mucho texto Mucho texto Mucho texto ', 'Mucho texto Mucho texto Mucho texto Mucho texto Mucho texto Mucho texto Mucho texto Mucho texto Mucho texto Mucho texto Mucho texto Mucho texto Mucho texto Mucho texto Mucho texto Mucho texto Mucho texto Mucho texto Mucho texto Mucho texto Mucho texto Mucho texto ', 'Mucho texto Mucho texto Mucho texto Mucho texto Mucho texto Mucho texto Mucho texto Mucho texto Mucho texto Mucho texto Mucho texto Mucho texto Mucho texto Mucho texto Mucho texto Mucho texto Mucho texto Mucho texto Mucho texto Mucho texto Mucho texto Mucho texto ', 'Mucho texto Mucho texto Mucho texto Mucho texto Mucho texto Mucho texto Mucho texto Mucho texto Mucho texto Mucho texto Mucho texto Mucho texto Mucho texto Mucho texto Mucho texto Mucho texto Mucho texto Mucho texto Mucho texto Mucho texto Mucho texto Mucho texto ', 'Mucho texto Mucho texto Mucho texto Mucho texto Mucho texto Mucho texto Mucho texto Mucho texto Mucho texto Mucho texto Mucho texto Mucho texto Mucho texto Mucho texto Mucho texto Mucho texto Mucho texto Mucho texto Mucho texto Mucho texto Mucho texto Mucho texto ', 'Mucho texto Mucho texto Mucho texto Mucho texto Mucho texto Mucho texto Mucho texto Mucho texto Mucho texto Mucho texto Mucho texto Mucho texto Mucho texto Mucho texto Mucho texto Mucho texto Mucho texto Mucho texto Mucho texto Mucho texto Mucho texto Mucho texto ', 'Mucho texto Mucho texto Mucho texto Mucho texto Mucho texto Mucho texto Mucho texto Mucho texto Mucho texto Mucho texto Mucho texto Mucho texto Mucho texto Mucho texto Mucho texto Mucho texto Mucho texto Mucho texto Mucho texto Mucho texto Mucho texto Mucho texto ', 'Mucho texto Mucho texto Mucho texto Mucho texto Mucho texto Mucho texto Mucho texto Mucho texto Mucho texto Mucho texto Mucho texto Mucho texto Mucho texto Mucho texto Mucho texto Mucho texto Mucho texto Mucho texto Mucho texto Mucho texto Mucho texto Mucho texto ', 'Mucho texto Mucho texto Mucho texto Mucho texto Mucho texto Mucho texto Mucho texto Mucho texto Mucho texto Mucho texto Mucho texto Mucho texto Mucho texto Mucho texto Mucho texto Mucho texto Mucho texto Mucho texto Mucho texto Mucho texto Mucho texto Mucho texto ', 'Mucho texto Mucho texto Mucho texto Mucho texto Mucho texto Mucho texto Mucho texto Mucho texto Mucho texto Mucho texto Mucho texto Mucho texto Mucho texto Mucho texto Mucho texto Mucho texto Mucho texto Mucho texto Mucho texto Mucho texto Mucho texto Mucho texto ');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `examenes`
--

CREATE TABLE `examenes` (
  `id_examen` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `comentarios` varchar(200) DEFAULT 'Sin comentarios',
  `liga` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `examenes`
--

INSERT INTO `examenes` (`id_examen`, `nombre`, `comentarios`, `liga`) VALUES
(1, 'Examen Prueba 1', 'Sin comentarios', 'https://www.facebook.com/CoachFridaEspinosa'),
(2, 'Examen Prueba 2', 'Sin comentarios', 'https://www.instagram.com/evofridamental/');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `examenes_grupos`
--

CREATE TABLE `examenes_grupos` (
  `id` int(11) NOT NULL,
  `id_examen` int(11) NOT NULL,
  `id_grupo` int(11) NOT NULL,
  `fecha_aplicacion` date DEFAULT current_timestamp(),
  `activo` tinyint(4) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `examenes_grupos`
--

INSERT INTO `examenes_grupos` (`id`, `id_examen`, `id_grupo`, `fecha_aplicacion`, `activo`) VALUES
(1, 2, 11, '2023-05-25', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `examenes_reactivos`
--

CREATE TABLE `examenes_reactivos` (
  `id_reactivo` int(11) NOT NULL,
  `id_examen` int(11) NOT NULL,
  `reactivo` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `examenes_reactivos`
--

INSERT INTO `examenes_reactivos` (`id_reactivo`, `id_examen`, `reactivo`) VALUES
(1, 1, '¿Cuáles son los tres dominios en la coherencia del observador?'),
(2, 1, 'Describe los principios del observador'),
(3, 1, 'Describe un ejemplo de tu vida en el que te hayas movido de observador'),
(4, 1, 'Menciona los 3 enemigos del aprendizaje que son con los que más te identificas y describe por qué'),
(5, 1, 'Menciona los precios que has pagado a causa de estar apegado a esos enemigos del aprendizaje'),
(6, 1, 'Menciona los postulados de la ontología del lenguaje'),
(7, 2, '¿Qué es un juicio?'),
(8, 2, 'Enuncia 3 juicios que has hecho sobre ti y explica cómo han impactado en tu realidad'),
(9, 2, 'Menciona los 4 estados de ánimo básicos'),
(10, 2, 'Explica lo que es un quiebre y lo que es una transparencia'),
(11, 2, 'Explica un ejemplo de tu vida en el cual has sido víctima y uno en el que has sido responsable'),
(12, 2, 'Menciona los pasos para una despedida');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `examenes_reactivos_usuarios`
--

CREATE TABLE `examenes_reactivos_usuarios` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_reactivo` int(11) NOT NULL,
  `respuesta` longtext DEFAULT NULL,
  `correcto` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `examenes_usuarios`
--

CREATE TABLE `examenes_usuarios` (
  `id` int(11) NOT NULL,
  `id_examen` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `resultado` int(11) DEFAULT 0,
  `fecha_aplicacion` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `examenes_usuarios`
--

INSERT INTO `examenes_usuarios` (`id`, `id_examen`, `id_usuario`, `resultado`, `fecha_aplicacion`) VALUES
(1, 1, 1, 69, '2023-05-25 20:12:43'),
(2, 2, 1, 100, '2023-05-25 20:12:43');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `feedback_usuarios`
--

CREATE TABLE `feedback_usuarios` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_modulo` int(11) NOT NULL,
  `feedback` longtext DEFAULT 'Sin Feedback',
  `autor` varchar(45) DEFAULT 'Desconocido',
  `fecha` date DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `feedback_usuarios`
--

INSERT INTO `feedback_usuarios` (`id`, `id_usuario`, `id_modulo`, `feedback`, `autor`, `fecha`) VALUES
(1, 1, 3, 'Este es un Feedback de prueba Este es un Feedback de prueba Este es un Feedback de prueba Este es un Feedback de prueba Este es un Feedback de prueba Este es un Feedback de prueba Este es un Feedback de prueba Este es un Feedback de prueba ', 'Flavio Almanza', '2023-06-04'),
(2, 1, 4, 'Sin Feedback', 'Desconocido', '2023-06-04'),
(3, 1, 4, 'Este es un Feedback de prueba Este es un Feedback de prueba Este es un Feedback de prueba Este es un Feedback de prueba Este es un Feedback de prueba Este es un Feedback de prueba Este es un Feedback de prueba Este es un Feedback de prueba Este es un Feedback de prueba ', 'Flavio Almanza', '2023-06-04');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `grupos`
--

CREATE TABLE `grupos` (
  `id_grupo` int(11) NOT NULL,
  `nombre_grupo` varchar(45) NOT NULL,
  `fecha_inicio` date DEFAULT current_timestamp(),
  `fecha_terminacion` date DEFAULT NULL,
  `sede` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `grupos`
--

INSERT INTO `grupos` (`id_grupo`, `nombre_grupo`, `fecha_inicio`, `fecha_terminacion`, `sede`) VALUES
(0, 'Directivos', '2010-01-20', NULL, 'Chihuahua'),
(8, 'Probando', '2010-04-15', NULL, 'Mérida'),
(9, 'Prueba1', '2020-04-15', NULL, 'Guachochi'),
(10, 'Prueba2', '2021-04-15', NULL, 'Chihuahua'),
(11, 'Dharma', '2022-04-15', NULL, 'Chihuahua');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `modulos`
--

CREATE TABLE `modulos` (
  `id_modulo` int(11) NOT NULL,
  `nombre_modulo` varchar(45) NOT NULL,
  `descripcion` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `modulos`
--

INSERT INTO `modulos` (`id_modulo`, `nombre_modulo`, `descripcion`) VALUES
(1, 'Observador Enemigos', 'Descripcón genérica de Observador Enemigos'),
(2, 'Certezas y huevo', 'Descripcón genérica de Certezas y huevo'),
(3, 'Corporalidad y despedida', 'Descripcón genérica de Corporalidad y despedida'),
(4, 'Visión de vida y 7 leyes', 'Descripcón genérica de Visión de vida y 7 leyes'),
(5, 'Escucha y Bases del Coaching', NULL),
(6, 'Juicios', NULL),
(7, 'Quejas y pedidos', NULL),
(8, 'Emociones, quiebre y transparencia', NULL),
(9, 'Expos y diseño de taller', NULL),
(10, 'Expos', NULL),
(11, 'Coaching vida y negocios', NULL),
(12, 'Conclusiones contratos cuarto fin', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `modulos_grupos`
--

CREATE TABLE `modulos_grupos` (
  `id` int(11) NOT NULL,
  `id_modulo` int(11) NOT NULL,
  `id_grupo` int(11) NOT NULL,
  `fecha_impartido` date DEFAULT NULL,
  `disponible` tinyint(4) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `modulos_grupos`
--

INSERT INTO `modulos_grupos` (`id`, `id_modulo`, `id_grupo`, `fecha_impartido`, `disponible`) VALUES
(1, 1, 11, NULL, 1),
(2, 2, 11, NULL, 1),
(3, 3, 11, NULL, 1),
(4, 4, 11, NULL, 1),
(5, 5, 11, NULL, 0),
(6, 6, 11, NULL, 0),
(7, 7, 11, NULL, 0),
(8, 8, 11, NULL, 0),
(9, 9, 11, NULL, 0),
(10, 10, 11, NULL, 0),
(11, 11, 11, NULL, 0),
(12, 12, 11, NULL, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `modulos_usuarios`
--

CREATE TABLE `modulos_usuarios` (
  `id_mod_usu` int(11) NOT NULL,
  `id_modulo` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `status` tinyint(4) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `modulos_usuarios`
--

INSERT INTO `modulos_usuarios` (`id_mod_usu`, `id_modulo`, `id_usuario`, `status`) VALUES
(1, 1, 1, 1),
(2, 2, 1, 1),
(3, 3, 1, 1),
(4, 4, 1, 1),
(5, 5, 1, 1),
(6, 6, 1, 1),
(7, 7, 1, 1),
(8, 1, 2, 1),
(9, 2, 2, 1),
(10, 3, 2, 1),
(11, 4, 2, 1),
(12, 5, 2, 1),
(13, 6, 2, 1),
(14, 7, 2, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `modulo_personal`
--

CREATE TABLE `modulo_personal` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `nombre_cv` varchar(100) DEFAULT NULL,
  ` formato_inscripcion` varchar(100) DEFAULT NULL,
  `id_frontal` varchar(100) DEFAULT NULL,
  `id_trasera` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `modulo_personal`
--

INSERT INTO `modulo_personal` (`id`, `id_usuario`, `nombre_cv`, ` formato_inscripcion`, `id_frontal`, `id_trasera`) VALUES
(1, 1, 'cv.docx', 'asdasdghui.xcd', 'id_1.png', NULL),
(2, 2, NULL, NULL, NULL, NULL),
(3, 3, NULL, NULL, NULL, NULL),
(4, 4, NULL, NULL, NULL, NULL),
(5, 5, NULL, NULL, NULL, NULL),
(6, 6, NULL, NULL, NULL, NULL),
(7, 7, NULL, NULL, NULL, NULL),
(8, 8, NULL, NULL, NULL, NULL),
(9, 9, NULL, NULL, NULL, NULL),
(10, 10, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `niveles_usuario`
--

CREATE TABLE `niveles_usuario` (
  `id_nivel` int(11) NOT NULL,
  `nombre_nivel` varchar(45) NOT NULL,
  `permisos` longtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `niveles_usuario`
--

INSERT INTO `niveles_usuario` (`id_nivel`, `nombre_nivel`, `permisos`) VALUES
(1, 'Estudiante', NULL),
(2, 'Staff', NULL),
(3, 'Administrador', NULL),
(4, 'Master Coach', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pagos`
--

CREATE TABLE `pagos` (
  `id_pago` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `importe` int(6) NOT NULL,
  `fecha_pago` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `pagos`
--

INSERT INTO `pagos` (`id_pago`, `id_usuario`, `importe`, `fecha_pago`) VALUES
(0, 2, 3000, '2022-12-20'),
(1, 2, 2000, '2022-12-24'),
(2, 3, 2000, '2022-12-27');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `presentaciones`
--

CREATE TABLE `presentaciones` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `tema` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `presentaciones_feedback`
--

CREATE TABLE `presentaciones_feedback` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `nombre_feedback` varchar(50) DEFAULT 'Feedback presentacion',
  `archivo` varchar(100) DEFAULT 'Desconocido',
  `autor` varchar(100) DEFAULT 'Desconocido',
  `fecha_subido` date DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `presentaciones_feedback`
--

INSERT INTO `presentaciones_feedback` (`id`, `id_usuario`, `nombre_feedback`, `archivo`, `autor`, `fecha_subido`) VALUES
(3, 1, 'Feedback presentacion', 'Desconocido', 'Desconocido', '2023-05-25');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tareas_modulos`
--

CREATE TABLE `tareas_modulos` (
  `id_tarea` int(11) NOT NULL,
  `nombre_tarea` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `id_modulo` int(11) NOT NULL,
  `comentarios` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT 'Sin comentarios',
  `plantilla` varchar(50) DEFAULT 'Sin plantilla',
  `status` tinyint(4) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `tareas_modulos`
--

INSERT INTO `tareas_modulos` (`id_tarea`, `nombre_tarea`, `id_modulo`, `comentarios`, `plantilla`, `status`) VALUES
(1, 'Autobiografía', 1, 'Comentario genérico', 'Sin plantilla', 0),
(2, 'Desapego', 1, 'comentarios de Desapego', 'Sin plantilla', 0),
(3, 'Bitácora emociones', 1, 'comentarios de Bitácora de emociones', 'Sin plantilla', 0),
(4, '10P / 10S', 1, 'comentarios de 10p 10s', 'Sin plantilla', 0),
(5, 'Erase Me', 6, 'Comentario genérico', 'Sin Plantilla', 0),
(6, 'Erase Me 343', 3, 'prueba de insert', 'Sin Plantilla', 1),
(7, 'Erase Me 343', 3, 'prueba de insert', 'Sin Plantilla', 1),
(8, 'Erase Me 345', 3, 'prueba de insert', 'Sin Plantilla', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tareas_usuarios`
--

CREATE TABLE `tareas_usuarios` (
  `id` int(11) NOT NULL,
  `id_tarea` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `adjunto` varchar(100) DEFAULT 'Sin adjunto',
  `fecha_subida` date DEFAULT current_timestamp(),
  `revisado` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `tareas_usuarios`
--

INSERT INTO `tareas_usuarios` (`id`, `id_tarea`, `id_usuario`, `adjunto`, `fecha_subida`, `revisado`) VALUES
(1, 1, 1, 'Regimen Fiscal.xlsx', '2022-08-26', 3),
(2, 2, 1, 'prueba 2_tareas.docx', '2022-08-26', 1),
(3, 3, 1, 'Contrato_de_servicio_cliente.docx', '2022-08-26', 1),
(11, 4, 1, 'prueba 2_tareas.docx', '2024-01-22', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `trabajos_modulos`
--

CREATE TABLE `trabajos_modulos` (
  `id_trabajo` int(11) NOT NULL,
  `nombre_trabajo` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `id_modulo` int(11) NOT NULL,
  `comentarios` varchar(200) DEFAULT 'Sin comentarios',
  `plantilla` varchar(50) DEFAULT 'Sin plantilla',
  `status` tinyint(4) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_bin;

--
-- Volcado de datos para la tabla `trabajos_modulos`
--

INSERT INTO `trabajos_modulos` (`id_trabajo`, `nombre_trabajo`, `id_modulo`, `comentarios`, `plantilla`, `status`) VALUES
(1, 'Maestro/Aprendiz', 1, 'Sin comentarios', 'Sin plantilla', 0),
(2, 'Claro/Oscuro', 1, 'Sin comentarios', 'Sin plantilla', 0),
(3, 'Estrategia de vida', 2, 'Sin comentarios', 'Sin plantilla', 0),
(4, 'Corporalidad', 3, 'Sin comentarios', 'Sin plantilla', 0),
(5, 'Emociones', 8, 'Sin comentarios', 'Sin plantilla', 0),
(6, 'Tapete', 8, 'Sin comentarios', 'Sin plantilla', 0),
(7, 'Feedback Exposición Emociones', 8, 'Sin comentarios', 'Sin plantilla', 0),
(8, 'Erase me', 2, 'Comentario genérico', 'Sin plantilla', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `trabajos_usuarios`
--

CREATE TABLE `trabajos_usuarios` (
  `id` int(11) NOT NULL,
  `id_trabajo` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `adjunto` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT 'Sin adjunto',
  `fecha_subido` date NOT NULL DEFAULT current_timestamp(),
  `revisado` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_bin;

--
-- Volcado de datos para la tabla `trabajos_usuarios`
--

INSERT INTO `trabajos_usuarios` (`id`, `id_trabajo`, `id_usuario`, `adjunto`, `fecha_subido`, `revisado`) VALUES
(1, 1, 1, 'prueba-1_trabajos.docx', '2022-11-07', 0),
(2, 2, 1, 'prueba 2_trabajos.docx', '2022-11-07', 1),
(6, 1, 2, 'prueba 2_trabajos.docx', '2024-01-17', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellidos` varchar(50) NOT NULL,
  `id_pl` int(4) DEFAULT NULL,
  `id_grupo` int(11) NOT NULL,
  `fecha_ingreso` date DEFAULT current_timestamp(),
  `nombre_preferido` varchar(45) DEFAULT NULL,
  `nivel_usuario` tinyint(1) NOT NULL,
  `login_user` varchar(45) NOT NULL,
  `login_pass` varchar(45) NOT NULL,
  `correo` varchar(50) NOT NULL,
  `telefono` varchar(10) NOT NULL,
  `status` tinyint(4) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `apellidos`, `id_pl`, `id_grupo`, `fecha_ingreso`, `nombre_preferido`, `nivel_usuario`, `login_user`, `login_pass`, `correo`, `telefono`, `status`) VALUES
(1, 'Flavio Ariel', 'Almanza Fierro', 78, 11, '2023-07-03', 'Yayo', 1, 'flavio.almanza', '5f4dcc3b5aa765d61d8327deb882cf99', 'flavio.almanza01@gmail.com', '6144074509', 0),
(2, 'Flor Adriana', 'Almanza Sigala', 77, 11, '2022-03-22', 'Flor', 1, 'flor.almanza', '5f4dcc3b5aa765d61d8327deb882cf99', 'test@hotmail.com', '6141236544', 0),
(3, 'Javier Iván', 'Almanza Fierro', 75, 10, '2021-03-15', 'Iván', 1, 'ivan.almanza', '5f4dcc3b5aa765d61d8327deb882cf99', 'almanza.fierro@gmail.com', '6141234567', 0),
(4, 'Yaremí', 'Aké', NULL, 0, NULL, 'Yare', 3, 'yaremi.ake', '5f4dcc3b5aa765d61d8327deb882cf99', '', '', 0),
(7, 'Cesar Omar', 'Olivas Domínguez', NULL, 10, '2023-07-10', 'César', 2, 'cesar.olivas', '5f4dcc3b5aa765d61d8327deb882cf99', '', '', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario_web`
--

CREATE TABLE `usuario_web` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `usuario` varchar(45) NOT NULL,
  `pass` varchar(45) NOT NULL,
  `foto_perfil` varchar(200) DEFAULT NULL,
  `directorio_local` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `usuario_web`
--

INSERT INTO `usuario_web` (`id`, `id_usuario`, `usuario`, `pass`, `foto_perfil`, `directorio_local`) VALUES
(1, 1, 'flavio.almanza', '', 'resources/users/Flavio Ariel Almanza Fierro/imagen_2023-06-04_123133378.png', 'resources/users/Flavio Ariel Almanza Fierro/');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `clases`
--
ALTER TABLE `clases`
  ADD PRIMARY KEY (`id_clase`);

--
-- Indices de la tabla `coaching`
--
ALTER TABLE `coaching`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `coaching_usuarios`
--
ALTER TABLE `coaching_usuarios`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `examenes`
--
ALTER TABLE `examenes`
  ADD PRIMARY KEY (`id_examen`);

--
-- Indices de la tabla `examenes_grupos`
--
ALTER TABLE `examenes_grupos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `examenes_reactivos`
--
ALTER TABLE `examenes_reactivos`
  ADD PRIMARY KEY (`id_reactivo`);

--
-- Indices de la tabla `examenes_reactivos_usuarios`
--
ALTER TABLE `examenes_reactivos_usuarios`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `examenes_usuarios`
--
ALTER TABLE `examenes_usuarios`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `feedback_usuarios`
--
ALTER TABLE `feedback_usuarios`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `grupos`
--
ALTER TABLE `grupos`
  ADD PRIMARY KEY (`id_grupo`),
  ADD UNIQUE KEY `nombre_grupo` (`nombre_grupo`),
  ADD UNIQUE KEY `id_grupo` (`id_grupo`);

--
-- Indices de la tabla `modulos`
--
ALTER TABLE `modulos`
  ADD PRIMARY KEY (`id_modulo`);

--
-- Indices de la tabla `modulos_grupos`
--
ALTER TABLE `modulos_grupos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_mod-grup_modulos` (`id_modulo`),
  ADD KEY `fk_mod-grup_grupos` (`id_grupo`);

--
-- Indices de la tabla `modulos_usuarios`
--
ALTER TABLE `modulos_usuarios`
  ADD PRIMARY KEY (`id_mod_usu`);

--
-- Indices de la tabla `modulo_personal`
--
ALTER TABLE `modulo_personal`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `niveles_usuario`
--
ALTER TABLE `niveles_usuario`
  ADD PRIMARY KEY (`id_nivel`);

--
-- Indices de la tabla `presentaciones`
--
ALTER TABLE `presentaciones`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `presentaciones_feedback`
--
ALTER TABLE `presentaciones_feedback`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tareas_modulos`
--
ALTER TABLE `tareas_modulos`
  ADD PRIMARY KEY (`id_tarea`),
  ADD KEY `fk_tar-mod_mod` (`id_modulo`);

--
-- Indices de la tabla `tareas_usuarios`
--
ALTER TABLE `tareas_usuarios`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `trabajos_modulos`
--
ALTER TABLE `trabajos_modulos`
  ADD PRIMARY KEY (`id_trabajo`),
  ADD KEY `fk_trab_mod-mod` (`id_modulo`);

--
-- Indices de la tabla `trabajos_usuarios`
--
ALTER TABLE `trabajos_usuarios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_trab_usu-trab_mod` (`id_trabajo`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_UNIQUE` (`id`),
  ADD KEY `usuario_grupo_idx` (`id_grupo`);

--
-- Indices de la tabla `usuario_web`
--
ALTER TABLE `usuario_web`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `coaching`
--
ALTER TABLE `coaching`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `coaching_usuarios`
--
ALTER TABLE `coaching_usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `examenes`
--
ALTER TABLE `examenes`
  MODIFY `id_examen` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `examenes_grupos`
--
ALTER TABLE `examenes_grupos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `examenes_reactivos`
--
ALTER TABLE `examenes_reactivos`
  MODIFY `id_reactivo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `examenes_reactivos_usuarios`
--
ALTER TABLE `examenes_reactivos_usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `examenes_usuarios`
--
ALTER TABLE `examenes_usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `feedback_usuarios`
--
ALTER TABLE `feedback_usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `modulos_grupos`
--
ALTER TABLE `modulos_grupos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `modulos_usuarios`
--
ALTER TABLE `modulos_usuarios`
  MODIFY `id_mod_usu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `modulo_personal`
--
ALTER TABLE `modulo_personal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `niveles_usuario`
--
ALTER TABLE `niveles_usuario`
  MODIFY `id_nivel` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `presentaciones`
--
ALTER TABLE `presentaciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `presentaciones_feedback`
--
ALTER TABLE `presentaciones_feedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `tareas_modulos`
--
ALTER TABLE `tareas_modulos`
  MODIFY `id_tarea` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `tareas_usuarios`
--
ALTER TABLE `tareas_usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `trabajos_modulos`
--
ALTER TABLE `trabajos_modulos`
  MODIFY `id_trabajo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `trabajos_usuarios`
--
ALTER TABLE `trabajos_usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `usuario_web`
--
ALTER TABLE `usuario_web`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `modulos_grupos`
--
ALTER TABLE `modulos_grupos`
  ADD CONSTRAINT `fk_mod-grup_grupos` FOREIGN KEY (`id_grupo`) REFERENCES `grupos` (`id_grupo`),
  ADD CONSTRAINT `fk_mod-grup_modulos` FOREIGN KEY (`id_modulo`) REFERENCES `modulos` (`id_modulo`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `tareas_modulos`
--
ALTER TABLE `tareas_modulos`
  ADD CONSTRAINT `fk_tar-mod_mod` FOREIGN KEY (`id_modulo`) REFERENCES `modulos` (`id_modulo`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `trabajos_modulos`
--
ALTER TABLE `trabajos_modulos`
  ADD CONSTRAINT `fk_trab_mod-mod` FOREIGN KEY (`id_modulo`) REFERENCES `modulos` (`id_modulo`);

--
-- Filtros para la tabla `trabajos_usuarios`
--
ALTER TABLE `trabajos_usuarios`
  ADD CONSTRAINT `fk_trab_usu-trab_mod` FOREIGN KEY (`id_trabajo`) REFERENCES `trabajos_modulos` (`id_trabajo`);

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `idx_usuariogrupo1` FOREIGN KEY (`id_grupo`) REFERENCES `grupos` (`id_grupo`) ON DELETE NO ACTION ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
