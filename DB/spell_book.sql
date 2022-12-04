-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: localhost
-- Время создания: Дек 04 2022 г., 13:23
-- Версия сервера: 10.9.4-MariaDB
-- Версия PHP: 8.1.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `spell_book`
--

-- --------------------------------------------------------

--
-- Структура таблицы `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `post_id` int(11) DEFAULT NULL,
  `name` varchar(20) NOT NULL,
  `email` int(100) NOT NULL,
  `text` text NOT NULL,
  `moder_id` int(11) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `date_write` date NOT NULL DEFAULT current_timestamp(),
  `date_modification` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `from_id` int(11) NOT NULL,
  `to_id` int(11) NOT NULL,
  `message` varchar(255) NOT NULL,
  `date_write` date NOT NULL DEFAULT current_timestamp(),
  `date_read` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `title` varchar(50) NOT NULL,
  `text` text NOT NULL,
  `date_write` date NOT NULL,
  `readings` int(11) NOT NULL DEFAULT 0,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `posts`
--

INSERT INTO `posts` (`id`, `title`, `text`, `date_write`, `readings`, `image`) VALUES
(1, 'Заклинание', 'Я дарю тебе странные речи,\r\nЧто согреют холодной зимою.\r\nЧто дорогу осветят как свечи,\r\nИ помогут проститься с тоскою.\r\n\r\nЯ дарю всему миру надежду,\r\nНа прохладу в придвериях ада.\r\nНе запачкается пусть одежда,\r\nОт косого на улице взгляда.\r\n\r\nОт болезней, невзгод и ударов,\r\nОграждаю, читатель, до срока.\r\nЗакрываю от жутких кошмаров,\r\nТех, кто жизни усвоил урока.\r\n\r\nБудь собой, даже в жерле вулкана,\r\nДаже с крыши упав, не теряйся.\r\nНе бери в свою жизнь ты обмана,\r\nОставаться собою старайся.\r\n\r\nВозлагаю я в вышние строки,\r\nВсю ту силу, что мне помогает.\r\nПусть всевышний мои же оброки,\r\nНа нуждающихся распределяет.', '2022-01-08', 0, NULL),
(2, 'Заклинание', 'Я дарю тебе странные речи,\r\nЧто согреют холодной зимою.\r\nЧто дорогу осветят как свечи,\r\nИ помогут проститься с тоскою.\r\n\r\nЯ дарю всему миру надежду,\r\nНа прохладу в придвериях ада.\r\nНе запачкается пусть одежда,\r\nОт косого на улице взгляда.\r\n\r\nОт болезней, невзгод и ударов,\r\nОграждаю, читатель, до срока.\r\nЗакрываю от жутких кошмаров,\r\nТех, кто жизни усвоил урока.\r\n\r\nБудь собой, даже в жерле вулкана,\r\nДаже с крыши упав, не теряйся.\r\nНе бери в свою жизнь ты обмана,\r\nОставаться собою старайся.\r\n\r\nВозлагаю я в вышние строки,\r\nВсю ту силу, что мне помогает.\r\nПусть всевышний мои же оброки,\r\nНа нуждающихся распределяет.', '2022-01-08', 0, NULL),
(3, 'Заклинание', 'Я дарю тебе странные речи,\r\nЧто согреют холодной зимою.\r\nЧто дорогу осветят как свечи,\r\nИ помогут проститься с тоскою.\r\n\r\nЯ дарю всему миру надежду,\r\nНа прохладу в придвериях ада.\r\nНе запачкается пусть одежда,\r\nОт косого на улице взгляда.\r\n\r\nОт болезней, невзгод и ударов,\r\nОграждаю, читатель, до срока.\r\nЗакрываю от жутких кошмаров,\r\nТех, кто жизни усвоил урока.\r\n\r\nБудь собой, даже в жерле вулкана,\r\nДаже с крыши упав, не теряйся.\r\nНе бери в свою жизнь ты обмана,\r\nОставаться собою старайся.\r\n\r\nВозлагаю я в вышние строки,\r\nВсю ту силу, что мне помогает.\r\nПусть всевышний мои же оброки,\r\nНа нуждающихся распределяет.', '2022-01-08', 0, NULL),
(4, 'Заклинание', 'Я дарю тебе странные речи,\r\nЧто согреют холодной зимою.\r\nЧто дорогу осветят как свечи,\r\nИ помогут проститься с тоскою.\r\n\r\nЯ дарю всему миру надежду,\r\nНа прохладу в придвериях ада.\r\nНе запачкается пусть одежда,\r\nОт косого на улице взгляда.\r\n\r\nОт болезней, невзгод и ударов,\r\nОграждаю, читатель, до срока.\r\nЗакрываю от жутких кошмаров,\r\nТех, кто жизни усвоил урока.\r\n\r\nБудь собой, даже в жерле вулкана,\r\nДаже с крыши упав, не теряйся.\r\nНе бери в свою жизнь ты обмана,\r\nОставаться собою старайся.\r\n\r\nВозлагаю я в вышние строки,\r\nВсю ту силу, что мне помогает.\r\nПусть всевышний мои же оброки,\r\nНа нуждающихся распределяет.', '2022-01-08', 0, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `nickname` varchar(13) NOT NULL,
  `name` varchar(20) NOT NULL,
  `surename` varchar(25) NOT NULL,
  `email` varchar(100) NOT NULL,
  `role` tinyint(4) NOT NULL DEFAULT 2,
  `password` varchar(255) NOT NULL,
  `date_register` date NOT NULL DEFAULT current_timestamp(),
  `date_login` date DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
