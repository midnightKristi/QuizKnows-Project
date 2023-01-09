<?php
// Created Gillian/Steven
$dbc = new mysqli('localhost', 'user', '246810', 'flashcards');

if($dbc->connect_errno){
    echo "Failed to connect to MySQL: ",$dbc->connect_errno, $dbc->connect_error;
}
?>