<?php
// Делаем коннект к БД:
function dbConnect(){
    global $box;
    if (!$db){
        // Подключение с параметрами из конфига:
        if($box['config']['sql']['port']==""){
            $db = mysqli_connect($box['config']['sql']['host'], $box['config']['sql']['login'], $box['config']['sql']['password'], $box['config']['sql']['bd']);
        } else{
            $db = mysqli_connect($box['config']['sql']['host'].":".$box['config']['sql']['port'], $box['config']['sql']['login'], $box['config']['sql']['password'], $box['config']['sql']['bd']);
        }
        if ($db){
            // Кодировка:
            mysqli_set_charset($db, "utf8");
        }
    }
    return $db;
}

$box['db'] = dbConnect();

// Получить список значений
function allContent(){
    global $box;
    return mysqli_fetch_all(mysqli_query($box['db'], "SELECT * FROM {$box['table']} {$box['params']}"), MYSQLI_ASSOC);
}
// Получить 1 значение
function oneContent(){
    global $box;
    return mysqli_fetch_assoc(mysqli_query($box['db'], "SELECT * FROM {$box['table']} {$box['params']}"));
}

// Обновить значения:
function updContent(){
    global $box;
    mysqli_query($box['db'], "UPDATE {$box['table']} {$box['params']}");
}

// Добавить значения
function addContent(){
    global $box;
    mysqli_query($box['db'], "INSERT INTO {$box['table']} {$box['params']}");
}

// Удалить значение
function delContent(){
    global $box;
    mysqli_query($box['db'], "DELETE FROM {$box['table']} {$box['params']}");
}
// Пока не изменял
// Свободный запрос
function freeContent($sql){
    global $box;
    return mysqli_fetch_all(mysqli_query($box['db'], $sql), MYSQLI_ASSOC);
}

// Test_setup_block
function addTable($params){
    global $box;
    mysqli_query($box['db'], $params);
}