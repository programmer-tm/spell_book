<?php
// Подключаем модели:
include_once "../core/model/functions.php"; // Функционал сайта
getConfig(); // Получим конфиг
getDB(); // Получим БД
getPost(); // Получим пост
$box['page']=$box['post']['title']; // Отображение в шапке сайта
getMailCount(); // Смотрим его непрочитанные письма
$box['userlist']=getUsers("all"); // Получим список пользователей
$_GET['cmd']=clear($_GET['cmd']); // Смотрим команду управления
$_GET['c_id']=chislo(clear($_GET['c_id'])); 
$box['comments']=getComments(); // Получим комментарии
// Проверим его наличие:
if ($box['post'] != ""){ // Есть пост...
    if ($_GET['cmd'] == "updPost" && $_SESSION['role'] == "0"){
        $box['image']=getImage(); // Грузим картинку
        updPost(); // Обновим пост
        clearData(); // Почистим данные
        browse("/post/?id={$_GET['id']}"); // Переадресация пользователя
    } elseif($_GET['cmd'] == "updComment"){
        updComment(); // Обновим комментарий
        clearData(); // Почистим данные
        browse("/post/?id={$_GET['id']}"); // Переадресация пользователя
    } elseif ($_GET['cmd'] == "delPost" && $_SESSION['role'] == "0"){
        delPost(); // Удалим пост
        clearData(); // Почистим данные
        browse(); // Переадресация пользователя
    } elseif ($_GET['cmd'] == "rest" && $_SESSION['role'] == "0"){
        resetReadings(); // Обновим пост
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
    } 
} else {
    clearData(); // Почистим данные
    browse("/404");
}