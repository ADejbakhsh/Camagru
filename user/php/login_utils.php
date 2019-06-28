<?PHP
require_once($_SERVER["DOCUMENT_ROOT"] . "/src/utils.php");
require_once(path("/config/db_utils.php"));


# error handling for register
function error_register($login, $email, $pass, $pass_bis)
{
  $error_array = array_merge(error_email($email), error_login($login), error_password($pass, $pass_bis));
  return ($error_array);
}

# user creation

function user_creation($login, $email, $pass)
{
  global $DB_connect;
  $token =  uniqid();
  $pass = password_hash($pass, PASSWORD_DEFAULT);

  $statement =  $DB_connect->prepare("INSERT INTO db.user
  (login, email, password, token) 
  VALUES 
  (:login , :email , :pass , :token);");
  $statement->execute(['login' => $login, 'email' => $email, 'pass' => $pass, 'token' => $token]);
  mail($email, "Token for camagrue ", "hello, click on the link to activate your camagru account http://localhost:8080/user/php/auth.php?token=" . $token);
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
  if (password_verify($pass, $statement->fetch()['1']))
    return (true);
  else
    return (false);
}

# check if user is connected and redirect him to index.php if so
function check_if_connected_and_redirect()
{
  if (isset($_SESSION['login']) && $_SESSION['login'] != NULL)
    header('Location: /index.php');
}

# reverse result of the previous function
function check_if_not_connected_and_redirect()
{
  if (!isset($_SESSION['login']) || $_SESSION['login'] == NULL)
    header('Location: /index.php');
}

# clear the token row
function clear_token($token)
{
  global $DB_connect;

  $statement =  $DB_connect->prepare("UPDATE db.user set token = NULL WHERE token = :token");
  $statement->execute(['token' => $token]);
}

# check if token exist
function check_if_token_exist($token)
{
  global $DB_connect;

  $statement =  $DB_connect->prepare("SELECT
        token
      FROM 
        db.user
      WHERE
        token = :token;");
  $statement->execute(['token' => $token]);
  if ($statement->fetch())
    return (true);
  return (false);
}

#error password return a array
function error_password($pass, $pass_bis)
{
  $error = array();
  if (strlen($pass) < 8 || strlen($pass) >= 255)
    array_push($error, "error password must be longer than 8 and shorter than 255 ");
  if ($pass !== $pass_bis)
    array_push($error, "password do not match");
  return ($error);
}

#error login return a array
function error_login($login)
{
  $error_array = array();

  if (fetch_bool("login", $login))
    array_push($error_array, "error username already in use");
  if (!preg_match("/^[a-zA-Z0-9]*$/u", $login))
    array_push($error_array, "Login must be alphanumerique only");
  if (strlen($login) < 3 || strlen($login) >= 255)
    array_push($error_array, "login must be longer than 3 and shorter than 255");
  return ($error_array);
}

#error email return a array
function error_email ($email)
{
  $error_array = array();

  if (fetch_bool("email", $email))
    array_push($error_array, "error email already in use");
  if (!preg_match("/^\ *[!-~]{2,20}@[!-~]{2,20}\.[!-~]{2,20}\ *$/i", $email))
   array_push($error_array, "invalide  email");
  return($error_array);
}

#update password from pivot ->see exemple in /user/password_reset.php l33
function update_password($new_pass, $pivot, $data_from_pivot)
{
  global $DB_connect;
  $new_pass = password_hash($new_pass, PASSWORD_DEFAULT);

  $statement =  $DB_connect->prepare("UPDATE db.user set password = :password WHERE " . $pivot . " = :data_from_pivot");
  $statement->execute(['password' => $new_pass, 'data_from_pivot' => $data_from_pivot]);
}

#update login from old login variable
function update_login($new_login, $login)
{
  global $DB_connect;

  $statement =  $DB_connect->prepare("UPDATE db.user set login = :new_login WHERE login = :login");
  $statement->execute(['new_login' => $new_login, 'login' => $login]);
}

#update email from login variable
function update_email($email, $login)
{
  global $DB_connect;

  $statement =  $DB_connect->prepare("UPDATE db.user set email = :email WHERE login = :login");
  $statement->execute(['email' => $email, 'login' => $login]);
}


# 

function reset_email_if_all_good()
{
  if (isset($_POST['submit']) && $_POST['submit'] === "Change email")
    if (isset($_POST['email'])) 
    {
      $error = error_email($_POST['email']);
     if (isset($error['0'])) {
       echo "<ul>";
       foreach ($error as $ttt => $tmp) 
       {
         echo "<li>" . $tmp . "</li>";
       }
       echo "</ul>";
     } 
     else {
       update_email($_POST['email'], $_SESSION['login']);
       echo "<h2>This is your new email ".$_POST['email']."</h2>";
      }
    }
}

#
function reset_login_if_all_good()
{
  if (isset($_POST['submit']) && $_POST['submit'] === "Change login")
    if (isset($_POST['login'])) 
    {
      $error = error_login($_POST['login']);
      if (isset($error['0'])) {
        echo "<ul>";
        foreach ($error as $ttt => $tmp) 
        {
          echo "<li>" . $tmp . "</li>";
        }
        echo "</ul>";
      } 
      else {
        update_login($_POST['login'], $_SESSION['login']);
        echo "<h2>Welcome ".$_POST['login']."</h2>";
      }
    }
}

#
function reset_password_if_all_good()
{
  if (isset($_POST['submit']) && $_POST['submit'] === "Reset")
    if (isset($_POST['pass']) && isset($_POST['pass_bis'])) {
      $error = error_password($_POST['pass'], $_POST['pass_bis']);
      if (isset($error['0'])) {
        echo "<ul>";
        foreach ($error as $ttt => $tmp) {
          echo "<li>" . $tmp . "</li>";
        }
        echo "</ul>";
      } else {
        update_password($_POST['pass'], "token", $_GET['token']);
        clear_token($_GET['token']);
        echo "<h2>You can now login</h2>";
      }
    }
}

# register form
function register_form()
{
  if (isset($_POST['submit']) && $_POST['submit'] === "Register") {
    $error = error_register($_POST['login'], $_POST['email'], $_POST['pass'], $_POST['pass_bis']);
    if (isset($error['0'])) {
      echo "<ul>";
      foreach ($error as $ttt => $tmp) {
        echo "<li>" . $tmp . "</li>";
      }
      echo "</ul>";
    } else {
      user_creation($_POST['login'], $_POST['email'], $_POST['pass']);
      echo "<h1 style='border: 1px solid black;' >Check your mail</h1>";
    }
  }
}
?>