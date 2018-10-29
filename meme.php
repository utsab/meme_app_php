<?php
session_start(); 

include 'functions.php'; 
include 'database.php';

checkLoggedIn(); 

$dbConn = getDatabaseConnection();

// Fetch the category_id from the categories table for the chosen meme type

function getCategoryID($memeType) {
  global $dbConn; 
  
  $sql = "SELECT category_id from categories WHERE meme_type = '$memeType'";
     
  $statement = $dbConn->prepare($sql); 
  
  $statement->execute(); 
  $records = $statement->fetchAll(); 
  $categoryID = $records[0]['category_id']; 
  
  echo "categoryID: $categoryID <br/>"; 
  return $categoryID; 
}

// INSERT the new meme into the all_memes table

function insertMeme($line1, $line2, $categoryID) {
    global $dbConn; 
    
    $sql = "INSERT INTO `all_memes` 
      (`id`, `line1`, `line2`, `category_id`, `create_date`, `user_id`) 
      VALUES 
      (NULL, '$line1', '$line2', '$categoryID', NOW(), '{$_SESSION['user_id']}');"; 
    
    $statement = $dbConn->prepare($sql); 
    $result = $statement->execute(); 
    
    return $result; 
}

// fetch the newly created meme object from database JOINED with the
// the appropriate category information (meme url)
    
function fetchMemeFromDB($memeID) {
  global $dbConn; 
    
  
  $sql = "SELECT 
      all_memes.line1, 
      all_memes.line2, 
      categories.meme_url 
    FROM all_memes INNER JOIN categories 
    ON all_memes.category_id = categories.category_id 
    WHERE all_memes.id = $memeID"; 
  
  
  $statement = $dbConn->prepare($sql); 
  
  $statement->execute(); 
  $records = $statement->fetchAll(); 
  $newMeme = $records[0]; 
  
  return $meme; 
}


function createMeme($line1, $line2, $memeType) {
    global $dbConn; 
    
    $categoryID = getCategoryID($memeType); 
    $result = insertMeme($line1, $line2, $categoryID); 
    
    if (!$result)
      return null; 
    
    
    $last_id = $dbConn->lastInsertId();

    $newMeme = fetchMemeFromDB($last_id); 
    return $newMeme; 
    
}

function displayMemes() {
    global $dbConn; 
    
    $sql = "SELECT 
        all_memes.line1, 
        all_memes.line2, 
        categories.meme_url 
      FROM all_memes INNER JOIN categories 
      ON all_memes.category_id = categories.category_id 
      WHERE 1"; 
    
    if(isset($_POST['search'])) {
      // query the databse for any records that match this search
      $sql .= " AND (line1 LIKE '%{$_POST['search']}%' OR line2 LIKE '%{$_POST['search']}%')";
    } 
    
    if(isset($_POST['meme-type-search']) && !empty($_POST['meme-type-search'])) {
      $sql .= " AND meme_type = '{$_POST['meme-type-search']}'"; 
    }

    echo "sql!!!!!!: $sql <br/>"; 
    
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


if (isset($_POST['line1']) && isset($_POST['line2'])) {
  $memeObj = createMeme($_POST['line1'], $_POST['line2'], $_POST['meme-type']); 
}



?>

<!DOCTYPE html>
<html>
  <head>
    <title>A Meme</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
  </head>
  <body>
    <?php include('navigation.php'); ?>
    
    <?php if ($memeObj) {  ?>
      <h1>Your Meme</h1>
      <!--The image needs to be rendered for each new meme
      so set the div's background-image property inline -->
      <div class="meme-div" style="background-image:url(<?= $memeObj['meme_url']; ?>)">
        <h2 class="line1"> <?=  $memeObj['line1'] ?> </h2>
        <h2 class="line2"> <?=  $memeObj['line2'] ?> </h2>
      </div>
    <?php } ?>
    
    <h1>All memes</h1>
    <form method="post" action="meme.php">
        Search:  <input type="text" name="search"></input> 
        Meme type: <select name="meme-type-search">
          <option value=""></option>
          <option value="college-grad">Happy College Grad</option>
          <option value="thinking-ape">Deep Thought Monkey</option>
          <option value="coding">Learning to Code</option>
          <option value="old-class">Old Classroom</option>
        </select> <br/>
        ORDER: 
        <input type="radio"  name="order" value="newest-first"> Newest first
        <input type="radio"  name="order" value="oldest-first"> Oldest first
        <br/>
        <input type="submit"></input>
    </form>
    <div class="memes-container">
      <?php displayMemes(); ?>
      <div style="clear:both"></div>
    </div>
    
  </body>
</html>