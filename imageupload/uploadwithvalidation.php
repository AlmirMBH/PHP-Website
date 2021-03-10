<?php $message = ''; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Image upload with validation</title>
</head>
<body>
    <h1>Upload image with validation</h1>
    <form action="uploadwithvalidation.php" method="POST" enctype="multipart/form-data">
        <input type="file" name="image" accept="image/jpeg, image/jpg, image/png"><br><br>
        <button>Upload</button>
    </form>

    <?php 
        if(isset($_FILES['image']['name']) and $_FILES['image']['name'] != ''){
                // to get data params below (error, size,etc.) use: print_r($_FILES['image']);
                $image = "uploadedimages/".microtime(true). "." . pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION); 
                $temporary = $_FILES['image']['tmp_name'];
                $error = $_FILES['image']['error'];
                $size = $_FILES['image']['size'];
            if(!file_exists($image)){
                if($size < 500000){
                        $allowed_extensions = array('jpg', 'jpeg', 'png');
                        $image_extension = strtolower(pathinfo($image, PATHINFO_EXTENSION));
                    if(in_array($image_extension, $allowed_extensions)){
                            $uploaded_image = getimagesize($temporary);
                        if($uploaded_image){                            
                            if($uploaded_image[0] <= 2000 and $uploaded_image[1] <= 2000){
                                 if(@move_uploaded_file($temporary, $image)){

                                    $message = "Your image has been uploaded";

                                }else{ $message = "Your image has not been uploaded!"; }
                            }else{ $message = "Your image is too small!"; }                            
                        }else{ $message = "Only images are allowed!"; }                                            
                    }else{ $message = "Only png, jpg and jpeg images allowed!"; }
                }else{ $message = "Your image is too large to be uploaded! The allowed size is 500Kb"; }
            }else{ $message = "A file with the same name already exists in the database!"; }                                    
        }else{ $message = "Welcome to upload page"; }
    ?>
    
    <div><p><?php echo $message; ?></p></div>

</body>
</html>