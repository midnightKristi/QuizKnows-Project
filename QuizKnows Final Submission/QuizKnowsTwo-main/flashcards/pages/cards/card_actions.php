<?php
// Created by Aaron Chance Edwards based off of navbar
// Edited by Kristi
 /*
 // Created by Aaron Chance Edwards based off of navbar
 * This script will create a set a navigation links that are specific to the cards page.
 * They will be:
 * - List
 * - Create
 * - Read
 * - Update
 * - Delete
 */
?>

<div class="navbar">
    <ul>
        <li><a href="<?php echo get_url('pages/cards/create.php'); ?>">Create</a></li>
        <li><a href="<?php echo get_url('pages/cards/update.php'); ?>">Update</a></li>
        <li><a href="<?php echo get_url('pages/cards/delete.php'); ?>">Delete</a></li>
        <li><a href="<?php echo get_url('pages/cards/read.php'); ?>">Read</a></li>
        <li><a href="<?php echo get_url('pages/cards/list.php'); ?>">View All</a></li>
        <li><a href="<?php echo get_url('pages/cards/showsetcards.php'); ?>">View a Set</a></li>

    </ul>
</div>
