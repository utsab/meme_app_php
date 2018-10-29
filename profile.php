<?php

session_start();

include 'functions.php'; 
include 'database.php';

checkLoggedIn(); 

$dbConn = getDatabaseConnection();


function displayMemes() {
    global $dbConn; 
    
    $sql = "SELECT 
        all_memes.line1, 
        all_memes.line2, 
        categories.meme_url 
      FROM all_memes INNER JOIN categories 
        ON all_memes.category_id = categories.category_id 
      INNER JOIN users 
        ON all_memes.user_id = users.user_id
      WHERE all_memes.user_id = " . $_SESSION['user_id']; 
    
   
    
    $statement = $dbConn->prepare($sql); 
    
    $statement->execute(); 
    $records = $statement->fetchAll(); 
    
    foreach ($records as $record) {
       $memeURL = $record['meme_url']; 
       echo  '<div class="meme-div" style="background-image:url('. $memeURL .')">'; 
       echo  '<h2 class="line1">' . $record["line1"] . '</h2>'; 
       echo  '<h2 class="line2">' . $record["line2"] . '</h2>'; 
       echo  '</div>'; 
    }
} 



  
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
    
    <div class="memes-container">
      <?php displayMemes(); ?>
      <div style="clear:both"></div>
    </div>
    
  </body>
</html>