<?php
echo "<a href=/>".$box['config']['site']['title']."</a><br>";
echo '<a onclick="javascript:history.back(); return false;" title="Назад в будущее!">Назад</a><br>';
?>
<?php if($_SESSION['login']):?>
    <a href=/logout>Выход</a> <a href=/mail>(<?=$box['mail'];?>)</a><br>
    <form action="/admin" method="post" enctype="multipart/form-data">
        <img loading="auto" src="/img/<?=$box['user']['avatar'];?>" width="350" height="250" alt="<?=$box['user']['nickname'];?>"><br>
        <input accept=".jpg, .jpeg, .png, .gif, .bmp" name="image" type="file" /><br>
        <input class="form_in_reg" type="text" value="<?=$box['user']['name'];?>" name="user[name]" required><br>
        <input class="form_in_reg" type="text" value="<?=$box['user']['surename'];?>" name="user[surename]" required><br>
        <input class="form_in_reg" type="password" placeholder="Введите пароль" name="user[password]"><br>
        <input class="form_in_reg" type="password" placeholder="Введите пароль" name="user[password2]"><br>
        <button type="submit">Изменить</button> <button type="reset" class="cancelbtn">Отменить всё!</button>
        <a href="/admin/?cmd=del">Самоликвидироваться!!!</a>
    </form>
    <?php if($_SESSION['role'] != 2):?>
        <p>Вашего внимания ожидают несколько комментариев... (<?=$box['countComments'];?>)</p>
        <?php foreach($box['comments'] as $comment):?>
            <p><?=$comment['name'];?> пишет: <?=$comment['text'];?> <a href=/post/?id=<?=$comment['post_id'];?>>Тут</a></p>
        <?php endforeach;?>
    <?php endif;?>
    <?php if($_SESSION['role'] == "0"):?>
        <h2>Управление пользователями</h2>
        <?php foreach($box['userlist'] as $user):?>
            <p>Пользователь: <?=$user['nickname'];?> (<?=$user['name'];?>, <?=$user['surename'];?>)<br>Зарегистрирован: <?=$user['date_register'];?>,<br>Последний раз был: <?=$user['date_login'];?></p>
            <br><a href="/admin/?cmd=upd&u_id=<?=$user['id'];?>">
            <?php if($user['role'] == "2"):?>
                В модераторы!
            <?php elseif($user['role'] == "1"):?>
                Разжаловать из модераторов!
            <?php else:?>
                Осторожно, модерн!
            <?php endif;?>
            </a>
        <?php endforeach;?>
        <h1>Управление настройками сайта</h1>
        <form action="/admin" method="post" enctype="multipart/form-data">
            Количество постов на страницу: <input type="number" value="<?=$box['config']['site']['CountPost'];?>" name="CountPost" required><br>
            Число личных сообщений: <input type="number" value="<?=$box['config']['site']['CountMessage'];?>" name="CountMessage" required><br>
            Тема сайта: <select name="theme">
                <?php foreach (scandir('../core/theme') as $k => $theme):?>
                    <?php if($theme != "." && $theme != ".." && is_dir("../core/theme/$theme")):?>
                        <?php if($theme == $box['config']['site']['theme']):?>
                            <option selected value="<?=$theme;?>"><?=$theme;?></option>
                        <?php else:?>
                            <option value="<?=$theme;?>"><?=$theme;?></option>
                        <?php endif;?>
                    <?php endif;?>
                <?php endforeach;?>
                </select><br>
            <button type="submit">Изменить</button> <button type="reset" class="cancelbtn">Отменить всё!</button>
        </form>
    <?php endif;?> 
<?php elseif($_GET['cmd'] == "reset" && $_GET['t_id'] != ""):?>
    <h2>Новый пароль</h2>
    <form action="/admin/?cmd=reset&t_id='.$_GET['t_id'].'" method="post" enctype="multipart/form-data">
        <input class="form_in_reg" type="password" placeholder="Введите пароль" name="password"><br>
        <input class="form_in_reg" type="password" placeholder="Введите пароль" name="password2"><br>
        <button type="submit">Изменить</button>
        <button type="reset" class="cancelbtn">Очистить</button><br>
    </form>
<?php elseif($_GET['cmd'] == "reset"):?>
    <h2>Сброс пароля</h2>
    <form action="/admin/?cmd=reset" method="post" enctype="multipart/form-data">
        <input type="text" placeholder="Введите логин" name="login" required><br>
        <button type="submit">Восстановить</button>
        <button type="reset" class="cancelbtn">Очистить</button><br>
    </form>
<?php else:?>
    <h2>Вход</h2>
        <form action="/admin" method="post" enctype="multipart/form-data">
        <input type="text" placeholder="Введите логин" name="login" required><br>
        <input type="password" placeholder="Введите пароль" name="password" required><br>
        <a href=/admin/?cmd=reset>Забыл пароль?</a><br>
        <button type="submit">Вход</button>
        <button type="reset" class="cancelbtn">Очистить</button><br>
    </form><br>
    <h2>Регистрация</h2>
    <form action="/admin" method="post" enctype="multipart/form-data">
        <input class="form_in_reg" type="text" placeholder="Введите логин" name="user[nickname]" required><br>
        <input class="form_in_reg" type="text" placeholder="Введите имя" name="user[name]" required><br>
        <input class="form_in_reg" type="text" placeholder="Введите фамилию" name="user[surename]" required><br>
        <input class="form_in_reg" type="email" placeholder="Введите email" name="user[email]" required><br>
        <input class="form_in_reg" type="password" placeholder="Введите пароль" name="user[password]" required><br>
        <input class="form_in_reg" type="password" placeholder="Введите пароль" name="user[password2]" required><br>
        <button type="submit">Регистрировать меня!</button> <button type="reset" class="cancelbtn">Отменить всё!</button>
    </form>
<?php endif;?>