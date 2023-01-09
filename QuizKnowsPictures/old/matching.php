<?php
require($_SERVER['DOCUMENT_ROOT'] . '/flashcards/core/app.php');
require(APP_ROOT_DIR .'/fragments/header.php');
require APP_ROOT_DIR."/pages/auth.php";
?>
<!DOCTYPE html>
<html lang="en">
<meta charset="UTF-8">
<title>Matching - Learn</title>
<meta name="viewport" content="width=device-width,initial-scale=1">
<link rel="stylesheet" href="../styleindex.css">
    <h1>Matching</h1>
    <body>
        <?php
            $mysqli = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
            
            if (mysqli_connect_errno()) 
            {
                printf("Connect failed: %s\n", mysqli_connect_error());
                exit();
            } 
            else 
            {
                $sql = "SELECT question, answer FROM card WHERE subject_id=?;";
                if ($stmt = mysqli_prepare($mysqli, $sql))
                {
                    mysqli_stmt_bind_param($stmt, "s", $subject);
                    $subject =$_POST["subject_id"];
                    mysqli_stmt_execute($stmt);
                    mysqli_stmt_store_result($stmt);
                    mysqli_stmt_bind_result($stmt, $question, $answer);
                }
            }
        ?>
        <form method="POST">
            <div>
                <input type="text" name="subject_id" placeholder="Enter Set ID">
                <input type="submit">
            </div>
        </form>
        <div id="q">
            <?php while ($stmt->fetch()): ?>
            <div id="q1"></div>
                <?php echo $question ?>
                <?php echo $answer ?>
            <?php endwhile; ?>
            <div id="q2"></div>
            <div id="q3"></div>
            <div id="q4"></div>
        </div>
        <div id="a">
            <div id="a1"></div>
            <div id="a2"></div>
            <div id="a3"></div>
            <div id="a4"></div>
        </div>
    </body>
</html>