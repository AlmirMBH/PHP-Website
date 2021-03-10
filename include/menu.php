<?php 
    require_once('_require.php');    
?>
    <div class="brand">
        <img src="images/logo.png" alt="brand">
    </div>
    
    <nav id="navbar">
        <ul>
            <li><a href="index.php">HOME</a></li>
            <li>
                <div class="dropdown">
                    <button class="dropbtn">FRAMEWORKS</button>
                    <div class="dropdown-content">
                        
                        <?php                             
                            $connection = new Database();
                                if(!$connection->connect()){
                                    exit();
                                }

                            $query = "SELECT * FROM categories";                            
                            $result = $connection->query($query);
                                                       
                                while($row = $connection->fetch_object($result)){                            
                                    echo "<a href='index.php?category={$row->id}'>" . strtoupper($row->category_name) . "</a>";
                                }
                        ?>
                    </div>
                </div>
            </li>            
            <li><a href="about.php">ABOUT</a></li>
            <?php 
                if(login()){
                    echo "<li><a href='logout.php'>LOGOUT</a></li>";
            }else{
                    echo "<li><a href='login.php'>LOGIN</a></li>";
                    echo "<li><a href='register.php'>REGISTER</a></li>";
            }
            ?>
            
        </ul>
    </nav>
