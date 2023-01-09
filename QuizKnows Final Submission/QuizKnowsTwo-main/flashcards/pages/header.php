<?php
//Created by Steven modified by Aaron
require 'auth.php';
 echo'<div class="topNav"div>';
 echo'<a class="active" href="/flashcards/pages/index.php">Home</a>';
 echo'<a class="active" href="/flashcards/pages/search.php">Search</a>';
 echo'<a class="active" href="/flashcards/pages/learn/learn.php">Learn</a>';
 echo'<a class="active" href="/flashcards/pages/cards/create.php">My Sets</a>';
if($_SESSION["loggedinasadmin"]==true)
{
    echo'<a class="active" href="/flashcards/pages/Admin/Card/adminDeleteCard.php">Admin Control Panel</a>';
}
 echo'<a class="active" href="/flashcards/pages/logOut.php">Logout</a>';
echo'</div>';
