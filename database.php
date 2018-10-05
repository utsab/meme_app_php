<?php
// connect to our mysql database server

function getDatabaseConnection() {
    $host = "localhost";
    $username = "root";
    $password = "cst336";
    $dbname = "memes"; 
    
    // Create connection
    $dbConn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $dbConn -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    return $dbConn; 
}


//$dbConn = getDatabaseConnection(); 



?>