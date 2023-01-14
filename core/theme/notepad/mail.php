<?php if(empty($box['incoming'])):?>
    <div id="right_content">
        <h2>Входящие</h2>
        <p>Писем до Вас нет...</p>
        <hr class="hr" align="right">
    </div>
<?php else:?>
    <div id="right_content">
        <h2>Входящие</h2>
        <?php foreach($box['incoming'] as $in):?>
            <?php foreach($box['userlist'] as $to):?>
                <?php if($to['id'] == $in['from_id']):?>
                    <p>Тебе пишет: <?=$to['nickname'];?>(<?=$to['surename'];?> <?=$to['name'];?>)</p>
                <?php endif;?>
            <?php endforeach;?>
            <p>Сообщение: <?=$in['message'];?></p>
            <p>Отправлено: <?=$in['date_write'];?></p>
            <p>
            <?php if(is_null($in['date_read'])):?>
                <a href=/mail/?cmd=read&m_id=<?=$in['id'];?>>Прочитать!</a>
            <?php endif;?>
            </p>
            <a href=/mail/?cmd=del&m_id=<?=$in['id'];?>>Удалить!</a>
        <?php endforeach;?>
        <hr class="hr" align="right">
    </div>   
<?php endif;?>

<?php if(empty($box['outgoing'])):?>
    <div id="right_content">
        <h2>Исходящие</h2>
        <p>Писем от Вас нет...</p>
        <hr class="hr" align="right">
    </div>
<?php else:?>
    <div id="right_content">
        <h2>Исходящие</h2>
        <?php foreach($box['outgoing'] as $out):?>
            <?php foreach($box['userlist'] as $to):?>
                <?php if($to['id'] == $out['to_id']):?>
                    <p>Ты пишешь: <?=$to['nickname'];?>(<?=$to['surename'];?> <?=$to['name'];?>)</p>
                <?php endif;?>
            <?php endforeach;?>
            <p>Сообщение: <?=$out['message'];?></p>
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
        <hr class="hr" align="right">
    </div>
<?php endif;?>
<?php if($_SESSION['id'] !=""):?>
    <div id="right_content">
        <h2>Выбор пользователя</h2>
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
        <hr class="hr" align="right">
    </div>
<?php endif;?>