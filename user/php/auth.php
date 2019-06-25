<?PHP
require ("./login_utils.php");


if (isset ($_GET['token']))
{
    $statement =  $DB_connect->prepare("UPDATE db.user set token = NULL WHERE token = :token;");
    $statement->execute(['token' => $_GET['token']]);
 
}
header("Location: ../login_page.php?error=2");
?>