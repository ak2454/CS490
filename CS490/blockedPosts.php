<?php require_once("../partials/nav.php");
require_once("../partials/flash.php");
 ?>
<link rel="stylesheet" href="styles.css" type="text/css">
<?php

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

//we use this to safely get the email to display
$email = "";
if (isset($_SESSION["user"]) && isset($_SESSION["user"]["email"])) {
    $email = $_SESSION["user"]["email"];

}
 
if(isset($_POST['block'])) {
    $postID = $_POST['id'];
    $stmt = $db->prepare("UPDATE Posts SET is_blocked = 1 WHERE (id = $postID)"); 
    $r = $stmt->execute();
}

$stmt = $db->prepare("SELECT Posts.id as id, Posts.user_id, Posts.caption, Posts.img_url, Posts.created, Posts.is_blocked, Users.username from Posts JOIN Users ON Users.id = Posts.user_id ORDER BY Posts.created DESC ");
$r = $stmt->execute();
$result = $stmt->fetchall(PDO::FETCH_ASSOC);


?>
<?php if ($email){ ?>
    <?php //for each post to be shown on feed, grab post-ID , post-owner-username, post-owner-profile-image, post-image, post-caption, comments-text, comment-owner, comment-date  ?>
    <?php foreach( $result as $post){ ?>
        <?php if ($post["is_blocked"] == 2){ ?>
            <div class="card" style="width: 40rem;">
            <img class="user-img" src="https://www.cityofturlock.org/_images/dogbarking.jpg" width="30" height="30">
            <div style="flex-direction:row;">
                <h5  style="display:inline-block; float:left;" ><?php echo $post["username"] ?></h5>
                <?php if (has_role("Admin")): ?>
                    <form method="POST">
                        <input type="submit" name="block" style="display:inline-block; float:right; margin-right: 50px;" value="unblock">
                        <input type="text" name="id" style="display:inline-block; float:right; margin-right: 50px;" value="<?php safer_echo($post["id"]) ?>" hidden>
                    </form>
                <?php endif; ?>
            </div>
            <div class="card-body">
                <img class="card-img-top" src="uploads/<?php echo $post["img_url"];?>" alt="Card image cap">
                <p class="card-text"><strong><?php echo $post["username"] ?>:</strong> <?php echo $post["caption"] ?></p>
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
            </div>
        <?php } ?>
    <?php } ?>

  <?php } ?>