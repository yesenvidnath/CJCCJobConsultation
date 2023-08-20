<?php
session_start();

// Destroy the session and unset user data
session_unset();
session_destroy();

// Redirect back to the login page or any other page as needed
header('Location: login.php');
exit();
?>