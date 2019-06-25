<?PHP
require ("php/login_utils.php");

$_SESSION['login'] = NULL;

header('Location: /index.php');
?>