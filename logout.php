<?php
    session_start();
    require_once("include/_require.php");
    Statistics::writeLog("logs/login.log", "{$_SESSION['name']} logged out.");

    session_unset();
    session_destroy();

    setcookie("id", "", time()-1,"/");
    setcookie("name", "", time()-1,"/");
    setcookie("role", "", time()-1,"/");
    setcookie("email", "", time()-1,"/");

    header('Location:index.php');
?>