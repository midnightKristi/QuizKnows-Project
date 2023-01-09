<?php
//Credits Aaron: original creation of skeleton
//        Steven: Prepared statements
//        Gillian: connection statements
//        Kristi: edits, corrections

    require($_SERVER['DOCUMENT_ROOT'] . '/flashcards/core/app.php'); 
    require(APP_ROOT_DIR . '/fragments/header.php');
    require APP_ROOT_DIR."/pages/auth.php";

// Only do the following if the FORM action was a POST
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
         // get the value from the POST form

        $sql = "SELECT card.id, card.question, card.answer FROM card WHERE card.subject_id=? AND username=?";

        if($stmt=mysqli_prepare($db_conn, $sql))
        {
            mysqli_stmt_bind_param($stmt, 'is', $posted_subject_id,$username);
            $username=$_SESSION['username'];
            $posted_subject_id = $_POST['subject_id'];
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);
            mysqli_stmt_bind_result($stmt,$cardid,$cardQuestion,$cardAnswer);
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
  width: 40%;
  border-collapse: collapse;
  border: 3px solid white;
	}
   .showHideColumn
   {
	color: blue;
	cursor : pointer;
	background: white;
   }
    </style>

<script
  src="https://code.jquery.com/jquery-3.6.0.min.js"
  integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
  crossorigin="anonymous"></script>

<script>
$(document).ready(function() 
{ 
	$('view_details').on('click', function() { 
	$('#get_started').show();
});	
</script>

<script src="Scripts/jquery-1.3.2.js"
type="text/javascript"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#btnHide').click(function() {
                $('td:nth-child(3)').hide();
            });
	   $('#btnShow').click(function() {
                $('td:nth-child(3)').show();
            });
        });
    </script>
<body style="background-color:#0FC1D3;text-align:left">
<h1>Cards: View a Set</h1>
<!-- include the card_actions, the navigation buttons for the card pages -->
<?php require(APP_ROOT_DIR . '/pages/cards/card_actions.php'); ?>

<p>Use the form below to search for a set by the SubjectID.</p>
<form action="" method="post">
    SubjectID: <input type="text" name="subject_id"><br>
    <input type="submit">

<?php if(!empty($stmt) && $stmt->num_rows > 0): ?>
  <p>Subjects found: <?php echo $stmt->num_rows; ?></p>


</form>
    <table>
        <tr>
	    <th>CardID</th>
            <th>Question</th>
            <th>Answer</th>
        </tr>
        <?php while($stmt->fetch()): ?>
            <tr>
                <td><?php echo $cardid; ?></td>
                <td><?php echo $cardQuestion; ?></td>
                <td><?php echo $cardAnswer; ?></td>
            </tr>
        <?php endwhile; ?>
    </table>
     <input id="btnHide" type="button" value="Hide Answer"/>
     <input id="btnShow" type="button" value="Reveal Answer"/>
</div>
</script>
<?php else: ?>
    <p>No card found!</p>
<?php endif; ?>

<!-- include the footer fragment -->
<?php require(APP_ROOT_DIR . '/fragments/footer.php'); ?>
