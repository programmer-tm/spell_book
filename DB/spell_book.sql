-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: localhost
-- Время создания: Янв 05 2023 г., 10:46
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
  `email` varchar(100) NOT NULL,
  `text` varchar(255) NOT NULL,
  `moder_id` int(11) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `date_write` date NOT NULL DEFAULT current_timestamp(),
  `date_modification` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `comments`
--

INSERT INTO `comments` (`id`, `post_id`, `name`, `email`, `text`, `moder_id`, `status`, `date_write`, `date_modification`) VALUES
(1, 1, 'admin', 'programmer-tm@mail.ru', 'Тестовый комментарий!', 3, 1, '2022-12-07', '2023-01-03'),
(2, 5, 'fsd', 'sdfsdfg@sdg', 'sdgsdg', 1, 2, '2022-12-09', '2022-12-09');

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
  `date_read` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `messages`
--

INSERT INTO `messages` (`id`, `from_id`, `to_id`, `message`, `date_write`, `date_read`) VALUES
(1, 1, 2, '1111', '2022-12-09', '2023-01-01'),
(2, 2, 1, '1212122rwefsfs', '2022-12-09', NULL);

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
(1, 'Заклинание', 'Я дарю тебе странные речи,\r\nЧто согреют холодной зимою.\r\nЧто дорогу осветят как свечи,\r\nИ помогут проститься с тоскою.\r\n\r\nЯ дарю всему миру надежду,\r\nНа прохладу в придвериях ада.\r\nНе запачкается пусть одежда,\r\nОт косого на улице взгляда.\r\n\r\nОт болезней, невзгод и ударов,\r\nОграждаю, читатель, до срока.\r\nЗакрываю от жутких кошмаров,\r\nТех, кто жизни усвоил урока.\r\n\r\nБудь собой, даже в жерле вулкана,\r\nДаже с крыши упав, не теряйся.\r\nНе бери в свою жизнь ты обмана,\r\nОставаться собою старайся.\r\n\r\nВозлагаю я в вышние строки,\r\nВсю ту силу, что мне помогает.\r\nПусть всевышний мои же оброки,\r\nНа нуждающихся распределяет.', '2022-01-08', 108, NULL),
(2, 'Заклинание', 'Я дарю тебе странные речи,\r\nЧто согреют холодной зимою.\r\nЧто дорогу осветят как свечи,\r\nИ помогут проститься с тоскою.\r\n\r\nЯ дарю всему миру надежду,\r\nНа прохладу в придвериях ада.\r\nНе запачкается пусть одежда,\r\nОт косого на улице взгляда.\r\n\r\nОт болезней, невзгод и ударов,\r\nОграждаю, читатель, до срока.\r\nЗакрываю от жутких кошмаров,\r\nТех, кто жизни усвоил урока.\r\n\r\nБудь собой, даже в жерле вулкана,\r\nДаже с крыши упав, не теряйся.\r\nНе бери в свою жизнь ты обмана,\r\nОставаться собою старайся.\r\n\r\nВозлагаю я в вышние строки,\r\nВсю ту силу, что мне помогает.\r\nПусть всевышний мои же оброки,\r\nНа нуждающихся распределяет.', '2022-01-08', 13, NULL),
(3, 'Заклинание', 'Я дарю тебе странные речи,\r\nЧто согреют холодной зимою.\r\nЧто дорогу осветят как свечи,\r\nИ помогут проститься с тоскою.\r\n\r\nЯ дарю всему миру надежду,\r\nНа прохладу в придвериях ада.\r\nНе запачкается пусть одежда,\r\nОт косого на улице взгляда.\r\n\r\nОт болезней, невзгод и ударов,\r\nОграждаю, читатель, до срока.\r\nЗакрываю от жутких кошмаров,\r\nТех, кто жизни усвоил урока.\r\n\r\nБудь собой, даже в жерле вулкана,\r\nДаже с крыши упав, не теряйся.\r\nНе бери в свою жизнь ты обмана,\r\nОставаться собою старайся.\r\n\r\nВозлагаю я в вышние строки,\r\nВсю ту силу, что мне помогает.\r\nПусть всевышний мои же оброки,\r\nНа нуждающихся распределяет.', '2022-01-08', 5, NULL),
(4, 'Заклинание', 'Я дарю тебе странные речи,\r\nЧто согреют холодной зимою.\r\nЧто дорогу осветят как свечи,\r\nИ помогут проститься с тоскою.\r\n\r\nЯ дарю всему миру надежду,\r\nНа прохладу в придвериях ада.\r\nНе запачкается пусть одежда,\r\nОт косого на улице взгляда.\r\n\r\nОт болезней, невзгод и ударов,\r\nОграждаю, читатель, до срока.\r\nЗакрываю от жутких кошмаров,\r\nТех, кто жизни усвоил урока.\r\n\r\nБудь собой, даже в жерле вулкана,\r\nДаже с крыши упав, не теряйся.\r\nНе бери в свою жизнь ты обмана,\r\nОставаться собою старайся.\r\n\r\nВозлагаю я в вышние строки,\r\nВсю ту силу, что мне помогает.\r\nПусть всевышний мои же оброки,\r\nНа нуждающихся распределяет.', '2022-01-08', 1, NULL),
(5, '1111', 'gbhfyunbxhngxbkgjuvdbjtjbjnjgnjvиирароаеитанирсапрскисаенич исарапьгыви вбеатвнрчн вк7ьы рвк7тткв тннгее ы', '2022-12-07', 29, '9c6290dc359f8c56.jpg');

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
  `avatar` varchar(255) DEFAULT NULL,
  `token` varchar(16) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `nickname`, `name`, `surename`, `email`, `role`, `password`, `date_register`, `date_login`, `avatar`, `token`) VALUES
(1, 'programmer-tm', 'admin', 'admin', 'programmer-tm@mail.ru', 0, '$2y$10$ataCl61BTCs0bGxP6Zm8BupTyq8lkE/i83BQLTCymGcR6vxTHwMsu', '2022-12-05', '2023-01-03', '26007ea0ade309ec.png', NULL),
(2, 'user', 'user', 'user', 'user@mail.ru', 1, '$2y$10$tE0p.hKwUeAQGvx76lsNzOxF4RTBdxVup/4Io2e9GMG7TSy3co1Qm', '2022-12-07', '2023-01-01', NULL, NULL),
(3, 'test', 'test', 'test1', 'test@test', 1, '$2y$10$ZIBrTJ3V3UAsIKB4b6J7DugV6dfArv/VsHibUyLIOp95d7uTMx3Ki', '2022-12-14', '2023-01-03', '8493f48d6e37fb46.png', NULL);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `status` (`status`);

--
-- Индексы таблицы `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `from_id` (`from_id`),
  ADD KEY `to_id` (`to_id`);

--
-- Индексы таблицы `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nickname` (`nickname`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `token` (`token`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT для таблицы `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT для таблицы `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
