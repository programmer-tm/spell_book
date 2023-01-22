<?php
echo "<a href=/>".$box['config']['site']['title']."</a><br>";
?>
<?php if($_SESSION['role'] == "0"):?>
	<?php echo date("Y-m-d");?>
	<h2>Новая запись:</h2>
	<form action="/" method="post" enctype="multipart/form-data">
    	<input type="text" placeholder="Заголовок записи" name="post[title]" required><br>
    	<textarea name="post[text]" rows="19" cols="44" placeholder="Текст записи"></textarea><br>
    	<input accept=".jpg, .jpeg, .png, .gif, .bmp" name="image" type="file" /><br>
   		<input type="date" value="<?php echo date("Y-m-d");?>" name="post[date_write]" required><br>
    	<button type="submit">Добавить</button>
    	<button type="reset" class="cancelbtn">Очистить</button><br>
    </form>
<?php endif;?>
<?php if(empty($box['posts'])){$box['posts']=[['id'=>'0','title'=>'Чистая установка','text'=>'Тестовый пост для вывода на сайт']];} ?>
<?php foreach($box['posts'] as $post):?>
	<?=$post['date_write'];?>
    <h2><a href="/post/?id=<?=$post['id']?>"  title="Просмотр всего произведения"><?=$post['title'];?></a></h2>
	<a href="post/?id=<?=$post['id']?>"  title="Просмотр всего произведения">
	<img src="/img/<?php echo ($post['image']) ?: 'null.jpeg';?>" loading="auto" alt="<?php echo ($post['image']) ?: 'null.jpeg';?>"></a>
	<?php $text = explode("\r\n", $post['text']); echo $text[0]."<br>".$text[1]."<br>".$text[2]."<br>".$text[3];?><br>
	<a href="/post/?id=<?=$post['id']?>"  title="Просмотр всего произведения">Читать далее...(<?=$post['readings'];?>)</a>
	<br>
<?php endforeach;?>

<?php if($box['config']['site']['CountPost'] != "0" && $box['config']['site']['CountPost'] != "" && $box['pMax'] != "0" && $box['config']['site']['CountPost'] != $box['pCount']):?>
	<?php if($_GET['page'] == "0" || $_GET['page'] == "1"):?>
		<a href="/?page=2">Далее</a>
	<?php elseif($_GET['page'] >= $box['pMax']):?>
		<?php if($_GET['page']=="2"):?>
			<a href="/">Назад</a>
		<?php else:?>
			<?php $_GET['page']=$_GET['page']-1;?>
				<a href="/?page=<?=$_GET['page'];?>">Назад</a>
		<?php endif;?>
		<?php elseif($_GET['page'] == "2"):?>
			<a href="/">Назад</a>
			<?php $_GET['page']=$_GET['page']+1;?>
			<a href="/?page=<?=$_GET['page'];?>">Далее</a>
		<?php else:?>
			<?php $_GET['page']=$_GET['page']-1;?>
			<a href="/?page=<?=$_GET['page'];?>">Назад</a>
			<?php $_GET['page']=$_GET['page']+2;?>
			<a href="/?page=<?=$_GET['page'];?>">Далее</a>
		<?php endif;?>
<?php endif;?>