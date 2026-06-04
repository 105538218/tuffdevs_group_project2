<?php
/* Ends the manager session and sends the user back to login.php */

session_start();
session_unset();
session_destroy();

header("Location: login.php");
exit();
?>