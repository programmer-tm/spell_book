<?php
echo "<a href=/>".$box['config']['site']['title']."</a><br>";
echo "Это главная страница сайта<br>";
echo "<a href=/admin>".getLogin()."</a><br>";
if (getLogin() != "Гость"){
    echo "<a href=/logout>Выход</a><br>";
}
if ($_SESSION['role'] == "0"){
    echo '<form action="/" method="post" enctype="multipart/form-data">
    <input type="text" placeholder="Заголовок записи" name="post[title]" required><br>
    <textarea name="post[text]" rows="19" cols="44" placeholder="Текст записи"></textarea><br>
    <input type="date" placeholder="" name="post[date_write]" required><br>
    <button type="submit">Добавить</button>
    <button type="reset" class="cancelbtn">Очистить</button><br>
    </form>';
}

foreach($box['posts'] as $post){
    echo "<a href=/post/?id=".$post['id'].">".$post['title']."</a><br>";
    $text=explode("\r\n", $post['text']); echo $text[0]."<br>".$text[1]."<br>".$text[2]."<br>".$text[3]."<br>";
    echo $post['date_write']."<br>";
    echo $post['readings']."<br>";
    echo $post['image']."<br>";
}