
<?php
session_start();
// remove all session variables
unset($_SESSION['customer']); 
unset($_SESSION['med']); 
unset($_SESSION['doctor']); 
print_r($_SESSION);
// destroy the session 
session_destroy(); 
header("Location:index.html");

?>