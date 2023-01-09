<?php
require($_SERVER['DOCUMENT_ROOT'] . '/flashcards/core/app.php');
require(APP_ROOT_DIR .'/fragments/header.php');
require APP_ROOT_DIR."/pages/auth.php";
?>
<!DOCTYPE html>
<html lang="en">
    <meta charset="UTF-8">
    <title>Multiple Choice - Learn</title>
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link rel="stylesheet" href="CSS/styleindex.css">
    <h1>Multiple Choice</h1>
    <body>
        <div id="q"></div>
        <div id="choices">
            <div id="c1"></div>
            <div id="c2"></div>
            <div id="c3"></div>
            <div id="c4"></div>
        </div>
        <?php
            $mysqli = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

            if (mysqli_connect_errno()) 
            {
                printf("Connect failed: %s\n", mysqli_connect_error());
                exit();
            } 
            else 
            {
                $setID = mysqli_real_escape_string($mysqli, $_POST['setID']);
                $sql = "SELECT question, answer FROM card WHERE subject_id=".$setID;
                $res = mysqli_query($mysqli, $sql);
                
                if ($res) 
                {
                    while ($newArray = mysqli_fetch_array($res, MYSQLI_ASSOC)) 
                    {
                        $q = $newArray['question'];
                        $a = $newArray['answer'];
                    }
                } 
                else 
                {
                    printf("Could not retrieve records: %s\n", mysqli_error($mysqli));
                }
                
                mysqli_free_result($res);
                mysqli_close($mysqli);
            }
        ?>
    </body>
</html>