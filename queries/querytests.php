<?php
    require_once('include/_require.php');

$query = "SELECT * FROM `news` INNER JOIN users ON users.id = news.author WHERE news.deleted=0 ORDER BY news.id DESC";

    $connection = new Database();
        if(!$connection->connect()){
            exit();
        }

        $result = $connection->query($query);

        while($row = $connection->fetch_object($result)){
            echo $row->email . "<br>";
            echo $row->password . "<br>";
            echo "---------------------------------<br>";
        }




