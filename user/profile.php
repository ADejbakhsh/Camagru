<?PHP
require("php/login_utils.php");
check_if_not_connected_and_redirect();
require_once($_SERVER['DOCUMENT_ROOT'] . "/header/layout.php");
layout("login");



?>

<head>
    <link rel="stylesheet" type="text/css" href="/css/login.css">
</head>
<body>
    <div class="grid-container">
        <div class="login">
            <?PHP
            reset_login_if_all_good();
            ?>
            <form method="post" action="/user/profile.php">
                <p>New login :</p>
                <input type="text" name="login" placeholder="xX_Darkness2005_Xx" class="input" required>
                <br>
                <br>
                <input class="button" type="submit" name="submit" value="Change login">
            </form>
            <div class="login">
            <?PHP
            reset_email_if_all_good();
            ?>
            <form method="post" action="/user/profile.php">
                <p>New email :</p>
                <input type="text" name="email" placeholder="bocal@staff.42.fr" class="input" required>
                <br>
                <br>
                <input class="button" type="submit" name="submit" value="Change email">
            </form>
            </div>
            <div class="login">
                <?PHP
                 reset_password_if_all_good();
                ?>
            <form method="post" action="/user/profile.php">
                <p>New password :</p>
                <input type="password" name="pass" placeholder="l33t.48920%nasa:" class="input" required>
                <br>
                <p>Re-enter the new Password :</p>
                <input type="password" name="pass_bis" placeholder="Tough password again" class="input" required>
                <br>
                <br>
                <input class="button" type="submit" name="submit" value="Reset">
            </form>
            </div>
        </div>
    </div>
</body>

</html>