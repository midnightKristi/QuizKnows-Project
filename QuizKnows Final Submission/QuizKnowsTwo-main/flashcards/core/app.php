<?php
// Created by Aaron Chance Edwards
// load database and variables 
define("APP_FOLDER_NAME", "flashcards"); 
define("APP_ROOT_DIR", $_SERVER['DOCUMENT_ROOT'] . '/' . APP_FOLDER_NAME . '/');
require(APP_ROOT_DIR . 'core/constants.php');
require(APP_ROOT_DIR . 'core/database.php');
require(APP_ROOT_DIR . 'core/functions.php');
?>