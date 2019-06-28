<?PHP
require_once($_SERVER['DOCUMENT_ROOT']."/php/login_utils.php");

session_destroy();

header('Location: /index.php');
?>
