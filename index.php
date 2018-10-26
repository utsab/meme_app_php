<?php
include 'database.php';


function displayRandomMeme() {
    $dbConn = getDatabaseConnection(); 
    
    $sql = "SELECT * from all_memes ORDER BY RAND() LIMIT 1"; 
    
  
    $statement = $dbConn->prepare($sql); 
    
    $statement->execute(); 
    $records = $statement->fetchAll(); 
    
    $meme = $records[0]; 
    
    echo  '<div class="meme-div" style="background-image:url('. $meme['meme_url'] .')">'; 
    echo  '<h2 class="line1">' . $meme["line1"] . '</h2>'; 
    echo  '<h2 class="line2">' . $meme["line2"] . '</h2>'; 
    echo  '</div>'; 
    
} 

?>

<!DOCTYPE html>
<html>
  <head>
    <title>Welcome</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
  </head>
  <body>
    <h1>Meme Generator</h1>
    <?php displayRandomMeme(); ?>
    <h2>Welcome to my Meme Generator!</h2>
    
    <form method="post" action="meme.php">
        Line 1: <input type="text" name="line1"></input> <br/>
        Line 2: <input type="text" name="line2"></input> <br/>
        Meme Type:
        <select name="meme-type">
          <option value="college-grad">Happy College Grad</option>
          <option value="thinking-ape">Deep Thought Monkey</option>
          <option value="coding">Learning to Code</option>
          <option value="old-class">Old Classroom</option>
        </select>

        <input type="submit"></input>
    </form>
    
    <a href="./meme.php">View all memes</a>
    
    
  </body>
</html>