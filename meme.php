<?php

include 'database.php';


function createMeme($line1, $line2) {
    
    $dbConn = getDatabaseConnection(); 

    $sql = "INSERT INTO `all_memes` (`id`, `line1`, `line2`) VALUES (NULL, '$line1', '$line2');"; 
    $statement = $dbConn->prepare($sql); 
    
    $statement->execute(); 
}

function displayMemes() {
    
    $dbConn = getDatabaseConnection(); 

    $sql = "SELECT * from all_memes"; 
    $statement = $dbConn->prepare($sql); 
    
    $statement->execute(); 
    $records = $statement->fetchAll(); 
    
    foreach ($records as $record) {
        echo '<div class="meme-div" style="background-image:url(https://upload.wikimedia.org/wikipedia/commons/f/ff/Deep_in_thought.jpg);">'; 
        echo "<h2 class='line1'>".$record['line1']."</h2>"; 
        echo "<h2 class='line2'>".$record['line2']."</h2>"; 
        echo "</div>"; 
    }
}



if (isset($_POST['line1']) && isset($_POST['line2'])) {
  createMeme($_POST['line1'], $_POST['line2']); 
}



?>

<!DOCTYPE html>
<html>
  <head>
    <title>A Meme</title>
    <style>
      .meme-div{
      width: 450px;
      height: 450px;
      background-size: cover;
      text-align: center;
      position: relative;
      }
      h2 {
        position: absolute;
        left: 0;
        right: 0;
        margin: 15px 0;
        padding: 0 5px;
        font-family: impact;
        color: white;
        text-shadow: 1px 1px black;
      }
      .line1 {
         top: 0;
       }
      .line2 {
         bottom: 0;
       }
       
       
       
       .memes-container .meme-div {
         float: left;
         margin: 0px 20px;
       }
       
    </style>
  </head>
  <body>
    <h1>Your Meme</h1>
    <!--The image needs to be rendered for each new meme
    so set the div's background-image property inline -->
    <div class="meme-div" style="background-image:url(https://upload.wikimedia.org/wikipedia/commons/f/ff/Deep_in_thought.jpg);">
      <h2 class="line1"><?= $_POST['line1'] ?> </h2>
      <h2 class="line2"><?= $_POST['line2'] ?></h2>
    </div>
    
    <h1>All memes</h1>
    <div class="memes-container">
      <?php displayMemes(); ?>
    </div>
  </body>
</html>