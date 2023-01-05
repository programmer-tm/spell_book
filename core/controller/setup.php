<?php
// Подключаем модели:
include_once "../core/model/functions.php"; // Функционал сайта
getConfig(); // Получим конфиг
getDB(); // Получим БД
function updConf(){
    global $box;
    $fp = fopen('config.ini', 'w+');
    foreach($box['config'] as $parts => $array){
        fwrite($fp, "[{$parts}]\n");
        foreach($array as $params => $value){
            fwrite($fp, "$params = '$value'\n");
        }
    }
    fclose($fp);
}
//$box['config']['site']['CountPost']="4";
//updConf();


/*
$fp = fopen('config.ini', 'w+');
fwrite($fp, "[site]\n");
fwrite($fp, "sql = localhost\n");
fclose($fp);


foreach($box['config'] as $parts => $array){
    echo "[{$parts}]\n";
    foreach($array as $params => $value){
        echo "$params = $value\n";
    }
}
*/


// Установим таблицы:
$box['params'] = "CREATE TABLE `comments` (
    `id` int(11) NOT NULL,
    `post_id` int(11) DEFAULT NULL,
    `name` varchar(20) NOT NULL,
    `email` varchar(100) NOT NULL,
    `text` varchar(255) NOT NULL,
    `moder_id` int(11) DEFAULT NULL,
    `status` tinyint(4) NOT NULL DEFAULT 1,
    `date_write` date NOT NULL DEFAULT current_timestamp(),
    `date_modification` date DEFAULT NULL
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";
addTable();
// Комменты залили
$box['params'] = "CREATE TABLE `posts` (
    `id` int(11) NOT NULL,
    `title` varchar(50) NOT NULL,
    `text` text NOT NULL,
    `date_write` date NOT NULL,
    `readings` int(11) NOT NULL DEFAULT 0,
    `image` varchar(255) DEFAULT NULL
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";
addTable();
// Посты залили
$box['params'] = "CREATE TABLE `users` (
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
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";
addTable();
// Юзеров залили
$box['params'] = "CREATE TABLE `messages` (
    `id` int(11) NOT NULL,
    `from_id` int(11) NOT NULL,
    `to_id` int(11) NOT NULL,
    `message` varchar(255) NOT NULL,
    `date_write` date NOT NULL DEFAULT current_timestamp(),
    `date_read` date DEFAULT NULL
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";
addTable();
// Залили таблицу личных сообщений
// Добавим логику БД:
$box['params'] = "ALTER TABLE `comments`
    ADD PRIMARY KEY (`id`),
    ADD KEY `status` (`status`);";
addTable();
$box['params'] = "ALTER TABLE `messages`
    ADD PRIMARY KEY (`id`),
    ADD KEY `from_id` (`from_id`),
    ADD KEY `to_id` (`to_id`);";
addTable();
$box['params'] = "ALTER TABLE `posts`
    ADD PRIMARY KEY (`id`);";
addTable();
$box['params'] = "ALTER TABLE `users`
    ADD PRIMARY KEY (`id`),
    ADD UNIQUE KEY `nickname` (`nickname`),
    ADD UNIQUE KEY `email` (`email`),
    ADD UNIQUE KEY `token` (`token`);";
addTable();
// Обнуляем автоинкременты...
$box['params'] = "ALTER TABLE `comments`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;";
addTable();
$box['params'] = "ALTER TABLE `messages`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;";
addTable();
$box['params'] = "ALTER TABLE `posts`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;";
addTable();
$box['params'] = "ALTER TABLE `users`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;";
addTable();
// Добавим админа с настройками по умолчанию пока
$box['params'] = "INSERT INTO `users` (`id`, `nickname`, `name`, `surename`, `email`, `role`, `password`, `date_register`, `date_login`, `avatar`, `token`) VALUES
(1, 'programmer-tm', 'admin', 'admin', 'programmer-tm@mail.ru', 0, '$2y$10$ataCl61BTCs0bGxP6Zm8BupTyq8lkE/i83BQLTCymGcR6vxTHwMsu', '2022-12-05', '2023-01-03', '26007ea0ade309ec.png', NULL);";
addTable();