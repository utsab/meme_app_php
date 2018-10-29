<?php

session_start();

include 'functions.php'; 
  
checkLoggedIn(); 
  
?>

<!DOCTYPE html>
<html>
  <head>
    <title>Welcome</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
  </head>
  <body>
    <?php include('navigation.php'); ?>
    <h1>Welcome <?= $_SESSION['username'] ?>!</h1>
    
    <h2>Your memes: </h2>
    
    
    
  </body>
</html>