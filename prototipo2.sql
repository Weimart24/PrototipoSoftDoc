-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 11-05-2025 a las 02:34:03
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `prototipo2`
--

DELIMITER $$
--
-- Procedimientos
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `validar_usuario` (IN `p_correo` VARCHAR(50), IN `p_contrasena` VARCHAR(255), OUT `p_mensaje` VARCHAR(255))   BEGIN
    DECLARE v_count INT;

    SELECT COUNT(*)
    INTO v_count
    FROM funcionario
    WHERE correo = p_correo
      AND contrasena = p_contrasena;

    IF v_count = 1 THEN
        SET p_mensaje = 'Usuario válido';
    ELSE
        SET p_mensaje = 'Usuario no válido';
    END IF;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dependencia`
--

CREATE TABLE `dependencia` (
  `id_dependencia` varchar(10) NOT NULL,
  `nombre_dependencia` varchar(45) DEFAULT NULL,
  `telefono` varchar(50) DEFAULT NULL,
  `activo` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `dependencia`
--

INSERT INTO `dependencia` (`id_dependencia`, `nombre_dependencia`, `telefono`, `activo`) VALUES
('10', 'Dirección General', '9876543210', 1),
('21', 'Gestión Documental', '8888888888', 1),
('22', 'Recepción General', '7777777777', 1),
('32', 'Bienestar Estudiantil', '6666666666', 1),
('33', 'Programas de Apoyo', '5555555555', 1),
('41', 'Tesorería / Presupuesto', '4444444444', 1),
('51', 'Promoción Institucional', '3333333333', 1),
('Admin', 'Administrador', '8876387', 1),
('CAA987', 'Coordinación Académica', '+4445556666', 1),
('CBQC654', 'Coordinación de Bienestar y Calidad', '+7778889999', 1),
('CNT789', 'Contabilidad y Administración', '+1112223333', 1),
('DIR456', 'Dirección', '+9876543210', 1),
('MDK123', 'Mercadeo', '+1234567890', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `funcionario`
--

CREATE TABLE `funcionario` (
  `id_funcionario` int(11) NOT NULL,
  `tipo_documento` varchar(10) NOT NULL,
  `cedula` varchar(45) NOT NULL,
  `nombre_funcionario` varchar(45) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `contrasena` varchar(255) NOT NULL,
  `telefono` varchar(35) NOT NULL,
  `direccion` varchar(80) NOT NULL,
  `id_dependencia` varchar(10) NOT NULL,
  `codigo_area` varchar(5) NOT NULL,
  `jerarquia` int(11) NOT NULL,
  `reset_token` varchar(255) DEFAULT NULL,
  `reset_expiration` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `funcionario`
--

INSERT INTO `funcionario` (`id_funcionario`, `tipo_documento`, `cedula`, `nombre_funcionario`, `correo`, `contrasena`, `telefono`, `direccion`, `id_dependencia`, `codigo_area`, `jerarquia`, `reset_token`, `reset_expiration`) VALUES
(1, 'cc', '1121323', 'Juan Pérez', 'juan.perez@example.com', 'contraseña123', '555-1234', 'Calle 123, Ciudad', '21', 'GQ', 20, NULL, NULL),
(2, 'cc', '2234234', 'Flor Ruiz', 'flor@gmail.com', '987', '555-5678', 'Avenida Principal, Pueblo', '51', 'GC', 50, NULL, NULL),
(3, 'cc', '3234234', 'María González', 'maria.gonzalez@example.com', 'clave456', '555-5678', 'Avenida Principal, Pueblo', '32', 'GA', 30, NULL, NULL),
(5, 'cc', '5545345', 'Lila González', 'dirlortr@gmail.com', '$2y$10$yRnjnxUgOXxNDSDw2RK5q.r6cOyBNBhYtV3YRyff4IoxEhGccNCza', '555-5678', 'Avenida 34, Pablo', '41', 'AF', 40, NULL, NULL),
(6, 'CC', '1060650654', 'Weimar Tamayo ', 'weimart24@gmail.com', 'Admin', '3147587078', 'Vereda la Guayana', '33', 'GA', 30, NULL, NULL),
(7, 'CC', '123456789', 'Admin', 'admin@admin.com', 'Admin12345', '123456', 'Cra 23 # 21 - 81', 'Admin', 'GD', 10, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `radicacion`
--

CREATE TABLE `radicacion` (
  `id_radicado` int(11) NOT NULL,
  `radicado` varchar(20) NOT NULL,
  `nombre_remitente` varchar(45) NOT NULL,
  `tipo_documento` varchar(10) NOT NULL,
  `cedula_remitente` varchar(45) DEFAULT NULL,
  `telefono` varchar(35) NOT NULL,
  `direccion` varchar(80) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `fecha_radicado` date NOT NULL,
  `asunto` varchar(100) NOT NULL,
  `pais` varchar(45) NOT NULL,
  `departamento` varchar(45) NOT NULL,
  `municipio` varchar(45) NOT NULL,
  `documento` varchar(100) DEFAULT NULL,
  `id_dependencia` varchar(10) DEFAULT NULL,
  `id_funcionario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `radicacion`
--

INSERT INTO `radicacion` (`id_radicado`, `radicado`, `nombre_remitente`, `tipo_documento`, `cedula_remitente`, `telefono`, `direccion`, `correo`, `fecha_radicado`, `asunto`, `pais`, `departamento`, `municipio`, `documento`, `id_dependencia`, `id_funcionario`) VALUES
(1, '5-CNT789-2025-001', 'pepito', 'CC', '124352', '234356675', 'ftima', 'dirlortr@gmail.com', '2025-05-09', 'pruebas', 'Colombia', 'Caldas', 'Manizales', 'app/document/1.jpg', 'CNT789', 5),
(2, '5-CNT789-2025-002', 'dirlen', 'CC', '25365', '345664887', 'fati', 'dirlenyrodriguez.2375@gmail.com', '2025-05-09', 'pruebas', 'Colombia', 'Caldas', 'Manizales', 'app/document/carnet destruccion.png', 'CNT789', 5),
(3, 'AF40-CNT789-2025-003', 'paradsd', 'CC', '32356', '32436', 'fat', 'dirlortr@gmail.com', '2025-05-09', 'pruebas', 'Colombia', 'Caldas', 'Manizales', 'app/document/1.jpg', 'CNT789', 5),
(4, 'AF40-CNT789-2025-004', 'pruebas', 'CC', '218576728', '34566789', 'fatima', 'dirlortr@gmail.com', '2025-05-09', 'prueba1', 'Colombia', 'Caldas', 'Manizales', 'app/document/1.jpg', 'CNT789', 5),
(5, 'AF40-CNT789-2025-005', 'PRUEBAS 4', 'CC', '4365768579', '2122435', 'FATIM', 'dirlortr@gmail.com', '2025-05-09', 'pruebas 5', 'Colombia', 'Caldas', 'Manizales', 'app/document/carnet destruccion.png', 'CNT789', 5),
(6, 'AF40-CNT789-2025-006', 'PRUEBAS 4', 'CC', '4365768579', '2122435', 'FATIM', 'dirlortr@gmail.com', '2025-05-09', 'pruebas 5', 'Colombia', 'Caldas', 'Manizales', 'app/document/carnet destruccion.png', 'CNT789', 5),
(7, 'AF40-CNT789-2025-007', 'PRUEBAS 6', 'CC', '4365768579', '212243586', 'FATIMas', 'dirlortr@gmail.com', '2025-05-09', 'pruebas 5', 'Colombia', 'Caldas', 'Manizales', 'app/document/carnet destruccion.png', 'CNT789', 5),
(8, 'AF40-CNT789-2025-008', 'PRUEBAS 99', 'CC', '4365768579', '212243586', 'sol', 'dirlortr@gmail.com', '2025-05-09', 'pruebas 99', 'Colombia', 'Caldas', 'Manizales', 'app/document/carnet destruccion.png', 'CNT789', 5),
(9, 'AF40-CNT789-2025-009', 'nana', 'CC', '18997539', '3200393583', 'centro', 'dirlortr@gmail.com', '2025-05-09', 'para pruebas', 'Colombia', 'Caldas', 'Manizales', 'app/document/1.jpg', 'CNT789', 5),
(10, 'AF40-CNT789-2025-010', 'lina', 'CC', '111111112', '3324325', 'chipre', 'dirlenyrodriguez.2375@gmail.com', '2025-05-09', 'mios', 'Colombia', 'Caldas', 'Manizales', 'app/document/carnet destruccion.png', 'CNT789', 5),
(11, 'AF40-CNT789-2025-011', 'sandra', 'CC', '11111111435', '3324325', 'chipre', 'dirlenyrodriguez.2375@gmail.com', '2025-05-09', 'mios', 'Colombia', 'Caldas', 'Manizales', 'app/document/carnet destruccion.png', 'CNT789', 5),
(12, 'AF40-CNT789-2025-012', 'sandrita', 'CC', '11111111435', '3324325', 'chipre', 'dirlenyrodriguez.2375@gmail.com', '2025-05-09', 'mios', 'Colombia', 'Caldas', 'Manizales', 'app/document/carnet destruccion.png', 'CNT789', 5),
(13, 'AF40-CNT789-2025-013', 'final', 'CC', '93289577', '256324', 'estadio', 'dirlenyrodriguez.2375@gmail.com', '2025-05-09', 'final de pruebas', 'Colombia', 'Caldas', 'Manizales', 'app/document/carnet destruido.png', 'CNT789', 5),
(14, 'AF40-41-2025-014', 'PRUEBAS FINALES', 'CC', '11182647278', '8164', 'FRANCIA', 'dirlortr@gmail.com', '2025-05-09', 'Pruebs finals', 'Colombia', 'Caldas', 'Manizales', '', '41', 5),
(15, 'GA30-32-2025-015', 'Paola', 'CC', '12342453', '321343356', 'velez', 'dirlenyrodriguez.2375@gmail.com', '2025-05-09', 'dinny', 'Colombia', 'Caldas', 'Manizales', 'app/document/Requerimiento_comparativo.pdf', '32', 3),
(16, '2025-05-09 - 1', 'papitas', 'CC', '22334556', '11111111', 'bajos', 'dirlenyrodriguez.2375@gmail.com', '2025-05-09', 'sena pruebas', 'Colombia', 'Caldas', 'Manizales', 'app/document/context_clues_infographic.jpg', 'CAA987', 6),
(17, '2025-05-09 - 2', 'holas', 'CC', '213152646', '3234253356', 'rrrrrr', 'dirlortr@gmail.com', '2025-05-09', 'holas', 'Colombia', 'Caldas', 'Manizales', '', 'CAA987', 6),
(18, '2025-05-09 - 3', 'tania', 'CC', '333333333', '11111111111', 'velez', 'dirlortr@gmail.com', '2025-05-09', 'propiedad', 'Colombia', 'Caldas', 'Manizales', 'app/document/1.jpg', 'CAA987', 6),
(19, 'GA30-CAA987-2025-016', 'PRUEBAS 1000', 'CC', '11111111111', '2222222222', 'ORO', 'dirlortr@gmail.com', '2025-05-09', 'pruebas 1000', 'Colombia', 'Caldas', 'Manizales', 'app/document/1.jpg', 'CAA987', 6),
(20, 'GA30-CAA987-2025-017', 'pruebas dir', 'CC', '11111122324', '333333333', 'sol', 'dirlortr@gmail.com', '2025-05-09', 'solecitos', 'Colombia', 'Caldas', 'Manizales', 'app/document/1.jpg', 'CAA987', 6),
(21, 'GA30-CAA987-2025-018', 'pruebas dir', 'CC', '11111122324', '333333333', 'sol', 'dirlortr@gmail.com', '2025-05-09', 'solecitos', 'Colombia', 'Caldas', 'Manizales', 'app/document/1.jpg', 'CAA987', 6),
(22, 'GA30-CAA987-2025-019', 'moni', 'CC', '111111', '00000', 'sole', 'dirlortr@gmail.com', '2025-05-09', 'pruebas', 'Colombia', 'Caldas', 'Manizales', '', 'CAA987', 6),
(23, 'GA30-CAA987-2025-020', 'mis pruebas', 'CC', '555555', '55555', 'centro', 'dirlortr@gmail.com', '2025-05-09', 'pruebas', 'Colombia', 'Caldas', 'Manizales', '', 'CAA987', 6),
(24, 'GA30-CAA987-2025-021', 'carlos', 'CC', '1111111111', '3245668900', 'rionegro', 'dirortr@mail.com', '2025-05-09', 'pruebasss', 'Colombia', 'Caldas', 'Manizales', 'app/document/1.jpg', 'CAA987', 6),
(25, 'GQ20-21-2025-022', 'Dirleny', 'CC', '11224435544', '111111111', 'fatima', 'dirlenyrodriguez.2375@gmail.com', '2025-05-10', 'milpruebas', 'Colombia', 'Caldas', 'Manizales', 'app/document/1.jpg', '21', 1),
(26, 'GA30-CAA987-2025-023', 'dirlen', 'CC', '12871246737', '24252', 'ggggg', 'dirlenyrodriguez.2375@gmail.com', '2025-05-10', '2345678', 'Colombia', 'Caldas', 'Manizales', 'app/document/1.jpg', 'CAA987', 6);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `seguimiento_radicado`
--

CREATE TABLE `seguimiento_radicado` (
  `id_seguimiento` int(11) NOT NULL,
  `id_radicado` int(11) NOT NULL,
  `fecha_seguimiento` date NOT NULL,
  `detalle` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `seguimiento_radicado`
--

INSERT INTO `seguimiento_radicado` (`id_seguimiento`, `id_radicado`, `fecha_seguimiento`, `detalle`) VALUES
(1, 1, '2025-05-09', 'hola'),
(2, 2, '2025-05-09', 'sdghf'),
(3, 3, '2025-05-09', 'fs'),
(4, 4, '2025-05-09', 'hola'),
(5, 5, '2025-05-09', 'efghd'),
(6, 6, '2025-05-09', 'efghd'),
(7, 7, '2025-05-09', 'efghd'),
(8, 8, '2025-05-09', 'efghd'),
(9, 9, '2025-05-09', 'erer'),
(10, 10, '2025-05-09', 'hjdkf'),
(11, 11, '2025-05-09', 'hjdkf'),
(12, 12, '2025-05-09', 'hjdkf'),
(13, 13, '2025-05-09', 'ok'),
(14, 14, '2025-05-09', 'olis'),
(15, 15, '2025-05-09', 'hola'),
(16, 16, '2025-05-09', 'proyecto'),
(17, 17, '2025-05-09', 'daas'),
(18, 18, '2025-05-09', 'pruebas'),
(19, 19, '2025-05-09', 'olis'),
(20, 20, '2025-05-09', 'dsd'),
(21, 21, '2025-05-09', 'dsd'),
(22, 22, '2025-05-09', 'p'),
(23, 23, '2025-05-09', 'mil pruebas'),
(24, 24, '2025-05-09', 'hola'),
(25, 25, '2025-05-10', 'oli'),
(26, 26, '2025-05-10', 'jafg');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `dependencia`
--
ALTER TABLE `dependencia`
  ADD PRIMARY KEY (`id_dependencia`);

--
-- Indices de la tabla `funcionario`
--
ALTER TABLE `funcionario`
  ADD PRIMARY KEY (`id_funcionario`),
  ADD KEY `funcionario_ibfk_1` (`id_dependencia`);

--
-- Indices de la tabla `radicacion`
--
ALTER TABLE `radicacion`
  ADD PRIMARY KEY (`id_radicado`),
  ADD KEY `radicacion_ibfk_1` (`id_dependencia`),
  ADD KEY `radicacion_ibfk_2` (`id_funcionario`);

--
-- Indices de la tabla `seguimiento_radicado`
--
ALTER TABLE `seguimiento_radicado`
  ADD PRIMARY KEY (`id_seguimiento`),
  ADD KEY `seguimiento_radicado_ibfk_1` (`id_radicado`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `funcionario`
--
ALTER TABLE `funcionario`
  MODIFY `id_funcionario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `radicacion`
--
ALTER TABLE `radicacion`
  MODIFY `id_radicado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT de la tabla `seguimiento_radicado`
--
ALTER TABLE `seguimiento_radicado`
  MODIFY `id_seguimiento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `funcionario`
--
ALTER TABLE `funcionario`
  ADD CONSTRAINT `funcionario_ibfk_1` FOREIGN KEY (`id_dependencia`) REFERENCES `dependencia` (`id_dependencia`);

--
-- Filtros para la tabla `radicacion`
--
ALTER TABLE `radicacion`
  ADD CONSTRAINT `radicacion_ibfk_1` FOREIGN KEY (`id_dependencia`) REFERENCES `dependencia` (`id_dependencia`),
  ADD CONSTRAINT `radicacion_ibfk_2` FOREIGN KEY (`id_funcionario`) REFERENCES `funcionario` (`id_funcionario`);

--
-- Filtros para la tabla `seguimiento_radicado`
--
ALTER TABLE `seguimiento_radicado`
  ADD CONSTRAINT `seguimiento_radicado_ibfk_1` FOREIGN KEY (`id_radicado`) REFERENCES `radicacion` (`id_radicado`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
