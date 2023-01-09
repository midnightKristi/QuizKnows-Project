<?php
//Credit: Steven based off of auth

session_start();

// Check if the user is already logged in, if yes then redirect him to welcome page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){

    header("Location: /flashcards/pages/login.php");
    die;
}

if($_SESSION["loggedinasadmin"]!=true)
{
    header("Location: /flashcards/pages/login.php");
    die;
}
?>