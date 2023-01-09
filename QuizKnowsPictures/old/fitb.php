<?php
require($_SERVER['DOCUMENT_ROOT'] . '/flashcards/core/app.php');
require(APP_ROOT_DIR .'/fragments/header.php');
require APP_ROOT_DIR."/pages/auth.php";
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
        <?php
        $mysqli = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

        if (mysqli_connect_errno())
        {
            printf("Connect failed: %s\n", mysqli_connect_error());
            exit();
        }
        else
        {
            $sql = "SELECT id,question, answer FROM card WHERE subject_id=?;";
            if ($stmt = mysqli_prepare($mysqli, $sql))
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
    <div name="questionDiv" id="questionDiv">

    </div>
   <div name="answerDiv" id=answerDiv">
       Type your answer here:<input type="text" name="answer"></input>
   </div>
        <div name="correct/not" id="correct/not">
        </div>


    <div name="buttons">
        <button onclick="checkCorrect()">Check Answer</button>
        <button onclick="nextQuestion()">Next Question</button>


    </div>

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
            document.getElementById('correct/not').innerHTML="You are correct!";
        }
        else
        {
            document.getElementById('correct/not').innerHTML="Try again";
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