<?php

    // used until php ver 6
    function errorHandling($errorNumber, $errorMessage, $errorScript, $errorLine){ // php provides the variable values
        $error = "An error occured!<br>";
        $error .= "Error number: " . $errorNumber . "<br>";
        $error .= "Error message: " . $errorMessage . "<br>";
        $error .= "Error script: " . $errorScript . "<br>";
        $error .= "Error line: " . $errorLine . "<br>";
        echo $error;

        $errorLog = date('d-m-Y H:i:s', time()) . 
                "\n" . "Error number: [{$errorNumber}]" . "\n" . 
                "Issue: " . $errorMessage . "\n" . 
                "Script name: " . $errorScript . "\n" . 
                "Line number: " . $errorLine;

        $errorLogs = '';

        if(file_exists('errors.txt')){           
                $errorLogs = file_get_contents('errors.txt');
        }
        file_put_contents('errors.txt', "\n" . $errorLog . "\n" . $errorLogs . "\n");
    }


    set_error_handler("errorHandling");


    echo A/0;
?>