<?php
//Credits Aaron: original creation of skeleton
//        Steven: Prepared statements
//        Gillian: connection statements
//        Kristi: edits, corrections, clean up

/**
 * pages/cards/read.php
 *
 * Used to read, or retrieve, the details of a card.
 * Selects the row from the card table by its ID.
 *
 */
    require($_SERVER['DOCUMENT_ROOT'] . '/flashcards/core/app.php');
    require(APP_ROOT_DIR . '/fragments/header.php');
    require APP_ROOT_DIR."/pages/auth.php";
    require APP_ROOT_DIR."/pages/connectuser.php";

// Only do the following if the FORM action was a POST
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
         // get the value from the POST form
        $posted_card_id = $_POST['card_id'];
        $sql = "SELECT id,question,answer,subject_id FROM card WHERE id=? and username = ?";

        if($stmt=mysqli_prepare($dbc, $sql))
        {
            mysqli_stmt_bind_param($stmt, "is", $posted_card_id,$username);
            $posted_card_id = $_POST['card_id'];
            $username=$_SESSION['username'];
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);
            mysqli_stmt_bind_result($stmt,$cardid,$cardQuestion,$cardAnswer,$subjectName);
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
<h1>Cards: Read a Card</h1>

<!-- include the card_actions, the navigation buttons for the card pages -->
<?php require(APP_ROOT_DIR . '/pages/cards/card_actions.php'); ?>

<p>Use the form below to search for a card by the CardID.</p>

<form action="" method="post">
    Card Id: <input type="text" name="card_id"><br>
    <input type="submit">
</form>

<?php if(!empty($stmt) && $stmt->num_rows > 0): ?>
  <p>Cards found: <?php echo $stmt->num_rows; ?></p>
    <table>
        <tr>
            <th>Card ID</th>
            <th>Subject ID</th>
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
<?php else: ?>
    <p>No card found!</p>
<?php endif; ?>

<!-- include the footer fragment -->
<?php require(APP_ROOT_DIR . '/fragments/footer.php'); ?>