<?php
    //$file = date('d-m-Y_', time()) . "comments.txt";
    $file = "comments.txt";
    $message = "";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

    <h1>Add comment</h1>
    <form action="comments.php" method="POST">
        <input type="text" name="name" placeholder="Enter your name"><br>
        <textarea name="comment" id="comment" placeholder="Enter your comment"></textarea><br>
        <button>Submit comment</button>
    </form>

    <?php
        if(isset($_POST['name']) and isset($_POST['comment'])){
            $name = $_POST['name'];
            $comment = $_POST['comment'];
            if($name != '' and $comment != ''){
                // EXTRACTING ALL COMMENTS, ADDING A NEW COMMENT AS LAST, WRITING EVERYTHING BACK IN FILE   
                // IN SOME CASES FILE NAMES ARE GENERATED BY USING DATE()FILENAME; E.G. DAILY LOGS
                 $fileContents = file_get_contents($file);
                 $text = "\n" . date('d-m-Y H:i:s', time()) . "\n" . $name . "\n" . $comment . "\n";
                 $newtext = $text . $fileContents;
                 file_put_contents($file, $newtext);
                 
                // APPENDING A COMMENT BELOW THE LAST ONE
                // $fileOpen = fopen($file, "a");
                // $text = "\n" . date('d-m-Y H:i:s', time()) . "\n" . $name . "\n" . $comment . "\n";
                // fwrite($fileOpen, $text);
                // fclose($fileOpen);
            }else{
                $message = "All fields are required!";
            }
        }else{
                echo "Welcome to comment page!";
        }
    ?>


    <h3>Comments</h3>
    <?php        
        if(file_exists($file)){            
            $comments = file_get_contents($file);
            $comments = nl2br($comments);
            echo $comments;
        }else{
            $message = "No comments yet!";
        }
    ?>

    <div><?php echo $message; ?></div>
</body>
</html>