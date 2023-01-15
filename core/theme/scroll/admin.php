<?php if($_SESSION['login']):?>
    <div class="post">
	<div class="post-title">
		<div class="post-date">
			<br>
			<?=$box['user']['date_register'];?>
		</div>
        <form action="/admin" method="post" enctype="multipart/form-data">		
		<h2>
            О Вас
		</h2>
	</div>
	<div class="post-entry">
        <img loading="auto" src="/img/<?php echo ($_SESSION['avatar']) ?: 'admin.gif';?>" width="350" height="250" alt="<?=$box['user']['nickname'];?>"><br>
		<input accept=".jpg, .jpeg, .png, .gif, .bmp" name="image" type="file" /><br>
        Имя: <input class="form_in_reg" type="text" value="<?=$box['user']['name'];?>" name="user[name]" required><br>
        Фамилия: <input class="form_in_reg" type="text" value="<?=$box['user']['surename'];?>" name="user[surename]" required><br>
        Новый пароль: <input class="form_in_reg" type="password" placeholder="Введите пароль" name="user[password]"><br>
        Повтор: <input class="form_in_reg" type="password" placeholder="Введите пароль" name="user[password2]"><br>
	</div>
	<div class="post-info">
    <button type="submit">Изменить</button> <button type="reset" class="cancelbtn">Отменить всё!</button>
        <input type="button" onclick="if(confirm('Убить тебя об стенку?!\nЭта операция не обратима!')){document.location.href = '/admin/?cmd=del';};" value="Удалить профиль"/>
    </form>
	</div>
	<div class="clear"></div>
    </div>
    <?php if($_SESSION['role'] != 2):?>
        <div class="post">
	    <div class="post-title">
		<div class="post-date">
			<br>
			<center>***</center>
		</div>	
		<h2>
            Новые комментарии (<?=$box['countComments'];?>)
		</h2>
        </div>
        <div class="post-entry">
            <?php foreach($box['comments'] as $comment):?>
                <a href=/post/?id=<?=$comment['post_id'];?>><?=$comment['name'];?> пишет: <?=$comment['text'];?></a></p>
            <?php endforeach;?>
        </div>
        <div class="post-info">
            Вас понял!
        </div>
        <div class="clear"></div>
        </div>
    <?php endif;?>
    <?php if($_SESSION['role'] == "0"):?>

        <div class="post">
	    <div class="post-title">
		<div class="post-date">
			<br>
			<center>***</center>
		</div>	
		<h2>
            <h2>Управление пользователями</h2>
		</h2>
        </div>
        <div class="post-entry">
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
        </div>
        <div class="post-info">
            Вас понял!
        </div>
        <div class="clear"></div>
        </div>

        <div class="post">
	    <div class="post-title">
		<div class="post-date">
			<br>
			<center>***</center>
		</div>	
		<h2>
            <h1>Управление настройками сайта</h1>
		</h2>
        </div>
        <div class="post-entry">
            <form action="/admin" method="post" enctype="multipart/form-data">
                Записей на страницу: <input type="number" value="<?=$box['config']['site']['CountPost'];?>" name="CountPost" required><br>
                Максимум личных сообщений: <input type="number" value="<?=$box['config']['site']['CountMessage'];?>" name="CountMessage" required><br>
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
        </div>
        <div class="post-info">
            Вас понял!
        </div>
        <div class="clear"></div>
        </div>
    <?php endif;?> 
<?php elseif($_GET['cmd'] == "reset" && $_GET['t_id'] != ""):?>
    <div class="post">
	<div class="post-title">
		<div class="post-date">
			<br>
			<p><center>***</center></p>
		</div>			
	    <h2>Новый пароль</h2>
	</div>
	<div class="post-entry">
	<form action="/admin/?cmd=reset&t_id='.$_GET['t_id'].'" method="post" enctype="multipart/form-data">
        <input class="form_in_reg" type="password" placeholder="Введите пароль" name="password"><br>
        <input class="form_in_reg" type="password" placeholder="Введите пароль" name="password2"><br>
        <button type="submit">Изменить</button>
	</div>
	<div class="post-info">
    <button type="submit">Вход</button>
        <button type="reset" class="cancelbtn">Очистить</button><br>
    </form>
	</div>
	<div class="clear"></div>
    </div>
<?php elseif($_GET['cmd'] == "reset"):?>
    <div class="post">
	<div class="post-title">
		<div class="post-date">
			<br>
			<p><center>***</center></p>
		</div>			
	    <h2>Сброс пароля:</h2>
	</div>
	<div class="post-entry">
	<form action="/admin/?cmd=reset" method="post" enctype="multipart/form-data">
        <input type="text" placeholder="Введите логин" name="login" required><br>
        <button type="submit">Восстановить</button>
	</div>
	<div class="post-info">
        <button type="reset" class="cancelbtn">Очистить</button><br>
    </form>
	</div>
	<div class="clear"></div>
    </div>
<?php else:?>
    <div class="post">
	<div class="post-title">
		<div class="post-date">
			<br>
			<p><center>***</center></p>
		</div>			
	    <h2>Вход:</h2>
	</div>
	<div class="post-entry">
	<form action="/admin" method="post" enctype="multipart/form-data">
        <input type="text" placeholder="Введите логин" name="login" required><br>
        <input type="password" placeholder="Введите пароль" name="password" required><br>
        <a href=/admin/?cmd=reset>Забыл пароль?</a><br>
	</div>
	<div class="post-info">
    <button type="submit">Вход</button>
        <button type="reset" class="cancelbtn">Очистить</button>
    </form>
	</div>
	<div class="clear"></div>
    </div>

    <div class="post">
	<div class="post-title">
		<div class="post-date">
			<br>
			<p><center>***</center></p>
		</div>			
	    <h2>Регистрация:</h2>
	</div>
	<div class="post-entry">
	<form action="/admin" method="post" enctype="multipart/form-data">
        <input class="form_in_reg" type="text" placeholder="Введите логин" name="user[nickname]" required><br>
        <input class="form_in_reg" type="text" placeholder="Введите имя" name="user[name]" required><br>
        <input class="form_in_reg" type="text" placeholder="Введите фамилию" name="user[surename]" required><br>
        <input class="form_in_reg" type="email" placeholder="Введите email" name="user[email]" required><br>
        <input class="form_in_reg" type="password" placeholder="Введите пароль" name="user[password]" required><br>
        <input class="form_in_reg" type="password" placeholder="Введите пароль" name="user[password2]" required><br>
	</div>
	<div class="post-info">
        <button type="submit">Регистрировать меня!</button> <button type="reset" class="cancelbtn">Отменить всё!</button>
    </form>
	</div>
	<div class="clear"></div>
    </div>
<?php endif;?>