<?php    
    if(isset($_POST['username']) and isset($_POST['password'])){
        $username = $_POST['username'];
        $password = $_POST['password'];

        if($username != '' and $password != ''){
            setcookie('id', '1', time()+60, '/');
            setcookie('username', $username, time()+60, '/');            
            setcookie('status', 'Administrator', time()+60, '/');

            echo "You are logged in!";
        }else{
            echo "All fields are required!";
        }
    }else{
        echo "Welcome to our website!";
    }
?>