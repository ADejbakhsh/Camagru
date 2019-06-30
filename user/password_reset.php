<?PHP
require_once($_SERVER['DOCUMENT_ROOT']."/user/php/login_utils.php");
if (!(isset($_GET['token']) && check_if_token_exist($_GET['token'])))
    header('Location: /index.php');
block_if_connected();
require_once($_SERVER['DOCUMENT_ROOT'] . "/header/layout.php");
layout("Forgot password");
?>
    <link rel="stylesheet" type="text/css" href="/css/login.css">
    <div class="grid-container">
        <div class="login">
            <?PHP
            reset_password_if_all_good("token", $_GET['token']);
            clear_token($_GET['token']);
            echo  '<form method="post" action="/user/password_reset.php?token='.$_GET['token'].'">' ?>
                    <p>New Password :</p>
                    <input type="password" name="pass" placeholder="Tough password" class="input" required>
                    <br>
                    <p>Re-enter the new Password :</p>
                    <input type="password" name="pass_bis" placeholder="Tough password again" class="input" required>
                    <br>
                    <br>
                    <input class="button" type="submit" name="submit" value="Reset">
                </form>
            </div>
        </div>
    </body>
</html>
