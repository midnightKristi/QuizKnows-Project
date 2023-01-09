<?php
error_reporting(0);
// Credits: Gillian: skeleton/framework, minor edits
//          Kristi: code implementation, major edits
//          Steven: prepared statements, major edits

require($_SERVER['DOCUMENT_ROOT'] . '/flashcards/core/app.php');
require(APP_ROOT_DIR .'/fragments/header.php');
require APP_ROOT_DIR."/pages/auth.php";
require(APP_ROOT_DIR. "/pages/connectuser.php");
?>
<!DOCTYPE html>
<html lang="en">
<meta charset="UTF-8">
<title>Multiple Choice - Learn</title>
<meta name="viewport" content="width=device-width,initial-scale=1">
<link rel="stylesheet" href="../styleindex.css">
<head>
<script>
  src="https://code.jquery.com/jquery-3.6.0.min.js"
  integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
  crossorigin="anonymous"></script>

</script>
<script src="script.js"></script>
</head>
</div>
</div>
<h1>Matching</h1>
<body>
<form method="POST">
    <div id = "shee">
        <input type="text" name="set_id" placeholder="Enter Set ID">
        <input type="submit">
    </div>
	<br>
</form>
<div id="question1">
</div>
<div id="question2">
</div>
<div id="question3">
</div>
<div id="question4">
</div>
<br>
<div id="wordBankSeperator">
    <br>
    Word Bank
    <br>
    <br>
</div>
<div id="wordBank">
</div>
<br>
<div id="answer1">
    1:<input type="text" name="answer1"></input>
</div>
<div id="answer2">
    2:<input type="text" name="answer2"></input>
</div>
<div id="answer3">
    3:<input type="text" name="answer3"></input>
</div>
<div id="answer4">
    4:<input type="text" name="answer4"></input>
</div>
<br>
<div id="correctNot1">
</div>
<div id="correctNot2">
</div>
<div id="correctNot3">
</div>
<div id="correctNot4">
</div>
<br>
<div name="buttons">
    <button onclick="checkCorrect()">Check Answer</button>
    <button onclick="nextQuestion()">Next Question</button>
</div>
<?php
$sql = "SELECT question, answer FROM card WHERE subject_id=?";

if ($stmt = mysqli_prepare($dbc, $sql))
{
    mysqli_stmt_bind_param($stmt, "i", $subject);
    $subject =$_POST["set_id"];
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    mysqli_stmt_bind_result($stmt, $question, $answer);
}

$question_array= Array();
$answer_array=Array();
while ($stmt->fetch())
{
    $question_array[]=$question;
    $answer_array[]=$answer;
}
?>
<spacer type="horizontal" width="1000" height="1000"> ♢ Meet Jeff QuizKnow's diamond.</spacer>
    <script>
        var br=document.createElement("BR");
    var checker=false;
    var iter=0;
    var questions=<?php echo json_encode($question_array);?>;
    var answers=<?php echo json_encode($answer_array);?>;
    document.getElementById('question1').innerHTML = questions[iter];
    document.getElementById('question2').innerHTML = questions[iter+1];
    document.getElementById('question3').innerHTML = questions[iter+2];
    document.getElementById('question4').innerHTML = questions[iter+3];

    var scramble=[answers[iter], answers[iter+1], answers[iter+2], answers[iter+3]];
    shuffle(scramble);
    document.getElementById('wordBank').innerHTML=scramble[0] +"<br>"+ scramble[1] + "<br>" +scramble[2]+ "<br>"+ scramble[3];

    function shuffle(array) {
        for (let i = array.length - 1; i > 0; i--) {
            let j = Math.floor(Math.random() * (i + 1));
            [array[i], array[j]] = [array[j], array[i]];
        }
    }
    function checkCorrect()
    {
        var correctAnswer1=document.getElementsByName("answer1")[0].value;
        var correctAnswer2=document.getElementsByName("answer2")[0].value;
        var correctAnswer3=document.getElementsByName("answer3")[0].value;
        var correctAnswer4=document.getElementsByName("answer4")[0].value;
        var userAnswer=answers[iter];
        if(correctAnswer1 == userAnswer)
        {
          correctAnswer1=true
        }

        else
        {
           correctAnswer1=false
        }

         userAnswer=answers[iter+1]
        if(correctAnswer2 == userAnswer)
        {
            correctAnswer2=true
        }
        else
        {
            correctAnswer2=false
        }

         userAnswer=answers[iter+2]
        if(correctAnswer3 == userAnswer)
        {
            correctAnswer3=true
        }
        else
        {
            correctAnswer3=false
        }

         userAnswer=answers[iter+3]
        if(correctAnswer4 == userAnswer)
        {
            correctAnswer4=true
        }
        else
        {
            correctAnswer4=false
        }

        document.getElementById('correctNot1').innerHTML = "";
        document.getElementById('correctNot2').innerHTML = "";
        document.getElementById('correctNot3').innerHTML = "";
        document.getElementById('correctNot4').innerHTML = "";
        // if (correctAnswer1==true)
        // {
        //     document.getElementById('correctNot').append("Answer 1 is correct");
        // }
        //
        // if (correctAnswer2==true)
        // {
        //     document.getElementById('correctNot').append(br);
        //     document.getElementById('correctNot').append("Answer 2 is correct");
        // }
        //
        // if (correctAnswer3==true)
        // {
        //     document.getElementById('correctNot').append(br);
        //     document.getElementById('correctNot').append("Answer 3 is correct");
        // }
        //
        // if (correctAnswer4==true)
        // {
        //     document.getElementById('correctNot').append(br);
        //     document.getElementById('correctNot').append("Answer 4 is correct");
        // }
        if (correctAnswer1==true && correctAnswer2==true && correctAnswer3==true && correctAnswer4==true)
        {
            document.getElementById('correctNot1').innerHTML="All answers correct"
            document.getElementById('correctNot2').innerHTML=""
            document.getElementById('correctNot3').innerHTML=""
            document.getElementById('correctNot4').innerHTML=""
        }
        else
        {
            document.getElementById('correctNot1').innerHTML = (`Answer 1 is ${(correctAnswer1) ? "correct" : "incorrect"}`);
            document.getElementById('correctNot2').append(`Answer 2 is ${(correctAnswer2) ? "correct" : "incorrect"}`);
            document.getElementById('correctNot3').append(`Answer 3 is ${(correctAnswer3) ? "correct" : "incorrect"}`);
            document.getElementById('correctNot4').append(`Answer 4 is ${(correctAnswer4) ? "correct" : "incorrect"}`);
        }
        correctAnswer1=false;
        correctAnswer2=false;
        correctAnswer3=false;
        correctAnswer4=false;
    }

    function nextQuestion() {
        iter+=4;
        var qLength = questions.length;
        document.getElementById('correctNot1').innerHTML=""
        document.getElementById('correctNot2').innerHTML=""
        document.getElementById('correctNot3').innerHTML=""
        document.getElementById('correctNot4').innerHTML=""
        if (checker==true) {
            document.getElementById('question1').innerHTML = "End of matching quiz";
            document.getElementById('question2').innerHTML = "";
            document.getElementById('question3').innerHTML = "";
            document.getElementById('question4').innerHTML = "";
            document.getElementById('answer1').innerHTML = "";
            document.getElementById('answer2').innerHTML = "";
            document.getElementById('answer3').innerHTML = "";
            document.getElementById('answer4').innerHTML = "";
            document.getElementById('wordBank').innerHTML="";
            document.getElementById('wordBankSeperator').innerHTML="";
            console.log("sixth case" + iter + " "+ qLength);
            checker=false;
        }

        if (iter+4 <= qLength)
        {
            document.getElementById('question1').innerHTML = questions[iter];
            document.getElementById('question2').innerHTML = questions[iter + 1];
            document.getElementById('question3').innerHTML = questions[iter + 2];
            document.getElementById('question4').innerHTML = questions[iter + 3];
            scramble=[answers[iter], answers[iter+1], answers[iter+2], answers[iter+3]];
            shuffle(scramble);
            document.getElementById('wordBank').innerHTML=scramble[0] +"<br>"+ scramble[1] + "<br>" +scramble[2]+ "<br>"+ scramble[3];
            console.log("first case" + iter + " "+ qLength);
            if (iter+4 == qLength)
            {
                checker=true;
            }
        }
        else if (iter+3 == qLength)
            {
                document.getElementById('question1').innerHTML = questions[iter];
                document.getElementById('question2').innerHTML = questions[iter + 1];
                document.getElementById('question3').innerHTML = questions[iter + 2];
                document.getElementById('question4').innerHTML = "";
                document.getElementById('answer4').innerHTML="";
                scramble=[answers[iter], answers[iter+1], answers[iter+2]];
                shuffle(scramble);
                document.getElementById('wordBank').innerHTML=scramble[0] +"<br>"+ scramble[1] + "<br>" +scramble[2];

                iter+=3;
                checker=true;
                console.log("second case" + iter + " "+ qLength);
            }

           else if (iter+2 == qLength) {
                document.getElementById('question1').innerHTML = questions[iter];
                document.getElementById('question2').innerHTML = questions[iter + 1];
                document.getElementById('question3').innerHTML = "";
                document.getElementById('question4').innerHTML = "";
                document.getElementById('answer3').innerHTML="";
                document.getElementById('answer4').innerHTML="";
                scramble=[answers[iter], answers[iter+1]];
                shuffle(scramble);
                document.getElementById('wordBank').innerHTML=scramble[0] +"<br>"+ scramble[1];

                iter+=2;
                console.log("third case" + iter + " "+ qLength);
                checker=true;
            }

           else if (iter+1 == qLength) {
                document.getElementById('question1').innerHTML = questions[iter];
                document.getElementById('question2').innerHTML = "";
                document.getElementById('question3').innerHTML = "";
                document.getElementById('question4').innerHTML = "";
                document.getElementById('answer2').innerHTML = "";
                document.getElementById('answer3').innerHTML = "";
                document.getElementById('answer4').innerHTML = "";
                document.getElementById('wordBank').innerHTML=answers[iter];
                iter+=1;
                console.log("foruth case" + iter + " "+ qLength);
                checker=true
            }
        }

    document.onload(iter=0);
</script>
<style> 
#wordBankSeperator 
{ 
border: solid black 1px;
	text-align:center;
	background-color: black;
	width: 250px;
	font-family: "Times New Roman", Times, serif;
	font-size: 20px;
        color: white;
}
#question1 
{ 
border: solid black 1px;
	text-align:center;
	background-color: white;
	width: 250px;
	font-family: "Times New Roman", Times, serif;
	font-size: 20px;
        color: black;
}
#question2
{ 
border: solid white 1px;
	text-align:center;
	background-color: black;
	width: 250px;
	font-family: "Times New Roman", Times, serif;
	font-size: 20px;
        color: white;
}
#question3
{
border: solid black 1px;
	text-align:center;
	background-color: white;
	width: 250px;
	font-family: "Times New Roman", Times, serif;
	font-size: 20px;
        color: black;
}
#question4
{
border: solid white 1px;
	text-align:center;
	background-color: black;
	width: 250px;
	font-family: "Times New Roman", Times, serif;
	font-size: 20px;
        color: white;
}
#correctNot1
{
	text-align:center;
	background-color: white;
	width: 250px;
	font-family: "Times New Roman", Times, serif;
	font-size: 20px;
        color: black;
}
#correctNot2
{
	text-align:center;
	background-color: black;
	width: 250px;
	font-family: "Times New Roman", Times, serif;
	font-size: 20px;
        color: white;
}
#correctNot3
{
	text-align:center;
	background-color: white;
	width: 250px;
	font-family: "Times New Roman", Times, serif;
	font-size: 20px;
        color: black;
}
#correctNot4
{
	text-align:center;
	background-color: black;
	width: 250px;
	font-family: "Times New Roman", Times, serif;
	font-size: 20px;
        color: white;
}
#wordBank
{
text-align: center;
width: 250px;
background-color: white;
color: black;
border: solid white 1px;
}
#answer1
{
}
</style>
