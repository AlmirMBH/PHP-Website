<?php
    session_start();
    require_once('include/_require.php');

    $message = '';
    $connection = new Database();
        if(!$connection->connect()){
            exit();
        }

            if(isset($_POST['id']) and isset($_POST['name']) and isset($_POST['comment'])){
                
                $id = $_POST['id'];
                $name = $_POST['name'];
                $comment = $_POST['comment'];
                $userId = $_SESSION['id'];
                if($id != "" and $name != "" and $comment != ""){
                    $name = filter_var($name, FILTER_SANITIZE_STRING);
                    $comment = filter_var($comment, FILTER_SANITIZE_STRING);
                    $userId = filter_var($userId, FILTER_SANITIZE_NUMBER_INT);
                    $upit = "INSERT INTO comments (news_id, user_id, name, comment) VALUES ({$id}, {$userId}, '{$name}', '{$comment}')";
                    $connection->query($upit);
                    if($connection->error()){
                        $message = "Connection error!<br>".$connection->error();
                    }else{
                        $message = "Your comment has been received.";
                    }                        
                }else
                    $message = "All fields are required!!!";
            }
            ?>    

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/style.css" rel="stylesheet">
    <title>News</title>
</head>
<body>

    <div id="wrapper">

        <div id="header">
            <?php include_once('include/menu.php'); ?>
        </div>

        <div id="content">
            <div id="main" style="margin-top: 50px">      
                <div id="news">
                    
                    <?php                    
                        if(isset($_GET['id'])){                             
                            $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
                        }elseif(isset($id)){
                            $id = $id;                            
                        }
                       
                        if(isset($id) and $id != '' and $id > 0){                                    
                            if(filter_var($id, FILTER_VALIDATE_INT)){                                                           
                                $query = "SELECT * FROM wnews WHERE deleted = 0 AND id =" . $id;
                            }                          
                            
                            $result = $connection->query($query);
                            $row = $connection->fetch_object($result);
                            
                            $image = 'images/placeholder.png';
                    
                            if(file_exists("images/{$row->id}.jpg")){
                                $image = "images/{$row->id}.jpg";
                            }
                    
                            echo "<div style='float:left'>";
                            echo "<img style='width:200px; margin:10px 20px 0px 0px' src='$image'>";        
                            echo "</div>";
                            echo "<div><a style='margin-top:20px' href='index.php?category=" . $row->category . "'>" . $row->category_name . "</a></div>";
                            echo "<h3 style='border-bottom:0px;color:#777CB5'>".$row->title."</h3>";
                            echo $row->text . "<br>";
                            
                            if(file_exists('avatars/' . $row->author . '.jpg')){
                                $avatar = 'avatars/' . $row->author . '.jpg';
                            }else{
                                $avatar = 'avatars/' . 'nouser.png';
                            }
                        
                            echo "<img src='{$avatar}' height='15px'>";
                            echo "<b><a href='index.php?author=" . $row->author . "'>" . '&nbsp' . $row->name ."</a></b><br>";
                            echo "<i>".$row->time."</i><br>";                                
                            $viewed = $row->viewed;
                                if(isset($row->id)){
                                    $query = "UPDATE news SET viewed=viewed+1 WHERE id=" . $row->id;
                                    $connection->query($query);
                                }
                                
                                if(login()){
                                    if($_SESSION['role'] == 'admin'){
                                        echo "<i>Viewed: {$row->viewed} </i><br>";
                                    }
                                }

                            $query = "SELECT count(id) AS number FROM comments WHERE news_id={$id} and approved=1";
                            $numberOfComments = $connection->query($query);
                            $numberOfComments = $connection->fetch_object($numberOfComments);
                            echo "Number of comments: {$numberOfComments->number}";    
                            echo "<hr style='margin-top:10px'>";                        
                        }else{
                            $userAttempt = filter_var($_GET['id'], FILTER_SANITIZE_STRING);
                            echo "<p style='color:red; font-weight:900'>Hacking is considered a criminal act!<br> 
                                Your IP address: {$_SERVER['REMOTE_ADDR']}<br> Your attempt: " . $userAttempt . 
                                "<br><br> Think twice before you try again!</p>";

                                $log = "\n Hacking attempt from the following address: " . $_SERVER['REMOTE_ADDR'] . 
                                "\n Hacking script:" . $userAttempt ."\n" . 
                                "Hacking attempted on the following page: " . $_SERVER['REQUEST_URI'] . "\n";
                                Statistics::writeLog("logs/hacking.log", $log);
                        }
                    ?>

                    <?php
                        //Show comment                        
                        if(isset($id) and $id != '' and $id > 0){
                            $query = "SELECT * FROM comments WHERE news_id={$id} AND approved=1 ORDER by time DESC";
                            $result = $connection->query($query);
                                if($connection->num_rows($result) == 0){
                                    if($message == ''){
                                        if(login()){
                                            $message = "No comments for this news!";
                                        }else{
                                            $message = "No comments for this news!<br>Log in or register and be the first to comment this news!";
                                        }
                                    }
                                }else{
                                    echo "<h3 style='border-bottom: 0px; margin-top: 50px; color: #777CB5'>Comments</h3>";
                                    echo "<p>In order to comment this news you have to be a registered user.<p>";
                                }
                                while($row = $connection->fetch_object($result)){
                                    echo "<div>";
                                    echo "<div>{$row->time}</div>";
                                    echo  "<div><b>{$row->name}</b></div>";
                                    echo "<div>{$row->comment}</div>";
                                    echo "<div>Likes: {$row->likes} | Dislikes: {$row->dislikes}</div>";                                    
                                    echo "</div><br>";
                                }
                        }
                    ?>

                </div>
                <?php if(login()){?>
                <div>
                    <form action="single-news.php" method="POST">
                        <input type="text" name="name" placeholder="Enter name" required><br><br>                                        
                        <textarea name="comment" cols="30" rows="10" placeholder="Enter comment" required></textarea><br><br>
                        <input type="hidden" name="id" id="id" value="<?php echo $id; ?>">
                        <button>Submit comment</button>
                    </form>                
                </div>
                <?php }?>
                
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