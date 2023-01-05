<?php
echo "<a href=/>".$box['config']['site']['title']."</a><br>";
if (getLogin() != "Гость"){
    echo "<a href=/admin>".getLogin()."</a><a href=/mail>(".$box['mail'].")</a><br>";
    echo "<a href=/logout>Выход</a><br><br>";
} else {
    echo "<a href=/admin>".getLogin()."</a><br><br>";
}
if ($_SESSION['role'] == "0"){
    echo '<form action="/" method="post" enctype="multipart/form-data">
    <input type="text" placeholder="Заголовок записи" name="post[title]" required><br>
    <textarea name="post[text]" rows="19" cols="44" placeholder="Текст записи"></textarea><br>
    <input accept=".jpg, .jpeg, .png, .gif, .bmp" name="image" type="file" /><br>
    <input type="date" placeholder="" name="post[date_write]" required><br>
    <button type="submit">Добавить</button>
    <button type="reset" class="cancelbtn">Очистить</button><br>
    </form>';
}

foreach($box['posts'] as $post){
    echo '<img loading="auto" src="/img/'.$post['image'].'" width="350" height="250" alt="'.$post['title'].'"><br>';
    echo "<a href=/post/?id=".$post['id'].">".$post['title']."</a><br>";
    $text=explode("\r\n", $post['text']); echo $text[0]."<br>".$text[1]."<br>".$text[2]."<br>".$text[3]."<br>";
    echo "Написан: ".$post['date_write']."<br>";
    echo '<a href=/post/?id='.$post['id'].'>Просмотреть целиком ('.$post['readings'].')</a><br>';
    echo $post['image']."<br>";
}

if ($box['config']['site']['CountPost'] != "" && $box['pMax'] != "0" && $box['config']['site']['CountPost'] != $box['pCount']){
    echo "Навигация сайта:<br>";
    if ($_GET['page'] == "0" || $_GET['page'] == "1"){
        echo "<a href=/?page=2>NEXT</a><br>";
    } elseif ($_GET['page'] >= $box['pMax']){
        if ($_GET['page']=="2"){
            echo "<a href=/>Prev</a><br>";
        } else {
            $_GET['page']=$_GET['page']-1;
            echo "<a href=/?page={$_GET['page']}>Prev</a><br>";
        } 
    } elseif ($_GET['page'] == "2"){
        echo "<a href=/>Prev</a><br>";
        $_GET['page']=$_GET['page']+1;
        echo "<a href=/?page={$_GET['page']}>NEXT</a><br>";
    } else {
        $_GET['page']=$_GET['page']-1;
        echo "<a href=/?page={$_GET['page']}>Prev</a><br>";
        $_GET['page']=$_GET['page']+2;
        echo "<a href=/?page={$_GET['page']}>NEXT</a><br>";
    }
}