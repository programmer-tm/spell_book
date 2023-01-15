<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?=$box['config']['site']['title'];?> : <?=$box['page'];?></title>
    <?php if($_SESSION['in'] != "3"):?>
        <?php $_SESSION['in']=$_SESSION['in']+1;?>
        <script>
            var message="<?=$_SESSION['alert'];?>";
            if (message){
                alert(message);
            }
        </script>
    <?php else:?>
            <?php unset($_SESSION['in']); unset($_SESSION['alert']);?>
    <?php endif;?>
</head>
<body>
    <a href="/admin"><img src="../img/<?php echo ($_SESSION['avatar']) ?: 'admin.gif';?>" loading="auto" style="border-radius: 100px; /* Радиус скругления */ width: 80px; height: 80px; padding:10px 10px 10px 10px">
    <?php if (getLogin() != "Гость"):?>
	    <center><?=$_SESSION['login']?>(<a href="/mail/" title="Непрочитанных сообщений: <?=$box['mail'];?>"><?=$box['mail'];?></a>)<a title="Приветствуем тебя, пользователь: <?=getLogin();?>" href="/admin/"></a><br>
        <input type="button" onclick="alert('Уважаемый, <?=$_SESSION['login'];?>, ждем Вас снова в гости!'); document.location.href = '/logout';" value="Выход"/></center>
    <?php else:?>
        <center><input type="button" onclick="document.location.href = '/admin';" value="Вход"/></center>
	<?php endif;?>
    <?=$box['data'];?>
</body>
</html>