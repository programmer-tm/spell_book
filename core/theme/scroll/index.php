<?php if($_SESSION['role'] == "0"):?>
	<div class="post">
		<div class="post-title">
			<div class="post-date">
				<br>
				<br>
				<?php echo date("Y-m-d");?>
			</div>			
			<h2>Новая запись:</h2>
		</div>
		<div class="post-entry">
			<form action="/" method="post" enctype="multipart/form-data">
    			<input type="text" placeholder="Заголовок записи" name="post[title]" required><br>
    			<textarea name="post[text]" rows="19" cols="44" placeholder="Текст записи"></textarea><br>
    			<input accept=".jpg, .jpeg, .png, .gif, .bmp" name="image" type="file" /><br>
   				<input type="date" value="<?php echo date("Y-m-d");?>" name="post[date_write]" required><br>
		</div>
		<div class="post-info">
			<button type="submit">Добавить</button><button type="reset" class="cancelbtn">Очистить</button><br>
		</form>
		</div>
		<div class="clear"></div>
	</div>
<?php endif;?>
<?php if(empty($box['posts'])){$box['posts']=[['id'=>'0','title'=>'Чистая установка','text'=>'Тестовый пост для вывода на сайт']];} ?>
<?php foreach($box['posts'] as $post):?>
	<div class="post">
		<div class="post-title">
			<div class="post-date">
				<br>
				<br>
				<?=$post['date_write'];?>
			</div>			
			<h2><a href="/post/?id=<?=$post['id']?>"  title="Просмотр всего произведения"><?=$post['title'];?></a></h2>
		</div>
		<div class="post-entry">
			<a href="post/?id=<?=$post['id']?>"  title="Просмотр всего произведения">
			<img src="/img/<?php echo ($post['image']) ?: 'null.jpeg';?>" loading="auto" class="post-entry-img" alt="<?php echo ($post['image']) ?: 'null.jpeg';?>" hspace="4" align="left" class="float-left"></a>
			<?php $text = explode("\r\n", $post['text']); echo $text[0]."<br>".$text[1]."<br>".$text[2]."<br>".$text[3];?><br>
		</div>
		<div class="post-info">
			<a href="/post/?id=<?=$post['id']?>"  title="Просмотр всего произведения">Читать далее...(<?=$post['readings'];?>)</a>
		</div>
		<div class="clear"></div>
	</div>
<?php endforeach;?>
<?php if($box['config']['site']['CountPost'] != "0" && $box['config']['site']['CountPost'] != "" && $box['pMax'] != "0" && $box['config']['site']['CountPost'] != $box['pCount']):?>
	<div class="navigation">
		<?php if($_GET['page'] == "0" || $_GET['page'] == "1"):?>
			<div class="navigation-next"><a href="/?page=2">Далее</a></div>
		<?php elseif($_GET['page'] >= $box['pMax']):?>
			<?php if($_GET['page']=="2"):?>
				<div class="navigation-previous"><a href="/">Назад</a></div>
			<?php else:?>
				<?php $_GET['page']=$_GET['page']-1;?>
				<div class="navigation-previous"><a href="/?page=<?=$_GET['page'];?>">Назад</a></div>
			<?php endif;?>
		<?php elseif($_GET['page'] == "2"):?>
			<div class="navigation-previous"><a href="/">Назад</a></div>
			<?php $_GET['page']=$_GET['page']+1;?>
			<div class="navigation-next"><a href="/?page=<?=$_GET['page'];?>">Далее</a></div>
		<?php else:?>
			<?php $_GET['page']=$_GET['page']-1;?>
			<div class="navigation-previous"><a href="/?page=<?=$_GET['page'];?>">Назад</a></div>
			<?php $_GET['page']=$_GET['page']+2;?>
			<div class="navigation-next"><a href="/?page=<?=$_GET['page'];?>">Далее</a></div>
		<?php endif;?>
	</div>
<?php endif;?>