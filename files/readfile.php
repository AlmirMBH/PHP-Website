<?php
    $message = '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Read txt/word/php/html files</title>
</head>
<body>
    <h1>Read txt/word/php/html file 1</h1>
    <?php
        //$file = 'file.txt';
        $file = 'file.doc';
        //$file = 'file.php';
        //$file = 'file.html';
            if(file_exists($file)){
                $fileContents = fopen($file, "r");
                $readContent = fread($fileContents, filesize($file));
                fclose($fileContents);        
                //$formattedContents = str_replace("\n\r", '<br>', $readContent);
                $formattedContents = nl2br($readContent);
                echo $formattedContents;
                
            }else{
                $message = "File does not exist";
            }            
    ?>

    <hr>
    <h1>Read txt/word/php/html file 2 (simpler way, no need to open/close file)</h1>
    <?php
        //$file = 'file.txt';
        //$file = 'file.doc';
        $file = 'file.php';
        //$file = 'file.html';
            if(file_exists($file)){
                $fileContents = file_get_contents($file);
                $formattedContents = nl2br($fileContents);
                echo $formattedContents;
            }else{
                $message = "A file does not exist!";                
            }
    ?>

    <hr>
    <h1>Read txt/word/php/html file 3 (line by line until NULL occurs)</h1>
    <?php
        //$file = 'file.txt';
        $file = 'file.doc';
        //$file = 'file.php';
        //$file = 'file.html';
            if(file_exists($file)){
                $fileContents = fopen($file, "r");
                // $row = fgets($fileContents);
                // echo $row;
                // echo "<br>";
                // $row = fgets($fileContents);
                // echo $row;
                $i = 1;
                while(($row = fgets($fileContents)) != NULL){
                    //$row = fgets($fileContents); // cannot be done this way :)                
                    echo $i++ . ".". $row . "<br>";                                                            
                }
                fclose($fileContents);
            }else{
                $message = "A file does not exist!";                
            }
    ?>

    <hr>
    <h1>Read txt/word/php/html file 4 (line by line until EOF occurs)</h1>
    <?php
        //$file = 'file.txt';
        $file = 'file.doc';        
        //$file = 'file.php';
        //$file = 'file.html';
            if(file_exists($file)){
                $fileContents = fopen($file, "r");                
                $i = 1;
                while(!feof($fileContents)){ 
                    $row = fgets($fileContents);                   
                    echo $i++ . ".". $row . "<br>";                                                            
                }
                fclose($fileContents);
            }else{
                $message = "A file does not exist!";                
            }
    ?>

    <hr>
    <h1>Read txt/word file 5 (lines that contain specific characters/words)</h1>
    <?php
        //$file = 'file.txt';
        $file = 'file.doc';
            if(file_exists($file)){
                $fileContents = fopen($file, "r");               
                $i = 1;
                while(($row = fgets($fileContents)) != NULL){                    
                    if(strpos($row, 'y')){
                        echo $i++ . ".". $row . "<br>";                    
                    }                    
                }
                fclose($fileContents);
            }else{
                $message = "A file does not exist!";                
            }
    ?>

    <hr>
    <h1>Read txt/word/php/html file 6</h1>
    <?php
        //$file = 'file.txt';
        $file = 'file.doc';
        //$file = 'file.php';
        //$file = 'file.html';        
            if(file_exists($file)){
                $fileContents = fopen($file, "r");                               
                $i = 1;
                while(!feof($fileContents)){                
                    $row = fgets($fileContents);
                        echo $i++ . ".". $row . "<br>";
                    }
            }else{
                $message = "A file does not exist!";                
            }
    ?>

    <div><?php echo $message; ?></div>
</body>
</html>

