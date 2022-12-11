<?php
// Блок SQL:
// Делаем коннект к БД:
function dbConnect(){
    // Проброс переменных
    global $box;
    if (!$db){
        // Подключение с параметрами из конфига:
        if($box['config']['sql']['port']==""){
            // Если нет порта SQL
            $db = mysqli_connect($box['config']['sql']['host'], $box['config']['sql']['login'], $box['config']['sql']['password'], $box['config']['sql']['bd']);
        } else{
            // Если eсть порт SQL
            $db = mysqli_connect($box['config']['sql']['host'].":".$box['config']['sql']['port'], $box['config']['sql']['login'], $box['config']['sql']['password'], $box['config']['sql']['bd']);
        }
        if ($db){
            // Кодировка:
            mysqli_set_charset($db, "utf8");
        }
    }
    // Вертаем активное подключение:
    return $db;
}

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
// Блок SQL

function addPost(){
    global $box;
    $_POST['post']['title']=clear($_POST['post']['title']);
    $_POST['post']['text']=clear($_POST['post']['text']);
    $_POST['post']['date_write']=clear($_POST['post']['date_write']);
    $box['table']='posts';
    $box['params']="(`title`, `text`, `date_write`) VALUES ('{$_POST['post']['title']}', '{$_POST['post']['text']}', '{$_POST['post']['date_write']}')";
    addContent();
}

function clearData(){
    global $box;
    $box['table'] = "";
    $box['params'] = "";
    $_POST=[];
    $_REQUEST=[];
}

function browse($link = "/"){
    header("Location: $link");
}

function logout(){
    session_destroy();
}

function getLogin(){
    if ($_SESSION['login']){
        return $_SESSION['login'];
    } else {
        return "Гость";
    }
}

function clear($data){
    $data=strip_tags($data);
    return $data;
}
function chislo($data){
    $data=(int)($data);
    return $data;
}

function authUser(){
    global $box;
    $_POST['login']=clear($_POST['login']);
    $_POST['password']=clear($_POST['password']);
    $box['table']="users";
    $box['params']="where `nickname`='{$_POST['login']}'";
    $box['user']=oneContent();
    if (password_verify($_POST['password'], $box['user']['password'])){
        $_SESSION['id']=$box['user']['id'];
        $_SESSION['login']=$box['user']['nickname'];
        $_SESSION['role']=$box['user']['role'];
        $_SESSION['avatar']=$box['user']['avatar'];
        $box['params'] = "SET `date_login` = '".date("Y-m-d")."' where `id` = '{$_SESSION['id']}'";
        updContent();
    }
}

function updReadPost(){
    global $box;
    $box['table']="posts";
    ++$box['post']['readings'];
    $box['params']="SET `readings` = '{$box['post']['readings']}' where `id` = '{$_GET['id']}'";
    updContent();
}

function getPost(){
    global $box;
    $_GET['id']=chislo(clear($_GET['id'])); // Смотрим на ссылку и получаем id поста
    $box['table']="posts"; // Выбираем базу данных
    $box['params']="where id=".$_GET['id']; // Пропишем параметры
    $box['post']=oneContent(); // Получим пост
}

function getComments(){
    global $box;
    $box['table']="comments";
    $box['params']="where `post_id` = '{$_GET['id']}'";
    return allContent();
}

function updPost(){
    global $box;
    $_POST['post']['title']=clear($_POST['post']['title']);
    $_POST['post']['text']=clear($_POST['post']['text']);
    $box['table']='posts';
    $box['params']="SET `title` = '{$_POST['post']['title']}', `text` = '{$_POST['post']['text']}' where id = '{$_GET['id']}'";
    updContent();
}

function updComment(){
    global $box;
    $_POST['comment']['id']=chislo(clear($_POST['comment']['id']));
    $_POST['comment']['name']=clear($_POST['comment']['name']);
    $_POST['comment']['text']=clear($_POST['comment']['text']);
    $box['table']='comments';
    $box['params']="SET `name` = '{$_POST['comment']['name']}', `text` = '{$_POST['comment']['text']}', `date_modification` = '".date("Y-m-d")."', `status` = '1' where id = '{$_POST['comment']['id']}'";
    updContent();
}

function delPost(){
    global $box;
    $box['table']="posts";
    $box['params'] = "where id = '{$_GET['id']}'";
    delContent();
}

function addComment(){
    global $box;
    $_POST['comment']['name']=clear($_POST['comment']['name']);
    $_POST['comment']['text']=clear($_POST['comment']['text']);
    $_POST['comment']['email']=clear($_POST['comment']['email']);
    $box['table']='comments';
    $box['params']="(`post_id`, `name`, `text`, `email`) VALUES ('{$_GET['id']}', '{$_POST['comment']['name']}', '{$_POST['comment']['text']}', '{$_POST['comment']['email']}')";
    addContent();
}

function delComment(){
    global $box;
    $box['table']="comments";
    $box['params'] = "where id = '{$_GET['c_id']}'";
    delContent();
}

function modComment(){
    global $box;
    $box['table']='comments';
    $box['params'] = "where id = '{$_GET['c_id']}'";
    $comment=oneContent();
    if ($comment != ""){
        if ($comment['status'] == "0"){
            $box['params']="SET `status` = '1', `moder_id` = '{$_SESSION['id']}', `date_modification` = '".date("Y-m-d")."' where id = '{$_GET['c_id']}'";
        } else{
            $box['params']="SET `status` = '0', `moder_id`  = '{$_SESSION['id']}', `date_modification` = '".date("Y-m-d")."' where id = '{$_GET['c_id']}'";
        }
    }
    updContent();
}

function addUser(){
    global $box;
    $_POST['user']['nickname']=clear($_POST['user']['nickname']);
    $_POST['user']['name']=clear($_POST['user']['name']);
    $_POST['user']['surename']=clear($_POST['user']['surename']);
    $_POST['user']['email']=clear($_POST['user']['email']);
    $_POST['user']['password']=clear($_POST['user']['password']);
    $_POST['user']['password2']=clear($_POST['user']['password2']);
    $box['table']='users';
    $box['params']="where `nickname` = '{$_POST['user']['nickname']}'";
    $user = oneContent();
    $box['params']="where `email` = '{$_POST['user']['email']}'";
    $user2 = oneContent();
    if (($user == "" || $user2 == "") && ($_POST['user']['password'] == $_POST['user']['password2'])){
        $_POST['user']['password'] = password_hash($_POST['user']['password'], PASSWORD_DEFAULT);
        $box['params']="(`nickname`, `name`, `surename`, `email`, `password`) VALUES ('{$_POST['user']['nickname']}', '{$_POST['user']['name']}', '{$_POST['user']['surename']}', '{$_POST['user']['email']}', '{$_POST['user']['password']}')";
        addContent();
    }
}

function getUser(){
    global $box;
    $box['table']="users";
    $box['params']="where `id` = {$_SESSION['id']}";
    return oneContent();
}

function updUser(){
    global $box;
    $_POST['user']['name']=clear($_POST['user']['name']);
    $_POST['user']['surename']=clear($_POST['user']['surename']);
    $_POST['user']['password']=clear($_POST['user']['password']);
    $_POST['user']['password2']=clear($_POST['user']['password2']);
    $box['table']='users';
    if ($_POST['user']['password'] == $_POST['user']['password2'] && $_POST['user']['password'] != ""){
        $_POST['user']['password'] = password_hash($_POST['user']['password'], PASSWORD_DEFAULT);
        $box['params']="SET `name` = '{$_POST['user']['name']}', `surename`  = '{$_POST['user']['surename']}', `password` = '{$_POST['user']['password']}' where id = '{$_SESSION['id']}'";
    } else {
        $box['params']="SET `name` = '{$_POST['user']['name']}', `surename`  = '{$_POST['user']['surename']}' where id = '{$_SESSION['id']}'";
    }
    updContent();
}

function delUser(){
    global $box;
    $box['table']="users";
    $box['params'] = "where id = '{$_SESSION['id']}'";
    delContent();
}