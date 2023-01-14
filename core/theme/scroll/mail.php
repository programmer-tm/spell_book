<?php if(empty($box['incoming'])):?>
    <div class="post">
	    <div class="post-title">
		<div class="post-date">
			<br>
			<center>***</center>
		</div>	
		<h2>
            Входящие
		</h2>
        </div>
        <div class="post-entry">
            Писем до Вас нет...
        </div>
        <div class="post-info">
            Вас понял!
        </div>
        <div class="clear"></div>
    </div>
<?php else:?>
    <div class="post">
	    <div class="post-title">
		<div class="post-date">
			<br>
			<center>***</center>
		</div>	
		<h2>
            Входящие
		</h2>
        </div>
        <div class="post-entry">
            <?php foreach($box['incoming'] as $in):?>
                <?php foreach($box['userlist'] as $to):?>
                    <?php if($to['id'] == $in['from_id']):?>
                        <p>Тебе пишет: <?=$to['nickname'];?>(<?=$to['surename'];?> <?=$to['name'];?>) Сообщение: <?=$in['message'];?></p>
                    <?php endif;?>
                <?php endforeach;?>
                <p>Отправлено: <?=$in['date_write'];?></p>
                <p>
                <?php if(is_null($in['date_read'])):?>
                    <a href=/mail/?cmd=read&m_id=<?=$in['id'];?>>Прочитать!</a>
                <?php endif;?>
                </p>
                <a href=/mail/?cmd=del&m_id=<?=$in['id'];?>>Удалить!</a>
            <?php endforeach;?>
        </div>
        <div class="post-info">
            Вас понял!
        </div>
        <div class="clear"></div>
    </div>    
<?php endif;?>

<?php if(empty($box['outgoing'])):?>
    <div class="post">
	    <div class="post-title">
		<div class="post-date">
			<br>
			<center>***</center>
		</div>	
		<h2>
            Исходящие
		</h2>
        </div>
        <div class="post-entry">
            Писем от Вас нет...
        </div>
        <div class="post-info">
            Вас понял!
        </div>
        <div class="clear"></div>
    </div>
<?php else:?>
    <div class="post">
	    <div class="post-title">
		<div class="post-date">
			<br>
			<center>***</center>
		</div>	
		<h2>
            Исходящие
		</h2>
        </div>
        <div class="post-entry">
            <?php foreach($box['outgoing'] as $out):?>
                <?php foreach($box['userlist'] as $to):?>
                    <?php if($to['id'] == $out['to_id']):?>
                        <p>Ты пишешь: <?=$to['nickname'];?>(<?=$to['surename'];?> <?=$to['name'];?>) Сообщение: <?=$out['message'];?></p>
                    <?php endif;?>
                <?php endforeach;?>
                <p>Отправлено: <?=$out['date_write'];?></p>
                <p>
                <?php if(!is_null($out['date_read'])):?>
                    Прочитано: <?=$out['date_read'];?>
                <?php else:?>
                    Не прочитано
                <?php endif;?>
                </p>
                <a href=/mail/?cmd=del&m_id=<?=$out['id'];?>>Удалить!</a>
            <?php endforeach;?>
        </div>
        <div class="post-info">
            Вас понял!
        </div>
        <div class="clear"></div>
    </div>
<?php endif;?>

<?php if($_SESSION['id'] !=""):?>
    <div class="post">
	<div class="post-title">
		<div class="post-date">
        <br>
        <p class="post-date-title">Новое</p>
		</div>			
		<h2>Выбор пользователя</h2>
	</div>
	<div class="post-entry">
    <form method="post" enctype="multipart/form-data">
        <select name="to_id">
            <?php foreach($box['userlist'] as $to):?>
                <option value="<?=$to['id'];?>"><?=$to['nickname'];?>(<?=$to['surename'];?> <?=$to['name'];?>)</option>
            <?php endforeach;?>
        </select>
        <p>Введите сообщение:</p>
        <textarea name="message"></textarea>
        <button type="submit">Отправить</button>
    </form>
	</div>
	<div class="post-info">
    Вас понял!
	</div>
	<div class="clear"></div>
    </div>   
<?php endif;?>