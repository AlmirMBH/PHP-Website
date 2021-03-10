<?php
    if(login() and isset($_SESSION['name'])){
        echo "<p>Welcome " . $_SESSION['name'] . "</p>";

        if($_SESSION['role'] === 'admin'){
            echo "<h2>News</h2>";
            echo "<ul>";
            echo "<li><a href='addnews.php'>Add news</a></li>";
            echo "<li><a href='deletenews.php'>Delete news</a></li>";
            echo "<li><a href='topnews.php'>Most read news</a></li>";
            echo "</ul>";

            echo "<h2>Users</h2>";
            echo "<ul>";
            echo "<li><a href='adduser.php'>Add user</a></li>";
            echo "<li><a href='deleteuser.php'>Delete user</a></li>";
            echo "</ul>";

            echo "<h2>Comments and messages</h2>";
            echo "<ul>";
            echo "<li><a href='approvecomments.php'>Approve comments</a></li>";
            echo "<li><a href='deletecomments.php'>Delete approved comments</a></li>";
            echo "<li><a href='usermessages.php'>User messages</a></li>";            
            echo "</ul>";

            echo "<h2>Statistics</h2>";
            echo "<ul>";
            echo "<li><a href='statistics.php'>Statistics</a></li>";
            echo "</ul>";            
        }

            echo "<h2>Profile</h2>";
            echo "<ul>";
            echo "<li><a href='profile.php'>Edit profile</a></li>";
            echo "<li><a href='usercomments.php'>My comments</a></li>";
            if($_SESSION['role'] === 'user'){
            echo "<li><a href='adminmessages.php'>Admin messages</a></li>";
            }
            echo "</ul>";
        
    }
?>    
<h2>Featured</h2>
<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nulla ab 
nostrum harum dolor ea obcaecati voluptates voluptatibus animi, ratione 
quidem optio deserunt, magni officia dolorum nesciunt consectetur tempora magnam 
voluptas! <a href="single-news.php?id=6">Read more...</a>
</p>
<h2>Featured course</h2>
<div id="tags">
    <ul>
        <li><a href="index.php?category=1">Laravel</a></li>
        <li><a href="index.php?category=2">Symphony</a></li>
        <li><a href="index.php?category=3">CodeIgniter</a></li>
        <li><a href="index.php?category=1">Laravel</a></li>        
        <li><a href="index.php?category=2">Symphony</a></li>                
    </ul>
</div>
<div id="sidebar-image">
    <img src="images/banner.png" alt="">
</div>

<div class="article">
    <h1>PHP COMMUNITY</h1>
    <p class="intro">Lorem ipsum dolor sit amet, consectetur adipisicing elit.
    Sit harum placeat optio quisquam voluptatem rerum, praesentium, iure laborum in? 
    Nostrum tempora magnam doloremque, minima ex a repellendus! Assumenda veritatis, 
    deserunt? <a href="single-news.php?id=1">Read more...</a>
    </p>
    <img src="" alt="">
</div>

<div class="contact.php">
    <h2>Contact us</h2>
    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Molestias 
    fugit vitae deleniti, doloremque nulla assumenda eligendi dolorem 
    suscipit. Iste voluptatibus voluptas, voluptate maxime neque ut 
    accusamus a nihil harum. Voluptatem? <a href="about.php">Contact us...</a> 
    </p>
</div>