<?php
include_once "../core/model/config.php";
include_once "../core/model/sql.php";
include_once "../core/model/input.php";
if ($_POST['login'] && $_POST['password']){
    $_POST['login']=clear($_POST['login']);
    $_POST['password']=clear($_POST['password']);
    if ($_POST['login']=='admin' && $_POST['password']=='admin'){
        $_SESSION['login']=1;
        $_POST=[];
        $_REQUEST=[];
    }
}
include_once "../core/theme/".$box['config']['site']['theme']."/".$box['route'].".php";