<?PHP
require ("./login_utils.php");

$statement =  $DB_connect->prepare("SELECT
email
FROM
 db.user 
WHERE 
 email = :email");
$statement->execute(['email' => $_POST['email']]);
$token = hash("sh256" ,uniqid()); 
mail($email, "Token for camagrue ", "hello, click on the link to change the password fot your camagru account http://localhost:8080/user//forgot_pass.php?token=".$token);
?>