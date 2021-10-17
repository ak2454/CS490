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

$isValid = true;
$db = getDB();

$userID = get_user_id();
if (isset($_GET["id"])){ //checking which ID to use
    $userID = $_GET["id"];
}

// GRABBING USER INFO
$stmt = $db->prepare("SELECT email, username, created, privacy, bio from Users where id = :id");
$r = $stmt->execute([":id" => $userID]);
$userInfo = $stmt->fetchall(PDO::FETCH_ASSOC);
//var_export($userInfo);

// THIS IS FOR POSTS, IT WILL BE DYNAMIC! FOR SEARCHING FOR A USER OR THE USER PROFILE
$stmt = $db->prepare("SELECT id, caption, img_url, created from Posts where user_id = :id");
$r = $stmt->execute([":id" => $userID]);
$result = $stmt->fetchall(PDO::FETCH_ASSOC);


?>

<?php if (has_role("Admin")){
    echo "im an admin";
} 
?>

<div style="margin: auto; width: 50%; border: 1.5px solid grey;">
    <div>
        <div style="border: 3px solid white;">
            <img style="height:150px; width:150px;" src= "img/logo.png" />
        </div>
        <div style="position:relative; bottom:125; margin-top:50px; margin-left: 250px; border: 3px solid white;">
            <h5> <?php echo $userInfo[0]["username"]; ?> </h5>

            <input style="position:relative; left:200px;bottom:65px;" class="btn btn-primary" type="submit" name="settings" value="Edit Profile"/>
            <p> <?php echo $userInfo[0]["bio"]; ?></p>
        </div>
        <?php foreach($result as $post){?>
            <div class="card" style="border-radius: 0;margin: auto; width: 100%; border-left: 1.5px solid white;border-right: 1.5px solid white;">
                <img style class="user-img" src="https://www.cityofturlock.org/_images/dogbarking.jpg" width="30" height="30">
                <h5 class="card-title"><?php echo $userInfo[0]["username"]; ?>  <small style = "color:grey; position: relative; left: 700px"> <?php echo $post["created"];?></small></h5>

                <div class="card-body">
                    <img class="card-img-top" src=" img/<?php echo $post["img_url"];?>" alt="Card image cap">
                    <p class="card-text"><strong><?php echo $userInfo[0]["username"]; ?></strong> <?php echo $post["caption"];?></p>
                    <p class="card-text" style = "color:grey;"><strong>comments:</strong></p>

                    <ul class="list-group">
                        <?php //for each comment:
                        $postID = $post["id"];
                        $stmt = $db->prepare("SELECT Users.username as username, Comments.comment, Comments.post_id, Comments.created FROM Users JOIN  Comments on Users.id = Comments.user_id where Comments.post_id = :id ORDER BY Comments.created");
                        $r = $stmt->execute([":id" =>$postID]);
                        $commentInfo = $stmt->fetchall(PDO::FETCH_ASSOC);
                        foreach($commentInfo as $comment){
                        ?>
                        <li class="list-group-item"><strong><?php echo $comment["username"];?></strong> <?php echo $comment["comment"];?> <small style ="float: right; color:grey;"> <?php echo $comment["created"];?></small></li>
                        <?php } ?>
                    </ul>
                    <form method="POST">
                        <div class="form-group">
                            <input class="form-control" type="text" id="comment" name="comment" placeholder = "comment"/>
                            <input type="hidden" id="postID" name="postID" value="<?php echo $post["id"];?>">
                        </div>
                        <input class="btn btn-primary" type="submit" name="submit" value="add comment"/>
                    </form>
            </div>
        </div>
    <?php } ?>
</div>



<?php //add comment
if (isset($_POST["comment"]) && isset($_POST["submit"]) && strlen($_POST["comment"]) > 0 ) {
    $comment = $_POST["comment"]; //send to database where postID
    $postID = $_POST["postID"];
    if (isset($db)) {

        $stmt = $db->prepare("INSERT INTO Comments(comment, post_id, user_id) VALUES(:comment,:post, :user)");
        $params = array(":comment" => $comment, ":post" => $postID, ":user" => get_user_id());
        $r = $stmt->execute($params);
        $e = $stmt->errorInfo();
        if ($e[0] == "00000") {
            flash("comment added");
        }

    }


}
?>

<?php require("../partials/flash.php");?>