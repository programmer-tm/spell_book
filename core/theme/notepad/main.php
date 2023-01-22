<html>
    <head>
        <link rel="stylesheet" href="/css/style_notepad.css" type="text/css">
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
        <div id="container">
            <div id="content">
                <div id="left">
                    <div>
                    <a href="/admin"><img src="../img/<?php echo ($_SESSION['avatar']) ?: 'admin.gif';?>" loading="auto" style="border-radius: 100px; /* Радиус скругления */ width: 80px; height: 80px; padding:10px 10px 10px 10px">
                    <?php if (getLogin() != "Гость"):?>
				        <center><?=$_SESSION['login']?>(<a href="/mail/" title="Непрочитанных сообщений: <?=$box['mail'];?>"><?=$box['mail'];?></a>)<a title="Приветствуем тебя, пользователь: <?=getLogin();?>" href="/admin/"></a><br>
                        <button onclick="alert('Уважаемый, <?=$_SESSION['login'];?>, ждем Вас снова в гости!'); document.location.href = '/logout';">Выход</button></center>
                    <?php else:?>
    			        <center><button onclick="document.location.href = '/admin';">Вход</button></center>
			        <?php endif;?>
                    </a></div>
                    <div><h1><a href="/" title="На главную страницу сайта"><?=$box['config']['site']['title'];?></a></h1></div>
                </div>
                <div id="right">
                    <?=$box['data'];?>
                </div>
            </div>
            <div id="footer">
                <?php if($box['route'] == "index"):?>
                    <?php if($box['config']['site']['CountPost'] != "0" && $box['config']['site']['CountPost'] != "" && $box['pMax'] != "0" && $box['config']['site']['CountPost'] != $box['pCount']):?>
                        <?php if($_GET['page'] == "0" || $_GET['page'] == "1"):?>
                            <a class="nav" href="#"></a>
                            <a class="nav" href="/?page=2">Далее</a>
                        <?php elseif($_GET['page'] >= $box['pMax']):?>
                            <?php if($_GET['page']=="2"):?>
                                <a class="nav" href="/">Назад</a>
                            <?php else:?>
                                <?php $_GET['page']=$_GET['page']-1;?>
                                    <a class="nav" href="/?page=<?=$_GET['page'];?>">Назад</a>
                            <?php endif;?>
                            <?php elseif($_GET['page'] == "2"):?>
                                <a class="nav" href="/">Назад</a>
                                <?php $_GET['page']=$_GET['page']+1;?>
                                <a class="nav" href="/?page=<?=$_GET['page'];?>">Далее</a>
                            <?php else:?>
                                <?php $_GET['page']=$_GET['page']-1;?>
                                <a class="nav" href="/?page=<?=$_GET['page'];?>">Назад</a>
                                <?php $_GET['page']=$_GET['page']+2;?>
                                <a class="nav" href="/?page=<?=$_GET['page'];?>">Далее</a>
                            <?php endif;?>
                    <?php endif;?>
                <?php else:?>
                    <a class="nav" href="#"></a>
                    <a class="nav" href="/">&copy; Programmer-tm</a>
                <?php endif;?>
            </div>
        </div>
    </body>
</html>