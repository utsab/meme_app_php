<nav>
<?php 
        
    if (isset($_SESSION['user_id']))
      echo '<a href="logout.php">Log out</a>'; 
    else 
      echo '<a href="login.php">Log in</a>'; 
?>
<div class="clear"></div>
</nav>