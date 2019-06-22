<?php
function auth($login, $passwd, $users) {
	if (!$passwd || !$login || !$users)
		return FALSE;
	while ($usr = mysqli_fetch_assoc($users)) {
	//	echo ("<p>login ".$login." est compare avec ".$usr['login']."</p>");
//		echo ("<p>mp ".$passwd." est compare avec ".$usr['passwd']."</p>");
		if ($usr['login'] === $login && $usr['passwd'] === $passwd) {
			$_SESSION['permission'] = $usr['permission'];
			return TRUE; }
	}
	return FALSE;
}

session_start();

//$mysqli = new mysqli("e2r12p6:3306", "samy", "tititi", "DB");
$mysqli = new mysqli("localhost", "root", "popopo", "DB");
$query = "select login, passwd, permission from users";
if (($users = $mysqli->query($query)) === false) {
	        echo "error retrieving Users: " . $mysqli->error."\n";
}
$login = mysqli_real_escape_string($mysqli, $_POST['login']);
$passwd = mysqli_real_escape_string($mysqli, $_POST['passwd']);
$passwd = hash ('whirlpool', $passwd);

if (isset($_POST['submit']) && $_POST['submit'] === "Login")
{
	if ($_POST['login'] && $_POST['passwd'] && auth($login, $passwd, $users))
	{
		$_SESSION['user'] = $_POST['login'];
		$_SESSION['cart'] = $_POST['cart'];
		header('Location: index.php');
	}
	else {
		header('Location: login_page.php?error=1');
	}
}
mysqli_close($mysqli);
?>
