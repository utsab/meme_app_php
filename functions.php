
<?php

    session_start(); 
    
    //redirect user to login page if not logged in
    function checkLoggedIn() {
        if (!isset($_SESSION['user_id'])) {
            header("Location: login.php"); 
        }
    }
?>