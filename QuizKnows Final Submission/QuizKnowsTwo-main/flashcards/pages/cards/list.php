<?php
//Credits Aaron: original creation of skeleton
//        Steven: Prepared statements
//        Kristi: edits, corrections, clean up

    require($_SERVER['DOCUMENT_ROOT'] . '/flashcards/core/app.php'); 
    require(APP_ROOT_DIR . '/fragments/header.php');
    require APP_ROOT_DIR."/pages/auth.php";
    require(APP_ROOT_DIR. "/pages/connectuser.php");

    $sql = 'SELECT card.id, card.question, card.answer, subject.subject_name FROM card INNER JOIN subject ON card.subject_id = subject.id WHERE card.username=?';
    // Created by Aaron Chance Edwards
    if($stmt=mysqli_prepare($dbc, $sql))
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
  width: 60%;
  border-collapse: collapse;
  border: 3px solid white;
}
    </style>
<body style="background-color:#0FC1D3;text-align:left">
<h1>Cards: View All</h1>

<!-- include the card_actions, the navigation buttons for the cards pages -->
<?php require(APP_ROOT_DIR . '/pages/cards/card_actions.php'); ?>

<?php if($stmt->num_rows == 0): ?>
    <p>No cards found!</p>
<?php else: ?>
    <p>Cards found: <?php echo $stmt->num_rows; ?></p>
    <table>
        <tr>
            <th>Card ID</th>
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

<!-- include the footer fragment -->
<?php require(APP_ROOT_DIR . '/fragments/footer.php'); ?>
