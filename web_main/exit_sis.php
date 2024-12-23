<?php
session_start();
session_unset(); 
session_destroy(); 

// Удаление куки курортной
if (isset($_COOKIE['username'])) {
    setcookie("username", "", time() - 3600, "/"); 
}


header("Location: login.html"); 
exit();
?>
