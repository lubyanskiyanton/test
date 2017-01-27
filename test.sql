-- phpMyAdmin SQL Dump
-- version 4.2.12deb2+deb8u2
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Янв 27 2017 г., 13:45
-- Версия сервера: 5.5.53-0+deb8u1-log
-- Версия PHP: 5.6.27-0+deb8u1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `test`
--

-- --------------------------------------------------------

--
-- Структура таблицы `ipStat`
--

CREATE TABLE IF NOT EXISTS `ipStat` (
  `userId` int(11) NOT NULL,
  `action` text NOT NULL,
  `ip` text NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `ipStat`
--

INSERT INTO `ipStat` (`userId`, `action`, `ip`, `date`) VALUES
(13, 'registration', '192.168.10.10', '2017-01-27 08:56:23'),
(13, 'enter', '192.168.10.10', '2017-01-27 08:56:23'),
(14, 'registration', '192.168.10.111', '2017-01-27 08:56:50'),
(148, 'enter', '192.168.10.17', '2017-01-27 08:41:19'),
(211, 'registration', '192.168.10.17', '2017-01-27 08:41:19'),
(48, 'registration', '192.168.10.17', '2017-01-09 21:00:00'),
(98, 'registration', '192.168.10.17', '2017-01-27 08:44:45'),
(654, 'registration', '192.168.10.17', '2017-01-27 08:54:23'),
(99, 'enter', '192.168.10.17', '2017-01-27 08:54:51'),
(15, 'registration', '::1', '2017-01-27 09:29:21'),
(16, 'registration', '::1', '2017-01-27 09:30:42'),
(17, 'registration', '::1', '2017-01-27 09:32:23'),
(18, 'registration', '::1', '2017-01-27 09:41:30'),
(18, 'registration', '::1', '2017-01-27 09:42:04'),
(20, 'registration', '::1', '2017-01-27 09:49:18'),
(21, 'registration', '::1', '2017-01-27 09:59:38'),
(21, 'registration', '::1', '2017-01-27 10:05:26'),
(21, 'registration', '::1', '2017-01-27 10:12:33');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `lastName` text NOT NULL,
  `firstName` text NOT NULL,
  `date` date NOT NULL,
  `mobile` text NOT NULL,
  `email` text NOT NULL,
  `password` text NOT NULL,
`id` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`lastName`, `firstName`, `date`, `mobile`, `email`, `password`, `id`) VALUES
('Ivanov', 'Ivan', '2014-09-29', '+7-999-888-77-88', 'user1@mail.ru', '12345678', 13),
('Petrov', 'Petr', '2011-04-04', '+7-777-777-77-77', 'user2@mail.ru', '87654321', 14),
('Sidorov', 'Sidr', '2014-02-27', '+7-956-987-98-98', 'user3@mail.ru', '11111111', 15),
('qqqqqq', 'qqqq', '2017-01-03', '+7-988-888-99-77', 'aaaaa@aaa.aa', 'asdfasdfasdf', 20);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `id` (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=24;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
