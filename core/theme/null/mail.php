<?php
echo "<a href=/>".$box['config']['site']['title']."</a><br>";
echo "Это главная страница сайта<br>";
if (getLogin() != "Гость"){
    echo "<a href=/admin>".getLogin()."</a><a href=/mail>(".$box['mail'].")</a><br>";
    echo "<a href=/logout>Выход</a><br><br>";
} else {
    echo "<a href=/admin>".getLogin()."</a><br><br>";
}
if (empty($box['incoming'])){
    echo "<br>Писем до Вас нет...<br>";
} else {
    echo "Входящие:<br>";
    foreach ($box['incoming'] as $in){
        foreach($box['userlist'] as $to){
            if ($to['id'] == $in['from_id']){
                echo "Тебе пишет: {$to['nickname']}({$to['surename']} {$to['name']})<br>";
            }
        }
        echo 'Сообщение: '.$in['message'].'<br>
        Отправлено: '.$in['date_write'].'<br>';
        if (is_null($in['date_read'])){
            echo '<a href=/mail/?cmd=read&m_id='.$in['id'].'>Прочитать!</a><br>';
        }
        echo '<a href=/mail/?cmd=del&m_id='.$in['id'].'>Удалить!</a><br>';
    }  
}
if (empty($box['outgoing'])){
    echo "<br>Писем от Вас нет...<br>";
} else {
    echo "Исходящие:<br>";
    foreach ($box['outgoing'] as $out){
        foreach($box['userlist'] as $to){
            if ($to['id'] == $out['to_id']){
                echo "Ты пишешь: {$to['nickname']}({$to['surename']} {$to['name']})<br>";
            }
        }
        echo 'Сообщение: '.$out['message'].'<br>
        Отправлено: '.$out['date_write'].'<br>';
        if (!is_null($out['date_read'])){
            echo "Прочитано: {$out['date_read']}<br>";
        } else {
            echo "Не прочитано<br>";
        }
        echo '<a href=/mail/?cmd=del&m_id='.$out['id'].'>Удалить!</a><br>';
    }
}
if ($_SESSION['id'] !=""){
    echo '<form method="post" enctype="multipart/form-data">
    Выбор пользователя:
    <select name="to_id">';
    foreach($box['userlist'] as $to):
        echo '<option value="'.$to['id'].'">'.$to['nickname'].'('.$to['surename'].$to['name'].')</option>';
    endforeach;
    echo '</select>
    <br>
    Введите сообщение:
    <textarea name="message"></textarea>
    <button type="submit">Отправить</button>
    </form>';
}