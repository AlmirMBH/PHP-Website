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
        filter_var($email, FILTER_VALIDATE_EMAIL);
        return $email;
    }else{
        echo "Invalid email!<br>";
    }    
}


function validateInt($int){
    filter_var($int, FILTER_VALIDATE_INT);
    return $int;
}

?>