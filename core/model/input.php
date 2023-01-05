<?php
function clear($data){
    $data=strip_tags($data);
    return $data;
}
function chislo($data){
    $data=(int)($data);
    return $data;
}