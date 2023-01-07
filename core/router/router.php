<?php
// Смотрим сессию:
session_start();
// Подключаем модели:
include_once "../core/model/functions.php"; // Функционал сайта
// Откроем нашу коробку с переменными:
$box=[];
// Путь перехода по папкам (в нашем случае - имя контроллера)
$box=['route' => explode("/", $_SERVER["REQUEST_URI"])[1]];
// Анализируем переменную:
// Если пусто, то мы ссылаемся на главную:
if ($box['route'] == "" || stripos($box['route'], "?page=") !== false){ // Проверка на пустоту или номер страницы
    // Главный контроллер:
    $box['route']="index";
}
// Проверяем наличие файла контроллера, в том числе и главной страницы:
if (!file_exists("../core/controller/".$box['route'].".php")) {
    // Переводим пользователя на страницу 404:
    $box['route']=404;
}
// Передаем управление определенному контроллеру.
include_once "../core/controller/".$box['route'].".php";
render();