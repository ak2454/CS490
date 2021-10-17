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

$stmt = $db->prepare("SELECT username, sender_id, content FROM Messages JOIN Users ON Users.id = Messages.sender_id WHERE sender_id = $userID OR receiver_id = $userID");
$r = $stmt->execute();
$result = $stmt->fetchall(PDO::FETCH_ASSOC);

$stmt = $db->prepare("SELECT id, username FROM `Users`");
$r = $stmt->execute();
$users = $stmt->fetchall(PDO::FETCH_ASSOC);

?>

<h1> Messages</h1>
<div>
    <!-- Select users to chat with -->
    <h4>Chat with: </h4>
    <div class="list-group" style="width:500px;">
        <?php foreach($users as $user) { ?>
        <form method="POST">
            <a href="?id=<?php echo $user["id"] ?>" class="list-group-item list-group-item-action"><?php echo $user["username"]?></a>
            <input  onclick="showDiv('chat')"  type="button" name="user" style="display:inline-block; float:right; margin-right: 50px;" value="chat"> 
        </form>
        <?php } ?>
    </div>
    <!-- Open conversation -->
    <div id="chat" class="card" style="width:300px;">
        <?php foreach($result as $message){ ?>
            <?php if($message["sender_id"] == $userID) {  ?>
                <li class="list-group-item" style="text-align:right;"><?php echo $message["username"] . ": " . $message["content"] ?></li>
            <?php }else{ ?>
                <li class="list-group-item"><?php echo $message["username"] . ": ". $message["content"] ?></li>
            <?php } ?>
        <?php } ?>
    </div>
    
    
</div>