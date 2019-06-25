<?PHP
require_once($_SERVER["DOCUMENT_ROOT"]."/src/utils.php");
require (path("/config/db_utils.php"));


# error handling for register
function error_register($login, $email, $pass, $pass_bis)
{
  $error_array = Array();
  if (fetch_bool("login", $login))
    array_push( $error_array , 1);  #"error username already in use"
  if (!preg_match("/^[a-zA-Z0-9]*$/u" ,$login))
    array_push( $error_array , 9);  #"Login must be alphanumerique only"
  if (strlen($login) < 3 || strlen($login) >= 255)
    array_push($error_array, 5) ;   #"login must be longer than 3 and shorter than 255");
  if (strlen($pass) < 8 || strlen($pass) >= 255 )
    array_push( $error_array , 2);  #"error password must be longer than 8 and shorter than 255 "
  if ($pass !== $pass_bis)
    array_push( $error_array , 3);  #"password do not match"
  if (fetch_bool("email", $email))
    array_push( $error_array , 4);  #"error email already in use"
  if (!preg_match ( "/^\ *[!-~]{2,20}@[!-~]{2,20}\.[!-~]{2,20}\ *$/i" , $email))
    array_push( $error_array , 10); #"invalide  email");
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
        password
        FROM
         db.user 
        WHERE 
         login = :login");
  $statement->execute(['login' => $login]); 
  if (password_verify($pass , $statement->fetch()['1']))
    return (true);
  else
    return (false);
}

# check if user is connected and redirect him to index.php if so
function connect (){
  if (isset ($_SESSION['login']));
	  header('Location: index.php');
}

?>