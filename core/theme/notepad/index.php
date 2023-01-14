<?php if($_SESSION['role'] == "0"):?>
	<div id="right_content">
		<form action="/" method="post" enctype="multipart/form-data">
			<h2><input type="text" placeholder="Заголовок записи" name="post[title]" required><br></h2>
			<textarea name="post[text]" rows="19" cols="44" placeholder="Текст записи"></textarea><br>
			<input accept=".jpg, .jpeg, .png, .gif, .bmp" name="image" type="file" /><br>
			<input type="date" placeholder="" name="post[date_write]" required><br>
			<button type="submit">Добавить</button>
			<button type="reset" class="cancelbtn">Очистить</button><br>
		</form>
		<hr class="hr" align="right">
	</div>
<?php endif;?>
<?php foreach($box['posts'] as $post):?>
	<div id="right_content">
		<h2><a href="/post/?id=<?=$post['id']?>"  title="Просмотр всего произведения"><?=$post['title'];?></a></h2>
		<p>
		<a href="post/?id=<?=$post['id']?>"  title="Просмотр всего произведения"><img src="../img/<?php echo ($post['image']) ?: 'null.jpeg';?>" loading="auto" class="post-entry-img" alt="notepad.png" hspace="4" align="right" style="clip-path: polygon(3% 0, 7% 1%, 11% 0%, 16% 2%, 20% 0, 23% 2%, 28% 2%, 32% 1%, 35% 1%, 39% 3%, 41% 1%, 45% 0%, 47% 2%, 50% 2%, 53% 0, 58% 2%, 60% 2%, 63% 1%, 65% 0%, 67% 2%, 69% 2%, 73% 1%, 76% 1%, 79% 0, 82% 1%, 85% 0, 87% 1%, 89% 0, 92% 1%, 96% 0, 98% 3%, 99% 3%, 99% 6%, 100% 11%, 98% 15%, 100% 21%, 99% 28%, 100% 32%, 99% 35%, 99% 40%, 100% 43%, 99% 48%, 100% 53%, 100% 57%, 99% 60%, 100% 64%, 100% 68%, 99% 72%, 100% 75%, 100% 79%, 99% 83%, 100% 86%, 100% 90%, 99% 94%, 99% 98%, 95% 99%, 92% 99%, 89% 100%, 86% 99%, 83% 100%, 77% 99%, 72% 100%, 66% 98%, 62% 100%, 59% 99%, 54% 99%, 49% 100%, 46% 98%, 43% 100%, 40% 98%, 38% 100%, 35% 99%, 31% 100%, 28% 99%, 25% 99%, 22% 100%, 19% 99%, 16% 100%, 13% 99%, 10% 99%, 7% 100%, 4% 99%, 2% 97%, 1% 97%, 0% 94%, 1% 89%, 0% 84%, 1% 81%, 0 76%, 0 71%, 1% 66%, 0% 64%, 0% 61%, 0% 59%, 1% 54%, 0% 49%, 1% 45%, 0% 40%, 1% 37%, 0% 34%, 1% 29%, 0% 23%, 2% 20%, 1% 17%, 1% 13%, 0 10%, 1% 6%, 1% 3%); width: 95px; height: 70px;"><?php $text = explode("\r\n", $post['text']); echo $text[0]."<br>".$text[1]."<br>".$text[2]."<br>".$text[3];?><br>
		Написан: <?=$post['date_write'];?></a></p>
		<hr class="hr" align="right">
	</div>
<?php endforeach;?>