-- phpMyAdmin SQL Dump
-- version 4.3.7
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Май 08 2015 г., 00:57
-- Версия сервера: 5.5.38-0ubuntu0.12.04.1
-- Версия PHP: 5.4.30-2+deb.sury.org~precise+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `chat`
--

-- --------------------------------------------------------

--
-- Структура таблицы `message`
--

CREATE TABLE IF NOT EXISTS `message` (
  `id` int(11) NOT NULL,
  `from_id` int(11) NOT NULL,
  `to_id` int(11) DEFAULT NULL,
  `room_id` int(11) DEFAULT NULL,
  `date` int(11) NOT NULL,
  `text` text
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `message`
--

INSERT INTO `message` (`id`, `from_id`, `to_id`, `room_id`, `date`, `text`) VALUES
(1, 1, NULL, 5, 1430925315, 'saasda dasd as dasdadasdasd sadasdsaasda dasd as dasdadasdasd sadasdsaasda dasd as dasdadasdasd sadasdsaasda dasd as dasdadasdasd sadasd'),
(2, 1, NULL, 5, 1430946875, '2322323233'),
(3, 1, 2, NULL, 1430903349, 'asdasdasdasdasas'),
(14, 1, 2, NULL, 1431035725, 'hi, a''m admin');

-- --------------------------------------------------------

--
-- Структура таблицы `room`
--

CREATE TABLE IF NOT EXISTS `room` (
  `id` int(11) NOT NULL,
  `name` varchar(64) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `room`
--

INSERT INTO `room` (`id`, `name`) VALUES
(2, 'test'),
(4, 'sdfsdfsfsdfsdsdf'),
(5, 'rrrrrrrr21111');

-- --------------------------------------------------------

--
-- Структура таблицы `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL,
  `first_name` varchar(64) NOT NULL,
  `last_name` varchar(64) NOT NULL,
  `email` varchar(32) NOT NULL,
  `password` varchar(32) NOT NULL,
  `role` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `user`
--

INSERT INTO `user` (`id`, `first_name`, `last_name`, `email`, `password`, `role`) VALUES
(1, 'admin', 'admin', 'admin@admin.com', '0e33c826bd65617709569313eb045719', 0),
(2, 'user1', 'user1', 'user1@user1.com', '5f8ce8a3bcde4e7fd2e4d0b3c4a83edc', 1),
(4, 'user2', 'user2', 'user2@user2.com', '5f8ce8a3bcde4e7fd2e4d0b3c4a83edc', 1),
(5, 'user3', 'user3', 'user3@user3.com', '5f8ce8a3bcde4e7fd2e4d0b3c4a83edc', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `user_room`
--

CREATE TABLE IF NOT EXISTS `user_room` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `room_id` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `user_room`
--

INSERT INTO `user_room` (`id`, `user_id`, `room_id`) VALUES
(3, 4, 5);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `room`
--
ALTER TABLE `room`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `user_room`
--
ALTER TABLE `user_room`
  ADD PRIMARY KEY (`id`), ADD KEY `user_id` (`user_id`), ADD KEY `room_id` (`room_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `message`
--
ALTER TABLE `message`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT для таблицы `room`
--
ALTER TABLE `room`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT для таблицы `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT для таблицы `user_room`
--
ALTER TABLE `user_room`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `user_room`
--
ALTER TABLE `user_room`
ADD CONSTRAINT `ur_room_fk` FOREIGN KEY (`room_id`) REFERENCES `room` (`id`),
ADD CONSTRAINT `ur_user_fk` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
