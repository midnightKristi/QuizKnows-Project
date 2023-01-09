<?php
//Credits Aaron: original creation of skeleton
//        Steven: Prepared statements
//        Gillian: connection statements
//        Kristi: additions, edits
    require($_SERVER['DOCUMENT_ROOT'] . '/flashcards/core/app.php'); 
    require(APP_ROOT_DIR .'/fragments/header.php');
    require(APP_ROOT_DIR."/pages/auth.php");
    require(APP_ROOT_DIR. "/pages/connectuser.php");

    // Only do the following if the FORM action was a POST
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
         // get the value from the POST form

        $sql= "SELECT username from subject where username = ? and id=?";
            if($stmt=mysqli_prepare($dbc, $sql))
            {
            mysqli_stmt_bind_param($stmt, "si", $username, $posted_subject_id);
            $username = $_SESSION['username'];
            $posted_subject_id = $_POST['subject_id'];
            mysqli_stmt_execute($stmt);

            mysqli_stmt_store_result($stmt);
            mysqli_stmt_bind_result($stmt, $subjectUsername);
            $subjectUsername=$stmt->fetch();
            if($subjectUsername != NULL)
            {
                $sql= "INSERT INTO card(subject_id, question, answer, username) values (?,?,?,?)";

                if($stmt=mysqli_prepare($dbc, $sql))
                {
                    mysqli_stmt_bind_param($stmt, "isss", $posted_subject_id,$posted_card_question,$posted_card_answer,$username);
                    $posted_subject_id = $_POST['subject_id'];
                    $posted_card_question = $_POST['question'];
                    $posted_card_answer = $_POST['answer'];
                    $username=$_SESSION['username'];
                    mysqli_stmt_execute($stmt);

                }
            }
        }

    }
?>
<body style="background-color:#0FC1D3;text-align:left">
<h1>Cards: Create</h1>
<!-- include the card_actions, the navigation buttons for the card pages -->
<?php require(APP_ROOT_DIR . '/pages/cards/card_actions.php'); ?>

<p>Use the form below to add a new card.</p>
<form action="" method="post">
    Subject ID: <input type="text" name="subject_id"><br>
    Question: <input type="text" name="question"><br>
    Answer: <input type="text" name="answer"><br>
    <input type="submit">
</form>

<?php 
if(!empty($result) && $result == TRUE){
  echo "<p>Card successfully created!</p>";
}
?>


    <!-- Added list here to ease testing and improve user satisfaction - Kristi-->
<?php
$sql = 'SELECT card.id, card.question, card.answer, subject.subject_name FROM card INNER JOIN subject ON card.subject_id = subject.id WHERE card.username=?';

if($stmt=mysqli_prepare($db_conn, $sql))
{
    mysqli_stmt_bind_param($stmt, 's', $username);
    $username=$_SESSION['username'];
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    mysqli_stmt_bind_result($stmt,$cardid,$cardQuestion,$cardAnswer,$subjectName);
}
?>
    <style>

        a {
            background-color: black;
            color: white;
            padding: 1em 1em;
            text-decoration: none;
            text-transform: uppercase;
        }
        td {
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
            font-family: Arial, Helvetica, sans-serif;
            background-color: white;
            text-align: center;
            table-layout: fixed;
            width: 40%;
            border-collapse: collapse;
            border: 3px solid white;
        }
    </style>
<body style="background-color:#0FC1D3;text-align:left">
<h1>Created Cards:</h1>

<?php if($stmt->num_rows == 0): ?>
    <p>No cards found!</p>
<?php else: ?>
    <p>Cards found: <?php echo $stmt->num_rows; ?></p>
    <table>
        <tr>
            <th> Card ID</th>
            <th>Subject Name</th>
            <th>Question</th>
            <th>Answer</th>
        </tr>
        <?php while($stmt->fetch()): ?>
            <tr>
                <td><?php echo $cardid; ?></td>
                <td><?php echo $subjectName; ?></td>
                <td><?php echo $cardQuestion; ?></td>
                <td><?php echo $cardAnswer; ?></td>
            </tr>
        <?php endwhile; ?>
    </table>

<?php endif; ?>

<!-- added footer - Kristi -->
<!-- include the footer fragment -->
<?php require(APP_ROOT_DIR . '/fragments/footer.php'); ?>