<!--Объявили сайт, как таковой:-->
<!DOCTYPE html>
<!--Язык портала:-->
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--Данные для поисковиков: (Тут каждый прописывает то, что нужно именно в его случае)-->
    <meta name="keywords" content="Сергей, Минеев, стихи, Бредни писателя, Хранитель пустоты, Сайт стихов Сергея Минеева">
    <meta name="description" content="Сергей, Минеев, стихи, Бредни писателя, Хранитель пустоты, Сайт стихов Сергея Минеева">
    <!--Заголовочная часть-->
    <!-- Тут выводим название проекта из конфига, информационнное сообщение -->
	<title><?=$box['config']['site']['title'];?> : <?=$box['page'];?></title>
	<!--Иконка портала:-->
    <link rel="icon" href="/images/1.ico" type="image/x-icon">
	<!--Подключаем табличку стилей:-->
    <link rel="stylesheet" type="text/css" href="/css/style_scroll.css" />
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Marck+Script&display=swap" rel="stylesheet">
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
	<style>
            details summary {
            list-style-type: "";
            }
            details[open] summary {
            list-style-type: "";
            }
    </style>
</head>
<body>
	<!--Проверка сообщения для вывода или не в
	вывода информации:-->
	<div id="page">
	<div id="page-top">
	<div id="page-bottom">
	<div id="header">
	<!--Заголовок страницы:-->
	<div id="header-info">
		<h1><a href="/"><?=$box['config']['site']['title'];?></a></h1>
		<div class="description"><?=$box['page'];?></div>
	</div>
	<!--Навигационная система проекта-->
	<div id="header-menu">
		<ul>
			<li><a href="/" title="На главную страницу сайта">Главная</a></li>
			<?php if($_SESSION['id']):?>
			<li><a href="/admin/" title="В личный раздел">Личный кабинет</a></li>
			<li><a href="/mail/" title="Читать личные сообщения">Личные сообщения</a></li>
			<?php endif;?>
		</ul>
	</div>
	<!-- Подписки на новости не используются (Картинка вырезана из проекта)
	<div id="header-feed">
		<a href="rss.xml"><img src="/images/blank.gif" alt="RSS Feed" width="125" height="50" /></a>
	</div>-->
	</div>
	<div id="main">
	<div id="sidebar">
	<!-- Это блоки навигации -->
	<div class="sidebar-box">
	<div class="sidebar-box-top"></div>
	<div class="sidebar-box-in">
		<h3>Твой мир:</h3>
		<h4>
			<?php if (getLogin() != "Гость"):?>
				<?=$_SESSION['login']?>(<a href="/mail/" title="Непрочитанных сообщений: <?=$box['mail'];?>"><?=$box['mail'];?></a>)<a title="Приветствуем тебя, пользователь: <?=getLogin();?>" href="/admin/"><img src="/img/<?php echo ($_SESSION['avatar']) ?: 'admin.gif';?>" alt="<?=$_SESSION['login'];?>" align="left" hspace="2" class="menu-img"><br>(Личный кабинет)</a><br>
                <button onclick="alert('Уважаемый, <?=$_SESSION['login'];?>, ждем Вас снова в гости!'); document.location.href = '/logout';">Выход</button>
            <?php else:?>
				<button onclick="document.location.href = '/admin';">Вход на сайт (<?=getLogin();?>)</button>
			<?php endif;?>
		</H4>
	</div>
	<div class="sidebar-box-bottom"></div>
	</div>
	</div>
	<!--Контент сайта:-->
	<div id="content">
	<!--Тут основной контент сайта-->
		<?=$box['data'];?>
	<div class="clear"></div>
		</div>
	<div class="clear"></div>
	</div>
	<!--Подвал сайта с копирайтом-->
	<div id="footer">
	&copy; Programmer-tm
	</div>
	</div></div></div>
</body>
</html>