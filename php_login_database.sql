-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 14-02-2019 a las 00:29:07
-- Versión del servidor: 10.1.37-MariaDB
-- Versión de PHP: 7.3.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `php_login_database`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `account_role`
--

CREATE TABLE `account_role` (
  `id_role` int(2) NOT NULL,
  `role_name` varchar(20) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `account_role`
--

INSERT INTO `account_role` (`id_role`, `role_name`) VALUES
(1, 'Super Admin'),
(2, 'Admin'),
(3, 'Base_user');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `question_catalogue`
--

CREATE TABLE `question_catalogue` (
  `id_question` int(11) NOT NULL,
  `Question` varchar(200) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `question_catalogue`
--

INSERT INTO `question_catalogue` (`id_question`, `Question`) VALUES
(1, 'Name of your best friend'),
(2, 'Name of your favorite pet'),
(3, 'Name of your first place of work');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `lastname` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `question_number` int(5) DEFAULT NULL,
  `question_answer` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `id_role` int(2) NOT NULL DEFAULT '3'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `name`, `lastname`, `question_number`, `question_answer`, `id_role`) VALUES
(4, 'juan@hotmail.com', '$2y$10$pjxsxHlfTvS87TkFq0G8zus7TvxXF5ZoMIc5.xenxhrb6jMZTpWay', 'Juan', 'Bertozzi', 3, 'nada', 1),
(5, 'ale@hotmail.com', '$2y$10$aA03ygvsN9QmiOMSKRd3w.6HzJMMDEwq1Br3VgeE2okn48HBoDnUa', 'Alejandro', 'Bertozzi', 3, 'adidas', 3),
(6, 'gabo@hotmail.com', '$2y$10$wmsHA7NrAYh9tksaxDBgWeF90YFxsd92ddvl5ZDi3n6zCjgrBdVRa', 'gabriel', 'Perez', 3, 'sykes', 2),
(7, 'dani@hotmail.com', '$2y$10$HyNtudfqsfLLBqPWwKFrpOgI1wWWxSZ8ERVFhFUi6LnF/qz2UiJVC', 'Daniela', 'Solano', 1, 'alejandro', 3),
(8, 'carlos@hotmail.com', '$2y$10$dArp0I9leFvXZuNsCtnb0.FjtJnEGUUJg/66pQNGfCDB3fUnSpk4m', 'carlos', 'Madrigal', 1, 'alejandro', 3),
(9, 'felipe@hotmail.com', '$2y$10$H4NKXfiQkFWM7Y2NobCDK.s8VnlOAYi5P6LLsG67F8OBwDn/.S1N6', 'Felipe', 'Ovares', 1, 'kevin', 3),
(11, 'fpm@gmail.com', '$2y$10$lLcXBSWh1fPfba1VbvkjpeTJL0v1/PVAMmucZSzKNe9/IP4DliYY2', 'Felmast', 'Pro', 2, 'Coffee', 3),
(12, 'kbacon@outlook.com', '$2y$10$2rlJBmAAOjVUMsb2Unoi9uBE9hZqk3apZ6QxLKGnhhInwzxf67jOy', 'Kevin', 'Bacon', 1, 'hola', 3),
(13, 'juan@hotmail.com', '$2y$10$pjxsxHlfTvS87TkFq0G8zus7TvxXF5ZoMIc5.xenxhrb6jMZTpWay', 'Juan', 'Bertozzi', 2, 'Firulais', 3),
(14, 'juan1@hotmail.com', '$2y$10$enMaBTWsHjvgLTcROaXFoOh4BfIS5CXTmlfjvZVzZ9vswWSL0UR76', 'Juan', 'Bertozzi', 3, 'xcape', 3);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `account_role`
--
ALTER TABLE `account_role`
  ADD PRIMARY KEY (`id_role`);

--
-- Indices de la tabla `question_catalogue`
--
ALTER TABLE `question_catalogue`
  ADD PRIMARY KEY (`id_question`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `Users_account_role_fk` (`id_role`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `account_role`
--
ALTER TABLE `account_role`
  MODIFY `id_role` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `question_catalogue`
--
ALTER TABLE `question_catalogue`
  MODIFY `id_question` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `Users_account_role_fk` FOREIGN KEY (`id_role`) REFERENCES `account_role` (`id_role`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
