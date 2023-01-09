<?php
error_reporting(0);
//Credits Aaron: original creation of skeleton
//        Steven: PHP code
//        Gillian: connection statements

require($_SERVER['DOCUMENT_ROOT'] . '/flashcards/core/app.php');
require APP_ROOT_DIR . "/pages/Admin/adminAuth.php";
require APP_ROOT_DIR . "/pages/Admin/adminHeader.php";
require(APP_ROOT_DIR. "/pages/connectadmin.php");
?>
<!DOCTYPE html>
<link rel="stylesheet" href="/flashcards/pages/style.css">
<html lang="en">
<head>
<style>	
  td 
  {
  border-right: 1px solid black;
  border-top: 1px solid black;
  padding: 7px;
  text-overflow: ellipsis; 
  }
  th 
  { 
    text-align: center;
    color: white;
    background-color: black;
    padding: 7px;
  } 
  table {
  color: black;
  font-family: Arial, Helvetica, sans-serif;
  background-color: white;
  text-align: center;
  table-layout: fixed;
  width: 40%;
  border-collapse: collapse;
  border: 3px solid white;
}
    </style>
    <meta charset="UTF-8">
    <title>PHP Search</title>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2" style="margin-top: 1%;">
            <div class="row">
                <?php
                if($_POST['type']=="Username")
                {
                    $sql=("SELECT card.id,card.subject_id,card.question,card.answer,users.created_at,users.loginNum,users.latestLog from card,users where card.username=? and users.username=?");
                    if($stmt=mysqli_prepare($dbc, $sql))
                    {
                        mysqli_stmt_bind_param($stmt, "ss", $username,$username);
                        $username = $_POST['search'];
                        mysqli_stmt_execute($stmt);
                        mysqli_stmt_store_result($stmt);
                        mysqli_stmt_bind_result($stmt, $cardID,$subjectID,$question,$answer,$createdAt,$loginNum,$latestLog);

                    }
                }
                if($_POST['type']=="cardID")
                {
                    $sql=("SELECT subject_id,question,answer from card where id=?");
                    if($stmt=mysqli_prepare($dbc, $sql))
                    {
                        mysqli_stmt_bind_param($stmt, "s", $cardID);
                        $cardID = $_POST['search'];
                        mysqli_stmt_execute($stmt);
                        mysqli_stmt_store_result($stmt);
                        mysqli_stmt_bind_result($stmt, $subjectID,$question,$answer);
                    }
                }
                if($_POST['type']=="subjectID")
                {
                    $sql=("SELECT subject.subject_name,card.id,card.question,card.answer from card,subject where card.subject_id=? and subject.id=?");
                    if($stmt=mysqli_prepare($dbc, $sql))
                    {
                        mysqli_stmt_bind_param($stmt, "ss", $subjectID,$subjectID);
                        $subjectID = $_POST['search'];
                        mysqli_stmt_execute($stmt);
                        mysqli_stmt_store_result($stmt);
                        mysqli_stmt_bind_result($stmt, $subjectName,$cardID,$question,$answer);
                    }
                }

                ?>

                <form action="" method="POST">
                    <div class="col-md-6">
                        <input type="text" name="search" placeholder="Input here"  </input>
                        <select name="type" id="type">
                            <option value="Username">Username</option>
                            <option value="cardID">Card ID</option>
                            <option value="subjectID">Subject ID</option>
                        </select>
                        <input type="submit">
                    </div>
                    <div class="col-md-6 text-left">
                    </div>
                </form>

                <br>
                <br>
            </div>

            <table class="table table-bordered">
                <tr>
                    <?php
                        if($_POST['type']=="Username")
                        {
                            echo "<th>Card ID</th>
                                  <th>Subject ID</th>
                                  <th>Question</th>
                                  <th>Answer</th>";
                        }
                        if($_POST['type']=="cardID")
                        {
                            echo  "<th>Subject ID</th>
                                  <th>Question</th>
                                  <th>Answer</th>";
                        }
                        if($_POST['type']=="subjectID")
                        {

                            echo "<th>Card ID</th>
                                  <th>Question</th>
                                  <th>Answer</th>";
                        }
                    ?>

                </tr>
                <?php $i=0;
                while($stmt->fetch()):
                    $i++;
                    if($i==1 && $_POST['type']=="Username")
                    {
                        echo $username."'s account was created at ".$createdAt."<br>";
                        echo $username." has logged in ".$loginNum." times<br>";
                        echo $username." was last online at ".$latestLog."<br>";
                    }
                    if($i==1 && $_POST['type']=="subjectID")
                    {
                        echo "This is the subject by the name of ".$subjectName."";
                    }
                ?>
                    <tr>

                            <?php
                                if($_POST['type']=="Username")
                                {
                                    echo"<td>";
                                    echo $cardID;
                                    echo"</td>";
                                }
                                if($_POST['type']=="cardID")
                                {
                                    echo"<td>";
                                    echo $subjectID;
                                    echo"</td>";

                                }
                                if($_POST['type']=="subjectID")
                                {
                                    echo"<td>";
                                    echo $cardID;
                                    echo"</td>";
                                }
                            ?>



                            <?php
                                if($_POST['type']=="Username")
                                {
                                    echo"<td>";
                                    echo $subjectID;
                                    echo"</td>";
                                }
                                if($_POST['type']=="cardID" )
                                {
                                    echo"<td>";
                                    echo $question;
                                    echo"</td>";
                                }
                                if($_POST['type']=="subjectID")
                                {
                                    echo"<td>";
                                    echo $question;
                                    echo"</td>";
                                }
                            ?>



                            <?php
                                if($_POST['type']=="Username")
                                {
                                    echo"<td>";
                                    echo $question;
                                    echo"</td>";
                                }
                                if($_POST['type']=="cardID")
                                {
                                    echo"<td>";
                                    echo $answer;
                                    echo"</td>";
                                }
                                if($_POST['type']=="subjectID")
                                {
                                    echo"<td>";
                                    echo $answer;
                                    echo"</td>";
                                }
                            ?>


                            <?php
                            if($_POST['type']=="Username")
                            {
                                echo"<td>";
                                echo $answer;
                                echo"</td>";
                            }
                            if($_POST['type']=="cardID")
                            {
                                echo "";
                            }
                            if($_POST['type']=="subjectID")
                            {
                                echo "";

                            }
                            ?>
                    </tr>
                <?php endwhile;
                $usernameCheck=0;
                ?>
            </table>
        </div>
    </div>
</div>
</body>
</html>
