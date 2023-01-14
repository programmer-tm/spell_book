<html>
    <head>
        <link rel="stylesheet" href="/css/style_notepad.css" type="text/css">
        <title><?=$box['config']['site']['title'];?> : <?=$box['page'];?></title>
    </head>
    <body>
        <div id="container">
            <div id="content">
                <div id="left">
                    <div><a href="/admin"><img src="../img/<?=$_SESSION['avatar'];?>" loading="auto" style="border-radius: 100px; /* Радиус скругления */ width: 80px; height: 80px; padding:10px 10px 10px 10px">
                    <?php
			        if (getLogin() != "Гость"){
				        echo '<center>'.$_SESSION['login'].'(<a href="/mail/" title="Непрочитанных сообщений: '.$box['mail'].'">'.$box['mail'].'</a>)<a title="Приветствуем тебя, пользователь: '.getLogin().'" href="/admin/"></a><br><a href="/logout">Выход</a></center>';
			        } else {
    			        echo "<center><a href=/admin>".getLogin()."</a></center>";
			        }
			        ?>
                    </a></div>
                    <div><h1 style="writing-mode: vertical-rl; width: 0; transform: rotate(180deg); padding-top: 20px;"><a href="/"><?=$box['config']['site']['title'];?></a></h1></div>
                </div>
                <div id="right">
                    <?=$box['data'];?>
                </div>
            </div>
            <div id="footer">
                <?php if($box['route'] == "index"):?>
                    <?php if($box['config']['site']['CountPost'] != "0" && $box['config']['site']['CountPost'] != "" && $box['pMax'] != "0" && $box['config']['site']['CountPost'] != $box['pCount']):?>
                        <?php if($_GET['page'] == "0" || $_GET['page'] == "1"):?>
                            <a href="#"></a>
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
                <?php else:?>
                    <p></p>
                    <p>
                        &copy; Programmer-tm<br> 
                    </p>
                <?php endif;?>
            </div>
        </div>
    </body>
</html>