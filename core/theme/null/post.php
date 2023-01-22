<?php echo "<a href=/>".$box['config']['site']['title']."</a><br>";

echo $box['post']['title']."<br>";
?>

<?php if($_SESSION['role'] == "0"):?>
	<form action="?id=<?=$box['post']['id'];?>&cmd=updPost" method="post" enctype="multipart/form-data">
<?php endif;?>
<?=$box['post']['date_write'];?>		
<h2>
	<?php if($_SESSION['role'] == "0"):?>
		<input type="text" value="<?=$box['post']['title']?>" name="post[title]" required>
	<?php else:?>
		<?=$box['post']['title'];?>
	<?php endif;?>
</h2>
<img loading="auto" src="/img/<?php echo ($box['post']['image']) ?: 'null.jpeg';?>" width="350" height="250" alt="<?=$box['post']['title']?>"><br>
<?php if($_SESSION['role'] == "0"):?>
    <input accept=".jpg, .jpeg, .png, .gif, .bmp" name="image" type="file" /><br>
	<textarea name="post[text]" rows="19" cols="44"><?=$box['post']['text'];?></textarea><br>
<?php else:?>
	<?php echo str_replace(array("\r\n", "\r", "\n"), '<br>', $box['post']['text'])."<br>"?>
<?php endif;?>
<?php if($_SESSION['role'] == "0"):?>
	<button type="submit">Сохранить</button><button type="reset" class="cancelbtn">Отменить</button>
    <input type="button" onclick="if(confirm('Затереть пост?!\nЭта операция не обратима!')){document.location.href = '?id=<?=$box['post']['id'];?>&cmd=delPost';};" value="Удалить пост"/>
    <input type="button" onclick="if(confirm('Обнулить просмотры записи?!')){document.location.href = '?id=<?=$box['post']['id'];?>&cmd=rest';};" value="Удалить прочтения"/>
<?php else:?>
	Это интересно?
<?php endif;?>
<?php if($_SESSION['role'] == "0"):?>
	</form>
<?php endif;?>

<?php foreach($box['comments'] as $comment):?>
    <?php if(($_SESSION['role'] != "2" && $_SESSION['role'] != "") || $comment['name'] == $_SESSION['login']):?>
        <form action="?id=<?=$box['post']['id'];?>&cmd=updComment" method="post" enctype="multipart/form-data">
        <input type="text" value="<?=$comment['id'];?>" name="comment[id]" required hidden><br>
        <input type="text" value="<?=$comment['name'];?>" name="comment[name]" required><br>
        <textarea name="comment[text]" rows="19" cols="44"><?=$comment['text'];?></textarea><br>
        <button type="submit">Сохранить</button>
        <button type="reset" class="cancelbtn">Отменить</button>
        <?php if($_SESSION['role'] != "2"):?>
            <input type="button" onclick="if(confirm('Изменить статус комментария?!')){document.location.href = '?id=<?=$box['post']['id'];?>&cmd=modComment&c_id=<?=$comment['id'];?>';};" value="<?php if($comment['status'] == "0"):?>Закрыть!<?php elseif($comment['status'] == "1"):?>Публиковать!<?php else:?>На проверку!<?php endif;?>"/><br>
        <?php else:?> 
            <p>
            <?php if($comment['status'] == "0"):?>
                Опубликовано
            <?php else:?>
                На модерации
            <?php endif;?>
            </p>
        <?php endif;?>
        <input type="button" onclick="if(confirm('Удалить комментарий?!')){document.location.href = '?id=<?=$box['post']['id'];?>&cmd=delComment&c_id=<?=$comment['id'];?>';};" value="Удалить комментарий"/>
            <?php foreach($box['userlist'] as $user):?>
                <?php if($user['id'] == $comment['moder_id']):?>
                    <p>Последние действия: (<?=$user['nickname']?>, <?=$comment['date_modification'];?>)</p>
                <?php endif;?>
            <?php endforeach;?>
        </form>
        <p>Оставлен: <?=$comment['date_write'];?></p>
    <?php elseif($comment['status'] == "0"):?>
        <h2><?=$comment['name'];?></h2>
        <p>Пишет: <?=$comment['text'];?></p> 
        <p>Оставлен: <?=$comment['date_write'];?></p>
    <?php endif;?>
<?php endforeach;?>

<!-- Форма отправки коммента, в зависимости от авторизации -->
<h2>Форма отправки комментариев:</h2><br>
<form action="/post/?id=<?=$box['post']['id'];?>&cmd=addComment" method="post" enctype="multipart/form-data">
    <?php if (!$_SESSION['login']):?>
        <input class="form_in_otz_p" type="text" placeholder="Введите имя" name="comment[name]" required><br>
        <input class="form_in_otz_p" type="email" size = 25 placeholder="Введите email" name="comment[email]" required><br>
    <?php endif;?>
    <textarea class="form_in_otz_p_b" placeholder="Введите текст комментария" name="comment[text]" required></textarea><br>
    <button type="submit">Отправить</button>
    <button type="reset" class="cancelbtn">Очистить</button>
</form>