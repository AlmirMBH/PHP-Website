<?php
    session_start();
    require_once('include/_require.php');

    if($_SESSION['role'] != 'admin'){
        $message = "You have to be loggeed in to access this page!";
        header('Location: login.php?message='.$message);
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
    <title>Add User</title>
</head>
<body>

    <div id="wrapper">

        <div id="header">
            <?php include_once('include/menu.php'); ?>
        </div>

        <div id="content">

            <div id="main"> 
                <div id="search">
                    <?php //include_once('include/search.php'); ?>
                </div>

                <section id="new-user">                        
                    <div id="add-user">
                        <h2>Add user</h2>
                        <div id="new-user-form">
                            <form action="adduser.php" method="POST" enctype="multipart/form-data">
                                <input type="text" name="name" placeholder="Enter name" required><br>
                                <input type="text" name="email" placeholder="Enter email" required><br>
                                <input type="text" name="username" placeholder="Enter username" required><br>
                                <textarea name="comment" id="comment" cols="16" rows="5" placeholder="Enter your comment"></textarea><br>
                                <select name="role" id="role">
                                    <option value="0">-- Select user role --</option>
                                    <option value="1">admin</option>
                                    <option value="2">user</option>
                                </select><br>                            
                                <input type="file" name="avatar"><br><br> 
                                <button name="new-user-button">Add user</button>
                            </form>
                        </div>                
                        <hr>
                </section>
                    
                <?php
                    if(isset($_POST['new-user-button'])){
                        $name = $_POST['name'];
                        $email = $_POST['email'];
                        $username = $_POST['email'];
                        $comment = $_POST['comment'];
                        $role = $_POST['role'];
                        
                        if($name != '' and $email != '' and $role != '0'){

                            $query = "INSERT INTO users (name, email, username, password, role, status, comment) 
                            VALUES('{$name}', '{$email}', '{$username}', '12345', '{$role}', 'active', '{$comment}')";

                            $connection->query($query);

                            if($connection->error()){
                                $message = "Database error" . $connection->error();
                                Statistics::writeLog("logs/users.log", "{$_SESSION['name']} Database error {$connection->error()}");
                            }else{
                                $user_id = $connection->insert_id();
                                $message = "A new user with an id {$user_id} has been added.<br>";
                                Statistics::writeLog("logs/users.log", "{$_SESSION['name']} has added a new user {$name}.");

                                if($_FILES['avatar']['name'] != ''){
                                    $image_name = 'avatars/' . $user_id.".jpg";
                                    $temporary = $_FILES['avatar']['tmp_name'];
                                    $allowed_extensions = array('png', 'jpg', 'jpeg');
                                                                        
                                    if(in_array(pathinfo($image_name, PATHINFO_EXTENSION), $allowed_extensions)){
                                        if(@move_uploaded_file($temporary, $image_name)){
                                            $message .= "Avatar image has been uploaded.";
                                        }else{ $message .= "Avatar image has not been uploaded."; }
                                    }
                                }
                            }
                        }else{ $message = "All fields are required!"; }
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