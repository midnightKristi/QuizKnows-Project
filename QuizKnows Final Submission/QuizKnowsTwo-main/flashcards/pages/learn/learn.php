<?php
// Credits: Gillian: skeleton/framework, minor edits
//          Kristi: code implementation, major edits
//          Steven: prepared statements

require "../header.php";
?>
<!DOCTYPE html>
<html lang="en">
    <meta charset="UTF-8">
    <title>Learn</title>
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link rel="stylesheet" href="../styleindex.css">
    <style>
  html, body {
  width: 100%;
  height:100%;
}

body {
    background: linear-gradient(-45deg, #ee7752, #e73c7e, #23a6d5, #23d5ab);
    background-size: 400% 400%;
    animation: gradient 20s ease infinite;
}

@keyframes gradient {
    0% {
        background-position: 0% 50%;
    }
    50% {
        background-position: 100% 50%;
    }
    100% {
        background-position: 0% 50%;
    }
}
	
    </style>
    <img src="/flashcards/pages/images/learn.jpg" width = "100" height = "100" alt="Learn">
    <body>
    </div>
        
<p style = "font-size: 24px;">Welcome to the Learn page! <br><br> Here, you can test your knowledge of your sets through various quiz games. <br><br> <u>Choose one of the options below to get started!</u></p>
	<p style ="font-size: 20px;">Study: View cards definition one at a time, then check the definition.</p>
        <a href = "study.php">
            <button>Study</button>
        </a>
	<p style ="font-size: 20px;">Matching: Match a cards definition with one correct answer.</p>
        <a href = "matching.php">
        <button>Matching</button>
        </a>
	<p style ="font-size: 20px;">Fill in the blank: Type answer in text form. </p>
        <a href = "fitb.php">
        <button>Fill In The Blank</button>
        </a>
	<style>
	.background-img {
	padding-top: 80px;
        padding-right: 30px;
        padding-bottom: 50px;
        padding-left: 50px;
	}
	</style>
	</div>
    </body>
</html>
