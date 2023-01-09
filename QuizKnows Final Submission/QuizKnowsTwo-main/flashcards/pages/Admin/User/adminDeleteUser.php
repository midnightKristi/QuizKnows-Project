<?php
//Credits Aaron: original creation of skeleton
//        Steven: Prepared statements and skeleton modification
//        Gillian: connection statements
//        Kristi: clean up

require($_SERVER['DOCUMENT_ROOT'] . '/flashcards/core/app.php');
require(APP_ROOT_DIR.'/pages/Admin/adminHeader.php');
require APP_ROOT_DIR . "/pages/Admin/adminAuth.php";
require(APP_ROOT_DIR. "/pages/connectadmin.php");


// Only do the following if the FORM action was a POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // get the value from the POST form

    // note to group: deleted post card id line from here, if not working put back here

    // Delete the user
    $sql = "DELETE FROM users WHERE username=?";
    if($stmt=mysqli_prepare($dbc, $sql))
    {
        mysqli_stmt_bind_param($stmt, "s", $username);
        $username = $_POST['username'];
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
<h1>Users - Delete</h1>

<!-- include the card_actions, the navigation buttons for the card pages -->
<p>Use the form below to delete a user.</p>

<form action="" method="post">
    Username: <input type="text" name="username"><br>
    <input type="submit">
</form>

<?php

if(!empty($result) && $result == TRUE){
    // the row was updated
    echo "<p>User successfully deleted!</p>";
}

?>

<!-- include the footer fragment -->
<?php require(APP_ROOT_DIR . '/fragments/footer.php'); ?>