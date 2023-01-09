<?php
//Credits Aaron: original creation of skeleton
//        Steven: Prepared statements
//        Gillian: connection statements
//        Kristi: clean up
/**
 * pages/subjects/read.php
 * 
 * Used to read, or retrieve, the details of a subject.
 * Selects the row from the subject table by its ID.
 * 
 */
    require($_SERVER['DOCUMENT_ROOT'] . '/flashcards/core/app.php'); 
    require(APP_ROOT_DIR . '/fragments/header.php');
    require(APP_ROOT_DIR."/pages/auth.php");
    require(APP_ROOT_DIR."/pages/connectuser.php");
    // Only do the following if the FORM action was a POST
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
         // get the value from the POST form
        $sql = "SELECT id,subject_name FROM subject WHERE id=? and username=?";
        if($stmt=mysqli_prepare($dbc, $sql))
        {
            mysqli_stmt_bind_param($stmt, "is", $posted_subject_id,$username);
            $posted_subject_id = $_POST['subject_id'];
            $username=$_SESSION['username'];
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);
            mysqli_stmt_bind_result($stmt,$subjectId, $subjectName);
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
  width: 30%;
  border-collapse: collapse;
  border: 3px solid white;
}
    </style>
<body style="background-color:#0FC1D3;text-align:left">
<h1>Subjects: Read</h1>

<!-- include the subject_actions, the navigation buttons for the subject pages -->
<?php require(APP_ROOT_DIR . '/pages/subjects/subject_actions.php'); ?>

<p>Use the form below to search for a subject by the ID.</p>

<form action="" method="post">
    Subject Id: <input type="text" name="subject_id"><br>
    <input type="submit">
</form>



<?php if(!empty($stmt) && $stmt->num_rows > 0): ?>
  <p>Subjects found: <?php echo $stmt->num_rows; ?></p>
    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
        </tr>
        <?php while($stmt->fetch()): ?>
            <tr>
                <td><?php echo $subjectId; ?></td>
                <td><?php echo $subjectName; ?></td>
            </tr>
        <?php endwhile; ?>
    </table>
<?php else: ?>
    <p>No subject found!</p>
<?php endif; ?>

<!-- include the footer fragment -->
<?php require(APP_ROOT_DIR . '/fragments/footer.php'); ?>