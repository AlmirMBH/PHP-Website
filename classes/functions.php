<?php

        
function validateString($str){
    $str = filter_var($str, FILTER_SANITIZE_STRING); // annuls html tags
    if(strpos($str, ' ')!==false) return false;
    if(strpos($str, '=')!==false) return false;
    if(strpos($str, '(')!==false) return false;
    if(strpos($str, ')')!==false) return false;
    if(strpos($str, '*')!==false) return false;
    if(strpos($str, '<')!==false) return false;
    if(strpos($str, '>')!==false) return false;
    
    return true;
}


function validateEmail($email){        
    if(filter_var($email, FILTER_VALIDATE_EMAIL)){
        $email = filter_var($email, FILTER_VALIDATE_EMAIL);
        return $email;
    }else{
        echo "Invalid email!<br>";
    }    
}


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