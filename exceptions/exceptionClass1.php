<?php

class connectionException extends Exception{}
class queryException extends Exception{}

$location = 'localhost';
$username = 'root';
$password = '';
$database = 'advancedphp';

try{
    $connection = @mysqli_connect($location, $username, $password, $database);
        if(!$connection){ 
            throw new connectionException(mysqli_connect_error());
        }                 
            $query = "SELECT * FROM korisnici";
            $result = @mysqli_query($connection, $query);

        if(mysqli_error($connection)){
            throw new queryException(mysqli_error($connection));
        }
        echo "Number of rows: " . mysqli_num_rows($result);
        
}catch(connectionException $e){
    echo "Connection error!<br>";        
    echo "Error code: " . $e->getCode() . "<br>".
         "Issue: " . $e->getMessage() . "<br>" . 
         "File: " . $e->getFile() . "<br>" .
         "Line: " . $e->getLine() . "<br>";
}

catch(queryException $e){
    echo "Query error!<br>";        
    echo "Error code: " . $e->getCode() . "<br>".
         "Issue: " . $e->getMessage() . "<br>" . 
         "File: " . $e->getFile() . "<br>" .
         "Line: " . $e->getLine() . "<br>";
}


?>