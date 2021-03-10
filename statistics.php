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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/style.css" rel="stylesheet">
    <title>Statistics</title>
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

                <section id="statistics">                        
                    <div id="statistics">
                        <h2>Statistics</h2>
                        <div id="statistics">
                            <form action="statistics.php" method="POST">                                
                                <select name="file" id="file">
                                    <option value="0">-- Select log file --</option>
                                    <option value="login.log">Logins</option>
                                    <option value="users.log">Users</option>
                                    <option value="news.log">News</option>
                                    <option value="hacking.log">Hacking</option>
                                </select>                                                            
                                <button name="statistics">Submit</button>
                            </form>
                        </div>                
                        <hr>
                </section>
                    
                <?php
                    if(isset($_POST['file']) and $_POST['file'] != '0'){
                        $file = $_POST['file'];

                        if(file_exists('logs/'.$file)){
                            $fileContents = file_get_contents("logs/$file");                            
                            $fileContents = filter_var($fileContents, FILTER_SANITIZE_STRING) ;
                            $fileContents = nl2br($fileContents);                            
                            echo "<p style='width:500px'>$fileContents</p>";
                        }else{
                            $message = "No logs available!";
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