<?php
// Подключаем модели:
include_once "../core/model/functions.php"; // Функционал сайта
include_once "../core/model/config.php"; // Кофигурация сайта
include_once "../core/model/sql.php"; // Работа с sql
$_GET['cmd']=clear($_GET['cmd']); // Смотрим команду управления
// Проверяем наличие логина и пароля от пользователя:
if ($_POST['login'] && $_POST['password']){
    authUser(); // Выполним авторизацию
    clearData(); // Почистим данные
    browse($_SERVER['HTTP_REFERER']); // Переадрес на предыдущую страницу
} elseif ($_POST['user'] != "" && $_SESSION['login'] == ""){
    addUser(); // Регистрируем пользователя
    clearData(); // Почистим данные
    browse(); // Переадресация пользователя
} elseif ($_POST['user'] != "" && $_SESSION['login'] != ""){
    updUser(); // Обновим пользователя
    clearData(); // Почистим данные
    browse("/admin"); // Переадресация пользователя
} elseif ($_SESSION['id'] != "" && $_GET['cmd'] == "del") {
    delUser(); // Совершим самоубийство с сайта
    logout(); // Разлогиним пользователя
    clearData(); // Почистим данные
    browse(); // Переадресация пользователя
} elseif ($_SESSION['id'] != "") {
    $box['user']=getUser(); // Получим залогиненного пользователя
}
// Подключим модуль отображения информации для пользователя:
include_once "../core/theme/".$box['config']['site']['theme']."/".$box['route'].".php";