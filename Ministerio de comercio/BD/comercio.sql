-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 24-10-2023 a las 07:44:56
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `comercio`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `flujo`
--

CREATE TABLE `flujo` (
  `id` int(11) NOT NULL,
  `tipo` enum('importacion','exportacion') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `flujo`
--

INSERT INTO `flujo` (`id`, `tipo`) VALUES
(1, 'importacion'),
(2, 'exportacion');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `paises`
--

CREATE TABLE `paises` (
  `id` int(11) NOT NULL,
  `nombre_pais` varchar(50) NOT NULL,
  `tipo_relacion` varchar(250) DEFAULT NULL,
  `fecha_relacion` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `paises`
--

INSERT INTO `paises` (`id`, `nombre_pais`, `tipo_relacion`, `fecha_relacion`) VALUES
(1, 'China', 'Tratado de Libre Comercio', '2009-01-01'),
(2, 'Brasil', 'Cooperación en defensa, energía e infraestructura', '2010-02-01'),
(3, 'Japón', 'Acuerdo de Asociación Económica', '2011-01-01'),
(4, 'España', 'Relaciones culturales y diplomáticas', '2012-01-02');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `flujo_id` int(11) DEFAULT NULL,
  `pais_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `nombre`, `descripcion`, `flujo_id`, `pais_id`) VALUES
(1, 'Oro', 'El paquete ira a Brasil', 1, 2),
(2, 'Mineral de zinc', 'Este cargamento va a España', 2, 4),
(3, 'Frutas tropicales', 'El paquete va a China', 2, 1),
(4, 'Café ', 'paquete que viene desde Japón', 1, 3),
(5, 'Fosfato y cobre', 'paquete que va a Brasil', 2, 2),
(6, 'Plomo', 'Este cargamento va a Japón', 2, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre_usuario` varchar(50) NOT NULL,
  `contraseña` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre_usuario`, `contraseña`) VALUES
(1, 'administrador', '$2y$10$JG4vesSPNabyLrH98HUfCOSyy9bwKJ.qpnfZrgMoZoVknUElaBD9W'),
(2, 'general', '$2y$10$f5qXIvw2Jr9Znx8UiXdrDuA2ZEmhS/ppph8GoTPDZFaKKAQYz7K4q');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `flujo`
--
ALTER TABLE `flujo`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `paises`
--
ALTER TABLE `paises`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_producto_flujo` (`flujo_id`),
  ADD KEY `fk_producto_pais` (`pais_id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `flujo`
--
ALTER TABLE `flujo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `paises`
--
ALTER TABLE `paises`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `fk_producto_flujo` FOREIGN KEY (`flujo_id`) REFERENCES `flujo` (`id`),
  ADD CONSTRAINT `fk_producto_pais` FOREIGN KEY (`pais_id`) REFERENCES `paises` (`id`),
  ADD CONSTRAINT `productos_ibfk_1` FOREIGN KEY (`flujo_id`) REFERENCES `flujo` (`id`),
  ADD CONSTRAINT `productos_ibfk_2` FOREIGN KEY (`pais_id`) REFERENCES `paises` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
