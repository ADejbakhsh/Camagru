<?PHP 
require ("php/login_utils.php");
check_if_connected_and_redirect ();
require_once($_SERVER['DOCUMENT_ROOT']."/header/layout.php");
layout("Register"); 



?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="/css/login.css">
</head>
<body>
<div class="grid-container">
  <div class="login">
    <form method="post" action="./register_page.php">
    <?PHP
    if (isset($_POST['submit']) && $_POST['submit'] === "Register")
    {
      $error = error_register($_POST['login'], $_POST['email'], $_POST['pass'], $_POST['pass_bis']);
      if (isset ($error['0']))
      {
        echo "<ul>";
        foreach ($error as $ttt => $tmp)
        {
          echo "<li>".$tmp."</li>";
        }
        echo "</ul>";        
      }
      else
      {
        user_creation($_POST['login'], $_POST['email'], $_POST['pass']);
        header('Location: ../check_mail.php');
      }
    }
    ?>
        <h1 style="text-align: center;">Register</h1>
        <p>Login :</p>
        <input type="text" name="login" placeholder="Cool name here" class="input" required>
        <br>
        <p>email :</p>
        <input type="email" name="email" placeholder="123@gmail.com" class="input" required>
        <br>
        <p>Password :</p>
        <input type="password" name="pass" placeholder="Tough password" class="input" required>
        <br>
        <p>Re-enter Password :</p>
        <input type="password" name="pass_bis" placeholder="Tough password again" class="input" required>
        <br>
        <br>
        <input class="button" type="submit" name="submit" value="Register">
    </form>
  </div>
</div>
</body>
</html>