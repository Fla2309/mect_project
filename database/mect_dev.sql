-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 23-06-2023 a las 03:16:51
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
  `id_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `nombre_tarea` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `id_modulo` int(11) NOT NULL,
  `comentarios` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `tareas_modulos`
--

INSERT INTO `tareas_modulos` (`id_tarea`, `nombre_tarea`, `id_modulo`, `comentarios`) VALUES
(1, 'Autobiografía', 1, 'comentarios de Autobiografía'),
(2, 'Desapego', 1, 'comentarios de Desapego'),
(3, 'Bitácora emociones', 1, 'comentarios de Bitácora de emociones'),
(4, '10P / 10S', 1, 'comentarios de 10p 10s');

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
(1, 1, 1, 'prueba-1_tareas.docx', '2022-08-26', 3),
(2, 2, 1, 'prueba 2_tareas.docx', '2022-08-26', 1),
(3, 3, 1, 'prueba-1_tareas.docx', '2022-08-26', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `trabajos_modulos`
--

CREATE TABLE `trabajos_modulos` (
  `id_trabajo` int(11) NOT NULL,
  `nombre_trabajo` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `id_modulo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_bin;

--
-- Volcado de datos para la tabla `trabajos_modulos`
--

INSERT INTO `trabajos_modulos` (`id_trabajo`, `nombre_trabajo`, `id_modulo`) VALUES
(1, 'Maestro/Aprendiz', 1),
(2, 'Claro/Oscuro', 1),
(3, 'Estrategia de vida', 2),
(4, 'Corporalidad', 3),
(5, 'Emociones', 8),
(6, 'Tapete', 8),
(7, 'Feedback Exposición Emociones', 8);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `trabajos_usuarios`
--

CREATE TABLE `trabajos_usuarios` (
  `id` int(11) NOT NULL,
  `id_trabajo` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `fecha_subido` date NOT NULL DEFAULT current_timestamp(),
  `revisado` tinyint(1) DEFAULT 0,
  `adjunto` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT 'Sin adjunto'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_bin;

--
-- Volcado de datos para la tabla `trabajos_usuarios`
--

INSERT INTO `trabajos_usuarios` (`id`, `id_trabajo`, `id_usuario`, `fecha_subido`, `revisado`, `adjunto`) VALUES
(1, 1, 1, '2022-11-07', 0, 'prueba-1_trabajos.docx'),
(2, 2, 1, '2022-11-07', 1, 'prueba 2_trabajos.docx');

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
  `fecha_ingreso` date DEFAULT NULL,
  `nombre_preferido` varchar(45) DEFAULT NULL,
  `nivel_usuario` tinyint(1) NOT NULL,
  `login_user` varchar(45) NOT NULL,
  `login_pass` varchar(45) NOT NULL,
  `correo` varchar(50) NOT NULL,
  `telefono` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `apellidos`, `id_pl`, `id_grupo`, `fecha_ingreso`, `nombre_preferido`, `nivel_usuario`, `login_user`, `login_pass`, `correo`, `telefono`) VALUES
(0, 'Yaremí', 'Aké', NULL, 0, NULL, NULL, 2, 'yaremi.ake', '5f4dcc3b5aa765d61d8327deb882cf99', '', ''),
(1, 'Flavio Ariel', 'Almanza Fierro', 78, 11, '2022-03-22', 'Yayo', 1, 'flavio.almanza', '5f4dcc3b5aa765d61d8327deb882cf99', 'flavio.almanza01@gmail.com', '6144074508'),
(2, 'Flor Adriana', 'Almanza Sigala', 77, 11, '2022-03-22', 'Flor', 1, 'flor.almanza', '5f4dcc3b5aa765d61d8327deb882cf99', 'test@hotmail.com', '6141236544'),
(3, 'Javier Iván', 'Almanza Fierro', 75, 10, '2021-03-15', 'Iván', 1, 'ivan.almanza', '5f4dcc3b5aa765d61d8327deb882cf99', 'almanza.fierro@gmail.com', '6141234567');

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
  ADD PRIMARY KEY (`id`),
  ADD KEY `coaching_usuarios_idx` (`id_usuario`);

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
  ADD PRIMARY KEY (`id_mod_usu`),
  ADD KEY `fk_mod-usu_usuarios` (`id_usuario`),
  ADD KEY `fk_mod-usu_modulos` (`id_modulo`);

--
-- Indices de la tabla `modulo_personal`
--
ALTER TABLE `modulo_personal`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `pagos`
--
ALTER TABLE `pagos`
  ADD KEY `fk_pago-usu` (`id_usuario`);

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
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_tar-usu_usu` (`id_usuario`),
  ADD KEY `fk_tar-usu_tar-mod` (`id_tarea`);

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
  ADD KEY `fk_trab_usu-trab_mod` (`id_trabajo`),
  ADD KEY `fk_trab_usu-usu` (`id_usuario`);

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
-- AUTO_INCREMENT de la tabla `modulo_personal`
--
ALTER TABLE `modulo_personal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

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
-- AUTO_INCREMENT de la tabla `tareas_usuarios`
--
ALTER TABLE `tareas_usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `trabajos_modulos`
--
ALTER TABLE `trabajos_modulos`
  MODIFY `id_trabajo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `trabajos_usuarios`
--
ALTER TABLE `trabajos_usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `usuario_web`
--
ALTER TABLE `usuario_web`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `coaching`
--
ALTER TABLE `coaching`
  ADD CONSTRAINT `fk_coach_usu` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `modulos_grupos`
--
ALTER TABLE `modulos_grupos`
  ADD CONSTRAINT `fk_mod-grup_grupos` FOREIGN KEY (`id_grupo`) REFERENCES `grupos` (`id_grupo`),
  ADD CONSTRAINT `fk_mod-grup_modulos` FOREIGN KEY (`id_modulo`) REFERENCES `modulos` (`id_modulo`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `modulos_usuarios`
--
ALTER TABLE `modulos_usuarios`
  ADD CONSTRAINT `fk_mod-usu_modulos` FOREIGN KEY (`id_modulo`) REFERENCES `modulos` (`id_modulo`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_mod-usu_usuarios` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `pagos`
--
ALTER TABLE `pagos`
  ADD CONSTRAINT `fk_pago-usu` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `tareas_modulos`
--
ALTER TABLE `tareas_modulos`
  ADD CONSTRAINT `fk_tar-mod_mod` FOREIGN KEY (`id_modulo`) REFERENCES `modulos` (`id_modulo`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `tareas_usuarios`
--
ALTER TABLE `tareas_usuarios`
  ADD CONSTRAINT `fk_tar-usu_tar-mod` FOREIGN KEY (`id_tarea`) REFERENCES `tareas_modulos` (`id_tarea`),
  ADD CONSTRAINT `fk_tar-usu_usu` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `trabajos_modulos`
--
ALTER TABLE `trabajos_modulos`
  ADD CONSTRAINT `fk_trab_mod-mod` FOREIGN KEY (`id_modulo`) REFERENCES `modulos` (`id_modulo`);

--
-- Filtros para la tabla `trabajos_usuarios`
--
ALTER TABLE `trabajos_usuarios`
  ADD CONSTRAINT `fk_trab_usu-trab_mod` FOREIGN KEY (`id_trabajo`) REFERENCES `trabajos_modulos` (`id_trabajo`),
  ADD CONSTRAINT `fk_trab_usu-usu` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`);

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `idx_usuariogrupo1` FOREIGN KEY (`id_grupo`) REFERENCES `grupos` (`id_grupo`) ON DELETE NO ACTION ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
