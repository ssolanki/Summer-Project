<?php
ob_start();
session_start();
unset($_SESSION["userid"]);
unset($_SESSION["pwd"]);
if(session_id() != '')
session_destroy();
header('Location: login.php');

?>
