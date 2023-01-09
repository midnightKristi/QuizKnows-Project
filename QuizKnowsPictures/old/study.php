<?php
require($_SERVER['DOCUMENT_ROOT'] . '/flashcards/core/app.php');
require(APP_ROOT_DIR .'/fragments/header.php');
require APP_ROOT_DIR."/pages/auth.php";
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
        $mysqli = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

        if (mysqli_connect_errno())
        {
            printf("Connect failed: %s\n", mysqli_connect_error());
            exit();
        }
        else
        {
            $sql = "SELECT question, answer FROM card WHERE subject_id=?;";
            if ($stmt = mysqli_prepare($mysqli, $sql))
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

        <div id="question"></div>
        <div id="answer"></div>
        <div id="button">
            <button onclick="showAnswer()">Show Answer</button>
            <button onclick="nextCard()">Next Card</button>
        </div>
    </body>
    <script>
        document.getElementById('question').innerHTML=questions[iter];
    </script>
</html>


