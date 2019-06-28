<?PHP 
require_once($_SERVER['DOCUMENT_ROOT']."/php/login_utils.php");
check_if_connected_and_redirect();
require_once($_SERVER['DOCUMENT_ROOT']."/header/layout.php");
layout("login");

?>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="../css/login.css">
</head>
<body>
<div class="grid-container">
  <div class="login">
    <?PHP
    if (isset($_GET['error']))
    {
      if ($_GET['error'] == '1')
        echo "<p>Error either the account is not validated or you didn't enter good information</p>";
      if ($_GET['error'] == '2')
      echo "<h2>Account validated</h2>";
    }
    ?>`
    <form method="post" action="php/login.php" class="form">
        <h1 style="text-align: center;">Login</h1>
        <p>Login :</p>
        <input type="text" name="login" placeholder="Login" class="input" required>
        <br>
        <br>
        <p>Password :</p>
        <input type="password" name="pass" placeholder="Password" class="input"  required>
        <br>
        <br>
        <input class="button" type="submit" name="submit" value="Login">
    </form>
    <a href="forgot_pass.php">Forgot password ?</a>
  </div>
</div>
</body>
</html>
