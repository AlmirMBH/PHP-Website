<?php

$a = 1;

function exception($a){
    if($a < 2){
        //throw new Exception();
        throw new Exception("Invalid number!"); // invoked as getMessage() see below
    }else{
        echo "The number is ok";
    }
}

try{
    exception($a);
}
catch(Exception $e){
    echo "The number is invalid!<br>";

    // php defined exception method calling
    echo "Code (user-defined code always 0): " . $e->getCode() . "<br>";
    echo "Message: " . $e->getMessage() . "<br>";
    echo "File: " . $e->getFile() . "<br>";
    echo "Line: " . $e->getLine() . "<br>";


    $exceptionLogs = '';
    
    $exceptionLog = date('d-m-Y H:i:s', time()) . 
                "\n" . "Code: [{$e->getCode()}]" . "\n" . 
                "Issue: " . $e->getMessage() . "\n" . 
                "Script name: " . $e->getFile() . "\n" . 
                "Line number: " . $e->getLine();

        if(file_exists('exceptions.txt')){           
                $exceptionLogs = file_get_contents('exceptions.txt');
        }

        file_put_contents('exceptions.txt', "\n" . $exceptionLog . "\n" . $exceptionLogs . "\n");
        
    
}





?>