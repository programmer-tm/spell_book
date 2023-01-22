<form action="/setup" method="post" enctype="multipart/form-data">
    <div class="post">
		<div class="post-title">
			<div class="post-date">
				<br>
				<br>
				***
			</div>			
			<h2>Настройки сайта:</h2>
		</div>
		<div class="post-entry">
            <input type="text" value="<?=$box['config']['site']['title'];?>" name="config[site][title]" required><br>
            <input type="text" value="<?=$box['config']['site']['theme'];?>" name="config[site][theme]" required><br>
            <input type="text" value="<?=$box['config']['site']['CountPost'];?>" name="config[site][CountPost]" required><br>
            <input type="text" value="<?=$box['config']['site']['CountMessage'];?>" name="config[site][CountMessage]" required><br>
		</div>
		<div class="post-info">
			Кнопки управления ниже...
		</div>
		<div class="clear"></div>
	</div>
    <div class="post">
		<div class="post-title">
			<div class="post-date">
				<br>
				<br>
				***
			</div>			
			<h2>Настройки администратора сайта:</h2>
		</div>
		<div class="post-entry">
            <input type="text" placeholder="Nickname" name="admin[nickname]" required><br>
            <input type="text" placeholder="Name" name="admin[name]" required><br>
            <input type="text" placeholder="Surename" name="admin[surename]" required><br>
            <input type="email" placeholder="Email" name="admin[email]" required><br>
            <input type="text" placeholder="Password" name="admin[password]" required><br>
        </div>
		<div class="post-info">
            <button type="submit">Сохранить!</button><button type="reset" class="cancelbtn">Очистить</button><br>
		</div>
		<div class="clear"></div>
	</div>  
</form>