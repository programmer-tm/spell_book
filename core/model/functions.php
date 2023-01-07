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

// Свободный запрос
function freeContent(){
    global $box;
    return mysqli_fetch_all(mysqli_query($box['db'], $box['params']), MYSQLI_ASSOC);
}

// Test_setup_block
function addTable(){
    global $box;
    mysqli_query($box['db'], $box['params']);
}
// Блок SQL

// Добавление поста на сайт (права админа):
function addPost(){
    global $box;
    if ($_SESSION['role'] == "0"){
        $_POST['post']['title']=clear($_POST['post']['title']);
        $_POST['post']['text']=clear($_POST['post']['text']);
        $_POST['post']['date_write']=clear($_POST['post']['date_write']);
        $box['table']='posts';
        $box['params']="(`title`, `text`, `date_write`, `image`) VALUES ('{$_POST['post']['title']}', '{$_POST['post']['text']}', '{$_POST['post']['date_write']}', '{$box['image']}')";
        addContent();
    }
}

// Сервисная функция (бесправна):
function clearData(){
    global $box;
    $box['table'] = "";
    $box['params'] = "";
    $_POST=[];
    $_REQUEST=[];
}

// Функция переадресации на любую страницу (без прочих прав):
function browse($link = "/"){
    header("Location: $link");
}

// Функция выхода из сеанса (без прав админа):
function logout(){
    session_destroy();
}

// Получение логина пользователя (без прав админа):
function getLogin(){
    if ($_SESSION['login']){
        return $_SESSION['login'];
    } else {
        return "Гость";
    }
}

// Функция очистки данных (без прав админа):
function clear($data){
    $data=strip_tags($data);
    return $data;
}

// Функция приведения к положительному числу (без прав админа):
function chislo($data){
    $data=abs((int)($data));
    return $data;
}

// Функция авторизации пользователя (без прав админа):
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

// Сервисная функция (без прав админа):
function updReadPost(){
    global $box;
    $box['table']="posts";
    ++$box['post']['readings'];
    $box['params']="SET `readings` = '{$box['post']['readings']}' where `id` = '{$_GET['id']}'";
    updContent();
}

// Получим пост (без прав админа):
function getPost(){
    global $box;
    $_GET['id']=chislo(clear($_GET['id'])); // Смотрим на ссылку и получаем id поста
    $box['table']="posts"; // Выбираем базу данных
    $box['params']="where id=".$_GET['id']; // Пропишем параметры
    $box['post']=oneContent(); // Получим пост
}

// Получение комментариев (без прав админа):
function getComments($params=""){
    global $box;
    $box['table']="comments";
    if ($params != ""){
        $box['params']=$params;
    } else{
        $box['params']="where `post_id` = '{$_GET['id']}'";
    }
    return allContent();
}

// Обновление поста (права админа):
function updPost(){
    global $box;
    if ($box['image'] != ""){
        getPost();
        delImage($box['post']['image']);
    }
    if ($_SESSION['role'] == "0"){
        $_POST['post']['title']=clear($_POST['post']['title']);
        $_POST['post']['text']=clear($_POST['post']['text']);
        $box['table']='posts';
        $box['params']="SET `title` = '{$_POST['post']['title']}', `text` = '{$_POST['post']['text']}', `image` = '{$box['image']}' where id = '{$_GET['id']}'";
        updContent();
    }
}

// Обновление комментариев (С учетом прав):
function updComment(){
    global $box;
    $comment=getComment($_POST['comment']['id']);
    if ($_SESSION['role'] != "2" || $comment['name'] == $_SESSION['login']){
        $_POST['comment']['name']=clear($_POST['comment']['name']);
        $_POST['comment']['text']=clear($_POST['comment']['text']);
        $box['table']='comments';
        $box['params']="SET `name` = '{$_POST['comment']['name']}', `text` = '{$_POST['comment']['text']}', `date_modification` = '".date("Y-m-d")."', `status` = '1' where id = '{$_POST['comment']['id']}'";
        updContent();
    }
}

function delComments($cmd){
    global $box;
    if ($cmd == "post"){
        $box['table']="comments";
        $box['params']="where `post_id` = '{$_GET['id']}'";
        $comments=allContent();
        if (!empty($comments)){
            foreach ($comments as $data){
                $box['params'] = "where id = '{$data['id']}'";
                delContent();
            }
        }
    } elseif ($cmd == "user") {
        $box['table']="comments";
        $box['params']="where `name` = '{$_SESSION['login']}'";
        $comments=allContent();
        if (!empty($comments)){
            foreach ($comments as $data){
                $box['params'] = "where id = '{$data['id']}'";
                delContent();
            }
        }
    }
}

// Удаление постов (права админа):
function delPost(){
    global $box;
    if ($_SESSION['role'] == "0"){
        delComments("post");
        getPost();
        delImage($box['post']['image']);
        $box['table']="posts";
        $box['params'] = "where id = '{$_GET['id']}'";
        delContent();
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
    } elseif ($_SESSION['id'] != ""){
        $user=getUser();
        $box['params']="(`post_id`, `name`, `text`, `email`) VALUES ('{$_GET['id']}', '{$user['nickname']}', '{$_POST['comment']['text']}', '{$user['email']}')";
    } else {
        $box['params']="(`post_id`, `name`, `text`, `email`) VALUES ('{$_GET['id']}', '{$_POST['comment']['name']}', '{$_POST['comment']['text']}', '{$_POST['comment']['email']}')";
    }
    $box['table']='comments';
    addContent();
}

// Сервисная функция (без админа):
function getComment($id){
    global $box;
    $id=chislo(clear($id));
    $box['table']="comments";
    $box['params'] = "where id = '{$id}'";
    return oneContent();
}

// Функция удаления комментария (проверка прав):
function delComment(){
    global $box;
    $box['table']="comments";
    if ($_SESSION['status'] == "0"){
        $box['params'] = "where id = '{$_GET['c_id']}'";
        delContent();
    } else {
        $comment=getComment($_GET['c_id']);
        if ($comment['name'] == $_SESSION['login'] || $_SESSION['role'] == "1"){
            $box['params'] = "SET `status` = '2' where id = '{$_GET['c_id']}'";
            updContent();
        }
    }
}

// Модерация комментариев (+возврат из удаленных, проверка прав админ/модер):
function modComment(){
    global $box;
    if ($_SESSION['role'] != "2"){
        $box['table']='comments';
        $box['params'] = "where id = '{$_GET['c_id']}'";
        $comment=oneContent();
        if ($comment != ""){
            if ($comment['status'] == "1"){
                $box['params']="SET `status` = '0', `moder_id` = '{$_SESSION['id']}', `date_modification` = '".date("Y-m-d")."' where id = '{$_GET['c_id']}'";
            } else {
                $box['params']="SET `status` = '1', `moder_id`  = '{$_SESSION['id']}', `date_modification` = '".date("Y-m-d")."' where id = '{$_GET['c_id']}'";
            }
        }
        updContent();
    }
}

// Регистрация пользователя (без прав админа):
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
    if ($user == "" && $user2 == "" && $_POST['user']['password'] == $_POST['user']['password2']){
        $_POST['user']['password'] = password_hash($_POST['user']['password'], PASSWORD_DEFAULT);
        $box['params']="(`nickname`, `name`, `surename`, `email`, `password`) VALUES ('{$_POST['user']['nickname']}', '{$_POST['user']['name']}', '{$_POST['user']['surename']}', '{$_POST['user']['email']}', '{$_POST['user']['password']}')";
        addContent();
    }
}

// Сервисная функция (без прав админа):
function getUser($id=""){
    global $box;
    $box['table']="users";
    if ($id != ""){
        $box['params']="where `id` = {$id}";
    } elseif ($_SESSION['id'] != ""){
        $box['params']="where `id` = {$_SESSION['id']}";
    }
    return oneContent();
}

// Проверка пользователя на залогиненность и корректность данных:
function updUser(){
    global $box;
    $user=getUser();
    if ($box['image'] != ""){
        delImage($user['avatar']);
        $_SESSION['avatar'] = $box['image'];
    }
    if ($_SESSION['id'] !="" && !empty($user)){
        $_POST['user']['name']=clear($_POST['user']['name']);
        $_POST['user']['surename']=clear($_POST['user']['surename']);
        $_POST['user']['password']=clear($_POST['user']['password']);
        $_POST['user']['password2']=clear($_POST['user']['password2']);
        if ($user['id'] == $_SESSION['id']){
            $box['table']='users';
            if ($_POST['user']['password'] == $_POST['user']['password2'] && $_POST['user']['password'] != ""){
                $_POST['user']['password'] = password_hash($_POST['user']['password'], PASSWORD_DEFAULT);
                $box['params']="SET `name` = '{$_POST['user']['name']}', `surename`  = '{$_POST['user']['surename']}', `password` = '{$_POST['user']['password']}',`avatar` = '{$box['image']}'  where id = '{$_SESSION['id']}'";
            } else {
                $box['params']="SET `name` = '{$_POST['user']['name']}', `surename`  = '{$_POST['user']['surename']}',`avatar` = '{$box['image']}' where id = '{$_SESSION['id']}'";
            }
            updContent();
        }
    }
}

// Удаление пользователя:
function delUser(){
    global $box;
    if ($_SESSION['id'] != "" && $_SESSION['id'] != "1"){
        delImage($_SESSION['avatar']);
        delComments("user");
        getMail();
        foreach ($box['incoming'] as $in){
            $_GET['m_id']=$in['id'];
            delMail();
        }
        foreach ($box['outgoing'] as $out){
            $_GET['m_id']=$out['id'];
            delMail();
        }
        $box['table']="users";
        $box['params'] = "where id = '{$_SESSION['id']}'";
        delContent();
    }
}

// Сервисная функция:
function getMail(){
    global $box;
    if ($_SESSION['id'] != ""){
        $box['table']="messages";
        $box['params']="where `to_id` = '{$_SESSION['id']}'";
        $box['incoming']=allContent();
        $box['table']="messages";
        $box['params']="where `from_id` = '{$_SESSION['id']}'";
        $box['outgoing']=allContent();
    }
}

// Сервисная функция (без прав админа):
function getUsers($cmd=""){
    global $box;
    $box['table']="users";
    if ($cmd == ""){
        $box['params']="where id<>'{$_SESSION['id']}'";
    } else {
        $box['params']="";
    }
    return allContent();
}

// Функция отправки сообщения (права пользователя):
function addMessage(){
    global $box;
    $_POST['to_id']=chislo(clear($_POST['to_id']));
    $box['params']="SELECT count(`id`) as count FROM `messages` where `from_id` = '{$_SESSION['id']}'";
    $mCount=freeContent()['0']['count'];
    if ($mCount < $box['config']['site']['CountMessage'] && $_SESSION['id'] != "" && $_POST['to_id'] != $_SESSION['id']){
        $_POST['message']=clear($_POST['message']);
        $box['table']="messages";
        $box['params']="(`from_id`, `to_id`, `message`) VALUES ('{$_SESSION['id']}', '{$_POST['to_id']}', '{$_POST['message']}')";
        addContent();
    }
}

// Проверить количество непрочитанной почты (права пользователя):
function getMailCount(){
    global $box;
    if ($_SESSION['id'] != ""){
        $box['table']="messages";
        $box['params']="SELECT count('id') as CountMail FROM `{$box['table']}` WHERE `to_id` = '{$_SESSION['id']}' and `date_read` is NULL";
        $box['mail']=freeContent()['0']['CountMail'];
    }
}

// Получить записи (без прав админа):
function getPosts(){
    global $box;
    $_GET['page']=chislo(clear($_GET['page']));
    $box['table']="posts"; // Выберем таблицу с записями
    if ($box['config']['site']['CountPost'] != ""){
        $box['params']="SELECT count(id) as postCount FROM `{$box['table']}`";
        $box['pCount']=freeContent()['0']['postCount'];
        $box['pMax'] = (int)($box['pCount'] / $box['config']['site']['CountPost']);
        if ($_GET['page'] == '0' || $_GET['page'] == '1'){
            $box['params']="order by id desc LIMIT {$box['config']['site']['CountPost']} OFFSET 0";
        } else {
            $p = abs($_GET['page']-1)*$box['config']['site']['CountPost'];
            $box['params']="order by id desc LIMIT {$box['config']['site']['CountPost']} OFFSET $p";
        }
    } else {
        $box['params']=""; // Параметры запроса
    }
    $box['posts']=allContent($table); // Получим все записи из таблицы
}

// Сервисная функция (без прав админа):
function getConfig(){
    global $box;
    // Парсим конфиг:
    if (!$config){
        $box['config'] = parse_ini_file("../core/config/config.ini", true); 
    }
}

// Сервисная функция (без прав админа):
function getDB(){
    global $box;
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
            function renDownAvatar($ext){
                // Генерим случайное имя:
                $avatar = substr(md5(time()), 0, 16).".".$ext;
                // Если его нет, то пишем так:
                if (!file_exists("img/{$avatar}")){
                    move_uploaded_file($_FILES["image"]["tmp_name"], 'img/'. $avatar);
                } else {
                    // Иначе, ну а вдруг, перезапустим гену снова:
                    renDownAvatar($ext);
                }
                // Отдадим поле в код:
                return $avatar;
            }
            // Отдадим имя файла дальше в код.
            return renDownAvatar($ext);
        }
    }
}

// Сервисная функция (без прав админа):
function getMessage($id){
    global $box;
    $box['table']="messages";
    $box['params']="where `id` = '{$id}'";
    return oneContent();
}

// Функция прочтения сообщения (с просмотром прав):
function readMail(){
    global $box;
    $_GET['m_id']=chislo(clear($_GET['m_id']));
    $message=getMessage($_GET['m_id']);
    if ($_SESSION['id'] == $message['to_id']){
        $box['table']='messages';
        $box['params']="SET `date_read` = '".date("Y-m-d")."' where `id` = '{$_GET['m_id']}'";
        updContent();
    }
}

// Функция удаления сообщения (с просмотром прав):
function delMail(){
    global $box;
    $_GET['m_id']=chislo(clear($_GET['m_id']));
    $message=getMessage($_GET['m_id']);
    if ($_SESSION['id'] == $message['to_id'] || $_SESSION['id'] == $message['from_id']){
        $box['table']='messages';
        $box['params']="where `id` = '{$_GET['m_id']}'";
        delContent();
    }
}

// Сброс прочтений записи (права админа):
function resetReadings(){
    global $box;
    if ($_SESSION['role'] == "0"){
        $box['table']='posts';
        $box['params']="SET `readings` = '0' where id = '{$_GET['id']}'";
        updContent();
    }
}

// Сервисная функция (без прав админа):
function genToken(){
    global $box;
    $token = substr(md5(time()), 0, 16);
    $box['params']="where `token` = '{$token}'";
    $user=getUser();
    if ($user != ""){
        genToken();
    } else {
        return $token;
    }
}

// Сброс пароля (функция):
function resetPass(){
    global $box;
    $_POST['login']=clear($_POST['login']);
    if ($_POST['login'] != ""){
        $box['params']="where `nickname` = '{$_POST['login']}'";
        $user=getUser();
        if ($user != ""){
            $box['table']="users";
            $token=genToken();
            $box['params']="SET `token` = '{$token}' where `nickname` = '{$_POST['login']}'";
            updContent();
            browse("/admin"); // Переадресация пользователя
        }
    } elseif ($_GET['t_id'] != ""){
        $_GET['t_id']=clear($_GET['t_id']);
        $_POST['password']=clear($_POST['password']);
        $_POST['password2']=clear($_POST['password2']);
        $box['params']="where `token` = '{$_GET['t_id']}'";
        $user=getUser();
        if ($_POST['password'] == $_POST['password2'] && $_POST['password'] != "" && $user != ""){
            $_POST['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $box['params']="SET `password` = '{$_POST['password']}', `token` = NULL where id = '{$user['id']}'";
            updContent();
            browse("/admin"); // Переадресация пользователя
        }
    }
}

// Функция удаления изображения:
function delImage($file){
    unlink("img/{$file}");
}

// Модератор:
function setUser(){
    global $box;
    if ($_SESSION['role'] == "0"){
        $user=getUser($_GET['u_id']);
        if ($user['role'] == "2"){
            $box['table']="users";
            $box['params']="SET `role` = '1' where id = '{$_GET['u_id']}'";
            updContent();
        } elseif ($user['role'] == "1"){
            $box['table']="users";
            $box['params']="SET `role` = '2' where id = '{$_GET['u_id']}'";
            updContent();
        }
    }
}

// Блок настройки конфига:
function updConf(){
    global $box;
    $fp = fopen('../core/config/config.ini', 'w+');
    foreach($box['config'] as $parts => $array){
        fwrite($fp, "[{$parts}]\n");
        foreach($array as $params => $value){
            fwrite($fp, "$params = '$value'\n");
        }
    }
    fclose($fp);
}

// Установка таблиц:
function setTable(){
    global $box;
    // Установим таблицы:
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
    addTable();
    // Комменты залили
    $box['params'] = "CREATE TABLE `posts` (
        `id` int(11) NOT NULL,
        `title` varchar(50) NOT NULL,
        `text` text NOT NULL,
        `date_write` date NOT NULL,
        `readings` int(11) NOT NULL DEFAULT 0,
        `image` varchar(255) DEFAULT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";
    addTable();
    // Посты залили
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
    addTable();
    // Юзеров залили
    $box['params'] = "CREATE TABLE `messages` (
        `id` int(11) NOT NULL,
        `from_id` int(11) NOT NULL,
        `to_id` int(11) NOT NULL,
        `message` varchar(255) NOT NULL,
        `date_write` date NOT NULL DEFAULT current_timestamp(),
        `date_read` date DEFAULT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";
    addTable();
    // Залили таблицу личных сообщений
    // Добавим логику БД:
    $box['params'] = "ALTER TABLE `comments`
        ADD PRIMARY KEY (`id`),
        ADD KEY `status` (`status`);";
    addTable();
    $box['params'] = "ALTER TABLE `messages`
        ADD PRIMARY KEY (`id`),
        ADD KEY `from_id` (`from_id`),
        ADD KEY `to_id` (`to_id`);";
    addTable();
    $box['params'] = "ALTER TABLE `posts`
        ADD PRIMARY KEY (`id`);";
    addTable();
    $box['params'] = "ALTER TABLE `users`
        ADD PRIMARY KEY (`id`),
        ADD UNIQUE KEY `nickname` (`nickname`),
        ADD UNIQUE KEY `email` (`email`),
        ADD UNIQUE KEY `token` (`token`);";
    addTable();
    // Обнуляем автоинкременты...
    $box['params'] = "ALTER TABLE `comments`
        MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;";
    addTable();
    $box['params'] = "ALTER TABLE `messages`
        MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;";
    addTable();
    $box['params'] = "ALTER TABLE `posts`
        MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;";
    addTable();
    $box['params'] = "ALTER TABLE `users`
        MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;";
    addTable();
    // Добавим админа:
    if (!empty($_POST['admin'])){
        $_POST['admin']['nickname']=clear($_POST['admin']['nickname']);
        $_POST['admin']['name']=clear($_POST['admin']['name']);
        $_POST['admin']['surename']=clear($_POST['admin']['surename']);
        $_POST['admin']['email']=clear($_POST['admin']['email']);
        $_POST['admin']['password']=password_hash(clear($_POST['admin']['password']), PASSWORD_DEFAULT);   
    }
    // Добавим админа в базу:
    $box['params'] = "INSERT INTO `users` (`id`, `nickname`, `name`, `surename`, `email`, `role`, `password`) VALUES
    (1, '{$_POST['admin']['nickname']}', '{$_POST['admin']['name']}', '{$_POST['admin']['surename']}', '{$_POST['admin']['email']}', 0, '{$_POST['admin']['password']}');";
    addTable();
}

// Проверим отсутствие таблиц
function checkTables(){
    global $box;
    $box['params']="SHOW TABLES like 'posts'";
    $posts=freeContent();
    $box['params']="SHOW TABLES like 'comments'";
    $comments=freeContent();
    $box['params']="SHOW TABLES like 'users'";
    $users=freeContent();
    $box['params']="SHOW TABLES like 'messages'";
    $messages=freeContent();
    if (empty($users) && empty($posts) && empty($messages) && empty($comments)){
        return true;
    } else {
        return false;
    }
}

// Блок проверки конфига:
function checkConf(){
    global $box;
    foreach($_POST['config'] as $parts => $array){
        foreach($array as $params => $value){
            $_POST['config']["$parts"]["$params"]=clear($value);
        }
    }
}

// Функция рендеринга
function render(){
    global $box;
    ob_start();
    include_once "../core/theme/".$box['config']['site']['theme']."/".$box['route'].".php";
    $data = ob_get_contents();
    ob_end_clean();
    include_once "../core/theme/".$box['config']['site']['theme']."/main.php";
}