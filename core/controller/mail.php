<?php
if ($_SESSION['id']){
    // Подключаем модели:
    include_once "../core/model/functions.php"; // Функционал сайта
    getConfig(); // Получим конфиг
    getDB(); // Получим БД
    $_GET['cmd']=clear($_GET['cmd']); // Смотрим команду управления
    if ($_POST['to_id'] != "" && $_POST['message'] != ""){
        addMessage(); // Отправка сообщения
        clearData(); // Проведем очистку переменных
        browse("/mail"); // Возврат на страницу сообщений
    } elseif($_SESSION['id'] != "" && $_GET['cmd'] == "read" && $_GET['m_id']){
        readMail(); // Прочтение сообщения
        clearData(); // Проведем очистку переменных
        browse("/mail"); // Возврат на страницу сообщений
    } elseif($_SESSION['id'] != "" && $_GET['cmd'] == "del" && $_GET['m_id']){
        delMail(); // Удаление сообщений
        clearData(); // Проведем очистку переменных
        browse("/mail"); // Возврат на страницу сообщений
    }
    getMailCount(); // Смотрим его непрочитанные письма
    getMail(); // Получим списки сообщений
    $box['userlist']=getUsers(); // Получим список пользователей
    clearData(); // Проведем очистку переменных
    // Подключим модуль отображения информации для пользователя:
    include_once "../core/theme/".$box['config']['site']['theme']."/".$box['route'].".php";
} else {
    // Подключим модуль отображения информации для пользователя (404):
    include_once "../core/controller/404.php";
}
