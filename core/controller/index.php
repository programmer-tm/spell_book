<?php
include_once "../core/model/config.php";
include_once "../core/model/sql.php";
$box['table']="posts";
$box['posts']=allContent($table);
include_once "../core/theme/".$box['config']['site']['theme']."/".$box['route'].".php";