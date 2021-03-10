<?php
    session_start();
    require_once("include/_require.php");

    $connection = new Database();
        if(!$connection->connect()){
            exit();
        }
        $message="";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/style.css" rel="stylesheet">
    <title>PHP</title>
</head>
<body>

<div id="wrapper">

    <div id="header">
        <?php include_once('include/menu.php'); ?>
    </div>

    <div id="content">
        <div id="main"> 
            <div id="login-form">
                <h1>Login</h1>
                <form action="login.php" method="post">
                    <input type="text" name="email" placeholder="Enter your email" required><br><br>
                    <input type="text" name="password" placeholder="Enter your password" required><br><br>
                    <input type="checkbox" name="remember" > Remember me on this PC <br>   <br>
                    <button>Log in</button>
                </form>
            </div>
        
            <?php
                if(isset($_POST['email']) and isset($_POST['password'])){

                    $email = $_POST['email'];
                    $password = $_POST['password'];

                    if($email != "" and $password != ""){
                        if(validateEmail($email) and validateString($password)){ // filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL)
                            
                            $query = "SELECT * FROM users WHERE email='{$email}'";
                            $result = $connection->query($query);

                            if($connection->num_rows($result) == 1){                            
                                $row = $connection->fetch_object($result);
                                
                                if($row->status == 'active'){
                                    if($row->password == $password){                                                                        

                                        //echo "{$row->name}, $row->status";
                                        $_SESSION['id'] = $row->id;
                                        $_SESSION['name'] = $row->name;
                                        $_SESSION['role'] = $row->role;
                                        $_SESSION['email'] = $row->email;
                                        Statistics::writeLog("logs/login.log", "{$_SESSION['name']} logged in.");
                                                                            
                                        if(isset($_POST['remember'])){
                                            
                                            setcookie("id", $_SESSION['id'], time()+3600,"/");
                                            setcookie("name", $_SESSION['name'], time()+3600,"/");
                                            setcookie("role", $_SESSION['role'], time()+3600,"/");
                                            setcookie("email", $_SESSION['email'], time()+3600,"/");
                                        }
                                        header("location:index.php");

                                    }else{ 
                                        $message = "Incorrect password '{$password}'!";
                                        Statistics::writeLog("logs/login.log", "Incorrect password {$password}."); 
                                    }
                                }else{ 
                                    $message = "User '{$email}' exists, but the account is inactive!"; 
                                    Statistics::writeLog("logs/login.log", "User {$email} is inactive.");
                                } 
                            }else{ 
                                $message = "User '{$email}' does not exist!"; 
                                Statistics::writeLog("logs/login.log", "User {$email} does not exist.");}
                        }else{ 
                            $message = "Email or password contain forbidden characters!"; 
                            Statistics::writeLog("logs/login.log", "User tried to use forbidden characters - email input: {$email}; password input: {$password}; IP address: {$_SERVER['REMOTE_ADDR']}.");}
                    }else{ 
                        $message = "All fields are required!"; 
                        Statistics::writeLog("logs/login.log", "User did not fill out all fields.");}
                }else{ 
                    $message = isset($_GET['message']) ? $_GET['message'] : "Welcome to login page!"; 
                }
                    
            ?>
                
            <div class="login-message">
                <p><?php echo $message; ?></p>
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