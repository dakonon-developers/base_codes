-- phpMyAdmin SQL Dump
-- version 4.2.12deb2+deb8u1build0.15.04.1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 27-01-2017 a las 10:13:30
-- Versión del servidor: 5.6.28-0ubuntu0.15.04.1
-- Versión de PHP: 5.6.4-4ubuntu6.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `calendar`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `calendar`
--

CREATE TABLE IF NOT EXISTS `calendar` (
`id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `events_topic_id` int(11) NOT NULL,
  `description` varchar(255) NOT NULL,
  `date` datetime DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `calendar`
--

INSERT INTO `calendar` (`id`, `user_id`, `events_topic_id`, `description`, `date`) VALUES
(1, 49, 1, 'DescripciÃ³n del evento uno', '2017-01-27 06:17:17'),
(2, 49, 2, 'Descripcion del pasado year', '2016-12-29 00:00:00'),
(3, 49, 3, 'Fista', '2017-03-02 00:00:00'),
(6, 49, 4, 'ReuniÃ³n de entrevista de trabajo.', '2017-01-28 04:45:00'),
(7, 49, 4, 'ReuniÃ³n de entrevista de trabajo.', '2017-01-29 04:45:00'),
(9, 49, 3, 'ReuniÃ³n de entrevista de trabajo.', '2017-01-29 04:45:00'),
(14, 49, 4, 'undefined', '2017-01-05 00:00:00'),
(17, 49, 4, 'undefined', '2017-02-01 00:00:00'),
(18, 49, 4, 'CumpleaÃ±os de Pablo Alejandro nÃºmero 24', '2017-01-29 00:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `events_topics`
--

CREATE TABLE IF NOT EXISTS `events_topics` (
`id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `events_topics`
--

INSERT INTO `events_topics` (`id`, `name`) VALUES
(1, 'Deportes'),
(2, 'Kids'),
(3, 'Trabajo'),
(4, 'Otros');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user`
--

CREATE TABLE IF NOT EXISTS `user` (
`id` int(11) NOT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `auth_token` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `genre` varchar(10) DEFAULT NULL,
  `username` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `user`
--

INSERT INTO `user` (`id`, `first_name`, `last_name`, `email`, `password`, `auth_token`, `address`, `genre`, `username`) VALUES
(49, 'Pablo', 'GonzÃ¡lez', 'pdonaire1@gmail.com', '$2y$12$80qXuqr8ZPZh/U3HDaamgeYl9/3odlmMMnwEEwqribs7a9hzU9.DC', 'e10b67795278cb45b008af75808ffbae', 'Santa Ana', 'M', 'pdonaire1'),
(50, 'PablÃ³', 'GonzÃ¡lez', 'pdonaire2@gmail.com', '$2y$12$TZG5q2gmbAffRTaBv9YSie3QrYpxgw.PBqOnqqJ.9vKInu0ksBJVi', '30a6877eab061aa8e679eb575468e522', 'Santa Ana', 'M', 'pdonaire2');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user_events_topic_colors`
--

CREATE TABLE IF NOT EXISTS `user_events_topic_colors` (
`id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `events_topic_id` int(11) NOT NULL,
  `color` varchar(20) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `user_events_topic_colors`
--

INSERT INTO `user_events_topic_colors` (`id`, `user_id`, `events_topic_id`, `color`) VALUES
(24, 49, 1, 'blue'),
(25, 49, 2, 'yellow'),
(26, 49, 3, 'orange'),
(27, 49, 4, 'green'),
(28, 50, 1, 'blue'),
(29, 50, 2, 'yellow'),
(30, 50, 3, 'orange'),
(31, 50, 4, 'green');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `calendar`
--
ALTER TABLE `calendar`
 ADD PRIMARY KEY (`id`), ADD KEY `user_id` (`user_id`,`events_topic_id`), ADD KEY `events_topic_id` (`events_topic_id`);

--
-- Indices de la tabla `events_topics`
--
ALTER TABLE `events_topics`
 ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `user`
--
ALTER TABLE `user`
 ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `user_events_topic_colors`
--
ALTER TABLE `user_events_topic_colors`
 ADD PRIMARY KEY (`id`), ADD KEY `user_id` (`user_id`,`events_topic_id`), ADD KEY `events_topic_id` (`events_topic_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `calendar`
--
ALTER TABLE `calendar`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT de la tabla `events_topics`
--
ALTER TABLE `events_topics`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT de la tabla `user`
--
ALTER TABLE `user`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=51;
--
-- AUTO_INCREMENT de la tabla `user_events_topic_colors`
--
ALTER TABLE `user_events_topic_colors`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=32;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `calendar`
--
ALTER TABLE `calendar`
ADD CONSTRAINT `calendar_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `user_events_topic_colors`
--
ALTER TABLE `user_events_topic_colors`
ADD CONSTRAINT `user_events_topic_colors_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `user_events_topic_colors_ibfk_2` FOREIGN KEY (`events_topic_id`) REFERENCES `events_topics` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
