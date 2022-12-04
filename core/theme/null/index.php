<?php
echo $box['config']['site']['title']."<br>";
echo "Это главная страница сайта<br>";
echo "<a href=/admin>Админка</a><br>";
echo "Записи:<br>";

foreach($box['posts'] as $post){
    echo "<a href=/post/?id=".$post['id'].">".$post['title']."</a><br>";
    $text=explode("\r\n", $post['text']); echo $text[0]."<br>".$text[1]."<br>".$text[2]."<br>".$text[3]."<br>";
    echo $post['date_write']."<br>";
    echo $post['readings']."<br>";
    echo $post['image']."<br>";
}
