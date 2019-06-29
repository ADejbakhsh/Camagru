<?PHP
require_once($_SERVER['DOCUMENT_ROOT']."/user/php/login_utils.php");
block_if_not_connected();
session_destroy();

header('Location: /index.php');
?>
