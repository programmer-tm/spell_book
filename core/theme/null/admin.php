<?php
echo $box['config']['site']['title']."<br>";
if ($_SESSION['login']){
    echo '<pre>';
    var_dump(get_defined_vars());
    echo '</pre>';
} else {
    echo '<form action="/admin" method="post" enctype="multipart/form-data">
    <input type="text" placeholder="Введите логин" name="login" required><br>
    <input type="password" placeholder="Введите пароль" name="password" required><br>
    <button type="submit">Вход</button>
    <button type="reset" class="cancelbtn">Очистить</button><br>
</form>';
}