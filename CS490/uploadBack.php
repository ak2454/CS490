<link rel="stylesheet" href="styles.css" type="text/css">
<?php require_once("../partials/nav.php"); ?>
<?php
//Note: we have this up here, so our update happens before our get/fetch
//that way we'll fetch the updated data and have it correctly reflect on the form below
//As an exercise swap these two and see how things change
if (!is_logged_in()) {
    //this will redirect to login and kill the rest of this script (prevent it from executing)
    flash("You must be logged in to access this page");
    die(header("Location: login.php"));
}

?>
<?php echo exec('whoami'); ?>
<?php

if (isset($_POST["submit"])){
   $file = $_FILES['file'];
   $fileName = $_FILES['file']['name'];
   $fileTmpName = $_FILES['file']['tmp_name'];
   $fileSize = $_FILES['file']['size'];
   $fileErr = $_FILES['file']['error'];
   $fileType = $_FILES['file']['type'];

   $fileExt = explode('.', $fileName);
   $fileActualExt = strtolower(end($fileExt));
   $acceptedExtensions = array('jpg', 'png', 'jpeg'); 
   
   if (in_array($fileActualExt, $acceptedExtensions)){
      if($fileErr === 0){
         if ($fileSize < 1000000){
            $fileNameNew = uniqid('', true).".".$fileActualExt;
            $fileDestination = 'uploads/'.$fileNameNew;
            move_uploaded_file($fileTmpName, $fileDestination);
            
         }
         else{
            echo " file size is too large!!";
         }

      } 
      else{
         echo "Error whiile uploading file";
      }
   }
   else{
      echo "Extension not accepted, Sorry! please use PNG, JPG, or JPEG files";
   }
}  
?>




<?php require("../partials/flash.php");?>