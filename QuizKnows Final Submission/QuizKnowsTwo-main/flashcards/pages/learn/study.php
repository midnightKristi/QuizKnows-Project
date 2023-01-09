<?php
// Credits: Gillian: skeleton/framework, minor edits
//          Kristi: code implementation, major edits
//          Steven: prepared statements
error_reporting(0);
require($_SERVER['DOCUMENT_ROOT'] . '/flashcards/core/app.php');
require(APP_ROOT_DIR .'/fragments/header.php');
require APP_ROOT_DIR."/pages/auth.php";
require(APP_ROOT_DIR. "/pages/connectuser.php");
?>
<!DOCTYPE html>
<html lang="en">
<meta charset="UTF-8">
<title>Study - Learn</title>
<meta name="viewport" content="width=device-width,initial-scale=1">
<link rel="stylesheet" href="../styleindex.css">
    <h1>Study</h1>
    <body>
        <form method="POST">
            <div>
                <input type="text" name="set_id" placeholder="Enter Set ID">
                <input type="submit">
            </div>
        </form>
        <?php
        if (mysqli_connect_errno())
        {
            printf("Connect failed: %s\n", mysqli_connect_error());
            exit();
        }
        else
        {
            $sql = "SELECT question, answer FROM card WHERE subject_id=?;";
            if ($stmt = mysqli_prepare($dbc, $sql))
            {
                mysqli_stmt_bind_param($stmt, "s", $subject);
                $subject =$_POST["set_id"];
                mysqli_stmt_execute($stmt);
                mysqli_stmt_store_result($stmt);
                mysqli_stmt_bind_result($stmt, $question, $answer);
                $question_array= Array();
                $answer_array=Array();
                while($stmt->fetch())
                {
                    $question_array[]=$question;
                    $answer_array[]=$answer;
                }
                $question_array=json_encode($question_array);
                $answer_array=json_encode($answer_array);

            }
        }?>
	<style>
	span 
        { 
	
         }
	.hello 
        { 
	background-color: black;
        }
	#question {
	border: solid white 2px;
	text-align:center;
	background-color: white;
	width: 300px;
	font-size: 30px;
	font-family: "Times New Roman", Times, serif;
        color: black
	}
	#answer {
	border: solid white 2px;
	text-align:center;
	background-color: white;
	width: 300px;
	font-family: "Times New Roman", Times, serif;
	font-size: 30px;
        color: black
	}
	#Hello {
	border: solid black 2px;
	text-align:center;
	color: white;
        width: 300px;
        border: solid black 2px;
	background-color: black;
	}
	#Goodbye {
        text-align:center;
	color: white;
        width: 300px;
        border: solid black 2px;
	background-color: black;
	}
	</style>
        <script>
            let iter=0;
            var questions=<?php echo $question_array;?>;
            var answers=<?php echo $answer_array;?>;
        </script>
        <script>
            function nextCard()
            {
                if(iter+1==questions.length)
                {
                    //check if the next one will be null
                }
                iter++;
                document.getElementById('question').innerHTML=questions[iter];
                document.getElementById('answer').innerHTML='';
            }
            function showAnswer()
            {
                console.log(answers[iter]);
                document.getElementById('answer').innerHTML=answers[iter];
            }
        </script>
	<br>
	<div id = "Hello">Question</div>
        <div id="question"></div>
	<br>
	<div id = "Goodbye">Answer</div>
        <div id="answer"></div>
	<br>
        <div id="button">
            <button onclick="showAnswer()">Show Answer</button>
            <button onclick="nextCard()">Next Card</button>
        </div>
    </body>
    <script>
        document.getElementById('question').innerHTML=questions[iter];
    </script>
</html>
