<?php
 // Created by Aaron Chance Edwards based off of navbar
 /*
 //  Links to: 
 * - List
 * - Create
 * - Read
 * - Update
 * - Delete
 */
?>

<div class="navbar">
    <ul>
        <li><a href="<?php echo get_url('pages/subjects/list.php'); ?>">List</a></li>
        <li><a href="<?php echo get_url('pages/subjects/create.php'); ?>">Create</a></li>
        <li><a href="<?php echo get_url('pages/subjects/read.php'); ?>">Read</a></li>
        <li><a href="<?php echo get_url('pages/subjects/update.php'); ?>">Update</a></li>
        <li><a href="<?php echo get_url('pages/subjects/delete.php'); ?>">Delete</a></li>
    </ul>
</div>
