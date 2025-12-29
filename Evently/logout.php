<?php
// Logout Function
// Backend: TRISTAN
session_start();
session_destroy();
header('Location: login.php');
exit();
?>

