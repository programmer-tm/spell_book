<?php
echo "<a href=/>".$box['config']['site']['title']."</a><br>";
echo '<a onclick="javascript:history.back(); return false;" title="Назад в будущее!">Назад</a><br>';
?>
<form action="/setup" method="post" enctype="multipart/form-data">
    <h2>Настройки сайта:</h2>
    <input type="text" value="<?=$box['config']['site']['title'];?>" name="config[site][title]" required><br>
    <input type="text" value="<?=$box['config']['site']['theme'];?>" name="config[site][theme]" required><br>
    <input type="text" value="<?=$box['config']['site']['CountPost'];?>" name="config[site][CountPost]" required><br>
    <h2>Настройки администратора сайта:</h2>
    <input type="text" placeholder="Nickname" name="admin[nickname]" required><br>
    <input type="text" placeholder="Name" name="admin[name]" required><br>
    <input type="text" placeholder="Surename" name="admin[surename]" required><br>
    <input type="email" placeholder="Email" name="admin[email]" required><br>
    <input type="text" placeholder="Password" name="admin[password]" required><br>
    <button type="submit">Сохранить!</button>
    <button type="reset" class="cancelbtn">Очистить</button><br>
</form>