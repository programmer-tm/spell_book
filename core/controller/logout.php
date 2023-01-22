<?php
// Подключаем модели:
include_once "../core/model/functions.php"; // Функционал сайта
logout(); // Разлогиним пользователя
if ($_SERVER['HTTP_REFERER'] != "/logout"){
    browse(); // Переадрес на главную страницу
} else {
    browse($_SERVER['HTTP_REFERER']); // Переадрес на предыдущую страницу
}