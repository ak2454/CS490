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

<h1><?php echo exec('whoami'); ?></h1>
<form role="form" id="uploadForm" method="post" enctype="multipart/form-data">
   <input id="fileToUpload" name="fileToUpload" type="file" class="file" />
   <button type="submit" name="submit" id="submit">Upload</button>
</form>



<?php
$target_dir = "./uploads/";

if(isset($_POST["submit"])) {
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
}

if (file_exists($target_file)) {
echo "Sorry, file already exists.";
$uploadOk = 0;
}

if ($_FILES["fileToUpload"]["size"] > 5000000) {
echo "Sorry, your file is too large.";
$uploadOk = 0;
}

if ($uploadOk == 0) {
echo $uploadOk . "Sorry, your file was not uploaded.";
} else {
  if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
   echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
  } else{
     echo "Sorry, there was an error uploading your file.";
  }
}
?>





<?php require("../partials/flash.php");?>