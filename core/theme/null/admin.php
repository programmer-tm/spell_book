<?php
echo "<a href=/>".$box['config']['site']['title']."</a><br>";
echo '<a onclick="javascript:history.back(); return false;" title="Назад в будущее!">Назад</a><br>';
if ($_SESSION['login']){
    echo "<a href=/logout>Выход</a> <a href=/mail>(".$box['mail'].")</a><br>";
    echo '<form action="/admin" method="post" enctype="multipart/form-data">
    <img loading="auto" src="/img/'.$box['user']['avatar'].'" width="350" height="250" alt="'.$box['user']['nickname'].'"><br>
    <input accept=".jpg, .jpeg, .png, .gif, .bmp" name="image" type="file" /><br>
    <input class="form_in_reg" type="text" value="'.$box['user']['name'].'" name="user[name]" required><br>
    <input class="form_in_reg" type="text" value="'.$box['user']['surename'].'" name="user[surename]" required><br>
    <input class="form_in_reg" type="password" placeholder="Введите пароль" name="user[password]"><br>
    <input class="form_in_reg" type="password" placeholder="Введите пароль" name="user[password2]"><br>
    <button type="submit">Изменить</button> <button type="reset" class="cancelbtn">Отменить всё!</button>
    <a href="/admin/?cmd=del">Самоликвидироваться!!!</a>
    </form>';
    if ($_SESSION['role'] != 2){
        echo "Вашего внимания ожидают несколько комментариев... ({$box['countComments']})<br>";
        foreach ($box['comments'] as $comment) {
            echo "{$comment['name']} пишет: {$comment['text']} <a href=/post/?id={$comment['post_id']}>Тут</a><br>";
        }
    }
    if ($_SESSION['role'] == "0"){
        echo "Управление пользователями:<br>";
        foreach ($box['userlist'] as $user) {
            echo "Пользователь: {$user['nickname']} ({$user['name']}, {$user['surename']})<br>Зарегистрирован: {$user['date_register']},<br>Последний раз был: {$user['date_login']}<br>";
            if ($user['role'] == "2"){
                echo "Пользователь";
                echo "<br><a href=/admin/?cmd=upd&u_id={$user['id']}>Повысить!</a><br>";
            } elseif ($user['role'] == "1"){
                echo "Модератор";
                echo "<br><a href=/admin/?cmd=upd&u_id={$user['id']}>Разжаловать!</a><br>";
            } elseif ($user['role'] == "0"){
                echo "Администратор";
            }
            echo "<br>";
        }
    }
    //echo '<pre>';
    //var_dump(get_defined_vars());
    //echo '</pre>';
} elseif ($_GET['cmd'] == "reset" && $_GET['t_id'] != ""){
    echo "Reset password!";
    echo '<form action="/admin/?cmd=reset&t_id='.$_GET['t_id'].'" method="post" enctype="multipart/form-data">
    <input class="form_in_reg" type="password" placeholder="Введите пароль" name="password"><br>
    <input class="form_in_reg" type="password" placeholder="Введите пароль" name="password2"><br>
    <button type="submit">Изменить</button>
    <button type="reset" class="cancelbtn">Очистить</button><br>
    </form><br><br>';
} elseif ($_GET['cmd'] == "reset"){
    echo "Reset password!";
    echo '<form action="/admin/?cmd=reset" method="post" enctype="multipart/form-data">
    <input type="text" placeholder="Введите логин" name="login" required><br>
    <button type="submit">Восстановить</button>
    <button type="reset" class="cancelbtn">Очистить</button><br>
    </form><br><br>';
} else {
    echo "Вход";
    echo '<form action="/admin" method="post" enctype="multipart/form-data">
    <input type="text" placeholder="Введите логин" name="login" required><br>
    <input type="password" placeholder="Введите пароль" name="password" required><br>
    <a href=/admin/?cmd=reset>Забыл пароль?</a><br>
    <button type="submit">Вход</button>
    <button type="reset" class="cancelbtn">Очистить</button><br>
    </form><br><br>';
    echo "Регистрация";
    echo '<form action="/admin" method="post" enctype="multipart/form-data">
    <input class="form_in_reg" type="text" placeholder="Введите логин" name="user[nickname]" required><br>
    <input class="form_in_reg" type="text" placeholder="Введите имя" name="user[name]" required><br>
    <input class="form_in_reg" type="text" placeholder="Введите фамилию" name="user[surename]" required><br>
    <input class="form_in_reg" type="email" placeholder="Введите email" name="user[email]" required><br>
    <input class="form_in_reg" type="password" placeholder="Введите пароль" name="user[password]" required><br>
    <input class="form_in_reg" type="password" placeholder="Введите пароль" name="user[password2]" required><br>
    <button type="submit">Регистрировать меня!</button> <button type="reset" class="cancelbtn">Отменить всё!</button>
    </form>';
}