<?php require_once("../partials/nav.php"); ?>
<?php
if (!is_logged_in()) {
    //this will redirect to login and kill the rest of this script (prevent it from executing)
    flash("You don't have permission to access this page");
    die(header("Location: login.php"));
}
?>
<?php

$results = [];
$query = "";
if(isset($_GET["search"])){
  $query = $_GET["search"];
}

if (isset($_GET["search"]) && !empty($query)) {
    $db = getDB();
    $stmt = $db->prepare("SELECT username, email, created,id, bio FROM Users WHERE username like :q");

    $r = $stmt->execute([":q" => "%$query%"]);
    if ($r) {
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        //var_export($results);
    }
    else {
        flash("There was a problem fetching the results " . var_export($stmt->errorInfo(), true));
    }
}
//var_export($results);


?>
<h1>SEARCH RESULTS</h1>
<div class="row" style= "margin-left: 4em;">
<?php if (count($results) > 0): ?>
    <?php foreach ($results as $r): ?>
      <div class="card" style="width: 20rem; margin: 1em;">
        <img src="not yet" class="card-img-top" alt="...">
        <div class="card-body">
          <a href = "profile.php?id=<?php safer_echo($r['id']);?>"> <strong>email: </strong> <?php safer_echo($r["email"]); ?></a>

          <h6 class="card-title"><strong>username: </strong> <?php  safer_echo($r["username"]); ?></h6>
          <p class="card-text"><strong>bio: </strong> <?php safer_echo($r["bio"]); ?></p>

          </div>
        </div>
<?php endforeach; ?>
<?php endif; ?>
</div>

<?php require("../partials/flash.php");?>