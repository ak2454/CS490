<?php require_once("../partials/nav.php");
require_once("../partials/flash.php");
 ?>
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


$stmt = $db->prepare("SELECT id, username FROM `Users` WHERE id  NOT IN ($userID) ORDER BY username");
$r = $stmt->execute();
$users = $stmt->fetchall(PDO::FETCH_ASSOC);

?>

<h1> Messages</h1>
<h4>Chat with: </h4>
<div style="display:block;">

<?php //add comment
    if (isset($_POST["message"]) && isset($_POST["submit"]) && strlen($_POST["message"]) > 0 ) {
        $message = $_POST["message"]; //send to database where postID
        $receiverID = "";
        
        if(isset($_GET["chat_id"])){
            $receiverID = $_GET["chat_id"];
        };

        $stmt = $db->prepare("INSERT INTO Messages(sender_id, receiver_id, content) VALUES(:sender,:receiver, :content)");
        $params = array(":sender" => $userID, ":receiver" => $receiverID, ":content" => $message);
        $r = $stmt->execute($params);
        $e = $stmt->errorInfo();

    } ?>
    
    <!-- Select users to chat with -->
    <div class="list-group" style="float:left; width:500px;">
        <?php foreach($users as $user) { ?>
            <form method="POST">
                <a href="?chat_id=<?php echo $user["id"];?>" class="list-group-item list-group-item-action"><?php echo $user["username"]?></a>
            </form>
        <?php } ?>
    </div>

    <!-- Open conversation -->
    <?php

        if(isset($_GET['chat_id'])){
            $chat_id = $_GET['chat_id'];
            $stmt = $db->prepare("SELECT Users.username as sender ,Messages.content, Messages.created_time, Messages.sender_id FROM Messages JOIN Users ON Users.id = Messages.sender_id  WHERE ( Messages.sender_id = $chat_id AND Messages.receiver_id = $userID) or (Messages.sender_id = $userID AND Messages.receiver_id = $chat_id) order by created_time;");
            $r = $stmt->execute();
            $messages = $stmt->fetchall(PDO::FETCH_ASSOC);
        } 


    ?>
    <div>
        <div id="chat" class="card" style="display: inline-block; text-align: center; margin-left: 600px; width:500px; height: 500px; overflow: auto;">
            <?php foreach($messages as $message){ ?>
                <?php if($message["sender_id"] == $userID) {  ?>
                    <li class="list-group-item" style="text-align:right;"><strong><?php echo $message["sender"];?></strong>: <?php echo $message["content"]; ?></li>
                <?php }else{ ?>
                    <li class="list-group-item" style=" background-color: #e0e0e0; text-align:left;"><strong><?php echo $message["sender"];?></strong>: <?php echo $message["content"]; ?></li>
                <?php } ?>
            <?php } ?>
        </div>
        <form method="POST">
            <div class="form-group" style = "display: flex; margin-top: 10; margin-left: auto; margin-bottom: 0; margin-right: auto; width: 200px">
                <input class="form-control" type="text" id="message" name="message" placeholder = "type message" style = "margin-left: -200px; width: 200px; " />
                <input type="hidden" id="sender_id" name="sender_id" value="<?php echo $message["sender_id"];?>">
                <input class="btn btn-primary" type="submit" name="submit" value="Send"/>
            </div>
            
        </form>
    </div>

    
</div>


