<?php
echo "<a href=/>".$box['config']['site']['title']."</a><br>";
echo $box['post']['title']."<br>";
echo "<a href=/admin>".getLogin()."</a><br>";
if (getLogin() != "Гость"){
    echo "<a href=/logout>Выход</a><br>";
    if ($_SESSION['role'] == "0"){
        echo '<form action="?id='.$box['post']['id'].'&cmd=updPost" method="post" enctype="multipart/form-data">
        <input type="text" value="'.$box['post']['title'].'" name="post[title]" required><br>
        <textarea name="post[text]" rows="19" cols="44" placeholder="Текст записи">'.$box['post']['text'].'</textarea><br>
        <button type="submit">Сохранить</button>
        <button type="reset" class="cancelbtn">Отменить</button>
        <a href="?id='.$box['post']['id'].'&cmd=delPost">X</a><br>
        </form>';
        echo '<form action="?id='.$box['post']['id'].'&cmd=addComment" method="post" enctype="multipart/form-data">
            <input type="text" placeholder="Имя/Ник" name="comment[name]" required><br>
            <input type="email" placeholder="Email" name="comment[email]" required><br>
            <textarea placeholder="Комментарий" name="comment[text]" rows="19" cols="44"></textarea><br>
            <button type="submit">Комментировать</button>
            <button type="reset" class="cancelbtn">Очистить</button><br>
            </form>';
        foreach($box['comments'] as $comment){
            echo '<form action="?id='.$box['post']['id'].'&cmd=updComment" method="post" enctype="multipart/form-data">
            <input type="text" value="'.$comment['id'].'" name="comment[id]" required><br>
            <input type="text" value="'.$comment['name'].'" name="comment[name]" required><br>
            <textarea name="comment[text]" rows="19" cols="44">'.$comment['text'].'</textarea><br>
            <button type="submit">Сохранить</button>
            <button type="reset" class="cancelbtn">Отменить</button>';
            if ($comment['status'] == "0"){
                echo '<a href="?id='.$box['post']['id'].'&cmd=modComment&c_id='.$comment['id'].'">-</a>';
            } else {
                echo '<a href="?id='.$box['post']['id'].'&cmd=modComment&c_id='.$comment['id'].'">+</a>';
            }
            echo '<a href="?id='.$box['post']['id'].'&cmd=modComment&c_id='.$comment['id'].'">X</a><br>
            </form>';
        }
    } else {
        echo $box['post']['id']."<br>";
        echo $box['post']['title']."<br>";
        echo str_replace(array("\r\n", "\r", "\n"), '<br>', $box['post']['text'])."<br>";
        echo $box['post']['date_write']."<br>";
        echo $box['post']['image']."<br>";
        if (empty($box['comments'])){
            echo "Нет комментариев!";
        } else {
            echo '<form action="?id='.$box['post']['id'].'&cmd=addComment" method="post" enctype="multipart/form-data">
            <input type="text" placeholder="Имя/Ник" name="comment[name]" required><br>
            <input type="email" placeholder="Email" name="comment[email]" required><br>
            <textarea placeholder="Комментарий" name="comment[text]" rows="19" cols="44"></textarea><br>
            <button type="submit">Комментировать</button>
            <button type="reset" class="cancelbtn">Очистить</button><br>
            </form>';
            foreach($box['comments'] as $comment){
                if ($comment['status'] == "0"){
                    echo $comment['id']."<br>";
                    echo $comment['name']." пишет:<br>";
                    echo $comment['text']."<br>";
                    echo $comment['date_write']."<br>";
                }
            }
        }
    }
} else {
    echo $box['post']['id']."<br>";
    echo $box['post']['title']."<br>";
    echo str_replace(array("\r\n", "\r", "\n"), '<br>', $box['post']['text'])."<br>";
    echo $box['post']['date_write']."<br>";
    echo $box['post']['image']."<br>";
    if (empty($box['comments'])){
        echo '<form action="?id='.$box['post']['id'].'&cmd=addComment" method="post" enctype="multipart/form-data">
            <input type="text" placeholder="Имя/Ник" name="comment[name]" required><br>
            <input type="email" placeholder="Email" name="comment[email]" required><br>
            <textarea placeholder="Комментарий" name="comment[text]" rows="19" cols="44"></textarea><br>
            <button type="submit">Комментировать</button>
            <button type="reset" class="cancelbtn">Очистить</button><br>
            </form>';
    } else {
        echo '<form action="?id='.$box['post']['id'].'&cmd=addComment" method="post" enctype="multipart/form-data">
            <input type="text" placeholder="Имя/Ник" name="comment[name]" required><br>
            <input type="email" placeholder="Email" name="comment[email]" required><br>
            <textarea placeholder="Комментарий" name="comment[text]" rows="19" cols="44"></textarea><br>
            <button type="submit">Комментировать</button>
            <button type="reset" class="cancelbtn">Очистить</button><br>
            </form>';
        foreach($box['comments'] as $comment){
            if ($comment['status'] == "0"){
                echo $comment['id']."<br>";
                echo $comment['name']." пишет:<br>";
                echo $comment['text']."<br>";
                echo $comment['date_write']."<br>";
            }
        }
    }
}