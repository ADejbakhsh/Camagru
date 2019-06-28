<?PHP 
require ("php/login_utils.php");
block_if_connected();
require_once($_SERVER['DOCUMENT_ROOT']."/header/layout.php");
layout("Register"); 
?>
		<link rel="stylesheet" type="text/css" href="/css/login.css">
		<div class="grid-container">
  			<div class="login">
    			<form method="post" action="./register_page.php">
    <?PHP
    register_form();
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
