<?php
     session_start();
     require_once('include/_require.php');         
 
     $connection = new Database();
     if(!$connection->connect()){
         exit();
     }
         
     $message = '';
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/style.css" rel="stylesheet">
    <title>PHP</title>
</head>
<body>

    <div id="wrapper">

        <div id="header">
            <?php include_once('include/menu.php'); ?>
        </div>

        <div id="content">

            <div id="main"> 
                <div id="about">
                    <h2>PHP</h2>
                    <p>PHP is a popular general-purpose scripting language that is especially suited to web development. Fast, flexible and pragmatic, PHP powers everything from your blog to the most popular websites in the world.</p>
                </div>
                <div id="contact">
                    <h2>Contact</h2>
                    <p>Marka Marulica 11<br>
                    71000 Sarajevo<br>
                    Bosnia and Herzegovina<br>
                    Tel. +387 61 743 249<br>
                    info@php.net<br>
                    www.php.net</p>
                </div>
                                
                <div id="contact-form">
                    <h2>Send us a message</h2>
                    <div id="user-message">
                        <form action="about.php" method="POST">
                            <input type="text" name="title" placeholder="Enter message title" required><br>                            
                                <?php if(!login()){?>                                    
                                    <input type="text" name="name" placeholder="Enter your name" required><br>
                                    <input type="text" name="email" placeholder="Enter your email" required><br>
                                <?php }?>
                            <textarea name="text" placeholder="Enter text" required></textarea><br>                                
                            <br>                                
                            <button name="user-message">Send message</button>
                        </form>
                    </div>
                </div>  

                <?php
                    // Save user message
                    if(isset($_POST['title']) and isset($_POST['text'])){
                        $userId = $_SESSION['id'];
                        $title = $_POST['title'];
                        $name = isset($_POST['name']) ? $_POST['name'] : $_SESSION['name'];
                        $email = isset($_POST['email']) ? $_POST['email'] : $_SESSION['email'];
                        $text = $_POST['text'];
                        
                        $title = filter_var($title, FILTER_SANITIZE_STRING);
                        $name = filter_var($name, FILTER_SANITIZE_STRING);
                        $email = filter_var($email, FILTER_SANITIZE_EMAIL);
                        $text = filter_var($text, FILTER_SANITIZE_STRING);
                        $userId = filter_var($userId, FILTER_SANITIZE_NUMBER_INT);
                       
                    
                        if($userId != '' and $title != '' and $name != '' and $email != '' and $text != ''){

                            $query = "INSERT INTO messages (user_id, title, name, email, text) 
                            VALUES({$userId}, '{$title}', '{$name}', '{$email}', '{$text}')";

                            $connection->query($query);

                            if($connection->error()){
                                $message = "Database error: " . $connection->error();
                            }else{
                                $messageId = $connection->insert_id();
                                $message = "A new message entitled \"{$title}\" has been sent to the admin.<br>";
                            }
                        }
                    }else{ 
                            $message = "Drop us a line!";                             
                        }    
                ?>
                <div class="user-message">
                    <p style="color:red; font-weight:900; text-align:center"><?php echo $message; ?></p>
                </div>

            </div>

            <div id="sidebar">
                <?php include_once('include/sidebar.php'); ?>
            </div>

        </div>

        <div id="footer">
            <?php include_once('include/footer.php'); ?> 
        </div>

    </div>   
             
</body>
</html>