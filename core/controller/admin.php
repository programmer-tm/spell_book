<?php
// Подключаем модели:
include_once "../core/model/functions.php"; // Функционал сайта
getConfig(); // Получим конфиг
getDB(); // Получим БД
$box['page']="Твой мир"; // Отображение в шапке сайта
$_GET['cmd']=clear($_GET['cmd']); // Смотрим команду управления
$_GET['t_id']=clear($_GET['t_id']); // Смотрим токен
$_GET['u_id']=chislo(clear($_GET['u_id'])); // Смотрим пользователя
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
    $box['image']=getImage(); // Грузим картинку
    updUser(); // Обновим пользователя
    clearData(); // Почистим данные
    browse("/admin"); // Переадресация пользователя
} elseif ($_SESSION['id'] != "" && $_GET['cmd'] == "del") {
    delUser(); // Совершим самоубийство с сайта
    logout(); // Разлогиним пользователя
    clearData(); // Почистим данные
    browse(); // Переадресация пользователя
} elseif ($_SESSION['id'] == "" && $_GET['cmd'] == "reset") {
    resetPass(); // Сброс пароля / генерация токена
    clearData(); // Почистим данные
} elseif ($_GET['u_id'] != "" && $_GET['cmd'] == "upd") {
    setUser(); // Обновление статуса пользователя
    clearData(); // Почистим данные
    browse("/admin"); // Переадресация пользователя
} elseif ($_POST['CountPost'] && $_POST['CountMessage'] && $_POST['theme']){
    $_POST['theme']=clear($_POST['theme']);
    $_POST['CountPost']=chislo(clear($_POST['CountPost']));
    $_POST['CountMessage']=chislo(clear($_POST['CountMessage']));
    $box['config']['site']['CountPost']=$_POST['CountPost'];
    $box['config']['site']['CountMessage']=$_POST['CountMessage'];
    $box['config']['site']['theme']=$_POST['theme'];
    updConf();
    clearData(); // Почистим данные
    browse("/admin"); // Переадресация пользователя
} elseif ($_SESSION['id'] != "") {
    if ($_SESSION['role'] == "0"){
        $box['userlist']=getUsers(); // Получим список пользователей
    }
    getMailCount(); // Смотрим его непрочитанные письма
    $box['comments']=getComments("WHERE status=1"); // Примерный запрос, изменить надо...
    $box['countComments']=count($box['comments']);
    $box['user']=getUser(); // Получим залогиненного пользователя
    clearData(); // Почистим данные
}