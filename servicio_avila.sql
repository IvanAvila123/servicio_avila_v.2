-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 03-07-2023 a las 03:11:37
-- Versión del servidor: 10.4.27-MariaDB
-- Versión de PHP: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `servicio_avila`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `apellido` varchar(100) NOT NULL,
  `telefono` varchar(100) NOT NULL,
  `domicilio` varchar(1000) NOT NULL,
  `estatus` enum('completado','pendiente','cancelado') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`id`, `nombre`, `apellido`, `telefono`, `domicilio`, `estatus`) VALUES
(2, 'Jesus Axel', 'Avila Rodriguez', '567894521', 'Calle Saturno 304,Iztapala,CDMX,CDMX,45632', 'cancelado'),
(3, 'Jorge', 'Rodriguez', '5874899565', 'sgswhhjjfrj', 'completado'),
(4, 'JESUS ALEXANDER', 'CRUZ', '5610725206', 'rkktktkng', 'cancelado'),
(6, 'MARIA DEL REFUGIO', 'TORRES VALDEZ', '9999999999', 'Calle Saturno 304,Iztapala,CDMX,CDMX,45632', 'cancelado'),
(8, 'JESUS LEOPOLDO', 'Ramirez', '5610725206', 'gogogogog pussy #69', 'pendiente');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle`
--

CREATE TABLE `detalle` (
  `id` int(11) NOT NULL,
  `equipo` varchar(200) NOT NULL,
  `problema` varchar(200) NOT NULL,
  `refacciones` varchar(200) NOT NULL,
  `fecha` date NOT NULL,
  `observacion` varchar(500) NOT NULL,
  `costo` mediumtext NOT NULL,
  `nombre` varchar(500) NOT NULL,
  `pdf` varchar(500) NOT NULL,
  `estatus` enum('completado','pendiente','cancelado') NOT NULL,
  `id_cliente` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `detalle`
--

INSERT INTO `detalle` (`id`, `equipo`, `problema`, `refacciones`, `fecha`, `observacion`, `costo`, `nombre`, `pdf`, `estatus`, `id_cliente`) VALUES
(1, 'Lavadora Samsung 18 KG', 'No lava, no exprime', 'Transmicion, agitador y Motor', '2023-06-12', 'El Cliente Dejo Un anticipo de $1200 MXN', '$4000', '', '', 'pendiente', 2),
(2, 'Lavadora Whirlpool 30KG', 'No Desagua', 'Bomba', '2023-05-11', 'El cliente dio un anticipo de $500', '$1500', '', '', 'completado', 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `apellido` varchar(100) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `telefono` varchar(15) NOT NULL,
  `perfil` varchar(100) DEFAULT NULL,
  `clave` varchar(200) NOT NULL,
  `token` int(100) DEFAULT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `estado` int(11) NOT NULL DEFAULT 1,
  `rol` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `apellido`, `correo`, `telefono`, `perfil`, `clave`, `token`, `fecha`, `estado`, `rol`) VALUES
(1, 'Jesus ', 'Avila', 'jesus_avilad@gmail.com', '56202478456', NULL, '$2y$10$9tP7m027ZwS.rkYdUi7kBO2zvDIby0u.gIwKrNECGGtxZRm9.qw5i', NULL, '2023-03-28 00:52:13', 1, 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `detalle`
--
ALTER TABLE `detalle`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_cliente` (`id_cliente`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `detalle`
--
ALTER TABLE `detalle`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `detalle`
--
ALTER TABLE `detalle`
  ADD CONSTRAINT `detalle_ibfk_1` FOREIGN KEY (`id_cliente`) REFERENCES `clientes` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
