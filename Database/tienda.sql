-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 01-03-2025 a las 23:03:10
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
-- Base de datos: `tienda`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id` int(255) NOT NULL,
  `nombre` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id`, `nombre`) VALUES
(1, 'Coches'),
(2, 'Motos'),
(3, 'SUV'),
(4, 'Deportivo'),
(11, 'Sedán');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lineas_pedidos`
--

CREATE TABLE `lineas_pedidos` (
  `id` int(255) NOT NULL,
  `pedido_id` int(255) NOT NULL,
  `producto_id` int(255) NOT NULL,
  `unidades` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Volcado de datos para la tabla `lineas_pedidos`
--

INSERT INTO `lineas_pedidos` (`id`, `pedido_id`, `producto_id`, `unidades`) VALUES
(6, 68, 5, 1),
(7, 69, 5, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE `pedidos` (
  `id` int(255) NOT NULL,
  `usuario_id` int(255) NOT NULL,
  `provincia` varchar(100) NOT NULL,
  `localidad` varchar(100) NOT NULL,
  `direccion` varchar(255) NOT NULL,
  `coste` float(200,2) NOT NULL,
  `estado` varchar(20) NOT NULL,
  `fecha` date DEFAULT NULL,
  `hora` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Volcado de datos para la tabla `pedidos`
--

INSERT INTO `pedidos` (`id`, `usuario_id`, `provincia`, `localidad`, `direccion`, `coste`, `estado`, `fecha`, `hora`) VALUES
(68, 10, 'Córdoba', 'Iznájar', 'Puente Señá Emilia 2', 1.00, 'Enviado', '2025-03-01', '17:18:10'),
(69, 10, 'Granada', 'Granada', 'Calle Ribera del Genil, 19, 1ºC', 1.00, 'Enviado', '2025-03-01', '20:50:52');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` int(255) NOT NULL,
  `categoria_id` int(255) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `precio` float(100,2) NOT NULL,
  `stock` int(255) NOT NULL,
  `oferta` varchar(2) DEFAULT NULL,
  `fecha` date NOT NULL,
  `imagen` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `categoria_id`, `nombre`, `descripcion`, `precio`, `stock`, `oferta`, `fecha`, `imagen`) VALUES
(2, 1, 'BMW M8 Competition', 'Motor de gasolina M TwinPower Turbo de V8 cilindros de alto rendimiento de 460 kW (625 CV)', 218650.00, 1, '0', '2025-02-25', 'm8Competition.jpg'),
(4, 2, 'S1000RR', 'Motor de cuatro tiempos y cuatro cilindros en línea, refrigerado por agua/aceite', 23850.00, 3, '0', '2025-02-25', 's1000rr.jpg'),
(5, 1, 'Audi RS7', 'El Audi RS 7 Sportback performance es un deportivo Gran Turismo que ofrece un rendimiento excepcional, las mejores prestaciones y una tecnología innovadora.', 1.00, 5, '0', '2025-02-25', 'rs7.jpg'),
(6, 2, 'Kawasaki Ninja H2R', 'Para los entusiastas de la velocidad, la Kawasaki Ninja H2R del 2022 ofrece un motor sobrealimentado de 998 cm³ con una impresionante potencia de 310 CV.', 55000.00, 2, '0', '2025-02-25', 'ninjah2r.jpg'),
(7, 1, 'Mitsubishi Lancer Evo IV', 'MITSUBISHI LANCER EVOLUTION 9 ULTIMATE 2.0 TURBO 4x4 CON ELECTRÓNICA 350CV', 64000.00, 1, '0', '2025-02-25', 'evo9.jpg'),
(12, 1, 'Mercedes G63 Brabus', 'El Mercedes más bonito del mundooo', 400000.00, 2, '0', '2025-02-25', 'g63Brabus.jpg'),
(13, 1, 'Alfa Romeo Giulia Quadrifoglio', 'La tecnología de vanguardia impulsa la impactante belleza del Alfa Romeo Giulia Quadrifoglio, ofreciendo un rendimiento asombroso con todo el estilo italiano.', 106480.00, 2, '0', '2025-02-25', 'giulia.jpg'),
(15, 2, 'Ducati Panigale V4', 'La maravilla es la sensación inmediata e intensa que uno experimenta al mirar y montar esta magnífica creación. Una maravilla mágica e irracional, lograda gracias a la increíble brillantez y dedicación de Ducati. En la saga épica de las superbikes de Ducati, la nueva Panigale V4 representa la séptima generación, una síntesis de diseño y tecnología.', 31590.00, 4, '0', '2025-02-25', 'panigale.jpg\r\n'),
(16, 2, 'Honda CBR1000RR-R Fireblade', 'Por eso corremos. Por eso siempre hemos competido, y son las opiniones de HRC y de nuestros pilotos las que han dado lugar a la nueva CBR1000RR-R Fireblade. Tiene más potencia en el rango medio gracias a las mejoras en la admisión y la culata, con relaciones de cambio revisadas para una salida de curva increíble.', 25000.00, 3, '0', '2025-02-27', '67c0b97218926_cbr1000rr.jpg'),
(27, 4, 'Porsche 911 GT3 RS', 'Los atletas lo saben: el máximo rendimiento requiere algo más que unas condiciones físicas inmejorables e incluso más que el factor “suerte”. El factor realmente decisivo es la voluntad, sin condicionamiento alguno, de ser más rápido y más fuerte con cada sesión de entrenamiento.', 286470.00, 2, '0', '2025-03-01', 'porsche911.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(255) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `apellidos` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `rol` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `apellidos`, `email`, `password`, `rol`) VALUES
(1, 'Raúl', 'Pacheco Ropero', 'raulpachecoropero@gmail.com', '$2y$04$Y5CD/uGpN5TZ9ZR3rifsFuLl5VcmXWEw9UCAP59iXFLQPV4KERGHS', 'admin'),
(3, 'Pepe', 'Pepeeeeeee', 'pepe@gmail.com', '$2y$04$e85gVYtgcwhCb2p50r4rc.bk/mIgnJdfHpZnV4koFs1m0Aw82aFqW', 'user'),
(10, 'Raúl', 'Pacheco Ropero', 'raulpachecoropero555@gmail.com', '$2y$04$0jZMWxGfH.q04LRf6n05dO7M3Cp92nXOxQ0CGfwOGfuZQmWKmiNTq', 'user');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `lineas_pedidos`
--
ALTER TABLE `lineas_pedidos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_linea_pedido` (`pedido_id`),
  ADD KEY `fk_linea_producto` (`producto_id`);

--
-- Indices de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_pedido_usuario` (`usuario_id`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_producto_categoria` (`categoria_id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_email` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT de la tabla `lineas_pedidos`
--
ALTER TABLE `lineas_pedidos`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `lineas_pedidos`
--
ALTER TABLE `lineas_pedidos`
  ADD CONSTRAINT `fk_linea_pedido` FOREIGN KEY (`pedido_id`) REFERENCES `pedidos` (`id`),
  ADD CONSTRAINT `fk_linea_producto` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`);

--
-- Filtros para la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD CONSTRAINT `fk_pedido_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`);

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `fk_producto_categoria` FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
