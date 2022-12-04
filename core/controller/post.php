<?php
include_once "../core/model/config.php";
include_once "../core/model/sql.php";
include_once "../core/model/input.php";
$box['table']="posts";
$_GET['id']=chislo(clear($_GET['id']));
$box['params']="where id=".$_GET['id'];
$box['post']=oneContent($table);
$_GET=[];
include_once "../core/theme/".$box['config']['site']['theme']."/".$box['route'].".php";