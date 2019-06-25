<?PHP
require_once($_SERVER["DOCUMENT_ROOT"]."/src/utils.php");
require (path("/config/db_utils.php"));


# error handling for register
function error_register($login, $email, $pass, $pass_bis)
{
  $error_array = Array();
  if (fetch_bool("login", $login))
    array_push( $error_array , "error username already in use");
  if (!preg_match("/^[a-zA-Z0-9]*$/u" ,$login))
    array_push( $error_array , "Login must be alphanumerique only");
  if (strlen($login) < 3 || strlen($login) >= 255)
    array_push($error_array, "login must be longer than 3 and shorter than 255");
  if (strlen($pass) < 8 || strlen($pass) >= 255 )
    array_push( $error_array , "error password must be longer than 8 and shorter than 255 ");
  if ($pass !== $pass_bis)
    array_push( $error_array , "password do not match");
  if (fetch_bool("email", $email))
    array_push( $error_array , "error email already in use");
  if (!preg_match ( "/^\ *[!-~]{2,20}@[!-~]{2,20}\.[!-~]{2,20}\ *$/i" , $email))
    array_push( $error_array , "invalide  email");
  return($error_array);
}

# user creation

function user_creation($login, $email, $pass)
{
  global $DB_connect;
  $token =  uniqid();
  $pass = password_hash($pass , PASSWORD_DEFAULT);

  $statement =  $DB_connect->prepare("INSERT INTO db.user
  (login, email, password, token) 
  VALUES 
  (:login , :email , :pass , :token);");
  $statement->execute(['login' => $login, 'email' => $email, 'pass' => $pass, 'token' => $token]);
  mail($email, "Token for camagrue ", "hello, click on the link to activate your camagru account http://localhost:8080/user/php/auth.php?token=".$token);
}

# user login
function user_connect($login, $pass)
{
  global $DB_connect;

  $statement =  $DB_connect->prepare("SELECT
        login,
        password,
        validated_account 
        FROM
         db.user 
        WHERE 
         login = :login AND validated_account = 1");
  $statement->execute(['login' => $login]); 
  if (password_verify($pass , $statement->fetch()['1']))
    return (true);
  else
    return (false);
}

# check if user is connected and redirect him to index.php if so
function check_if_connected_and_redirect (){
  if (isset ($_SESSION['login']) && $_SESSION['login'] != NULL)
      header('Location: /index.php');
}

# clear the token row
function clear_token($email)
{
  global $DB_connect;

  $statement =  $DB_connect->prepare("UPDATE db.user set token IS NULL WHERE email =: email");
  $statement->execute(['token' => $email]);
}
?>