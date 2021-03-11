<?php


function sanitizeString($string){
    filter_var($string, FILTER_SANITIZE_STRING);
    return $string;
}


function sanitizeEmail($email){
    filter_var($email, FILTER_SANITIZE_EMAIL);
    return $email;
}


function sanitizeInt($int){
    filter_var($int, FILTER_SANITIZE_NUMBER_INT);
    return $int;
}


?>