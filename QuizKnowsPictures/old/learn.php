<?php
require($_SERVER['DOCUMENT_ROOT'] . '/flashcards/core/app.php');
require(APP_ROOT_DIR .'/fragments/header.php');
require APP_ROOT_DIR."/pages/auth.php";
?>
<!DOCTYPE html>
<html lang="en">
    <meta charset="UTF-8">
    <title>Learn</title>
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link rel="stylesheet" href="../styleindex.css">
    <h1>Learn</h1>
    <body>
        <p>Welcome to the Learn page! Here, you can test your knowledge of your sets through various quiz games. Choose one of the options below to get started!</p>
        <a href = "study.php">
            <button>Study</button>
        </a>
        <a href = "matching.php">
        <button>Matching</button>
        </a>
        <a href = "fitb.php">
        <button>Fill In The Blank</button>
        </a>
        <a href = "multipleChoice.php">
        <button>Multiple Choice</button>
        </a>
    </body>
</html>