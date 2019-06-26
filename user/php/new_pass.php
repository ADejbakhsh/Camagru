<?PHP
require ("login_utils.php");
check_if_connected_and_redirect ();
require_once($_SERVER['DOCUMENT_ROOT']."/header/layout.php");
layout("check mail");

$statement =  $DB_connect->prepare("SELECT
email
FROM
 db.user 
WHERE 
 email = :email");
$statement->execute(['email' => $_POST['email']]);
if ($statement->fetch()) {
    $token = hash("sha256", uniqid());
    $statement =  $DB_connect->prepare("UPDATE
            db.user
        SET
            token = :token 
        WHERE 
            email = :email");
    $statement->execute(['token' => $token, 'email' => $_POST['email']]);
    mail($_POST['email'], "password for camagrue ", "hello, click on the link to change the password of your camagru account http://localhost:8080/user/password_reset.php?token=" . $token);
}
?>

<h1>If this account exist, we have sent a mail to change your password.<h1>