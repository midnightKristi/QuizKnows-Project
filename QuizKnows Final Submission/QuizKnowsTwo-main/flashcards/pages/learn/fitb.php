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
<title>Fill in the Blank - Learn</title>
<meta name="viewport" content="width=device-width,initial-scale=1">
<link rel="stylesheet" href="CSS/styleindex.css">
    <h1>Fill in the Blank</h1>
        <form method="POST">
            <div>
                <input type="text" name="set_id" placeholder="Enter Set ID">
                <input type="submit">
            </div>
        </form>
    <body>
	<style>
	#questionDiv 
        { 
	border: solid white 2px;
	text-align:center;
	background-color: white;
	width: 10%;
	font-size: 25px;
	font-family: "Times New Roman", Times, serif;
        color: black;
	}
	#Hello {
	width: 10%;
	border: solid black 2px;
	text-align:center;
	color: white;
        border: solid black 2px;
	background-color: black;
	}
	input[type=text] {
        transition: width 0.4s ease-in-out;
        }
	#answerDiv
        { 
	 font-size: 18px;
	 background-color: black;
	 width: 10%;
	 color: white;
        }
	#correctnot 
	{ 
	}
	}
	</style>
	<link rel="stylesheet" href="../styleindex.css">
        <?php
        if (mysqli_connect_errno())
        {
            printf("Connect failed: %s\n", mysqli_connect_error());
            exit();
        }
        else
        {
            $sql = "SELECT id,question, answer FROM card WHERE subject_id=?;";
            if ($stmt = mysqli_prepare($dbc, $sql))
            {
                mysqli_stmt_bind_param($stmt, "s", $subject);
                $subject=$_POST["set_id"];
                mysqli_stmt_execute($stmt);
                mysqli_stmt_store_result($stmt);
                mysqli_stmt_bind_result($stmt, $id,$question, $answer);
                $question_array= Array();
                $answer_array=Array();
                $id_array=Array();
                while($stmt->fetch())
                {
                    $question_array[]=$question;
                    $answer_array[]=$answer;
                    $id_array[]=$id;
                }
                $question_array=json_encode($question_array);
                $answer_array=json_encode($answer_array);

            }
        }
        $correct=false
        ?>
    <br>
	<div id = "Hello">Question</div>
    <div name="questionDiv" id="questionDiv">

    </div>
    <br>
   <div name="answerDiv" id="answerDiv">
       Answer(Insert): <br><input type="text" name="answer"></input>
   </div>
        <div name="correctnot" id="correctnot">
        </div>

    <br>
    <div name="buttons">
        <button onclick="checkCorrect()">Check Answer</button>
        <button onclick="nextQuestion()">Next Question</button>

    </div>
    <br?
    </body>
<script>
    var iter=0;
    var questions=<?php echo $question_array;?>;
    var answers=<?php echo $answer_array;?>;
    document.getElementById('questionDiv').innerHTML=questions[iter];

    function checkCorrect()
    {
        console.log(answers[iter])
        var writtenAnswer=document.getElementsByName("answer")[0].value;
        var actualAnswer=answers[iter];
        if(writtenAnswer == actualAnswer)
        {
            document.getElementById('correctnot').innerHTML = "<span style='font-size:20px; background-color: black; color: green;'> <br>You are correct.</span>";
        }
        else
        {
            document.getElementById('correctnot').innerHTML= "<span style='font-size:20px; background-color: black; color: red;'> <br>Incorrect please try again.</span>";
        }
    }

    function nextQuestion()
    {
        iter++;
        document.getElementById('questionDiv').innerHTML=questions[iter];
        document.getElementById('correct/not').innerHTML="";
    }
    document.onload(iter=0);
</script>

</html>
