<link rel="stylesheet" href="styles.css" type="text/css">
<?php require_once("../partials/nav.php"); ?>
<?php

if (!is_logged_in()) {
    //this will redirect to login and kill the rest of this script (prevent it from executing)
    flash("You must be logged in to access this page");
    die(header("Location: login.php"));
}

?>

<form class = "form" role="form"  id="uploadForm" method="post" enctype="multipart/form-data" style = "display: table; margin: 0 auto; margin-top: 300px; padding: 50px; border: 1px solid #ced4da; ">
   <input id="fileToUpload" name="file" type="file" class="file" required>
   <input class="form-control" type="text" id="caption" name="caption"  placeholder = "caption" style = "width: 400px; margin-top: 20px; "required/>
   <button type="submit" name="submit" id="submit" style="margin-top: 20px; border-color: #767676; border-width: 1px; border-radius: 2px;">Upload</button>
</form>

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

            



            $db = getDB();
            if (isset($db) && isset($_POST['caption'])) {
                  $caption = $_POST['caption'];
                  $id = get_user_id();
                  
                  $stmt = $db->prepare("INSERT INTO Posts(user_id, caption, img_url) VALUES(:user_id,:caption, :img_url)");
                  $params = array(":user_id" => $id, ":caption" => $caption, ":img_url" => $fileNameNew);
                  $r = $stmt->execute($params);
                  $e = $stmt->errorInfo();
                  if ($e[0] == "00000") {
                     flash("new post created");
                  }
                  else {
                     if ($e[0] == "23000") {//code for duplicate entry
                        flash("oops, something is wrong here.");
                     }
                     else {
                        flash("An error occurred, please try again");
                     }
                  }
            }
            

            
         }
         else{
            echo " file size is too large!!";
         }

      } 
      else{
         echo "Error while uploading file";
      }
   }
   else{
      echo "Extension not accepted, Sorry! please use PNG, JPG, or JPEG files";
   }
}
?>




<?php require("../partials/flash.php");?>