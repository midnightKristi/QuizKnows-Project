<?php
//Credits Aaron: original creation of skeleton
//        Steven: Prepared statements
//        Gillian: connection statements

    require($_SERVER['DOCUMENT_ROOT'] . '/flashcards/core/app.php'); 
    require(APP_ROOT_DIR . '/fragments/header.php');
    require APP_ROOT_DIR."/pages/auth.php";
    require(APP_ROOT_DIR. "pages/connectuser.php");

// Only do the following if the FORM action was a POST
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $sql = "SELECT username from subject where username = ? and id=?";
        if ($stmt = mysqli_prepare($dbc, $sql)) {
            mysqli_stmt_bind_param($stmt, "si", $username, $posted_subject_id);
            $username = $_SESSION['username'];
            $posted_subject_id = $_POST['subject_id'];
            mysqli_stmt_execute($stmt);

            mysqli_stmt_store_result($stmt);
            mysqli_stmt_bind_result($stmt, $subjectUsername);
            $subjectUsername = $stmt->fetch();
            if ($subjectUsername != NULL) {
                $sql = "UPDATE card set subject_id=?, question=?, answer=? where id=? and username=?";

                if ($stmt = mysqli_prepare($dbc, $sql)) {
                    mysqli_stmt_bind_param($stmt, "issis", $posted_subject_id, $posted_card_question, $posted_card_answer, $posted_card_id, $username);
                    $posted_card_id = $_POST['card_id'];
                    $posted_subject_id = $_POST['subject_id'];
                    $posted_card_question = $_POST['question'];
                    $posted_card_answer = $_POST['answer'];
                    $username = $_SESSION['username'];
                    mysqli_stmt_execute($stmt);
                }
            }
        }
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
  width: 70%;
  border-collapse: collapse;
  border: 3px solid white;
}
    </style>
<body style="background-color:#0FC1D3;text-align:left">
<h1>Cards: Update</h1>

<!-- include the card_actions, the navigation buttons for the card pages -->
<?php require(APP_ROOT_DIR . '/pages/cards/card_actions.php'); ?>

<p>Use the form below to update a card.</p>

<form action="" method="post">
    Card ID: <input type="text" name="card_id"><br>
    Subject ID: <input type="text" name="subject_id"><br>
    Question: <input type="text" name="question"><br>
    Answer: <input type="text" name="answer"><br>
    <input type="submit">
</form>

<?php 
if(!empty($result) && $result == TRUE){
  // the row was updated
  echo "<p>Card successfully updated!</p>";
}
?>

<!-- include the footer fragment -->
<?php require(APP_ROOT_DIR . '/fragments/footer.php'); ?>