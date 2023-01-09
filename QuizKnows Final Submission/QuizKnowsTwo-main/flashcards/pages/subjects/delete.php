<?php
//Credits Aaron: original creation of skeleton
//        Steven: Prepared statements
//        Gillian: connection statements
    require($_SERVER['DOCUMENT_ROOT'] . '/flashcards/core/app.php'); 
    require(APP_ROOT_DIR . '/fragments/header.php');
    require APP_ROOT_DIR."/pages/auth.php";
    require(APP_ROOT_DIR. "/pages/connectuser.php");

    // Only do the following if the FORM action was a POST
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        
        // get the value from the POST form
        $posted_subject_id = $_POST['subject_id'];
        
        // Delete it
        $sql = "DELETE FROM subject WHERE id=? and username=?";
        if($stmt=mysqli_prepare($dbc, $sql))
        {
            mysqli_stmt_bind_param($stmt, "is", $posted_subject_id,$username);
            $posted_subject_id = $_POST['subject_id'];
            $username=$_SESSION['username'];
            mysqli_stmt_execute($stmt);
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
    </style>
<body style="background-color:#0FC1D3;text-align:left">
<h1>Subjects: Delete</h1>

<!-- include the subject_actions, the navigation buttons for the subject pages -->
<?php require(APP_ROOT_DIR . '/pages/subjects/subject_actions.php'); ?>

<p>Use the form below to delete a subject.</p>

<form action="" method="post">
    Subject ID: <input type="text" name="subject_id"><br>
    <input type="submit">
</form>

<?php 

if(!empty($result) && $result == TRUE){
  // the row was updated
  echo "<p>Subject successfully delete!</p>";
}

?>

<!-- include the footer fragment -->
<?php require(APP_ROOT_DIR . '/fragments/footer.php'); ?>