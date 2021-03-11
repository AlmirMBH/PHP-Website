<?php

        
function login(){
    if(isset($_SESSION['id']) and isset($_SESSION['name']) and isset($_SESSION['role']) and isset($_SESSION['email'])){
        return true;   
    }elseif(isset($_COOKIE['id'])  and isset($_COOKIE['name']) and isset($_COOKIE['role']) and isset($_COOKIE['email'])){
        $_SESSION['id'] = $_COOKIE['id'];
        $_SESSION['name'] = $_COOKIE['name'];
        $_SESSION['role'] = $_COOKIE['role'];
        $_SESSION['email'] = $_COOKIE['email'];
        return true;
    }else{
        return false;
    }
}


?>