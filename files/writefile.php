<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Write/overwrite and append text in txt/word/php/html file</title>
</head>
<body>
    <h1>Write/overwrite text in txt/word/php/word file</h1>
    <?php
        // if a file does not exist, php will create it

        //$file = "file1.txt";
        $file = "file1.doc";
        //$file = "file1.php"; // use corresponding text below ($phptext)
        //$file = "file1.html"; // use corresponding text below ($htmltext)

        $fileOpen = fopen($file, "w");            

        // IMPORTANT: text/code that is written in a file in the same
        // line with <?php and ? > will not be read (use \n; see phptextbelow)!!!
        $phptext = "<?php \n if(isset(\$_GET['name'])){ echo \$_GET['name'];} \n?>";                        
        $htmltext = "<html><body><h1>Welcome to a generated html page</h1></body></html>";
        $txtdoctext = "This is the file entry that needs to be written in the file.\n";                

        fwrite($fileOpen, $txtdoctext);        
        fclose($fileOpen);
    ?>

    <h1>Write/overwrite text in txt/word/php/word file (file_put_contents())</h1>
    <?php        
        $file = "file3.txt";
        //$file = "file3.doc";
        //$file = "file3.php";
        //$file = "file3.html";
        $text = "<html><body><h1>This is your dynamic entry<h1></body></html>";
        $i = 1;
        file_put_contents($file, $text);
    ?>




    <h1>APPEND text/time in txt/word/php/html file</h1>
    <?php      
        $file = "file2.txt";
        //$file = "file2.doc";
        //$file = "file2.php"; // use corresponding text below ($phptext)
        //$file = "file2.html"; // use corresponding text below ($htmltext)

        $fileOpen = fopen($file, "a");            

        // IMPORTANT: text/code that is written in a file in the same
        // line with <?php and ? > will not be read (use \n; see phptextbelow)!!!
        $phptext = "<?php \n if(isset(\$_GET['name'])){ echo \$_GET['name'];} \n?>";                        
        $htmltext = "<html><body><h1>Welcome to a generated html page</h1></body></html>";
        $txtdoctext = date('d-m-Y H:i:s') . "\n This is the file entry that needs to be written in the file.\n";                

        fwrite($fileOpen, $txtdoctext);        
        fclose($fileOpen);
    ?>


    <?php
        echo "<hr>";
        echo "<h1>This is what you've just written in your file</h1>";
        $file = 'file3.txt';
        if(file_exists($file)){
            $fileContents = file_get_contents($file);
            $formattedContents = nl2br($fileContents);
            echo $formattedContents;
        }else{
            $message = "A file does not exist!";                
        }
    ?>
</body>
</html>