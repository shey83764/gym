-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 23-04-2025 a las 03:09:57
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `gimnasio`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clases`
--

CREATE TABLE `clases` (
  `id_clases` int(10) NOT NULL,
  `nombre` varchar(20) NOT NULL,
  `hora` time(6) NOT NULL,
  `cupo_max` int(10) NOT NULL,
  `fecha` date NOT NULL,
  `id_entrenador` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `clases`
--

INSERT INTO `clases` (`id_clases`, `nombre`, `hora`, `cupo_max`, `fecha`, `id_entrenador`) VALUES
(1, 'pilates', '11:00:00.000000', 22, '2025-04-18', 0),
(2, 'fulano', '09:00:00.000000', 33, '2025-04-17', 0),
(3, 'fulano', '09:00:00.000000', 33, '2025-04-17', 0),
(8, 'ss', '16:00:00.000000', 22, '2025-04-18', 0),
(9, 'ss', '16:00:00.000000', 22, '2025-04-18', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `id_cliente` int(11) NOT NULL,
  `nombre` varchar(20) DEFAULT NULL,
  `apellido` varchar(20) DEFAULT NULL,
  `telefono` varchar(10) NOT NULL,
  `DNI` varchar(20) NOT NULL,
  `fecha` date NOT NULL,
  `hora` time(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`id_cliente`, `nombre`, `apellido`, `telefono`, `DNI`, `fecha`, `hora`) VALUES
(7, 'sheyla', 'Perez', '1125636765', '32432432    ', '2025-04-23', '11:00:00.00000'),
(8, 'sss', 'ssss', '1125636765', '21.233.444', '2025-04-24', '00:00:00.00000'),
(9, 'sss', 'ssss', '1125636765', '21.233.444', '2025-04-24', '00:00:00.00000'),
(10, 'fulano', 'ssss', '1125636765', '1231', '2025-04-26', '00:00:00.00000'),
(11, 'sheyla', 'ssss', '1125636765', '23.343.555', '2025-04-24', '00:00:00.00000');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleados`
--

CREATE TABLE `empleados` (
  `id_entrenador` int(10) NOT NULL,
  `nombre` varchar(20) NOT NULL,
  `apellido` varchar(20) NOT NULL,
  `dni` varchar(10) NOT NULL,
  `puesto` varchar(20) NOT NULL,
  `telefono` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `empleados`
--

INSERT INTO `empleados` (`id_entrenador`, `nombre`, `apellido`, `dni`, `puesto`, `telefono`) VALUES
(0, 'sss', 'dsfsdf', '24738341', '', '2342342');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inscripciones`
--

CREATE TABLE `inscripciones` (
  `id_inscrip` int(10) NOT NULL,
  `fecha` date NOT NULL,
  `DNI` varchar(10) NOT NULL,
  `nombre` varchar(20) NOT NULL,
  `apellido` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `inscripciones`
--

INSERT INTO `inscripciones` (`id_inscrip`, `fecha`, `DNI`, `nombre`, `apellido`) VALUES
(1, '2025-04-16', '342422', 'sheyla', 'Perez'),
(2, '2025-04-25', '525624564', 'fulano', 'ssss'),
(3, '2025-04-30', '5448748', 'sssss', 'sss');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inter_clas_emp`
--

CREATE TABLE `inter_clas_emp` (
  `id` int(10) NOT NULL,
  `id_clase` int(10) NOT NULL,
  `id_emple` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `membresia`
--

CREATE TABLE `membresia` (
  `id_membresia` int(10) NOT NULL,
  `tipo_membre` varchar(20) NOT NULL,
  `precio` varchar(20) NOT NULL,
  `telefono` varchar(10) NOT NULL,
  `nombre` varchar(20) NOT NULL,
  `apellido` varchar(20) NOT NULL,
  `DNi` int(10) NOT NULL,
  `id_inscrip` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pago`
--

CREATE TABLE `pago` (
  `id_pago` int(10) NOT NULL,
  `monto_pago` varchar(20) NOT NULL,
  `metodo_pago` varchar(20) NOT NULL,
  `nombre` varchar(20) NOT NULL,
  `apellido` varchar(20) NOT NULL,
  `dni` int(20) NOT NULL,
  `id_cliente` int(10) NOT NULL,
  `id_membresia` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `clases`
--
ALTER TABLE `clases`
  ADD PRIMARY KEY (`id_clases`),
  ADD KEY `id_entrenador` (`id_entrenador`);

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id_cliente`);

--
-- Indices de la tabla `empleados`
--
ALTER TABLE `empleados`
  ADD PRIMARY KEY (`id_entrenador`);

--
-- Indices de la tabla `inscripciones`
--
ALTER TABLE `inscripciones`
  ADD PRIMARY KEY (`id_inscrip`);

--
-- Indices de la tabla `inter_clas_emp`
--
ALTER TABLE `inter_clas_emp`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_clase` (`id_clase`),
  ADD KEY `id_inscrip` (`id_emple`),
  ADD KEY `id_emple` (`id_emple`);

--
-- Indices de la tabla `membresia`
--
ALTER TABLE `membresia`
  ADD PRIMARY KEY (`id_membresia`),
  ADD KEY `id_inscrip` (`id_inscrip`);

--
-- Indices de la tabla `pago`
--
ALTER TABLE `pago`
  ADD PRIMARY KEY (`id_pago`),
  ADD KEY `id_cliente` (`id_cliente`),
  ADD KEY `id_membresia` (`id_membresia`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `clases`
--
ALTER TABLE `clases`
  MODIFY `id_clases` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id_cliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `inscripciones`
--
ALTER TABLE `inscripciones`
  MODIFY `id_inscrip` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `inter_clas_emp`
--
ALTER TABLE `inter_clas_emp`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `membresia`
--
ALTER TABLE `membresia`
  MODIFY `id_membresia` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `pago`
--
ALTER TABLE `pago`
  MODIFY `id_pago` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `inter_clas_emp`
--
ALTER TABLE `inter_clas_emp`
  ADD CONSTRAINT `inter_clas_emp_ibfk_1` FOREIGN KEY (`id_clase`) REFERENCES `clases` (`id_clases`),
  ADD CONSTRAINT `inter_clas_emp_ibfk_2` FOREIGN KEY (`id_emple`) REFERENCES `empleados` (`id_entrenador`);

--
-- Filtros para la tabla `membresia`
--
ALTER TABLE `membresia`
  ADD CONSTRAINT `membresia_ibfk_1` FOREIGN KEY (`id_inscrip`) REFERENCES `inscripciones` (`id_inscrip`);

--
-- Filtros para la tabla `pago`
--
ALTER TABLE `pago`
  ADD CONSTRAINT `pago_ibfk_1` FOREIGN KEY (`id_cliente`) REFERENCES `clientes` (`id_cliente`),
  ADD CONSTRAINT `pago_ibfk_2` FOREIGN KEY (`id_membresia`) REFERENCES `membresia` (`id_membresia`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
