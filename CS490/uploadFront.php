<link rel="stylesheet" href="styles.css" type="text/css">
<?php require_once("../partials/nav.php"); ?>
<?php

if (!is_logged_in()) {
    //this will redirect to login and kill the rest of this script (prevent it from executing)
    flash("You must be logged in to access this page");
    die(header("Location: login.php"));
}

?>



<form role="form" action= "uploadBack.php" id="uploadForm" method="post" enctype="multipart/form-data">
   <input id="fileToUpload" name="file" type="file" class="file" />
   <button type="submit" name="submit" id="submit">Upload</button>
</form>