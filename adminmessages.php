<?php
    session_start();
    require_once('include/_require.php');

    if($_SESSION['role'] != 'user'){
        $message = "You have to be loggeed in to access this page!";
        header('Location: login.php?message='.$message);
    }           
        
    $message = '';

    $connection = new Database();
        if(!$connection->connect()){
            exit();
        }

        if(isset($_GET['messageId']) and isset($_GET['action'])){
            $messageId = $_GET['messageId'];
            $action = $_GET['action'];

            if($action == 'delete'){
                $query = "DELETE FROM messages WHERE id={$messageId}";
                $connection->query($query);
                $message = "A message with the following id: {$messageId} has been deleted.";
            }else{
                echo "The message does not exist!";
            }
        }    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/style.css" rel="stylesheet">
    <title>User messages</title>
</head>
<body>

    <div id="wrapper">

        <div id="header">
            <?php include_once('include/menu.php'); ?>
        </div>

        <div id="content">

            <div id="main"> 
                <div id="approve-comments">
                    <h2>User messages</h2>  

                    <?php
                        $query = "SELECT * FROM messages WHERE user_id={$_SESSION['id']}";
                        $result = $connection->query($query);
                        if($connection->num_rows($result) > 0){
                            while($messages = $connection->fetch_object($result)){
                                echo "<div>";
                                echo $messages->time . "<br>";
                                echo "<b>" . $messages->title . "</b>" . "<br>";
                                echo $messages->name . "<br>";
                                echo $messages->email . "<br>";
                                echo $messages->text . "<br>"; 
                                echo "<br>";                               
                                echo $messages->answer ? "<b>Admin's answer</b><br> " . $messages->answer : '';
                                echo "<br>";                                
                                echo "<a href='adminmessages.php?messageId={$messages->id}&action=delete'><b>Delete message</b></a>";                                
                                echo "</div>";
                                echo "<br>";                                                            
                            }                            
                        }else{
                            $message = "No new messages!";
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


