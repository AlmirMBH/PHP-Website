<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Image upload</title>
</head>
<body>
    <h1>Upload image</h1>
    <form action="upload.php" method="POST" enctype="multipart/form-data">
        <input type="file" name="image"><br><br>
        <button>Upload</button>
    </form>


    <?php 
        if(isset($_FILES['image'])){
            // for data below use: print_r($_FILES['image']); 
            $tempfolder = $_FILES['image']['tmp_name'];
            $destfolder = 'uploadedimages/';
            $image = $_FILES['image']['name'];
            $error = $_FILES['image']['error'];
            $size = $_FILES['image']['size'];

            if(@move_uploaded_file($tempfolder, $destfolder . $image)){
                echo "Your image has been uploaded";
            }else{
                echo "Your image has not been uploaded!";
            }                        
        }else{
            echo "Welcome to upload page";
        }
    ?>
    
</body>
</html>