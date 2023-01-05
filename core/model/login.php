<?php
function getLogin(){
    if ($_SESSION['login']){
        return $_SESSION['login'];
    } else {
        return "Гость";
    }
}