<?php
session_start();
session_destroy(); 
// Check if the session is set and return the appropriate message
if (isset($_SESSION['email'])) { 
        header("Location: index.php");
} else {
	$msg = "<h2>Could not log you out</h2>";
} 
?> 