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

    if(isset($_POST['deleteUserButton'])){
        $userId = $_POST['userId'];
        if($userId != '0'){
            $query = "DELETE FROM users WHERE id = {$userId}";
            //$query = "UPDATE users SET deleted_at = {date('d-m-Y H:i:s')} WHERE id = $userId";
            $connection->query($query);
                        
            if($connection->error()){
                $message = "User with id {$userId} has not been deleted. Error: " . $connection->error();
                Statistics::writeLog("logs/users.log", "{$_SESSION['name']} has not managed to delete user {$userId}.");
            }else{
                $message = "User with id {$userId} has been deleted.";
                Statistics::writeLog("logs/users.log", "{$_SESSION['name']} has deleted user {$userId}.");
                if(file_exists('avatars/' . $userId . '.jpg')){
                    unlink('avatars/' . $userId . '.jpg'); 
                }
            }            
        }else{
            $message = "Select a user to delete!";
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
    <title>Delete User</title>
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
                        <h2>Delete user</h2>
                        <div id="deleteUserForm">
                            <form action="deleteuser.php" method="POST">                                
                                <select name="userId" id="userId">
                                    <option value="0">-- Select user --</option>
                                    <?php
                                        // deletion code (execution) must be above this block of code
                                        $query = "SELECT * FROM users";
                                        $result = $connection->query($query);
                                        while($row = $connection->fetch_object($result)){                                            
                                            echo "<option value='{$row->id}'>{$row->name}</option>";
                                        }                                                                                
                                    ?>
                                </select>                                  
                                <button name="deleteUserButton">Delete user</button>                                
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