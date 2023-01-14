<div id="right_content">
    <h2>Установка на хостинг!</h2>
    <form action="/setup" method="post" enctype="multipart/form-data">
        <h2>Настройки сайта:</h2>
        <input type="text" value="<?=$box['config']['site']['title'];?>" name="config[site][title]" required><br>
        <input type="text" value="<?=$box['config']['site']['theme'];?>" name="config[site][theme]" required><br>
        <input type="text" value="<?=$box['config']['site']['CountPost'];?>" name="config[site][CountPost]" required><br>
        <h2>Настройки базы данных:</h2>
        <input type="text" value="<?=$box['config']['sql']['host'];?>" name="config[sql][host]" required><br>
        <input type="text" value="<?=$box['config']['sql']['port'];?>" name="config[sql][port]" required><br>
        <input type="text" value="<?=$box['config']['sql']['login'];?>" name="config[sql][login]" required><br>
        <input type="text" value="<?=$box['config']['sql']['password'];?>" name="config[sql][password]" required><br>
        <input type="text" value="<?=$box['config']['sql']['bd'];?>" name="config[sql][bd]" required><br>
        <h2>Настройки администратора сайта:</h2>
        <input type="text" placeholder="Nickname" name="admin[nickname]" required><br>
        <input type="text" placeholder="Name" name="admin[name]" required><br>
        <input type="text" placeholder="Surename" name="admin[surename]" required><br>
        <input type="email" placeholder="Email" name="admin[email]" required><br>
        <input type="text" placeholder="Password" name="admin[password]" required><br>
        <button type="submit">Сохранить!</button>
        <button type="reset" class="cancelbtn">Очистить</button><br>
    </form>
    <hr class="hr" align="right">
</div>