-- phpMyAdmin SQL Dump
-- version 4.0.10.10
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1:3306
-- Время создания: Апр 01 2017 г., 04:13
-- Версия сервера: 5.5.45
-- Версия PHP: 5.6.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `zend_dz`
--

-- --------------------------------------------------------

--
-- Структура таблицы `history`
--

CREATE TABLE IF NOT EXISTS `history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` datetime NOT NULL,
  `ip` varchar(100) NOT NULL,
  `id_user` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=64 ;

--
-- Дамп данных таблицы `history`
--

INSERT INTO `history` (`id`, `date`, `ip`, `id_user`) VALUES
(1, '2017-03-02 00:00:00', '87.76.238.176\r\n', 15),
(2, '2017-03-08 00:00:00', '87.76.238.176\r\n', 15),
(3, '2017-03-14 00:00:00', '92.76.238.176\r\n', 1),
(4, '2017-03-02 00:00:00', '57.76.238.176\r\n', 15),
(5, '2017-04-01 12:12:53', '127.0.0.1', 15),
(6, '2017-04-01 12:13:19', '127.0.0.1', 15),
(7, '2017-04-01 12:14:57', '127.0.0.1', 38),
(8, '2017-04-01 12:15:14', '127.0.0.1', 15),
(9, '2017-04-01 12:16:33', '127.0.0.1', 15),
(10, '2017-04-01 12:16:47', '127.0.0.1', 15),
(11, '2017-04-01 12:17:39', '127.0.0.1', 38),
(12, '2017-04-01 12:20:58', '127.0.0.1', 15),
(13, '2017-04-01 12:30:38', '127.0.0.1', 15),
(14, '2017-04-01 12:31:13', '127.0.0.1', 15),
(15, '2017-04-01 12:33:06', '127.0.0.1', 38),
(16, '2017-04-01 12:33:16', '127.0.0.1', 15),
(17, '2017-04-01 12:39:54', '127.0.0.1', 15),
(18, '2017-04-01 12:40:52', '127.0.0.1', 15),
(19, '2017-04-01 12:41:28', '127.0.0.1', 15),
(20, '2017-04-01 12:41:41', '127.0.0.1', 38),
(21, '2017-04-01 12:42:30', '127.0.0.1', 15),
(22, '2017-04-01 12:42:44', '127.0.0.1', 15),
(23, '2017-04-01 12:42:51', '127.0.0.1', 38),
(24, '2017-04-01 12:44:51', '127.0.0.1', 15),
(25, '2017-04-01 12:47:53', '127.0.0.1', 15),
(26, '2017-04-01 01:05:33', '127.0.0.1', 15),
(27, '2017-04-01 01:06:03', '127.0.0.1', 39),
(28, '2017-04-01 01:20:10', '127.0.0.1', 39),
(29, '2017-04-01 01:20:30', '127.0.0.1', 39),
(30, '2017-04-01 01:20:47', '127.0.0.1', 15),
(31, '2017-04-01 01:20:53', '127.0.0.1', 39),
(32, '2017-04-01 01:21:21', '127.0.0.1', 39),
(33, '2017-04-01 01:21:43', '127.0.0.1', 39),
(34, '2017-04-01 01:22:34', '127.0.0.1', 39),
(35, '2017-04-01 01:33:09', '127.0.0.1', 39),
(36, '2017-04-01 01:35:21', '127.0.0.1', 39),
(37, '2017-04-01 01:35:42', '127.0.0.1', 39),
(38, '2017-04-01 01:35:50', '127.0.0.1', 39),
(39, '2017-04-01 01:36:22', '127.0.0.1', 39),
(40, '2017-04-01 01:36:44', '127.0.0.1', 15),
(41, '2017-04-01 01:36:54', '127.0.0.1', 39),
(42, '2017-04-01 01:38:54', '127.0.0.1', 39),
(43, '2017-04-01 01:39:11', '127.0.0.1', 39),
(44, '2017-04-01 01:40:11', '127.0.0.1', 39),
(45, '2017-04-01 01:40:20', '127.0.0.1', 39),
(46, '2017-04-01 01:41:30', '127.0.0.1', 39),
(47, '2017-04-01 01:41:36', '127.0.0.1', 39),
(48, '2017-04-01 01:43:25', '127.0.0.1', 39),
(49, '2017-04-01 01:43:29', '127.0.0.1', 39),
(50, '2017-04-01 01:44:20', '127.0.0.1', 39),
(51, '2017-04-01 01:44:25', '127.0.0.1', 39),
(52, '2017-04-01 01:45:04', '127.0.0.1', 39),
(53, '2017-04-01 01:45:23', '127.0.0.1', 39),
(54, '2017-04-01 01:46:09', '127.0.0.1', 39),
(55, '2017-04-01 01:46:45', '127.0.0.1', 39),
(56, '2017-04-01 01:49:57', '127.0.0.1', 39),
(57, '2017-04-01 01:51:36', '127.0.0.1', 39),
(58, '2017-04-01 01:52:10', '127.0.0.1', 39),
(59, '2017-04-01 01:54:23', '127.0.0.1', 39),
(60, '2017-04-01 01:57:44', '127.0.0.1', 15),
(61, '2017-04-01 03:43:22', '127.0.0.1', 41),
(62, '2017-04-01 03:43:34', '127.0.0.1', 15),
(63, '2017-04-01 03:50:03', '127.0.0.1', 15);

-- --------------------------------------------------------

--
-- Структура таблицы `resources`
--

CREATE TABLE IF NOT EXISTS `resources` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `resource_name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=17 ;

--
-- Дамп данных таблицы `resources`
--

INSERT INTO `resources` (`id`, `resource_name`) VALUES
(1, 'access/page-one'),
(4, 'access/page-two'),
(5, 'access/page-tree'),
(6, 'home'),
(7, 'user/auth'),
(8, 'access/default'),
(9, 'user/default'),
(10, 'user/input'),
(11, 'user/registration'),
(13, 'user/history'),
(14, 'user/edit'),
(15, 'user/activation-link'),
(16, 'administer/default');

-- --------------------------------------------------------

--
-- Структура таблицы `role`
--

CREATE TABLE IF NOT EXISTS `role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Дамп данных таблицы `role`
--

INSERT INTO `role` (`id`, `role_name`) VALUES
(3, 'admin'),
(4, 'guest');

-- --------------------------------------------------------

--
-- Структура таблицы `role_access`
--

CREATE TABLE IF NOT EXISTS `role_access` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_role` int(11) NOT NULL,
  `id_resource` int(11) NOT NULL,
  `access` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=27 ;

--
-- Дамп данных таблицы `role_access`
--

INSERT INTO `role_access` (`id`, `id_role`, `id_resource`, `access`) VALUES
(1, 3, 1, 0),
(2, 4, 5, 0),
(5, 3, 5, 1),
(6, 4, 1, 0),
(7, 3, 4, 0),
(8, 3, 8, 1),
(9, 4, 7, 1),
(10, 4, 6, 1),
(11, 3, 7, 1),
(12, 4, 4, 1),
(13, 3, 6, 1),
(14, 3, 9, 1),
(15, 3, 10, 1),
(16, 4, 10, 1),
(17, 4, 11, 1),
(20, 4, 13, 1),
(21, 4, 14, 1),
(22, 3, 13, 1),
(23, 3, 14, 1),
(24, 3, 15, 1),
(25, 4, 15, 1),
(26, 3, 16, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `login` varchar(100) NOT NULL,
  `password` varchar(120) NOT NULL,
  `role` varchar(100) NOT NULL DEFAULT 'guest',
  `active` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=43 ;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `email`, `login`, `password`, `role`, `active`) VALUES
(7, 'авыаы', 'фысяч', 'счясва', 'guest', 1),
(8, 'чясячс', 'ыфався', 'чсячмвыавыф', 'guest', 1),
(14, 'qwe', 'qwe', 'qwe', 'admin', 1),
(15, 'qqq@sdsd.vom', 'qqqqqq', 'qqqqqq', 'admin', 1),
(16, 'qqqqqqqqqqqqqqqqqqq@DFG', 'qqqqqqqq', 'qqqqqqqqqqq', 'guest', 1),
(23, 'qqqqqq@asdsq', 'qqqqqqqqqqqqqqqqqq', 'qqqqqqqqqqq', 'guest', 1),
(24, 'qqqqqq@asdsq', 'qqqqqqqqqqqqqqqqqqq', 'qqqqqqqqqqq', 'guest', 1),
(25, 'qqqqqq@asdsq', 'qqqqqqqqqqqqqqqqqqqq', 'qqqqqqqqqqq', 'guest', 1),
(26, 'qqqqqq@asdsqq', 'qqqqqqqqqqqqqqqqqqqqqqq', 'qqqqqqqqqqqq', 'guest', 1),
(27, 'qqqqqq@asdsqq', 'qqqqqqqqqqqqqqqqqqqqqqqq', 'qqqqqqqqqqq', 'guest', 1),
(29, 'qqqqqq@asdsq', 'qqqqqqqqs', 'qqqqqq', 'guest', 0),
(30, 'qqqqqq@asdsq', 'dsfdqqqq', 'qqqqqq', 'guest', 0),
(31, 'qqqqqq@asdsq', 'dsfdqqqqq', 'qqqqqq', 'guest', 0),
(32, 'qqqqqq@asdsq', 'dsfdqqqqqq', 'qqqqqq', 'guest', 0),
(33, 'qqqqqq@asdsqq', 'qwwwwwwwwwwwwwwwww', 'qqqqqqqqqqq', 'guest', 0),
(34, 'qqq@sdsd.vom', 'qqqqqqqwe', 'qqqqqq', 'guest', 0),
(35, 'qqq@sdsd.vom', 'qqqqqqqwer', 'qqqqqq', 'guest', 0),
(36, 'qqq@sdsd.vom', 'ddddddddddddddddd', 'qqqqqqqqqqq', 'guest', 0),
(37, 'qqq@sdsd.vom', 'sssssssssssssss', 'qqqqqq', 'guest', 0),
(38, 'asdasd@gfx.com', 'aaaaaa', 'aaaaaa', 'guest', 1),
(40, 'qqqqqq@asdsq', 'qqqqqqsw', 'qqqqqq', 'guest', 0),
(41, 'ffqq@bd', 'ffffgff', 'qqqqqq', 'guest', 1),
(42, 'qqq@sdsd.vom', 'asdasdasd', 'qqqqqq', 'guest', 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
