<?php

    $id='5';
    if(filter_var($id, FILTER_VALIDATE_INT))
            { echo "It's an integer<br>"; }
        else{ echo "Not an integer!<br>"; }

    $email = 'almir@almir.ba';
    if(filter_var($email, FILTER_VALIDATE_EMAIL))
            { echo "It's an email!<br>"; }
        else{ echo "Not an email!<br>"; }

    $ip = $_SERVER['REMOTE_ADDR'];
    //$ip = '172.16.17.255';
    if(filter_var($ip, FILTER_VALIDATE_IP))
            { echo "It's an IP: " . $ip; }
        else{ echo "It's not an IP"; }

?>