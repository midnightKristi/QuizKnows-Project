<?php
// Created Gillian/Steven
	$dbc = new mysqli('localhost', 'admin', '123456', 'flashcards');

    if($dbc->connect_errno){
		echo "Failed to connect to MySQL: ",$dbc->connect_errno, $dbc->connect_error;
	} 
	?>