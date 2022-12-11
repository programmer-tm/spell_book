<?php
// Подключаем модели:
include_once "../core/model/functions.php"; // Функционал сайта
logout(); // Разлогиним пользователя
browse($_SERVER['HTTP_REFERER']); // Переадрес на предыдущую страницу