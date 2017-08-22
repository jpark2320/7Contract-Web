<?php
	session_start();
	unset($_SESSION['email']);
	unset($_SESSION['isadmin']);
	session_unset();
	session_destroy();
	header("location: ../../");
?>
