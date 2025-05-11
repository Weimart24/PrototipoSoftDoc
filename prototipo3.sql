-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
-- Servidor: 127.0.0.1
-- Tiempo de generación: 14-09-2024 a las 02:49:33
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

-- Base de datos: `prototipo`

DELIMITER $$

-- Procedimientos
CREATE DEFINER=`root`@`localhost` PROCEDURE `validar_usuario` (IN `p_correo` VARCHAR(50), IN `p_contrasena` VARCHAR(255), OUT `p_mensaje` VARCHAR(255))   
BEGIN
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

-- Estructura de la tabla `dependencia` con campo `activo` para deshabilitarla
CREATE TABLE `dependencia` (
  `id_dependencia` varchar(10) NOT NULL,
  `nombre_dependencia` varchar(45) DEFAULT NULL,
  `telefono` varchar(50) DEFAULT NULL,
  `activo` BOOLEAN DEFAULT TRUE, -- Para inactivar la dependencia
  PRIMARY KEY (`id_dependencia`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcado de datos para la tabla `dependencia`
INSERT INTO `dependencia` (`id_dependencia`, `nombre_dependencia`, `telefono`, `activo`) VALUES
('Admin', 'Administrador', '8876387', TRUE),
('CAA987', 'Coordinación Académica', '+4445556666', TRUE),
('CBQC654', 'Coordinación de Bienestar y Calidad', '+7778889999', TRUE),
('CNT789', 'Contabilidad y Administración', '+1112223333', TRUE),
('DIR456', 'Dirección', '+9876543210', TRUE),
('MDK123', 'Mercadeo', '+1234567890', TRUE);


-- Estructura de tabla para la tabla `funcionario`
CREATE TABLE `funcionario` (
  `id_funcionario` int(11) NOT NULL AUTO_INCREMENT,
  `tipo_documento` varchar(10) NOT NULL,
  `cedula` varchar(45) NOT NULL,
  `nombre_funcionario` varchar(45) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `contrasena` varchar(255) NOT NULL,
  `telefono` varchar(35) NOT NULL,
  `direccion` varchar(80) NOT NULL,
  `id_dependencia` varchar(10) NOT NULL,
  `reset_token` varchar(255) NOT NULL,
  `reset_expiration` datetime NOT NULL,
  PRIMARY KEY (`id_funcionario`),
  CONSTRAINT `funcionario_ibfk_1` FOREIGN KEY (`id_dependencia`) REFERENCES `dependencia` (`id_dependencia`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcado de datos para la tabla `funcionario`
INSERT INTO `funcionario` (`id_funcionario`, `tipo_documento`, `cedula`, `nombre_funcionario`, `correo`, `contrasena`, `telefono`, `direccion`, `id_dependencia`) VALUES
(1, 'cc', '1121323', 'Juan Pérez', 'juan.perez@example.com', 'contraseña123', '555-1234', 'Calle 123, Ciudad', 'CBQC654'),
(2, 'cc', '2234234', 'Flor Ruiz', 'flor@gmail.com', '987', '555-5678', 'Avenida Principal, Pueblo', 'MDK123'),
(3, 'cc', '3234234', 'María González', 'maria.gonzalez@example.com', 'clave456', '555-5678', 'Avenida Principal, Pueblo', 'DIR456'),
(5, 'cc', '5545345', 'Martha González', 'martha.gonzalez@example.com', 'clave123', '555-5678', 'Avenida 34, Pablo', 'CNT789'),
(6, 'CC', '1060650654', 'Weimar Tamayo ', 'weimart24@gmail.com', 'Admin', '3147587078', 'Vereda la Guayana', 'CAA987'),
(7, 'CC', '123456789', 'Admin', 'admin@admin.com', 'Admin12345', '123456', 'Cra 23 # 21 - 81', 'Admin');

-- Estructura de tabla para la tabla `radicacion`
CREATE TABLE `radicacion` (
  `id_radicado` int(11) NOT NULL AUTO_INCREMENT,
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
  `id_funcionario` int(11) NOT NULL,
  PRIMARY KEY (`id_radicado`),
  CONSTRAINT `radicacion_ibfk_1` FOREIGN KEY (`id_dependencia`) REFERENCES `dependencia` (`id_dependencia`),
  CONSTRAINT `radicacion_ibfk_2` FOREIGN KEY (`id_funcionario`) REFERENCES `funcionario` (`id_funcionario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- Nueva tabla `seguimiento` para el seguimiento de radicados
CREATE TABLE `seguimiento_radicado` (
  `id_seguimiento` int(11) NOT NULL AUTO_INCREMENT,
  `id_radicado` int(11) NOT NULL,
  `fecha_seguimiento` date NOT NULL,
  `detalle` text NOT NULL,
  PRIMARY KEY (`id_seguimiento`),
  CONSTRAINT `seguimiento_radicado_ibfk_1` FOREIGN KEY (`id_radicado`) REFERENCES `radicacion` (`id_radicado`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- Estructura de tabla para `roles`
CREATE TABLE `roles` (
  `id_rol` INT(11) NOT NULL AUTO_INCREMENT,
  `nombre_rol` VARCHAR(45) NOT NULL,
  `descripcion` VARCHAR(255) DEFAULT NULL,
  PRIMARY KEY (`id_rol`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcado de datos para la tabla `roles`
INSERT INTO `roles` (`id_rol`, `nombre_rol`, `descripcion`) VALUES
(1, 'Administrador', 'Usuario con permisos completos'),
(2, 'Coordinador', 'Usuario con permisos limitados'),
(3, 'Funcionario', 'Usuario básico sin permisos especiales');

-- Estructura de tabla para `permisos`
CREATE TABLE `permisos` (
  `id_permiso` INT(11) NOT NULL AUTO_INCREMENT,
  `nombre_permiso` VARCHAR(45) NOT NULL,
  `descripcion` VARCHAR(255) DEFAULT NULL,
  PRIMARY KEY (`id_permiso`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcado de datos para la tabla `permisos`
INSERT INTO `permisos` (`id_permiso`, `nombre_permiso`, `descripcion`) VALUES
(1, 'Ver Radicados', 'Permite visualizar radicados'),
(2, 'Crear Radicado', 'Permite crear nuevos radicados'),
(3, 'Modificar Radicado', 'Permite modificar radicados existentes'),
(4, 'Eliminar Radicado', 'Permite eliminar radicados'),
(5, 'Gestionar Dependencias', 'Permite gestionar dependencias'),
(6, 'Gestionar Funcionario', 'Permite gestionar empleados');

-- Tabla intermedia para asignar roles a los funcionarios
CREATE TABLE `funcionario_roles` (
  `id_funcionario` INT(11) NOT NULL,
  `id_rol` INT(11) NOT NULL,
  PRIMARY KEY (`id_funcionario`, `id_rol`),
  CONSTRAINT `fk_funcionario` FOREIGN KEY (`id_funcionario`) REFERENCES `funcionario` (`id_funcionario`),
  CONSTRAINT `fk_rol` FOREIGN KEY (`id_rol`) REFERENCES `roles` (`id_rol`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Tabla intermedia para asignar permisos a los roles
CREATE TABLE `rol_permisos` (
  `id_rol` INT(11) NOT NULL,
  `id_permiso` INT(11) NOT NULL,
  PRIMARY KEY (`id_rol`, `id_permiso`),
  CONSTRAINT `fk_rol_permiso` FOREIGN KEY (`id_rol`) REFERENCES `roles` (`id_rol`),
  CONSTRAINT `fk_permiso` FOREIGN KEY (`id_permiso`) REFERENCES `permisos` (`id_permiso`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
