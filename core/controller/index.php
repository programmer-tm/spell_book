<?php
// Подключаем модели:
include_once "../core/model/functions.php"; // Функционал сайта
include_once "../core/model/config.php"; // Кофигурация сайта
include_once "../core/model/sql.php"; // Работа с sql
// Проверяем наличие нового поста и авторизации пользователя как администратора:
if ($_POST['post'] != "" && $_SESSION['role'] == "0"){
    addPost(); // Добавим новую запись в базу данных
    clearData(); // Проведем очистку переменных
    browse(); // Отправим пользователя на страницу по умолчанию - главная.
} else {
    // Иначе, если нет чего то из тех условий:
    $box['table']="posts"; // Выберем таблицу с записями
    $box['posts']=allContent($table); // Получим все записи из таблицы
}
// Подключим модуль отображения информации для пользователя:
include_once "../core/theme/".$box['config']['site']['theme']."/".$box['route'].".php";