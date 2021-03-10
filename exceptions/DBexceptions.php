<?php

    $location = 'localhost';
    $username = 'root';
    $password = '';
    $database = 'advancedphp';

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT); // sql exception
    try{
        $connection = @mysqli_connect($location, $username, $password, $database);
            // if(!$connection){ 
            //     throw new Exception(mysqli_connect_error());
            // }                 
                $query = "SELECT * FROM korisnici";                
                $result = @mysqli_query($connection, $query);

                // if(mysqli_error($connection)){
                //     throw new Exception(mysqli_error($connection));
                // }
                echo "Number of rows: " . mysqli_num_rows($result);
            
    }catch(Exception $e){
        echo "Connection error!<br>";        
        echo "Error code: " . $e->getCode() . "<br>".
             "Issue: " . $e->getMessage() . "<br>" . 
             "File: " . $e->getFile() . "<br>" .
             "Line: " . $e->getLine() . "<br>";
    }
    

    
?>