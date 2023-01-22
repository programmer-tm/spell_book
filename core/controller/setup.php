<?php
// Подключаем модели:
include_once "../core/model/functions.php"; // Функционал сайта
getConfig(); // Получим конфиг
getDB(); // Коннект к БД
$box['page']="Страница установки"; // Отображение в шапке сайта
checkConf(); // Проверка входных данных:
if (!empty($_POST['config'])){
    $box['config']['site']=$_POST['config']['site']; // Проброс конфига
    updConf(); // Обновление параметров конфига
    setTable(); // Ставим таблички
    browse(); // Переход на главную
} elseif(!checkTables()) {
    browse(); // Переход на главную
}