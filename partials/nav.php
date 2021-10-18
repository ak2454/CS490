<!-- <link rel="stylesheet" href="static/css/styles.css"> -->
<?php
//we'll be including this on most/all pages so it's a good place to include anything else we want on those pages
require_once( "../lib/helpers.php");
?>


<!-- CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
<!-- jQuery and JS bundle w/ Popper.js -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>

<script>
    if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }
</script>

<nav class="navbar navbar-expand-lg navbar-light" style=" background-color: #071D49;">
    <a class="navbar-brand" href="feed.php">
      <img src="img/logo.png" width="50" height="50" class="d-inline-block align-top" alt="" loading="lazy">
    </a>

    <?php if (is_logged_in()): ?>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"></button>
        <form name="form" action="searchResults.php" method="get" style ="margin-top:12px; display:inline-flex;">
        <span class="navbar-toggler-icon"></span>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <div class="input-group" style="width: 500; display:flex; margin-left: 610px;">
          <span class="input-group-prepend">
            <div class="input-group-text border-right-0">
              <i class="fa fa-search" ></i>
            </div>
          </span>
          <input class="form-control py-2 border-left-0 border" type="search" name="search" placeholder="search" id="search" />
          <?php
          $search = "";
          if(isset($_GET["search"])){
            $search = $_GET["search"];
          }
          ?>
          <span class="input-group-append">
            <button class="btn btn-light border-left-0 border " type="submit" style= "margin-top: 0px; margin-left: 0px; ">
              <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-search" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M10.442 10.442a1 1 0 0 1 1.415 0l3.85 3.85a1 1 0 0 1-1.414 1.415l-3.85-3.85a1 1 0 0 1 0-1.415z"/>
                <path fill-rule="evenodd" d="M6.5 12a5.5 5.5 0 1 0 0-11 5.5 5.5 0 0 0 0 11zM13 6.5a6.5 6.5 0 1 1-13 0 6.5 6.5 0 0 1 13 0z"/>
              </svg>
            </button>
          </span>
        </div>
        </div>
      </form>
      <div style="width: 100%; margin: 0 auto; display: flex; justify-content: center;">
        <?php if (has_role("Admin")): ?>     
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle;" href="#" id="navbarDropdown" style = "margin-top: -20px; color: white; " role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Admin features
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href="register.php">Add Account</a>
            <a class="dropdown-item" href="blockedPosts.php">View Blocked Posts</a>
            <a class="dropdown-item" href="#">more features coming soon</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#">what he said ^</a>
          </div>
        </li>
        <?php endif; ?>

        
          <div>        
              <a href="uploadFront.php">
              <button style="color: black; margin-top: 10px;"  type="button" class = "btn " data-toggle="tooltip" data-placement="bottom" title="Upload">
                <img src="../CS490/img/plus.png" style=" height:30px; width:30px;">
              </button>
            </a>
          </div>
          <div>
              <a href="profile.php">
              <button style="color: black; margin-top: 10px;"  type="button" class = "btn " data-toggle="tooltip" data-placement="bottom" title="Profile">
                <img src="../CS490/img/profile.png" style="height:30px; width:30px;">
              </button>
            </a>
          </div>
          <div>
              <a href="messages.php">
                <button style="color: black; margin-top: 10px;"  type="button" class = "btn" data-toggle="tooltip" data-placement="bottom" title="Chat">
                  <img src="../CS490/img/messagebox.png" style="height:30px; width:30px;">
                </button>
              </a>
          </div>
          <div>
              <a href="logout.php">
                <button style="float:left; color: black; margin-top: 10px;"  type="button" class = "btn " data-toggle="tooltip" data-placement="bottom" title="Logout">
                  <img src="../CS490/img/logout.png" style="height:30px; width:30px;">
                </button>
              </a>
          </div>
        </div>
    <?php endif; ?>
</nav>