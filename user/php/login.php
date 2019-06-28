<?php
require_once("../../requet_db/requet_utile.php");
require_once("./login_utils.php");

if (isset($_POST['login']) && $_POST['pass'] && user_connect($_POST['login'], $_POST['pass']))
{
	$_SESSION['login'] = $_POST['login'];
	$_SESSION['user_id'] = fetch_user_id();
	header('Location: /index.php');
}
else
	header('Location: ../login_page.php?error=1');
?>
