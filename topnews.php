<?php
    session_start();
    require_once('include/_require.php');

    $message = '';
    $connection = new Database();
        if(!$connection->connect()){
            exit();
        }
    
    if($_SESSION['role'] != 'admin'){
        $message = "You have to be loggeed in to access this page!";
        header('Location: login.php?message='.$message);
    }       
?>    

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/style.css" rel="stylesheet">
    <title>Top news</title>
</head>
<body>

    <div id="wrapper">

        <div id="header">
            <?php include_once('include/menu.php'); ?>
        </div>

        <div id="content">
            <div id="main">      
                <div id="news">
                    <h2>Top news</h2>
                    <?php                                                                  
                        $query = "SELECT * FROM wnews WHERE deleted = 0 ORDER BY viewed DESC LIMIT 3";
                        $result = $connection->query($query);
                        
                        while($row = $connection->fetch_object($result)){                        
                            $image = 'images/placeholder.png';

                            if(file_exists("images/{$row->id}.jpg")){
                                $image = "images/{$row->id}.jpg";
                            }
                
                            echo "<div style='float:left'>";
                            echo "<img style='width:200px; margin:10px 20px 0px 0px' src='$image'>";        
                            echo "</div>";
                            echo "<div><a style='margin-top:20px' href='index.php?category=" . $row->category . "'>" . $row->category_name . "</a></div>";
                            echo "<h3 style='border-bottom:0px;color:#777CB5'><a href='single-news.php?id=".$row->id."'>".$row->title."</a></h3>";                            
                            echo $row->text . "<br>";                            
                                if(file_exists('avatars/' . $row->author . '.jpg')){
                                    $avatar = 'avatars/' . $row->author . '.jpg';
                                }else{
                                    $avatar = 'avatars/' . 'nouser.png';
                                }                        
                            echo "<img src='{$avatar}' height='15px'>";
                            echo "<b><a href='index.php?author=" . $row->author . "'>" . '&nbsp' . $row->name ."</a></b><br>";
                            echo "<i>".$row->time."</i><br>";
                            echo "<i>Viewed: {$row->viewed} </i><br>";                            

                            $query = "SELECT count(id) AS number FROM comments WHERE news_id={$row->id} and approved=1";
                            $numberOfComments = $connection->query($query);
                            $numberOfComments = $connection->fetch_object($numberOfComments);

                            echo "Number of comments: {$numberOfComments->number}";    
                            echo "<hr style='margin-top:10px'>";  
                        }
                    ?>
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