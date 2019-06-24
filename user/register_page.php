<?PHP require_once("../header/layout.php"); ?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="../css/login.css">
</head>
<body>
    <form method="post" action="./php/register.php" class="form">
        <h1 style="text-align: center;">Register</h1>
        <p>Login :</p>
        <input type="text" name="login" placeholder="Cool name here" class="input" required>
        <br>
        <br>
        <p>email :</p>
        <input type="email" name="email" placeholder="123@gmail.com" class="input" required>
        <br>
        <br>
        <p>Password :</p>
        <input type="password" name="pass" placeholder="Tough password" class="input" required>
        <br>
        <br>
        <p>Re-enter Password :</p>
        <input type="password" name="pass_bis" placeholder="Tough password again" class="input" required>
        <br>
        <br>
        <input class="button" type="submit" name="submit" value="Register">
    </form>
</body>
</html>