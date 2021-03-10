<?php
    session_start();
    require_once('include/_require.php');

    if($_SESSION['role'] != 'admin'){
        $message = "You have to be loggeed in to access this page!";
        header('Location: login.php?message='.$message);
    }           

    $connection = new Database();
    if(!$connection->connect()){
        exit();
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
    <title>Add news</title>
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
                        <h2>Add news</h2>
                        <div id="new-user-form">
                            <form action="addnews.php" method="POST" enctype="multipart/form-data">
                                <input type="text" name="title" placeholder="Enter title" required><br>
                                <textarea name="text" placeholder="Enter text" required></textarea><br>                                
                                <!--<input type="text" name="name" placeholder="Enter author name" required><br>-->
                                <select name="category" id="category">
                                    <option value="0">-- Select category --</option>
                                    <?php     
                                        $query = "SELECT * FROM categories";                            
                                        $result = $connection->query($query);
                                                                
                                            while($row = $connection->fetch_object($result)){                            
                                                echo "<option value='{$row->id}'>" . $row->category_name . "</option>";
                                            }
                                    ?>                                    
                                </select><br>
                                <input type="file" name="image"><br>
                                <button name="add-news">Add news</button>
                            </form>
                        </div>                
                        <hr>
                </section>
                    
                <?php
                    if(isset($_POST['add-news'])){
                        $title = $_POST['title'];
                        $text = $_POST['text'];
                        $category = $_POST['category'];
                        $name = $_SESSION['id'];                                            
                        if($title != '' and $text != '' and $name != '' and $category != '0'){

                            $query = "INSERT INTO news (title, text, author, category) 
                            VALUES('{$title}', '{$text}', '{$name}', '{$category}')";

                            $connection->query($query);

                            if($connection->error()){
                                $message = "Database error" . $connection->error();
                                Statistics::writeLog("logs/news.log", "{$_SESSION['name']} Database error {$connection->error()}");
                            }else{
                                $newsId = $connection->insert_id();
                                $message = "News with an id {$newsId} has been added.<br>";
                                Statistics::writeLog("logs/news.log", "{$_SESSION['name']} has added a news {$title}.");

                                if($_FILES['image']['name'] != ''){
                                    $image_name = 'images/' . $newsId .".jpg";
                                    $temporary = $_FILES['image']['tmp_name'];
                                    $allowed_extensions = array('png', 'jpg', 'jpeg');
                                                                        
                                    if(in_array(pathinfo($image_name, PATHINFO_EXTENSION), $allowed_extensions)){
                                        if(@move_uploaded_file($temporary, $image_name)){
                                            $message .= "Image has been uploaded.";
                                        }else{ $message .= "Image image has not been uploaded."; }
                                    }
                                }
                            }
                        }else{ 
                            $message = "All fields are required!"; 
                            Statistics::writeLog("logs/news.log", "{$_SESSION['name']} has not filled out the required fields.");
                        }
                    }                
                ?>
                
                <div class="user-message">
                    <?php echo $message; ?>
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