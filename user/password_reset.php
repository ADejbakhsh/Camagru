<?PHP
require("php/login_utils.php");
if (!isset($_GET['token']) || !check_if_token_exist($_GET['token']))
    header('Location: /index.php');
check_if_connected_and_redirect();
require_once($_SERVER['DOCUMENT_ROOT'] . "/header/layout.php");
layout("Forgot password");
?>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="/css/login.css">
</head>

<body>
    <div class="grid-container">
        <div class="login">
            <?PHP
            if (isset($_POST['submit']) && $_POST['submit'] === "Reset")
                if (isset($_POST['pass']) && isset($_POST['pass_bis']))
                 {
                    $error = error_password($_POST['pass'], $_POST['pass_bis']); 
                    if (isset ($error['0']))
                    {
                        echo "<ul>";
                        foreach ($error as $ttt => $tmp) 
                        {
                            echo "<li>" . $tmp . "</li>";
                        }
                        echo "</ul>";
                     }
                     else
                     {
                         update_password($_POST['pass'], "token", $_GET['token']);
                         clear_token($_GET['token']);
                     }
                }
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