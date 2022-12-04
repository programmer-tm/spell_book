<?php
// Парсим конфиг:
if (!$config){
    $box['config'] = parse_ini_file("../core/config/config.ini", true); 
}