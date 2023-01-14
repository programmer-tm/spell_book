<?php
// Подключаем модели:
include_once "../core/model/functions.php"; // Функционал сайта
getConfig(); // Получим конфиг
getDB(); // Получим БД
$box['page']="Страница установки"; // Отображение в шапке сайта
checkConf(); // Проверка входных данных:
if (!empty($_POST['config'])){
    $box['config']=$_POST['config'];
    updConf();
    setTable();
    browse();
} elseif (!checkTables()) {
    browse();
}

// Подключим модуль отображения информации для пользователя:
//include_once "../core/theme/".$box['config']['site']['theme']."/".$box['route'].".php";
//$box['config']['site']['CountPost']="4";
//updConf();