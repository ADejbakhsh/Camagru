<?PHP 
require ("php/login_utils.php");
check_if_connected_and_redirect ();
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
    <form method="post" action="php/login.php" class="form">
<?php
if ($_GET['error'] == 1)
{
    echo "<h1 style=\"text-align: center;
                      color: red;\">Error</h1>";
    $_GET['error'] = 0;
}
if ($_GET['error'] == 2)
{
    echo "<h1 style=\"text-align: center;\">Please Log yourself</h1>";
}
else
{
    echo "<h1 style=\"text-align: center;\">Login</h1>";
}
?>
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
</body>
</html>