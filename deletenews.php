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

    if(isset($_POST['deleteNewsButton'])){
        $newsId = $_POST['newsId'];
        if($newsId != '0'){
            //$query = "DELETE FROM news WHERE id = {$userId}";
            $query = "UPDATE wnews SET deleted = 1 WHERE id = $newsId";
            $connection->query($query);
                        
            if($connection->error()){
                $message = "News with id {$newsId} has not been deleted. Error: " . $connection->error();
                Statistics::writeLog("logs/news.log", "{$_SESSION['name']} has not managed to delete news {$newsId}. Error: $connection->error()");
            }else{
                $message = "News with id {$newsId} has been deleted.";
                Statistics::writeLog("logs/news.log", "{$_SESSION['name']} has deleted news {$newsId}.");
                // if(file_exists('images/' . $newsId . '.jpg')){ // if soft delete is not used (query above)
                //     unlink('images/' . $newsId . '.jpg');      // unlink is used to delete avatar from server
                // }
            }            
        }else{
            $message = "Select news to delete!";
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
    <title>Delete news</title>
</head>
<body>

    <div id="wrapper">

        <div id="header">
            <?php include_once('include/menu.php'); ?>
        </div>

        <div id="content">

            <div id="main">                 

                <section id="deleteUser">                        
                    <div id="deleteUser">
                        <h2>Delete news</h2>
                        <div id="deleteUserForm">
                            <form action="deletenews.php" method="POST">                                
                                <select name="newsId" id="newsId">
                                    <option value="0">-- Select news --</option>
                                    <?php
                                        // deletion code (execution) must be above this block of code
                                        $query = "SELECT * FROM wnews WHERE deleted = 0 AND name='{$_SESSION['name']}' ORDER BY id DESC";
                                        $result = $connection->query($query);
                                        while($row = $connection->fetch_object($result)){
                                            echo "<option value='{$row->id}'>{$row->title}</option>";
                                        }
                                    ?>
                                </select>                                                            
                                <button name="deleteNewsButton">Delete news</button>
                            </form>
                        </div>                
                        <hr>
                </section>  
                
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