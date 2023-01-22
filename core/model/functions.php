<?php
// Блок SQL:
// Делаем коннект к БД
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
    // Пробросим глобально переменные
    global $box;
    return mysqli_fetch_all(mysqli_query($box['db'], "SELECT * FROM {$box['table']} {$box['params']}"), MYSQLI_ASSOC); // выполним запрос к БД
}
// Получить 1 значение
function oneContent(){
    // Пробросим глобально переменные
    global $box;
    return mysqli_fetch_assoc(mysqli_query($box['db'], "SELECT * FROM {$box['table']} {$box['params']}")); // выполним запрос к БД
}
// Обновить значения:
function updContent(){
    // Пробросим глобально переменные
    global $box;
    mysqli_query($box['db'], "UPDATE {$box['table']} {$box['params']}"); // выполним запрос к БД
}
// Добавить значения
function addContent(){
    // Пробросим глобально переменные
    global $box;
    mysqli_query($box['db'], "INSERT INTO {$box['table']} {$box['params']}"); // выполним запрос к БД
}
// Удалить значение
function delContent(){
    // Пробросим глобально переменные
    global $box;
    mysqli_query($box['db'], "DELETE FROM {$box['table']} {$box['params']}"); // выполним запрос к БД
}
// Свободный запрос
function freeContent(){
    // Пробросим глобально переменные
    global $box;
    return mysqli_fetch_all(mysqli_query($box['db'], $box['params']), MYSQLI_ASSOC); // выполним запрос к БД
}
// Test_setup_block
function addTable(){
    // Пробросим глобально переменные
    global $box;
    mysqli_query($box['db'], $box['params']); // выполним запрос к БД
}
// Блок SQL
// Вывод сообщения на сайт:
function alert($message){
    $_SESSION['in'] = 1; // активируем считалочку
    $_SESSION['alert'] = $message; // запишем сообщение в сессию
}
// Добавление поста на сайт (права админа):
function addPost(){
    // Пробросим глобально переменные
    global $box;
    if ($_SESSION['role'] == "0"){ // коль админ
        $_POST['post']['title']=clear($_POST['post']['title']); // готовим данные
        $_POST['post']['text']=clear($_POST['post']['text']); // готовим данные
        $_POST['post']['date_write']=clear($_POST['post']['date_write']); // готовим данные
        $box['table']='posts'; // выбираем записи
        $box['params']="(`title`, `text`, `date_write`, `image`) VALUES ('{$_POST['post']['title']}', '{$_POST['post']['text']}', '{$_POST['post']['date_write']}', '{$box['image']}')"; // формируем запрос
        addContent(); // вносим в таблицу
        alert("Запись успешно добавлена на сайт!"); // пишем сообщение
    } else {
        alert("Не тудой Вас тянет, сударь..."); // Формируем сообщение
    }
}
// Сервисная функция (бесправна):
function clearData(){
    // Пробросим глобально переменные
    global $box;
    $box['table'] = ""; // чистим переменные
    $box['params'] = ""; // чистим переменные
    $_POST=[]; // чистим переменные
    $_REQUEST=[]; // чистим переменные
}
// Функция переадресации на любую страницу (без прочих прав):
function browse($link = "/"){
    header("Location: $link"); // переадресация на заданный адрес
}
// Функция выхода из сеанса (без прав админа):
function logout(){
    session_destroy(); // сброс сессии
}
// Получение логина пользователя (без прав админа):
function getLogin(){
    if ($_SESSION['login']){ // читаем ник из сессии
        return $_SESSION['login']; // вернем его
    } else {
        return "Гость"; // или он гость
    }
}
// Функция очистки данных (без прав админа):
function clear($data){
    $data=strip_tags($data); // убираем теги html
    return $data; // возврат
}
// Функция приведения к положительному числу (без прав админа):
function chislo($data){
    $data=abs((int)($data)); // положительное число
    return $data; // возврат
}
// Функция авторизации пользователя (без прав админа):
function authUser(){
    // Пробросим глобально переменные
    global $box;
    $_POST['login']=clear($_POST['login']); // готовим данные
    $_POST['password']=clear($_POST['password']); // готовим данные
    $box['table']="users"; // Работаем с пользователями
    $box['params']="where `nickname`='{$_POST['login']}'"; // формируем запрос
    $box['user']=oneContent(); // Получим пользователя
    if (password_verify($_POST['password'], $box['user']['password'])){ // если пароль прошел
        $_SESSION['id']=$box['user']['id']; // запишем данные в сессию
        $_SESSION['login']=$box['user']['nickname']; // запишем данные в сессию
        $_SESSION['role']=$box['user']['role']; // запишем данные в сессию
        $_SESSION['avatar']=$box['user']['avatar']; // запишем данные в сессию
        alert("Здравствуй, {$_SESSION['login']}! Последний раз мы Вас помним... {$box['user']['date_login']}"); // дадим приветствие
        $box['params'] = "SET `date_login` = '".date("Y-m-d")."', `token` = NULL where `id` = '{$_SESSION['id']}'"; // запишем когда появился
        updContent(); // обновим в БД
    } else {
        alert('Внимание неверный пароль или такого пользователя нет на сайте'); // или уведомим об ошибке
    }
}
// Сервисная функция (без прав админа):
function updReadPost(){
    // Пробросим глобально переменные
    global $box;
    $box['table']="posts"; // работаем с записями
    ++$box['post']['readings']; // увеличим на 1 прочтения текущего поста
    $box['params']="SET `readings` = '{$box['post']['readings']}' where `id` = '{$_GET['id']}'"; // Сформируем запрос к БД
    updContent(); // Обновим информацию
}
// Получим пост (без прав админа):
function getPost(){
    // Пробросим глобально переменные
    global $box;
    $_GET['id']=chislo(clear($_GET['id'])); // Смотрим на ссылку и получаем id поста
    $box['table']="posts"; // Выбираем базу данных
    $box['params']="where id=".$_GET['id']; // Пропишем параметры
    $box['post']=oneContent(); // Получим пост
}
// Получение комментариев (без прав админа):
function getComments($params=""){
    // Пробросим глобально переменные
    global $box;
    $box['table']="comments"; // Работаем с комментариями
    if ($params != ""){
        $box['params']=$params; // Получим заданные комментарии
    } else {
        $box['params']="where `post_id` = '{$_GET['id']}'"; // Либо к конкретному посту
    }
    return allContent(); // Вернем данные по запросу
}
// Обновление поста (права админа):
function updPost(){
    // Пробросим глобально переменные
    global $box;
    if ($_SESSION['role'] == "0"){ // для админа
        if ($box['image'] != ""){ // если оно не пусто, то
            getPost(); // получим пост
            delImage($box['post']['image']); // обнулим старую картинку
        }
        $_POST['post']['title']=clear($_POST['post']['title']); // готовим данные
        $_POST['post']['text']=clear($_POST['post']['text']); // готовим данные
        $box['table']='posts'; // Работаем с записями
        if ($box['image'] != ""){ // если есть картинка, то
            $box['params']="SET `title` = '{$_POST['post']['title']}', `text` = '{$_POST['post']['text']}', `image` = '{$box['image']}' where id = '{$_GET['id']}'"; // параметр запроса
        } else {
            $box['params']="SET `title` = '{$_POST['post']['title']}', `text` = '{$_POST['post']['text']}' where id = '{$_GET['id']}'"; // если нет картинки
        }
        updContent(); // обновим в БД
        alert("Запись успешно обновлена!"); // Сообщение
    }
}
// Обновление комментариев (С учетом прав):
function updComment(){
    // Пробросим глобально переменные
    global $box;
    $comment=getComment($_POST['comment']['id']); // получим текущий комментарий
    if (($_SESSION['role'] != "2" && $_SESSION['id'] != "") || $comment['name'] == $_SESSION['login']){ // проверим права админа, модера, авторизацию и авторство коммента. если что-то есть, то
        $_POST['comment']['name']=clear($_POST['comment']['name']); // готовим данные
        $_POST['comment']['text']=clear($_POST['comment']['text']); // готовим данные
        $box['table']='comments'; // работаем с комментариями
        if ($_SESSION['role'] != "2"){ // если админ или модер
            $box['params']="SET `name` = '{$_POST['comment']['name']}', `text` = '{$_POST['comment']['text']}', `date_modification` = '".date("Y-m-d")."', `status` = '0', `moder_id` = '{$_SESSION['id']}' where id = '{$_POST['comment']['id']}'"; // добавим информацио о модификации
            alert("Комментарий обновлен..."); // сообщение
        } else {
            $box['params']="SET `name` = '{$_POST['comment']['name']}', `text` = '{$_POST['comment']['text']}', `date_modification` = '".date("Y-m-d")."', `status` = '1' where id = '{$_POST['comment']['id']}'"; // добавим информацию об изменении
            alert("Комментарий обновлен, отправлен на премодерацию..."); // Сообщение
        }
        updContent(); // Запишем в базу
    }
}
// Сервисная функция для удаления всех комментов по посту или пользователю:
function delComments($cmd){
    // Пробросим глобально переменные
    global $box;
    $box['table']="comments"; // Работаем с комментариями
    if ($cmd == "post"){ // если пост
        $box['params']="where `post_id` = '{$_GET['id']}'"; // запросим по номеру поста
    } elseif ($cmd == "user") {
        $box['params']="where `name` = '{$_SESSION['login']}'"; // запросим по номеру пользователя
    }
    $comments=allContent(); // получим комментарии
    if (!empty($comments)){ // если есть, то
        foreach ($comments as $data){ // пробежим по ним
            $box['params'] = "where id = '{$data['id']}'"; // подготовим запрос
            delContent(); // и удалим
        }
    }
}
// Удаление постов (права админа):
function delPost(){
    // Пробросим глобально переменные
    global $box;
    if ($_SESSION['role'] == "0"){ // Если адми
        delComments("post"); // удаление комментариев по посту
        getPost(); // Получаем его
        delImage($box['post']['image']); // Удалим картинку
        $box['table']="posts"; // переходим в таблицу записей
        $box['params'] = "where id = '{$_GET['id']}'"; // формируем запрос
        delContent(); // удалим запись
        alert("Запись удалена!"); // сообщим это
    } else {
        alert("Не тудой Вас тянет, сударь..."); // Формируем сообщение
    }
}
// Функция добавления комментариев (без прав админа, пока что):
function addComment(){
    global $box;
    $_POST['comment']['name']=clear($_POST['comment']['name']);
    $_POST['comment']['text']=clear($_POST['comment']['text']);
    $_POST['comment']['email']=clear($_POST['comment']['email']);
    if ($_SESSION['id'] != "" && $_SESSION['role'] != "2"){
        $user=getUser();
        $box['params']="(`post_id`, `name`, `text`, `email`, `status`) VALUES ('{$_GET['id']}', '{$user['nickname']}', '{$_POST['comment']['text']}', '{$user['email']}', '0')";
        alert("Комментарий добавлен!");
    } elseif ($_SESSION['id'] != ""){
        $user=getUser();
        $box['params']="(`post_id`, `name`, `text`, `email`) VALUES ('{$_GET['id']}', '{$user['nickname']}', '{$_POST['comment']['text']}', '{$user['email']}')";
        alert("Комментарий отправлен на рассмотрение");
    } else {
        $box['params']="(`post_id`, `name`, `text`, `email`) VALUES ('{$_GET['id']}', '{$_POST['comment']['name']}', '{$_POST['comment']['text']}', '{$_POST['comment']['email']}')";
        alert("Комментарий отправлен на рассмотрение");
    }
    $box['table']='comments';
    addContent();
}
// Сервисная функция (без админа):
function getComment($id){
    // Пробросим глобально переменные
    global $box;
    // Готовим переменные
    $id=chislo(clear($id));
    // Работаем с комментариями
    $box['table']="comments";
    // Получим конкретный комментарий
    $box['params'] = "where id = '{$id}'";
    // Вернем его
    return oneContent();
}
// Функция удаления комментария (проверка прав):
function delComment(){
    // Пробросим глобально переменные
    global $box;
    $box['table']="comments"; // работаем с комментариями
    if ($_SESSION['role'] == "0"){ // Если админ, то удалим на совсем
        $box['params'] = "where id = '{$_GET['c_id']}'"; // конкретный комментарий
        delContent(); // удалим
        alert("Комментарий удален! Совсем удален!"); // сообщение
    } else {
        $comment=getComment($_GET['c_id']); // Проверим комментарий
        if ($comment['name'] == $_SESSION['login'] || $_SESSION['role'] == "1"){ // Если модер или автор комментария, то
            $box['params'] = "SET `status` = '2' where id = '{$_GET['c_id']}'"; // отмечаем удаленным
            updContent(); // Пишем сие дело
            alert("Комментарий удален!"); // Сообщаем это
        } else {
            alert("Не тудой Вас тянет, сударь..."); // Формируем сообщение
        }
    }
}
// Модерация комментариев (+возврат из удаленных, проверка прав админ/модер):
function modComment(){
    // Пробросим глобально переменные
    global $box;
    // Сверим роль
    if ($_SESSION['role'] != "2"){ // модератор и админ:
        $box['table']='comments'; // Работаем с комментариями
        $box['params'] = "where id = '{$_GET['c_id']}'"; // Выбираем конкретный из них
        $comment=oneContent(); // получаем его
        if ($comment != ""){ // Если он есть, то
            if ($comment['status'] == "1"){ // Публикуем
                $box['params']="SET `status` = '0', `moder_id` = '{$_SESSION['id']}', `date_modification` = '".date("Y-m-d")."' where id = '{$_GET['c_id']}'"; // параметры запроса
                alert("Комментарий открыт для всех!"); // Сообщение с сайта
            } else { // отправим на проверку
                $box['params']="SET `status` = '1', `moder_id`  = '{$_SESSION['id']}', `date_modification` = '".date("Y-m-d")."' where id = '{$_GET['c_id']}'"; // параметры запроса
                alert("Комментарий закрыт для всех, кроме автора и администрации!"); // Сообщение от сайта
            }
            updContent(); // Делаем запрос к бд
        } else {
            alert("Не тудой Вас тянет, сударь..."); // Формируем сообщение
        }
    }
}
// Регистрация пользователя (без прав админа):
function addUser(){
    // Пробросим глобально переменные
    global $box;
    $_POST['user']['nickname']=clear($_POST['user']['nickname']); // Готовим данные
    $_POST['user']['name']=clear($_POST['user']['name']); // Готовим данные
    $_POST['user']['surename']=clear($_POST['user']['surename']); // Готовим данные
    $_POST['user']['email']=clear($_POST['user']['email']); // Готовим данные
    $_POST['user']['password']=clear($_POST['user']['password']); // Готовим данные
    $_POST['user']['password2']=clear($_POST['user']['password2']); // Готовим данные
    $box['table']='users'; // Работаем с пользователями
    $box['params']="where `nickname` = '{$_POST['user']['nickname']}'"; // проверим, есть ли на сайте
    $user = oneContent(); // запросим из БД
    $box['params']="where `email` = '{$_POST['user']['email']}'"; // проверим почту
    $user2 = oneContent(); // Запросим из БД
    if ($user == "" && $user2 == "" && $_POST['user']['password'] == $_POST['user']['password2']){ // Проверим все ли хорошо
        $_POST['user']['password'] = password_hash($_POST['user']['password'], PASSWORD_DEFAULT); // сгенерим хеш
        $box['params']="(`nickname`, `name`, `surename`, `email`, `password`) VALUES ('{$_POST['user']['nickname']}', '{$_POST['user']['name']}', '{$_POST['user']['surename']}', '{$_POST['user']['email']}', '{$_POST['user']['password']}')"; // параметр добавим
        addContent(); // запишем в БД
        alert("Успешная регистрация!"); // Все хорошо
    } elseif($user != "" ) {
        alert("Такой логин уже занят, придумайте другой!"); // Логин занят
    } elseif($user2 != "" ) {
        alert("Такой email уже занят, попробуйте восстановить пароль!"); // почта занята
    }
}
// Сервисная функция (без прав админа):
function getUser($id=""){
    // Пробросим глобально переменные
    global $box;
    // работаем с пользователями
    $box['table']="users";
    if ($id != ""){ // Если есть конкретный номер
        $box['params']="where `id` = {$id}"; // формируем запрос
    } elseif ($_SESSION['id'] != ""){ // либо
        $box['params']="where `id` = {$_SESSION['id']}"; // выбернем авторизованного пользователя
    }
    return oneContent(); // Возвращаем
}
// Проверка пользователя на залогиненность и корректность данных:
function updUser(){
    // Пробросим глобально переменные
    global $box;
    // получим пользователя
    $user=getUser();
    if ($_SESSION['id'] !="" && !empty($user) && $user['id'] == $_SESSION['id']){ // Если залогинились и юзер есть
        if ($box['image'] != ""){ // Сверим аватар
            delImage($user['avatar']); // удалим старый
            $_SESSION['avatar'] = $box['image']; // прокинем новый
        } else {
            $box['image'] = $user['avatar']; // Иначе ничего не трогаем
        }
        $_POST['user']['name']=clear($_POST['user']['name']); // Готовим данные
        $_POST['user']['surename']=clear($_POST['user']['surename']); // Готовим данные
        $_POST['user']['password']=clear($_POST['user']['password']); // Готовим данные
        $_POST['user']['password2']=clear($_POST['user']['password2']); // Готовим данные
        $box['table']='users'; // Работаем с таблицей пользователей
        if ($_POST['user']['password'] == $_POST['user']['password2'] && $_POST['user']['password'] != ""){ // Если все хорошо с паролями, то и их меняем
            $_POST['user']['password'] = password_hash($_POST['user']['password'], PASSWORD_DEFAULT); // Генерим хеш пароля
            $box['params']="SET `name` = '{$_POST['user']['name']}', `surename`  = '{$_POST['user']['surename']}', `password` = '{$_POST['user']['password']}',`avatar` = '{$box['image']}'  where id = '{$_SESSION['id']}'"; // Параметры запроса
            alert("Ваши данные обновлены! Пароль поменяли!"); // Сообщение от сайта
        } else {
            $box['params']="SET `name` = '{$_POST['user']['name']}', `surename`  = '{$_POST['user']['surename']}',`avatar` = '{$box['image']}' where id = '{$_SESSION['id']}'"; // Меняем без пароля
            alert("Ваши данные обновлены!"); // Сообщение от сайта
        }
        updContent(); // обновим данные
    } else {
        alert("Не тудой Вас тянет, сударь..."); // Формируем сообщение
        browse(); // Переадресация пользователя
    }
}
// Удаление пользователя:
function delUser(){
    // Пробросим глобально переменные
    global $box;
    if ($_SESSION['id'] != "" && $_SESSION['id'] != "1"){ // Если авторизованы и не админ портала (первый номер)
        delImage($_SESSION['avatar']); // Сносим аватарку
        delComments("user"); // удаляем все его комментарии
        getMail(); // Получим всю его почту
        foreach ($box['incoming'] as $in){
            $_GET['m_id']=$in['id']; // Перечислим
            delMail(); // подотрем по входному параметру
        }
        foreach ($box['outgoing'] as $out){ 
            $_GET['m_id']=$out['id']; // Перечислим
            delMail(); // подотрем по входному параметру
        }
        $box['table']="users"; // работаем с пользователями
        $box['params'] = "where id = '{$_SESSION['id']}'"; // Выбираем текущего
        delContent(); // удаляем
    } else {
        alert("Не тудой Вас тянет, сударь..."); // Формируем сообщение
        browse(); // Переадресация пользователя
    }
}
// Сервисная функция:
function getMail(){
    // Пробросим глобально переменные
    global $box;
    if ($_SESSION['id'] != ""){ // если авторизованы
        $box['table']="messages"; // работаем с таблицей сообщений
        $box['params']="where `to_id` = '{$_SESSION['id']}'"; // параметр входящих
        $box['incoming']=allContent(); // получим их
        $box['params']="where `from_id` = '{$_SESSION['id']}'"; // параметр исходящих
        $box['outgoing']=allContent(); // получим их
    }
}
// Сервисная функция (без прав админа):
function getUsers($cmd=""){
    // Пробросим глобально переменные
    global $box;
    // Табличка юзеры
    $box['table']="users";
    if ($cmd == ""){ // если ничего нам не дали, то дадим всех, кроме залогиненного юзера
        $box['params']="where id<>'{$_SESSION['id']}'";
    } else { // Иначе даем всех! для отзывов патч
        $box['params']=""; 
    }
    return allContent(); // вернем результат запроса
}
// Функция отправки сообщения (права пользователя):
function addMessage(){
    // Пробросим глобально переменные
    global $box;
    // Подготовка вводных данных
    $_POST['to_id']=chislo(clear($_POST['to_id']));
    // Параметр запроса
    $box['params']="SELECT count(`id`) as count FROM `messages` where `from_id` = '{$_SESSION['id']}'";
    // Выполним запрос на количество сообщений в базе от пользователя
    $mCount=freeContent()['0']['count'];
    if ($mCount < $box['config']['site']['CountMessage'] && $_SESSION['id'] != "" && $_POST['to_id'] != $_SESSION['id']){ // Если лимит не исчерпан, то
        $_POST['message']=clear($_POST['message']); // готовим текст к отправке
        $box['table']="messages"; // выбираем табличку
        $box['params']="(`from_id`, `to_id`, `message`) VALUES ('{$_SESSION['id']}', '{$_POST['to_id']}', '{$_POST['message']}')"; // готовим запрос
        addContent(); // отправляем
        alert("Депеша отправлена!"); // Говорим, что все хорошо
    } else { // Иначе
        alert("Депеша потерялася, вы превысили лимит и голубь подскользнулсо и самоубилсо!"); // Ахтунг!
    }
}
// Проверить количество непрочитанной почты (права пользователя):
function getMailCount(){
    // Пробросим глобально переменные
    global $box;
    if ($_SESSION['id'] != ""){ // Если мы залогинены
        $box['table']="messages"; // работаем с таблицей сообщений
        $box['params']="SELECT count('id') as CountMail FROM `{$box['table']}` WHERE `to_id` = '{$_SESSION['id']}' and `date_read` is NULL"; // Получим не прочитанные послания для залогиненного пользователя
        $box['mail']=freeContent()['0']['CountMail']; // запрос к БД
    }
}
// Получить записи (без прав админа):
function getPosts(){
    // Пробросим глобально переменные
    global $box;
    // Подготовим переменные
    $_GET['page']=chislo(clear($_GET['page']));
    $box['table']="posts"; // Выберем таблицу с записями
    if ($box['config']['site']['CountPost'] != "" && $box['config']['site']['CountPost'] != "0"){ // ПРоверим, включена ли навигация
        $box['params']="SELECT count(id) as postCount FROM `{$box['table']}`"; // Определяем, с какого по какой пост берем
        $box['pCount']=freeContent()['0']['postCount']; // Смотрим сколько всего постов
        // Смотрим остаток от деления количества постов, на их число на 1 страницу
        if (((int)($box['pCount'] % $box['config']['site']['CountPost'])) != "0" && $box['pCount'] > $box['config']['site']['CountPost']){
            $box['pMax'] = (int)($box['pCount'] / $box['config']['site']['CountPost']) + 1; // если он есть, то + 1 страница
        } else {
            $box['pMax'] = (int)($box['pCount'] / $box['config']['site']['CountPost']); // Иначе, все хорошо
        }
        // Смотрим номер страницы, и мобирем соответствующий запрос на записи
        if ($_GET['page'] == '0' || $_GET['page'] == '1'){
            $box['params']="order by id desc LIMIT {$box['config']['site']['CountPost']} OFFSET 0"; // для первой страницы
        } else {
            $p = abs($_GET['page']-1)*$box['config']['site']['CountPost'];
            $box['params']="order by id desc LIMIT {$box['config']['site']['CountPost']} OFFSET $p"; // для всех остальных
        }
    } else { // Нет навигации или все убирается на 1 странице, запускаем полный запрос
        $box['params']=""; // Параметры запроса
    }
    $box['posts']=allContent(); // Получим записи из таблицы
}
// Сервисная функция (без прав админа):
function getConfig(){
    // Пробросим глобально переменные
    global $box;
    // Парсим конфиг:
    if (!$config){
        // Чтение файла конфигурации
        $box['config'] = parse_ini_file("../core/config/config.ini", true); 
    }
}
// Сервисная функция (без прав админа):
function getDB(){
    // Пробросим глобально переменные
    global $box;
    // Запросим таблицу
    $box['db'] = dbConnect();
}
// Сервисная функция (без прав админа):
function getImage(){
    if ($_FILES && $_FILES["image"]["error"]== UPLOAD_ERR_OK)
    {
        // Получим расширение файла:
        $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        // Проверим, картинка ли это:
        if ($ext == "png" || $ext == "jpeg" || $ext == "gif" || $ext == "jpg" || $ext == "bmp"){
            // Переименуем файл и загрузим к картинкам.
            function renDown($ext){
                // Генерим случайное имя:
                $avatar = substr(md5(time()), 0, 16).".".$ext;
                // Если его нет, то пишем так:
                if (!file_exists("img/{$avatar}")){
                    move_uploaded_file($_FILES["image"]["tmp_name"], 'img/'. $avatar);
                } else {
                    // Иначе, ну а вдруг, перезапустим гену снова:
                    renDown($ext);
                }
                // Отдадим поле в код:
                return $avatar;
            }
            // Отдадим имя файла дальше в код.
            return renDown($ext);
        }
    }
}
// Сервисная функция (без прав админа):
function getMessage($id){
    // Пробросим глобально переменные
    global $box;
    // Таблица
    $box['table']="messages";
    // Запросим конкретное сообщение
    $box['params']="where `id` = '{$id}'";
    // Вертаем его
    return oneContent();
}
// Функция прочтения сообщения (с просмотром прав):
function readMail(){
    // Пробросим глобально переменные
    global $box;
    // Получим код письма
    $_GET['m_id']=chislo(clear($_GET['m_id']));
    // Получим само письмо
    $message=getMessage($_GET['m_id']);
    if ($_SESSION['id'] == $message['to_id']){ // Если оное нам, то чтим
        $box['table']='messages'; // работаем с сообщениями
        $box['params']="SET `date_read` = '".date("Y-m-d")."' where `id` = '{$_GET['m_id']}'"; // Ставим текущую дату в прочтение
        updContent(); // Обновим запись о том
        alert("Донесение прочитано!"); // И скажем это пользователю
    } else {
        alert("Не тудой Вас тянет, сударь...!"); // И скажем это пользователю
    }
}
// Функция удаления сообщения (с просмотром прав):
function delMail(){
    // Пробросим глобально переменные
    global $box;
    // Получим код сообщения
    $_GET['m_id']=chislo(clear($_GET['m_id']));
    // Запросим послание
    $message=getMessage($_GET['m_id']);
    if ($_SESSION['id'] == $message['to_id'] || $_SESSION['id'] == $message['from_id']){ // Коль оно есть, то проверим доступ пользователя к нему
        $box['table']='messages'; // Определи таблицу
        $box['params']="where `id` = '{$_GET['m_id']}'"; // Определим послание
        delContent(); // Удалим
        alert("Сообщение покинуло этот мир!"); // Уведомим об этом
    } else {
        alert("Не тудой Вас тянет, сударь..."); // Формируем сообщение
    }
}
// Сброс прочтений записи (права админа):
function resetReadings(){
    // Пробросим глобально переменные
    global $box;
    if ($_SESSION['role'] == "0"){ // если права админа, то
        $box['table']='posts'; // работаем с таблицей записи
        $box['params']="SET `readings` = '0' where id = '{$_GET['id']}'"; // Ищем запись и чистим прочтения
        updContent(); // Обновим данные в таблице
        alert("Обнулили прочтение записи на сайте!"); // Сообщим, что все успешно
    }
}
// Сервисная функция (без прав админа):
function genToken(){
    // Пробросим глобально переменные
    global $box;
    // Генерируем уникальный токен
    $token = substr(md5(time()), 0, 16);
    // Добавим к параметру запроса
    $box['params']="where `token` = '{$token}'";
    // Спросим с базы пользователя
    $user=getUser();
    if ($user != ""){ 
        genToken(); // Если оно не уникально, генерим снова
    } else {
        return $token; // Коль токен совсем уникален, то отдадим его
    }
}
// Сервисная функция отправки сообщения
function sendMail($email, $theme, $message){ 
    mail($email, $theme, $message); // Отправим на выбранную почту сообщение с некой темой и текстом
}
// Сброс пароля (функция):
function resetPass(){
    // Пробросим глобально переменные
    global $box;
    // Проверим логин
    $_POST['login']=clear($_POST['login']);
    if ($_POST['login'] != ""){ // оно не пуст
        // Параметр команды
        $box['params']="where `nickname` = '{$_POST['login']}'";
        // Запрос к базе
        $user=getUser();
        if ($user != ""){ // Коль юзверь есть, то
            $box['table']="users"; // Таблица, где работаем
            $token=genToken(); // Генерируем уникальный токен!
            $box['params']="SET `token` = '{$token}' where `nickname` = '{$_POST['login']}'"; // Параметр обращения к БД
            updContent(); // Обновим запись
            sendMail($user['email'], 'Ссылка на сброс пароля', "Доброе время суток, Ваша ссылка сброса пароля:\r\n http://programmer-tm.h1n.ru/admin/admin/?cmd=reset&t_id=$token"); // Отправим сообщение со ссылкой
            alert("Депеша отправлена вам на почту, следуйте по ссылке из письма!"); // Покажем уведомление на сайте
            browse("/admin"); // Переадресация пользователя
        } else {
            alert("Моя - Ваша не искать! Нема на портале..."); // Покажем уведомление на сайте
        }
    } elseif ($_GET['t_id'] != ""){ // Если прилетело ссылко с токеном
        $_GET['t_id']=clear($_GET['t_id']); // Прочистим, ну на всякой случай
        $_POST['password']=clear($_POST['password']); // Посмотрим паролько
        $_POST['password2']=clear($_POST['password2']); // Паролько повторко
        $box['params']="where `token` = '{$_GET['t_id']}'"; // Параметр запроса
        $user=getUser(); // Пробуем искать юзверя...
        if ($_POST['password'] == $_POST['password2'] && $_POST['password'] != "" && $user != ""){ // Коль у нас все хорошо, то идем дальше
            $_POST['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT); // Генерим хеш пароля
            $box['params']="SET `password` = '{$_POST['password']}', `token` = NULL where id = '{$user['id']}'"; // Стыкуем параметр запроса
            updContent(); // Обновляем базу с затиранием токена и сменой пароля
            alert("Успех сопутствует Вам, мастер, можно войти на сайт!"); // Формируем сообщение
            browse("/admin"); // Переадресация пользователя
        } elseif($_POST['password'] != $_POST['password2']) { // Ошибка повтора пароля
            alert("Пароля повтор тебя подвел, барин!"); // Формируем сообщение
            browse("/admin/?cmd=reset&t_id={$_GET['t_id']}"); // Переадресация пользователя
        } elseif ($user == "") { // Если нет пользователя по токену
            alert("Не тудой Вас тянет, сударь..."); // Формируем сообщение
            browse(); // Переадресация пользователя
        }
    }
}
// Функция удаления изображения:
function delImage($file){ // принимаем имя картинки
    unlink("img/{$file}"); // Удаляем
}
// Модератор:
function setUser(){
    // Пробросим глобально переменные
    global $box;
    // Проверяем роль и 1 номер в базе
    if ($_SESSION['role'] == "0" && $_GET['u_id'] != "1"){ // Роль админа и не 1 номер
        $user=getUser($_GET['u_id']); // Получим пользователя по номеру в базе
        $box['table']="users"; // В какой таблице правим
        if ($user['role'] == "2"){ // Если роль пользователя, то в модераторы
            $box['params']="SET `role` = '1' where id = '{$_GET['u_id']}'"; // Назначаем модератором
            alert("Сказано модерировать!"); // Генерируем сообщение на сайт
        } elseif ($user['role'] == "1"){ // Если он уже модератор, разжалуем
            $box['params']="SET `role` = '2' where id = '{$_GET['u_id']}'"; // Разжалуем
            alert("Сказано не модерировать!"); // Генерируем сообщение
        } else { // Иначе
            $box['params']="SET `role` = '2' where id = '{$_GET['u_id']}'";
            alert("Лежать!"); // Генерируем сообщение
        }
        updContent(); // Запишем изменения
    } else {
        alert("Куды полез! Не трож болезных..."); // Генерируем сообщение
    }
}
// Блок настройки конфига:
function updConf(){
    // Пробросим глобально переменные
    global $box;
    // Открываем файл по ссылке с правами на запись
    $fp = fopen('../core/config/config.ini', 'w+');
    // Обходим имеющийся конфиг
    foreach($box['config'] as $parts => $array){
        // Записываем раздел конфигурации в файл
        fwrite($fp, "[{$parts}]\n");
        // Обходим раздел внутри
        foreach($array as $params => $value){
            // Записываем параметр и значение в файл
            fwrite($fp, "$params = '$value'\n");
        }
    }
    // Закрываем файл и сохраняем его
    fclose($fp);
}
// Установка таблиц:
function setTable(){
    // Пробросим глобально переменные
    global $box;
    // Установим таблицы (Дамп с phpmyadmin):
    // Зададим параметры
    $box['params'] = "CREATE TABLE `comments` (
    `id` int(11) NOT NULL,
    `post_id` int(11) DEFAULT NULL,
    `name` varchar(20) NOT NULL,
    `email` varchar(100) NOT NULL,
    `text` varchar(255) NOT NULL,
    `moder_id` int(11) DEFAULT NULL,
    `status` tinyint(4) NOT NULL DEFAULT 1,
    `date_write` date NOT NULL DEFAULT current_timestamp(),
    `date_modification` date DEFAULT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";
    // Выполним запрос
    addTable();
    // Зададим параметры
    $box['params'] = "CREATE TABLE `posts` (
    `id` int(11) NOT NULL,
    `title` varchar(50) NOT NULL,
    `text` text NOT NULL,
    `date_write` date NOT NULL,
    `readings` int(11) NOT NULL DEFAULT 0,
    `image` varchar(255) DEFAULT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";
    // Выполним запрос
    addTable();
    // Зададим параметры
    $box['params'] = "CREATE TABLE `users` (
    `id` int(11) NOT NULL,
    `nickname` varchar(13) NOT NULL,
    `name` varchar(20) NOT NULL,
    `surename` varchar(25) NOT NULL,
    `email` varchar(100) NOT NULL,
    `role` tinyint(4) NOT NULL DEFAULT 2,
    `password` varchar(255) NOT NULL,
    `date_register` date NOT NULL DEFAULT current_timestamp(),
    `date_login` date DEFAULT NULL,
    `avatar` varchar(255) DEFAULT NULL,
    `token` varchar(16) DEFAULT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";
    // Выполним запрос
    addTable();
    // Зададим параметры
    $box['params'] = "CREATE TABLE `messages` (
    `id` int(11) NOT NULL,
    `from_id` int(11) NOT NULL,
    `to_id` int(11) NOT NULL,
    `message` varchar(255) NOT NULL,
    `date_write` date NOT NULL DEFAULT current_timestamp(),
    `date_read` date DEFAULT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";
    // Выполним запрос
    addTable();
    // Добавим логику БД
    // Зададим параметры
    $box['params'] = "ALTER TABLE `comments`
    ADD PRIMARY KEY (`id`),
    ADD KEY `status` (`status`);";
    // Выполним запрос
    addTable();
    // Зададим параметры
    $box['params'] = "ALTER TABLE `messages`
    ADD PRIMARY KEY (`id`),
    ADD KEY `from_id` (`from_id`),
    ADD KEY `to_id` (`to_id`);";
    // Выполним запрос
    addTable();
    // Зададим параметры
    $box['params'] = "ALTER TABLE `posts`
    ADD PRIMARY KEY (`id`);";
    // Выполним запрос
    addTable();
    // Зададим параметры
    $box['params'] = "ALTER TABLE `users`
    ADD PRIMARY KEY (`id`),
    ADD UNIQUE KEY `nickname` (`nickname`),
    ADD UNIQUE KEY `email` (`email`),
    ADD UNIQUE KEY `token` (`token`);";
    // Выполним запрос
    addTable();
    // Обнуляем автоинкременты...
    // Зададим параметры
    $box['params'] = "ALTER TABLE `comments`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;";
    // Выполним запрос
    addTable();
    // Зададим параметры
    $box['params'] = "ALTER TABLE `messages`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;";
    // Выполним запрос
    addTable();
    // Зададим параметры
    $box['params'] = "ALTER TABLE `posts`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;";
    // Выполним запрос
    addTable();
    // Зададим параметры
    $box['params'] = "ALTER TABLE `users`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;";
    // Выполним запрос
    addTable();
    // Добавим админа:
    if (!empty($_POST['admin'])){ // Если есть входные данные, то
        $_POST['admin']['nickname']=clear($_POST['admin']['nickname']); // Обработка вводимых данных
        $_POST['admin']['name']=clear($_POST['admin']['name']); // Обработка вводимых данных
        $_POST['admin']['surename']=clear($_POST['admin']['surename']); // Обработка вводимых данных
        $_POST['admin']['email']=clear($_POST['admin']['email']); // Обработка вводимых данных
        $_POST['admin']['password']=password_hash(clear($_POST['admin']['password']), PASSWORD_DEFAULT); // Обработка вводимых данных, генерация хеша пароля
    }
    // Добавим админа в базу:
    // Зададим параметры
    $box['params'] = "INSERT INTO `users` (`id`, `nickname`, `name`, `surename`, `email`, `role`, `password`) VALUES
    (1, '{$_POST['admin']['nickname']}', '{$_POST['admin']['name']}', '{$_POST['admin']['surename']}', '{$_POST['admin']['email']}', 0, '{$_POST['admin']['password']}');";
    // Выполним запрос
    addTable();
}
// Проверим отсутствие таблиц
function checkTables(){
    // Пробросим глобально переменные
    global $box;
    // Зададим параметры
    $box['params']="SHOW TABLES like 'posts'";
    // Запрос данных из базы
    $posts=freeContent();
    // Зададим параметры
    $box['params']="SHOW TABLES like 'comments'";
    // Запрос данных из базы
    $comments=freeContent();
    // Зададим параметры
    $box['params']="SHOW TABLES like 'users'";
    // Запрос данных из базы
    $users=freeContent();
    // Зададим параметры
    $box['params']="SHOW TABLES like 'messages'";
    // Запрос данных из базы
    $messages=freeContent();
    // Проверка состояния таблиц
    if (empty($users) && empty($posts) && empty($messages) && empty($comments)){
        return true; // Таблиц нет
    } else {
        return false; // Они есть
    }
}
// Блок проверки конфига:
function checkConf(){
    // Проходим конфиг в посте
    foreach($_POST['config'] as $parts => $array){
    // Проходим конфиг в посте
        foreach($array as $params => $value){
        // Очищаем входные данные
            $_POST['config']["$parts"]["$params"]=clear($value);
        }
    }
}
// Функция рендеринга
function render(){
    // Пробросим глобально переменные
    global $box;
    // Включение буферизации вывода
    ob_start();
    // Подключаем файл формы вывода соответствующей темы
    include_once "../core/theme/".$box['config']['site']['theme']."/".$box['route'].".php";
    // Буфер чтения файла добавим в переменную
    $box['data'] = ob_get_contents();
    // Чистим буфер
    ob_end_clean();
    // Подключаем главный шаблон
    include_once "../core/theme/".$box['config']['site']['theme']."/main.php";
}