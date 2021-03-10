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
                        $query = "SELECT * FROM messages";
                        $result = $connection->query($query);
                        if($connection->num_rows($result) > 0){
                            while($messages = $connection->fetch_object($result)){
                                echo "<div>";
                                echo $messages->time . "<br>";
                                echo "<b>" . $messages->title . "</b>" . "<br>";
                                echo $messages->name . "<br>";
                                echo $messages->email . "<br>";
                                echo $messages->text . "<br>";                                
                                echo $messages->answer ? "<b>Answer:</b> " . $messages->answer : '';
                                echo "<br>";
                                $messages->answer != '' ? $action = "Edit answer" : $action = "Answer message";
                                echo "<a href='usermessages.php?messageId={$messages->id}&action=delete'><b>Delete message</b></a> |";
                                echo "<a href='usermessages.php?messageId={$messages->id}&action=update'><b>{$action}</b></a>";
                                echo "</div>";
                                echo "<br>";                                                            
                            }                            
                        }else{
                            $message = "No new messages!";
                        }
                    ?>
                </div>

                    <?php                    
                        if(login()){
                            if(isset($_GET['messageId']) and isset($_GET['action'])){
                                $messageId = $_GET['messageId'];
                                $action = $_GET['action'];
                                if($action == 'update'){ 
                                    $query = "SELECT * FROM messages WHERE id={$messageId}";
                                    $result = $connection->query($query);
                                    $userMessage = $connection->fetch_object($result);
                                    $userId = $userMessage->user_id;
                                    $userName = $userMessage->name;
                                    $userEmail = $userMessage->email;
                    ?>                                    
                        <form action="usermessages.php" method="POST">
                            <input type="hidden" name="messageId" value="<?php echo $messageId; ?>">
                            <input type="hidden" name="userId" value="<?php echo $userId; ?>">
                            <input type="hidden" name="name" value="<?php echo $userName; ?>">
                            <input type="hidden" name="email" value="<?php echo $userEmail; ?>">
                            <textarea name="answer" cols="30" rows="10" placeholder="Enter your answer" required></textarea><br>
                            <button name="answer-message">Submit answer</button>
                        </form>
                                            
                    <?php 
                                }
                            }
                        }       
                    ?> 

                    <?php
                    if(isset($_POST['messageId']) and isset($_POST['userId']) and isset($_POST['name'])and isset($_POST['email']) and isset($_POST['answer'])){
                        $messageId = $_POST['messageId'] . "<br>";
                        $userId = $_POST['userId'] . "<br>";
                        //echo $_POST['name'] . "<br>";
                        //echo $_POST['email'] . "<br>";
                        $answer = $_POST['answer'];

                        $query = "UPDATE messages SET answer='{$answer}' WHERE id='{$messageId}'";
                        $queryExecuted = $connection->query($query);

                        if(!$queryExecuted){
                            $message = "Your answer has not been sent!";
                        }else{
                            $message = "Your message has just been sent.";
                        }
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


