-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 05-04-2025 a las 02:48:13
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
-- Base de datos: `transporte_optimizacion`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ciudades`
--

CREATE TABLE `ciudades` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ciudades`
--

INSERT INTO `ciudades` (`id`, `nombre`, `created_at`) VALUES
(1, 'La Paz', '2025-04-04 04:21:22'),
(2, 'Cochabamba', '2025-04-04 04:21:22'),
(3, 'Tarija', '2025-04-04 04:21:22');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `optimizaciones`
--

CREATE TABLE `optimizaciones` (
  `id` int(11) NOT NULL,
  `total_productos` int(11) NOT NULL,
  `fecha_calculo` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `optimizaciones`
--

INSERT INTO `optimizaciones` (`id`, `total_productos`, `fecha_calculo`) VALUES
(1, 1000, '2025-04-04 05:24:02'),
(2, 500, '2025-04-04 05:26:45'),
(3, 1500, '2025-04-04 05:34:46'),
(4, 100, '2025-04-04 05:37:43'),
(5, 1000, '2025-04-04 05:59:47'),
(6, 3000, '2025-04-04 06:02:20'),
(7, 1500, '2025-04-04 10:31:21'),
(8, 2000, '2025-04-04 11:45:29'),
(9, 500, '2025-04-04 11:58:04'),
(10, 1000, '2025-04-04 12:46:40');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `resultados_optimizacion`
--

CREATE TABLE `resultados_optimizacion` (
  `id` int(11) NOT NULL,
  `optimizacion_id` int(11) NOT NULL,
  `ruta_id` int(11) NOT NULL,
  `cantidad_productos` int(11) NOT NULL,
  `costo_total` decimal(15,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `resultados_optimizacion`
--

INSERT INTO `resultados_optimizacion` (`id`, `optimizacion_id`, `ruta_id`, `cantidad_productos`, `costo_total`) VALUES
(1, 1, 1, 1000, 15250000.00),
(2, 1, 2, 5000, 131250000.00),
(3, 1, 3, -5000, -87500000.00),
(4, 2, 1, 500, 7625000.00),
(5, 2, 2, 2500, 65625000.00),
(6, 2, 3, -2500, -43750000.00),
(7, 3, 1, 1500, 22875000.00),
(8, 3, 2, 7500, 196875000.00),
(9, 3, 3, -7500, -131250000.00),
(10, 4, 1, 100, 1525000.00),
(11, 4, 2, 500, 13125000.00),
(12, 4, 3, -500, -8750000.00),
(13, 5, 1, 1000, 15250000.00),
(14, 5, 1, 0, 0.00),
(15, 5, 2, 0, 0.00),
(16, 6, 1, 3000, 45750000.00),
(17, 6, 1, 0, 0.00),
(18, 6, 2, 0, 0.00),
(19, 7, 1, 1500, 22875000.00),
(20, 7, 1, 0, 0.00),
(21, 7, 2, 0, 0.00),
(22, 8, 1, 2000, 30500000.00),
(23, 8, 1, 0, 0.00),
(24, 8, 2, 0, 0.00),
(25, 9, 1, 500, 7625000.00),
(26, 9, 1, 0, 0.00),
(27, 9, 2, 0, 0.00),
(28, 10, 1, 1000, 15250000.00),
(29, 10, 1, 0, 0.00),
(30, 10, 2, 0, 0.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rutas`
--

CREATE TABLE `rutas` (
  `id` int(11) NOT NULL,
  `origen_id` int(11) NOT NULL,
  `destino_id` int(11) NOT NULL,
  `distancia` int(11) NOT NULL,
  `costo_km` decimal(10,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `rutas`
--

INSERT INTO `rutas` (`id`, `origen_id`, `destino_id`, `distancia`, `costo_km`, `created_at`) VALUES
(1, 1, 2, 610, 25.00, '2025-04-04 04:21:22'),
(2, 1, 3, 1050, 25.00, '2025-04-04 04:21:22'),
(3, 2, 3, 700, 25.00, '2025-04-04 04:21:22');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `ciudades`
--
ALTER TABLE `ciudades`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `optimizaciones`
--
ALTER TABLE `optimizaciones`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `resultados_optimizacion`
--
ALTER TABLE `resultados_optimizacion`
  ADD PRIMARY KEY (`id`),
  ADD KEY `optimizacion_id` (`optimizacion_id`),
  ADD KEY `ruta_id` (`ruta_id`);

--
-- Indices de la tabla `rutas`
--
ALTER TABLE `rutas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `origen_id` (`origen_id`),
  ADD KEY `destino_id` (`destino_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `ciudades`
--
ALTER TABLE `ciudades`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `optimizaciones`
--
ALTER TABLE `optimizaciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `resultados_optimizacion`
--
ALTER TABLE `resultados_optimizacion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT de la tabla `rutas`
--
ALTER TABLE `rutas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `resultados_optimizacion`
--
ALTER TABLE `resultados_optimizacion`
  ADD CONSTRAINT `resultados_optimizacion_ibfk_1` FOREIGN KEY (`optimizacion_id`) REFERENCES `optimizaciones` (`id`),
  ADD CONSTRAINT `resultados_optimizacion_ibfk_2` FOREIGN KEY (`ruta_id`) REFERENCES `rutas` (`id`);

--
-- Filtros para la tabla `rutas`
--
ALTER TABLE `rutas`
  ADD CONSTRAINT `rutas_ibfk_1` FOREIGN KEY (`origen_id`) REFERENCES `ciudades` (`id`),
  ADD CONSTRAINT `rutas_ibfk_2` FOREIGN KEY (`destino_id`) REFERENCES `ciudades` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
