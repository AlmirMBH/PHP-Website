<?php
    session_start();
    require_once('include/_require.php');

    if($_SESSION['role'] != 'admin'){
        $message = "You have to be loggeed in to access this page!";
        header('Location: login.php?message='.$message);
    }           
        
    $message = '';

    $connection = new Database();
        if(!$connection->connect()){
            exit();
        }

        if(isset($_GET['commentId']) and isset($_GET['action'])){
            $commentId = $_GET['commentId'];
            $action = $_GET['action'];

            if($action == 'delete'){
                $query = "DELETE FROM comments WHERE id={$commentId}";
            }else{
                $query = "UPDATE comments SET approved=1 WHERE id={$commentId}";
            }

            $connection->query($query);

        }
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/style.css" rel="stylesheet">
    <title>Approve comments</title>
</head>
<body>

    <div id="wrapper">

        <div id="header">
            <?php include_once('include/menu.php'); ?>
        </div>

        <div id="content">

            <div id="main"> 
                <div id="approve-comments">
                    <h2>Approve comments</h2>  

                    <?php
                        $query = "SELECT * FROM comments WHERE approved=0";
                        $result = $connection->query($query);
                        if($connection->num_rows($result) > 0){
                            while($comments = $connection->fetch_object($result)){
                                echo "<div>";
                                echo $comments->time . "<br>";
                                echo $comments->name . "<br>";
                                echo $comments->comment . "<br>";
                                $newsQuery = "SELECT * FROM news WHERE id=$comments->news_id";
                                $newsResult = $connection->query($newsQuery);
                                $news = $connection->fetch_object($newsResult);
                                echo "News title: " . $news->title . "<br><br>";
                                echo "<a href='approvecomments.php?commentId={$comments->id}&action=delete'>Delete comment</a> |";
                                echo "<a href='approvecomments.php?commentId={$comments->id}&action=approve'>Approve comment</a>";                                                                
                                echo "</div>";
                                echo "<br>";                                 
                            }
                        }else{
                            echo "No new comments!";
                        }
                    ?>
                </div>

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