<?php if($_SESSION['login']):?>
    <div id="right_content">
        <h2>О Вас</h2>
        <form action="/admin" method="post" enctype="multipart/form-data">
            <img loading="auto" src="/img/<?php echo ($_SESSION['avatar']) ?: 'admin.gif';?>" width="350" height="250" alt="<?=$box['user']['nickname'];?>"><br>
            <input accept=".jpg, .jpeg, .png, .gif, .bmp" name="image" type="file" /><br>
            <input class="form_in_reg" type="text" value="<?=$box['user']['name'];?>" name="user[name]" required>(Имя)<br>
            <input class="form_in_reg" type="text" value="<?=$box['user']['surename'];?>" name="user[surename]" required>(Фамилия)<br>
            <input class="form_in_reg" type="password" placeholder="Введите пароль" name="user[password]">(Пароль)<br>
            <input class="form_in_reg" type="password" placeholder="Введите пароль" name="user[password2]">(Постор пароля)<br>
            <button type="submit">Изменить</button> <button type="reset" class="cancelbtn">Отменить всё!</button><button onclick="if(confirm('Убить тебя об стенку?!\nЭта операция не обратима!')){document.location.href = '/admin/?cmd=del';};">Удалить профиль</button>
        </form>
		<hr class="hr" align="right">
	</div>
    <?php if($_SESSION['role'] != 2):?>
        <div id="right_content">
        <h2>Вашего внимания ожидают несколько комментариев... (<?=$box['countComments'];?>)</h2>
        <?php foreach($box['comments'] as $comment):?>
           <a href=/post/?id=<?=$comment['post_id'];?>><?=$comment['name'];?> пишет: <?=$comment['text'];?></a></p>
        <?php endforeach;?>
		<hr class="hr" align="right">
	    </div>
    <?php endif;?>
    <?php if($_SESSION['role'] == "0"):?>
        <div id="right_content">
            <h2>Управление пользователями</h2>
            <?php foreach($box['userlist'] as $user):?>
                <p>Пользователь: <?=$user['nickname'];?> (<?=$user['name'];?>, <?=$user['surename'];?>)<br>Зарегистрирован: <?=$user['date_register'];?>,<br>Последний раз был: <?=$user['date_login'];?></p>
                <br><button onclick="if(confirm('Изменить роль на сайте, а ты уверен?!')){document.location.href = '/admin/?cmd=upd&u_id=<?=$user['id'];?>';};"><?php if($user['role'] == "2"):?>В модераторы!<?php elseif($user['role'] == "1"):?>Разжаловать из модераторов!<?php else:?>Осторожно, модерн!<?php endif;?></button>
            <?php endforeach;?>
            <hr class="hr" align="right">
        </div>
        <div id="right_content">
            <h2>Управление настройками сайта</h2>
            <form action="/admin" method="post" enctype="multipart/form-data">
                <input type="text" value="<?=$box['config']['site']['title'];?>" name="title" required>(Название проекта)<br>
                <input type="number" value="<?=$box['config']['site']['CountPost'];?>" name="CountPost" required>(Количество постов на страницу)<br>
                <input type="number" value="<?=$box['config']['site']['CountMessage'];?>" name="CountMessage" required>(Число личных сообщений)<br>
                <select name="theme">
                <?php foreach (scandir('../core/theme') as $k => $theme):?>
                    <?php if($theme != "." && $theme != ".." && is_dir("../core/theme/$theme")):?>
                        <?php if($theme == $box['config']['site']['theme']):?>
                            <option selected value="<?=$theme;?>"><?=$theme;?></option>
                        <?php else:?>
                            <option value="<?=$theme;?>"><?=$theme;?></option>
                        <?php endif;?>
                    <?php endif;?>
                <?php endforeach;?>
                </select>(Тема сайта)<br>
                <button type="submit">Изменить</button><button type="reset" class="cancelbtn">Отменить всё!</button>
            </form>
            <hr class="hr" align="right">
        </div>
    <?php endif;?> 
<?php elseif($_GET['cmd'] == "reset" && $_GET['t_id'] != ""):?>
    <div id="right_content">
    <h2>Новый пароль</h2>
    <form action="/admin/?cmd=reset&t_id=<?=$_GET['t_id'];?>" method="post" enctype="multipart/form-data">
        <input class="form_in_reg" type="password" placeholder="Введите пароль" name="password"><br>
        <input class="form_in_reg" type="password" placeholder="Введите пароль" name="password2"><br>
        <button type="submit">Изменить</button>
        <button type="reset" class="cancelbtn">Очистить</button><br>
    </form>
		<hr class="hr" align="right">
	</div>
<?php elseif($_GET['cmd'] == "reset"):?>
    <div id="right_content">
        <h2>Сброс пароля</h2>
        <form action="/admin/?cmd=reset" method="post" enctype="multipart/form-data">
            <input type="text" placeholder="Введите логин" name="login" required><br>
            <button type="submit">Восстановить</button>
            <button type="reset" class="cancelbtn">Очистить</button><br>
        </form>
		<hr class="hr" align="right">
	</div>
<?php else:?>
    <div id="right_content">
    <details id="1" open>
	<summary><h2 onclick="(document.getElementById('2').open = false)">Вход</h2></summary>
		<form action="/admin" method="post" enctype="multipart/form-data">
            <input type="text" placeholder="Введите логин" name="login" required><br>
            <input type="password" placeholder="Введите пароль" name="password" required><br>
            <a href=/admin/?cmd=reset>Забыл пароль?</a><br>
            <button type="submit">Вход</button>
            <button type="reset" class="cancelbtn">Очистить</button><br>
        </form>
		<hr class="hr" align="right">
    </details> 
	</div>
    <div id="right_content">
    <details id="2">
	<summary><h2 onclick="(document.getElementById('1').open = false)">Регистрация</h2></summary>
            <form action="/admin" method="post" enctype="multipart/form-data">
                <input class="form_in_reg" type="text" placeholder="Введите логин" name="user[nickname]" required><br>
                <input class="form_in_reg" type="text" placeholder="Введите имя" name="user[name]" required><br>
                <input class="form_in_reg" type="text" placeholder="Введите фамилию" name="user[surename]" required><br>
                <input class="form_in_reg" type="email" placeholder="Введите email" name="user[email]" required><br>
                <input class="form_in_reg" type="password" placeholder="Введите пароль" name="user[password]" required><br>
                <input class="form_in_reg" type="password" placeholder="Введите пароль" name="user[password2]" required><br>
                <button type="submit">Регистрировать меня!</button> <button type="reset" class="cancelbtn">Отменить всё!</button>
            </form>
            <hr class="hr" align="right">
    </details> 
    </div>
<?php endif;?>