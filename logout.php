<?php
session_start();
session_destroy();
header("Location: /urbanloka/modules/auth/login.php");
exit();
?>