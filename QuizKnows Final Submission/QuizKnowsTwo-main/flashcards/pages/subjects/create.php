<?php
//Credits Aaron: original creation of skeleton
//        Steven: Prepared statements
//        Gillian: connection statements
//        Kristi: edits, additions, clean up
    require($_SERVER['DOCUMENT_ROOT'] . '/flashcards/core/app.php'); 
    require(APP_ROOT_DIR . '/fragments/header.php');
    require APP_ROOT_DIR."/pages/auth.php";
    require(APP_ROOT_DIR. "/pages/connectuser.php");

    // Only do the following if the FORM action was a POST
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
         // get the value from the POST form
        $posted_subject_name = $_POST['subject_name'];
        // Create the SQL to insert the subject_name.
        $sql = "INSERT INTO subject (subject_name, username) values (?,?)";
        if($stmt=mysqli_prepare($dbc, $sql))
        {
            mysqli_stmt_bind_param($stmt, "ss", $posted_subject_name,$username);
            $posted_subject_name = $_POST['subject_name'];
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
<h1>Subjects: Create</h1>

<!-- include the subject_actions, the navigation buttons for the subject pages -->
<?php require(APP_ROOT_DIR . '/pages/subjects/subject_actions.php'); ?>

<p>Use the form below to add a new subject.</p>

<form action="" method="post">
    Subject Name: <input type="text" name="subject_name"><br>
    <input type="submit">
</form>

<?php 
if(!empty($result) && $result == TRUE){
  // the row was updated
  echo "<p>Subject successfully created!</p>";
}
?>
<!--
//    Added Lists to show in the create, speeds up testing and makes website more user friendly
//      - Kristi
-->

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
            width: 20%;
            border-collapse: collapse;
            border: 3px solid white;
        }
    </style>
<body style="background-color:#0FC1D3;text-align:left">
<h1>Subjects - List</h1>


<!--
//    Added Lists to show in the create, speeds up testing and makes website more user friendly
//      - Kristi
-->
<?php
    $sql = 'SELECT id, subject_name FROM subject where username=?';
    if($stmt=mysqli_prepare($dbc, $sql))
    {
    mysqli_stmt_bind_param($stmt, 's', $username);
    $username=$_SESSION['username'];
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    mysqli_stmt_bind_result($stmt,$subjectID, $subjectName);
}?>
<?php if($stmt->num_rows == 0): ?>
    <p>No subjects found!</p>
<?php else: ?>
    <p>Subjects found: <?php echo $stmt->num_rows; ?></p>
    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
        </tr>
        <?php while($stmt->fetch()): ?>
            <tr>
                <td><?php echo $subjectID; ?></td>
                <td><?php echo $subjectName; ?></td>
            </tr>
        <?php endwhile; ?>
    </table>

<?php endif; ?>

<!-- include the footer fragment -->
<?php require(APP_ROOT_DIR . '/fragments/footer.php'); ?>