<?php
require ("./login_utils.php");

if (user_connect($_POST['login'], $_POST['pass']))
{

	$_SESSION['login'] = $_POST['login'];
	header('Location: /index.php');
}
else
	header('Location: ../login_page.php?error=1');
?>
