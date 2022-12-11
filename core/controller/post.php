<?php
// Подключаем модели:
include_once "../core/model/functions.php"; // Функционал сайта
include_once "../core/model/config.php"; // Кофигурация сайта
include_once "../core/model/sql.php"; // Работа с sql
getPost(); // Получим пост
$_GET['cmd']=clear($_GET['cmd']); // Смотрим команду управления
$box['comments']=getComments(); // Получим комментарии
// Проверим его наличие:
if ($box['post'] != ""){ // Есть пост...
    if ($_GET['cmd'] == "updPost" && $_SESSION['role'] == "0"){
        updPost(); // Обновим пост
        clearData(); // Почистим данные
        browse("/post/?id={$_GET['id']}"); // Переадресация пользователя
    } elseif($_GET['cmd'] == "updComment"){
        updComment(); // Обновим комментарий
        clearData(); // Почистим данные
        browse("/post/?id={$_GET['id']}"); // Переадресация пользователя
    } elseif ($_GET['cmd'] == "delPost" && $_SESSION['role'] == "0"){
        delPost(); // Обновим пост
        clearData(); // Почистим данные
        browse(); // Переадресация пользователя
    } elseif ($_GET['cmd'] == "addComment"){
        addComment(); // Добавим комментарий
        clearData(); // Почистим данные
        browse("/post/?id={$_GET['id']}"); // Переадресация пользователя
    } elseif ($_GET['cmd'] == "delComment" && $_GET['c_id'] != ""){
        delComment(); // Удалим комментарий
        clearData(); // Почистим данные
        browse("/post/?id={$_GET['id']}"); // Переадресация пользователя
    } elseif ($_GET['cmd'] == "modComment" && $_GET['c_id'] != ""){
        modComment(); // Модерируем комментарий
        clearData(); // Почистим данные
        browse("/post/?id={$_GET['id']}"); // Переадресация пользователя
    } else {
        updReadPost(); // Обновим прочтения
        clearData(); // Почистим данные
        // Подключим модуль отображения информации для пользователя:
        include_once "../core/theme/".$box['config']['site']['theme']."/".$box['route'].".php";
    } 
} else {
    clearData(); // Почистим данные
    // Подключим модуль отображения информации для пользователя:
    include_once "../core/controller/404.php";
}