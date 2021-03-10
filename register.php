<?php
    session_start();
    require_once('include/_require.php');     
        
    $message = '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/style.css" rel="stylesheet">
    <title>Register</title>
</head>
<body>

    <div id="wrapper">

        <div id="header">
            <?php include_once('include/menu.php'); ?>
        </div>

        <div id="content">

            <div id="main">                 

                <section id="new-user">                        
                    <div id="add-user">
                        <h2>Register</h2>
                        <div id="new-user-form">
                            <form action="register.php" method="POST" enctype="multipart/form-data">
                                <input type="text" name="name" placeholder="Enter name" required><br>
                                <input type="text" name="email" placeholder="Enter email" required><br>
                                <input type="text" name="username" placeholder="Enter username" required><br>
                                <input type="text" name="password" placeholder="Enter password" required><br>
                                <textarea name="comment" id="comment" cols="16" rows="5" placeholder="Enter your comment"></textarea><br>                                
                                <input type="file" name="avatar"><br><br> 
                                <button name="new-user-button">Register</button>
                            </form>
                        </div>   
                </section>
                    
                <?php
                    if(isset($_POST['new-user-button'])){
                        $name = $_POST['name'];
                        $email = $_POST['email'];
                        $username = $_POST['username'];
                        $comment = $_POST['comment'];
                        $password = $_POST['password'];
                        $role = 'user';
                        
                        if($name != '' and $email != '' and $username != '' and $password != ''){
                            if(validateString($name) and validateEmail($email) and validateString($username) and validateString($password)){
                                $query = "INSERT INTO users (name, email, username, password, role, comment) 
                                VALUES('{$name}', '{$email}', '{$username}', '{$password}', '{$role}', '{$comment}')";

                                $connection->query($query);

                            if($connection->error()){
                                $message = "Database error" . $connection->error();
                                Statistics::writeLog("logs/users.log", "{$name} Database error {$connection->error()}");
                            }
                                $userId = $connection->insert_id();                                
                                $_SESSION['id'] = $userId;
                                $_SESSION['name'] = $name;                                
                                $_SESSION['role'] = 'user';
                                Statistics::writeLog("logs/users.log", "{$_SESSION['name']} has been registered.");                                
                                $message = "Hi {$name}, you have just become a member of our community.<br>";
                                
                                if($_FILES['avatar']['name'] != ''){
                                    $imageName = 'avatars/' . $userId.".jpg";
                                    $temporary = $_FILES['avatar']['tmp_name'];
                                    $allowed_extensions = array('png', 'jpg', 'jpeg');
                                                                        
                                    if(in_array(pathinfo($imageName, PATHINFO_EXTENSION), $allowed_extensions)){
                                        if(@move_uploaded_file($temporary, $imageName)){
                                            $message .= "Avatar image has been uploaded.";
                                        }else{ $message .= "Avatar image has not been uploaded."; }
                                    }
                                }                            
                        }else {
                            $message = "You are not allowed to use forbidden characters!"; 
                            Statistics::writeLog("logs/users.log", "User tried to use forbidden characters - name input: {$name}; email input: {$email}; username input: {$username}; password input: {$password}; IP address: {$_SERVER['REMOTE_ADDR']}.");}
                        }else{ 
                            $message = "All fields are required!"; 
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