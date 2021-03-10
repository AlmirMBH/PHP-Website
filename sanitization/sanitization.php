<?php
    // sanitization -> validation

    $email = '<almir>.<b>mustafic</b>@almir.ba';
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);        
    $email = filter_var($email, FILTER_SANITIZE_STRING);
    
    if(filter_var($email, FILTER_VALIDATE_EMAIL)){
        $email = filter_var($email, FILTER_VALIDATE_EMAIL);
    }else{
        echo "Invalid email!<br>";
    }
    echo $email;

?>