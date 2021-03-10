<?php  
  
    require_once('_require.php');
            
$query = "SELECT * FROM wnews WHERE deleted = 0 ORDER BY id DESC";

    if(isset($_GET['id'])){        
        $id = $_GET['id'];
        if(filter_var($id, FILTER_VALIDATE_INT)){
            $showCommentForm = TRUE;
            $query = "SELECT * FROM wnews WHERE deleted = 0 AND id =" . $_GET['id'];
        }else{
            $userAttempt = filter_var($id, FILTER_SANITIZE_STRING);
            echo "<p style='color:red; font-weight:900'>Hacking is considered a criminal act!<br> 
                Your IP address: {$_SERVER['REMOTE_ADDR']}<br> Your attempt: " . $userAttempt . 
                "<br><br> Think twice before you try again!</p>";

                $log = "\n Hacking attempt from the following address: " . $_SERVER['REMOTE_ADDR'] . 
                "\n Hacking script:" . $userAttempt ."\n" . 
                "Hacking attempted on the following page: " . $_SERVER['REQUEST_URI'] . "\n";
                Statistics::writeLog("logs/hacking.log", $log);
        }
    }     

if(isset($_GET['category'])) 
    $query = "SELECT * FROM wnews WHERE deleted = 0 AND category ='" . $_GET['category'] . "' ORDER BY id DESC";

if(isset($_GET['author']))
    $query = "SELECT * FROM wnews WHERE deleted = 0 AND author ='" . $_GET['author'] . "' ORDER BY id DESC";
    
if(isset($_GET['search']))
    $query = "SELECT * FROM wnews WHERE deleted = 0 AND (title LIKE ('%".$_GET['search']."%') OR text LIKE ('%" . $_GET['search'] . "%')) ORDER BY id DESC";
    
    $result = $connection->query($query);

    if($connection->error()){
        echo "Connection error!!!!<br>";
        echo $connection->error()." (".$connection->errno().")";
        exit();
    }

 
    echo "<div class='news'><h2>Latest news</h2>";
    if(!isset($_GET['id'])){
        echo "<div style='color: red'>Number of news: ". $connection->num_rows($result) . "</div>";    
    }
    
while($row = $connection->fetch_object($result)){

        $image = 'images/placeholder.png';

        if(file_exists("images/{$row->id}.jpg")){
            $image = "images/{$row->id}.jpg";
        }

        echo "<div style='float:left'>";
        echo "<img style='width:200px; margin:25px 10px 0px 0px' src='$image'>";        
        echo "</div>";
        echo "<div style='margin-top:30px;'><a href='index.php?category=" . $row->category . "'>" . $row->category_name . "</a></div>";
        echo "<h3><a href='single-news.php?id=".$row->id."'>".$row->title."</a></h3>";
                                
        $tmp = explode(" ", $row->text);
        $new = array_slice($tmp, 0, 20);
        $text = implode(" ", $new)."...<br>";

        if(isset($_GET['search'])){
            echo str_replace(strtolower($_GET['search']), "<span style='background-color:#777CB5; padding-left:2px; padding-right:2px;'>".$_GET['search']."</span>", strtolower($text));
        }else{
            echo $text;
        }            
            
    if(file_exists('avatars/' . $row->author . '.jpg')){
        $avatar = 'avatars/' . $row->author . '.jpg';
    }else{
        $avatar = 'avatars/' . 'nouser.png';
    }

    echo "<img src='{$avatar}' height='15px'>";
    echo "<b><a href='index.php?author=" . $row->author . "'>" . '&nbsp' . $row->name ."</a></b><br>";
    echo "<i>".$row->time."</i><br>";
        if(isset($_SESSION['role']) == 'admin'){
            echo "<i>Viewed: {$row->viewed} </i><br>";
        }   

    $query = "SELECT count(id) AS number FROM comments WHERE news_id={$row->id} and approved=1";
    $numberOfComments = $connection->query($query);
    $numberOfComments = $connection->fetch_object($numberOfComments);
    echo "Number of comments: {$numberOfComments->number}";
    echo "<hr style='margin-top:10px'>";
}
    echo "</div>";   
     
    
?>    