<?PHP
#block connected user
block_if_connected();
require_once($_SERVER['DOCUMENT_ROOT']."/header/layout.php");
layout("Forgot password");
?>
<head>
    <link rel="stylesheet" type="text/css" href="../css/login.css">
</head>
<body>
<div class="grid-container">
  <div class="login">
  <form method="post" action="php/new_pass.php" class="form">
        <h1 style="text-align: center;">Forgot password</h1>
        <p>Email adress:</p>
        <input type="email" name="email" placeholder="123@gmail.com" class="input" required>
        <br>
        <br>
        <input class="button" type="submit" name="submit" value="forgot">
    </form>
  </div>
</div>
</body>
</html>
