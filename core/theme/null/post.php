<?php
echo "<a href=/>".$box['config']['site']['title']."</a><br>";
echo $box['post']['title']."<br>";
if (getLogin() != "Гость"){
    echo "<a href=/admin>".getLogin()."</a><a href=/mail>(".$box['mail'].")</a><br>";
    echo "<a href=/logout>Выход</a><br><br>";
} else {
    echo "<a href=/admin>".getLogin()."</a><br><br>";
}

if ($_SESSION['role'] == "0"){
    echo '<img loading="auto" src="/img/'.$box['post']['image'].'" width="350" height="250" alt="'.$box['post']['title'].'"><br>
    <form action="?id='.$box['post']['id'].'&cmd=updPost" method="post" enctype="multipart/form-data">
    <input type="text" value="'.$box['post']['title'].'" name="post[title]" required><br>
    <textarea name="post[text]" rows="19" cols="44" placeholder="Текст записи">'.$box['post']['text'].'</textarea><br>
    <input accept=".jpg, .jpeg, .png, .gif, .bmp" name="image" type="file" /><br>
    <button type="submit">Сохранить</button>
    <button type="reset" class="cancelbtn">Отменить</button>
    <a href="?id='.$box['post']['id'].'&cmd=delPost">X</a>
    <br><a href="?id='.$box['post']['id'].'&cmd=rest">Clear Readings</a><br> 
    </form>';
} else {
    echo '<img loading="auto" src="/img/'.$box['post']['image'].'" width="350" height="250" alt="'.$box['post']['title'].'"><br>';
    echo $box['post']['title']."<br>";
    echo str_replace(array("\r\n", "\r", "\n"), '<br>', $box['post']['text'])."<br>";
    echo "Написан: {$box['post']['date_write']}<br>";
    echo $box['post']['image']."<br>";
}

if ($_SESSION['role'] || $_SESSION['role'] == "0"){
    if ($_SESSION['role'] != "2"){
        if (empty($box['comments'])){
            echo "Нет комментариев!";
        } else {
            foreach($box['comments'] as $comment){
                echo '<form action="?id='.$box['post']['id'].'&cmd=updComment" method="post" enctype="multipart/form-data">
                <input type="text" value="'.$comment['id'].'" name="comment[id]" required><br>
                <input type="text" value="'.$comment['name'].'" name="comment[name]" required><br>
                <textarea name="comment[text]" rows="19" cols="44">'.$comment['text'].'</textarea><br>
                <button type="submit">Сохранить</button>
                <button type="reset" class="cancelbtn">Отменить</button>';
                if ($comment['status'] == "0"){
                    echo '<a href="?id='.$box['post']['id'].'&cmd=modComment&c_id='.$comment['id'].'">-</a>';
                } elseif ($comment['status'] == "1") {
                    echo '<a href="?id='.$box['post']['id'].'&cmd=modComment&c_id='.$comment['id'].'">+</a>';
                } else {
                    echo '<a href="?id='.$box['post']['id'].'&cmd=modComment&c_id='.$comment['id'].'">NaN</a>';
                }
                echo '<a href="?id='.$box['post']['id'].'&cmd=delComment&c_id='.$comment['id'].'">X</a><br>
                </form>';
                echo "Оставлен: {$comment['date_write']}<br>";
                if ($comment['date_modification']){
                    foreach ($box['userlist'] as $user){
                        if ($user['id'] == $comment['moder_id']){
                            echo "Последние действия: ({$user['nickname']}, {$comment['date_modification']})";
                        }
                    }
                }
            }
        }
    } else {
        if (empty($box['comments'])){
            echo "Нет комментариев!";
        } else {
            foreach($box['comments'] as $comment){
                if ($comment['name'] == $_SESSION['login'] && $comment['status'] != "2"){
                    echo '<form action="?id='.$box['post']['id'].'&cmd=updComment" method="post" enctype="multipart/form-data">
                    <input type="text" value="'.$comment['id'].'" name="comment[id]" required><br>
                    <input type="text" value="'.$comment['name'].'" name="comment[name]" required><br>
                    <textarea name="comment[text]" rows="19" cols="44">'.$comment['text'].'</textarea><br>
                    <button type="submit">Сохранить</button>
                    <button type="reset" class="cancelbtn">Отменить</button>';
                    if ($comment['status'] == "0"){
                        echo 'Опубликовано';
                    } else {
                        echo 'На модерации';
                    }
                    echo '<a href="?id='.$box['post']['id'].'&cmd=delComment&c_id='.$comment['id'].'">X</a><br>
                    </form>';
                } elseif ($comment['status'] == "0"){
                    echo "{$comment['name']} пишет:<br>{$comment['text']}<br>";
                }
                echo "Оставлен: {$comment['date_write']}<br>";
                if ($comment['date_modification']){
                    foreach ($box['userlist'] as $user){
                        if ($user['id'] == $comment['moder_id']){
                            echo "Последние действия: ({$user['nickname']}, {$comment['date_modification']})";
                        }
                    }
                }
            }
        }
    }
} else {
    if (empty($box['comments'])){
        echo "Нет комментариев!";
    } else {
        foreach($box['comments'] as $comment){
            if ($comment['status'] == "0"){
                echo "{$comment['name']} пишет:<br>{$comment['text']}<br>";
            }
            echo "Оставлен: {$comment['date_write']}<br>";
        }
    }
}

echo '<form action="?id='.$box['post']['id'].'&cmd=addComment" method="post" enctype="multipart/form-data">
<input type="text" placeholder="Имя/Ник" name="comment[name]" required><br>
<input type="email" placeholder="Email" name="comment[email]" required><br>
<textarea placeholder="Комментарий" name="comment[text]" rows="19" cols="44"></textarea><br>
<button type="submit">Комментировать</button>
<button type="reset" class="cancelbtn">Очистить</button><br>
</form>';