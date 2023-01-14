<?php // Начало работы
// Подключаем модели:
include_once "../core/model/functions.php"; // Функционал сайта
$box['page']="Главная страница"; // Отображение в шапке сайта
getConfig(); // Получим конфиг
getDB(); // Получим БД
// Проверяем наличие нового поста и авторизации пользователя как администратора:
if ($_POST['post'] != "" && $_SESSION['role'] == "0"){
    $box['image']=getImage(); // Грузим картинку
    addPost(); // Добавим новую запись в базу данных
    clearData(); // Проведем очистку переменных
    browse(); // Отправим пользователя на страницу по умолчанию - главная.
} elseif ($_SESSION['id'] != ""){ // Если кто-то авторизован:
    getMailCount(); // Смотрим его непрочитанные письма
    getPosts(); // Получаем записи на сайте
    clearData(); // Проведем очистку переменных
} elseif ($box['db'] && checkTables()){
    browse("/setup"); // Отправим пользователя на страницу по умолчанию - установка.
} else { // Если никто не авторизован...
    getPosts(); // Получаем записи на сайте
    clearData(); // Проведем очистку переменных
}