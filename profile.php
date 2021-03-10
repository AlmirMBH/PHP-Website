<?php
    session_start();
    require_once('include/_require.php');

    if(!login()){
        $message = "You have to be loggeed in to access this page!";
        header('Location: login.php?message='.$message);
    }           
        
    $message = '';

    $connection = new Database();
        if(!$connection->connect()){
            exit();
        }

    if(isset($_POST['update-user'])){
        $id = $_POST['id'];
        if($id != '0'){
            $name = $_POST['name'];
            $email = $_POST['email'];
            $username = $_POST['username'];
            $password = $_POST['password'];            
            
            $query = "UPDATE users SET name='{$name}', email='{$email}', username='{$username}', password={$password} WHERE id = $id";
            $connection->query($query);
            $message = "Your profile has been updated.";
                        
            if($connection->error()){
                $message = "{$name}, your profile has not been updated. Error: " . $connection->error();
                Statistics::writeLog("logs/users.log", "{$name} has not managed to update profile. Error: {$connection->error()}.");
            }else{
                $message = "{$name}, your profile has been updated.";
                Statistics::writeLog("logs/users.log", "{$name}'s profile has been updated");                
            }
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
    <title>Profile</title>
</head>
<body>

    <div id="wrapper">

        <div id="header">
            <?php include_once('include/menu.php'); ?>
        </div>

        <div id="content">

            <div id="main">                

                <section id="profile">                        
                    <div id="profile">
                        <h2>Profile</h2>
                        <div id="profileForm">
                            <?php
                                // update code (execution) must be above this block of code
                                $query = "SELECT * FROM users WHERE id=" . $_SESSION['id'];
                                $result = $connection->query($query);
                                $user = $connection->fetch_object($result);

                                $id = $user->id;
                                $name = $user->name;
                                $email = $user->email;
                                $username = $user->username;
                                $password = $user->password;                                
                            ?>

                            <form action="profile.php" method="POST">   
                                 <input type="hidden" name="id" value="<?php echo $id; ?>">                             
                                <input type="text" name="name" value="<?php echo $name; ?>" required><br>
                                <input type="text" name="email" value="<?php echo $email; ?>" required><br>
                                <input type="text" name="username" value="<?php echo $username; ?>" required><br>
                                <input type="text" name="password" value="<?php echo $password; ?>" required><br>
                                <button name="update-user">Update user data</button>                                
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