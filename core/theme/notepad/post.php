<div id="right_content">
    <?php if($_SESSION['role'] == "0"):?>
        <form action="?id=<?=$box['post']['id'];?>&cmd=updPost" method="post" enctype="multipart/form-data">
    <?php endif;?>
    <h2>
        <?php if($_SESSION['role'] == "0"):?>
            Управление постом:<br><input type="text" value="<?=$box['post']['title']?>" name="post[title]" required>
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
        <button type="submit">Сохранить</button><button type="reset" class="cancelbtn">Отменить</button><button onclick="if(confirm('Затереть пост?!\nЭта операция не обратима!')){document.location.href = '?id=<?=$box['post']['id'];?>&cmd=delPost';};">Удалить пост</button><button onclick="if(confirm('Обнулить просмотры записи?!')){document.location.href = '?id=<?=$box['post']['id'];?>&cmd=rest';};">Удалить прочтения</button><br>
    <?php endif;?>
    <?=$box['post']['date_write'];?>
    <?php if($_SESSION['role'] == "0"):?>
        </form>
    <?php endif;?>
    <hr class="hr" align="right">
</div>
<?php if(empty(getComments("where `post_id` = '{$box['post']['id']}' AND `status` = '0'")) && $_SESSION['id'] == ""):?>
    <div id="right_content">
        <h2>Нет доступных комментариев...</h2>
        <hr class="hr" align="right">
    </div>
<?php else:?>
    <?php foreach($box['comments'] as $comment):?>
        <div id="right_content">
            <?php if(($_SESSION['role'] != "2" && $_SESSION['role'] != "") || $comment['name'] == $_SESSION['login']):?>
                <form action="?id=<?=$box['post']['id'];?>&cmd=updComment" method="post" enctype="multipart/form-data">
                    <h2>Управление комментарием:</h2>
                    <input type="text" value="<?=$comment['id'];?>" name="comment[id]" required hidden><br>
                    <input type="text" value="<?=$comment['name'];?>" name="comment[name]" required><br>
                    <textarea name="comment[text]" rows="19" cols="44"><?=$comment['text'];?></textarea><br>
                    <button type="submit">Сохранить</button>
                    <button type="reset" class="cancelbtn">Отменить</button>
                    <?php if($_SESSION['role'] != "2"):?>
                        <button onclick="if(confirm('Изменить статус комментария?!')){document.location.href = '?id=<?=$box['post']['id'];?>&cmd=modComment&c_id=<?=$comment['id'];?>';};"><?php if($comment['status'] == "0"):?>Закрыть!<?php elseif($comment['status'] == "1"):?>Публиковать!<?php else:?>На проверку!<?php endif;?></button>
                    <?php else:?> 
                        <p>
                        <?php if($comment['status'] == "0"):?>
                            Опубликовано
                        <?php else:?>
                            На модерации
                        <?php endif;?>
                        </p>
                    <?php endif;?>
                    <button onclick="if(confirm('Удалить комментарий?!')){document.location.href = '?id=<?=$box['post']['id'];?>&cmd=delComment&c_id=<?=$comment['id'];?>';};">Удалить комментарий</button>
                        <?php foreach($box['userlist'] as $user):?>
                            <?php if($user['id'] == $comment['moder_id']):?>
                                <p>Последние действия: (<?=$user['nickname']?>, <?=$comment['date_modification'];?>)</p>
                            <?php endif;?>
                        <?php endforeach;?>
                    </form>
                    <p>Оставлен: <?=$comment['date_write'];?></p>
                    <hr class="hr" align="right">
                <?php elseif($comment['status'] == "0"):?>
                    <h2>Комментирует: <?=$comment['name'];?></h2>
                    <p>Пишет: <?=$comment['text'];?></p> 
                    <p>Оставлен: <?=$comment['date_write'];?></p>
                    <hr class="hr" align="right">
                <?php endif;?>
            
        </div>
    <?php endforeach;?>
<?php endif;?>
<div id="right_content">
    <h2>Форма отправки комментариев:</h2>
    <form action="/post/?id=<?=$box['post']['id'];?>&cmd=addComment" method="post" enctype="multipart/form-data">
        <?php if (!$_SESSION['login']):?>
            <input type="text" placeholder="Введите имя" name="comment[name]" required>(Ваше имя)<br>
            <input type="email" size = 25 placeholder="Введите email" name="comment[email]" required>(Email)<br>
        <?php endif;?>
        <textarea placeholder="Введите текст комментария" name="comment[text]" required></textarea>(Комментарий)<br>
        <button type="submit">Отправить</button>
        <button type="reset" class="cancelbtn">Очистить</button>
    </form>
    <hr class="hr" align="right">
</div>