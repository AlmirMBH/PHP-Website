<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
            <form action="single-news.php?<?php $id?>" method="post">
                <input type="text" name="ime" placeholder="Enter name" required><br><br>                
                <textarea name="komentar" id="komentar" cols="30" rows="10" placeholder="Enter comment" required></textarea><br><br>
                <button>Submit comment</button>
            </form>
            <br><br>

            

            <?php
            //Save commment
            //echo $_GET['id']; /ovdje dobijam id kad kliknem na single news
            if(isset($_GET['id']) and isset($_POST['ime']) and isset($_POST['komentar']))
            {
                echo $_POST['id'] . $_POST['ime'] . $_POST['komentar'];
                $id = $_POST['id'];
                $ime = $_POST['ime'];
                $komentar = $_POST['komentar'];
                if($id != "" and $ime != "" and $komentar != "")
                {
                    $ime = filter_var($ime, FILTER_SANITIZE_STRING);
                    $komentar = filter_var($komentar, FILTER_SANITIZE_STRING);
                    $upit = "INSERT INTO comments (news_id, name, comment) VALUES ({$id}, '{$ime}', '{$komentar}')";
                    $db->query($upit);
                    if($db->error())
                        echo "Connection error!!!<br>".$db->error();
                    else
                        echo "A comment added";
                } 
                else
                    echo "All fields required!!!";
            }
            ?>