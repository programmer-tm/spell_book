<?php
echo "<a href=/>".$box['config']['site']['title']."</a><br>";
echo '<a onclick="javascript:history.back(); return false;" title="Назад в будущее!">Назад</a><br>';
if ($_SESSION['login']){
    echo "<a href=/logout>Выход</a><br>";
    echo '<form action="/admin" method="post" enctype="multipart/form-data">
    <input class="form_in_reg" type="text" value="'.$box['user']['name'].'" name="user[name]" required><br>
    <input class="form_in_reg" type="text" value="'.$box['user']['surename'].'" name="user[surename]" required><br>
    <input class="form_in_reg" type="password" placeholder="Введите пароль" name="user[password]"><br>
    <input class="form_in_reg" type="password" placeholder="Введите пароль" name="user[password2]"><br>
    <button type="submit">Изменить</button> <button type="reset" class="cancelbtn">Отменить всё!</button>
    <a href="/admin/?cmd=del">Самоликвидироваться!!!</a>
    </form>';
    //echo '<pre>';
    //var_dump(get_defined_vars());
    //echo '</pre>';
} else {
    echo "Вход";
    echo '<form action="/admin" method="post" enctype="multipart/form-data">
    <input type="text" placeholder="Введите логин" name="login" required><br>
    <input type="password" placeholder="Введите пароль" name="password" required><br>
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