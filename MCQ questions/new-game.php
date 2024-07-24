<?php
session_start();
session_destroy(); // Clear the session
header("Location: index.php"); // Redirect to the quiz page
exit();
?>
