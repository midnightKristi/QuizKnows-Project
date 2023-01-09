<?php
// Created by Steven/Gillian edited by Aaron 
 if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 
 
// Check if the user is already logged in, if yes then redirect him to welcome page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){

    header("Location: login.php");
    die;
}
?>
