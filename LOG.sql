-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Хост: localhost
-- Время создания: Дек 07 2017 г., 13:57
-- Версия сервера: 5.5.57-0ubuntu0.14.04.1
-- Версия PHP: 7.1.9-1+ubuntu14.04.1+deb.sury.org+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `LOG`
--

-- --------------------------------------------------------

--
-- Структура таблицы `registry`
--

DROP TABLE IF EXISTS `registry`;
CREATE TABLE `registry` (
  `id` int(11) NOT NULL,
  `name` varchar(90) CHARACTER SET utf8 NOT NULL,
  `number` varchar(50) CHARACTER SET utf8 NOT NULL,
  `date` date NOT NULL,
  `area` varchar(50) CHARACTER SET utf8 NOT NULL,
  `organization` varchar(70) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- --------------------------------------------------------

--
-- Структура таблицы `registry_log`
--

DROP TABLE IF EXISTS `registry_log`;
CREATE TABLE `registry_log` (
  `id` int(11) NOT NULL,
  `name` varchar(90) CHARACTER SET utf8 NOT NULL,
  `number` varchar(50) CHARACTER SET utf8 NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


--
-- Индексы таблицы `registry`
--
ALTER TABLE `registry`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_2` (`id`),
  ADD UNIQUE KEY `number` (`number`),
  ADD KEY `id` (`id`);

--
-- Индексы таблицы `registry_log`
--
ALTER TABLE `registry_log`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `registry`
--
ALTER TABLE `registry`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT для таблицы `registry_log`
--
ALTER TABLE `registry_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
