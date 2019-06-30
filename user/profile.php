<?PHP
require_once($_SERVER['DOCUMENT_ROOT']."/user/php/login_utils.php");
block_if_not_connected();
require_once($_SERVER['DOCUMENT_ROOT'] . "/header/layout.php");
layout("login");
?>
    <link rel="stylesheet" type="text/css" href="/css/login.css">
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
                 reset_password_if_all_good("id", $_SESSION['user_id']);
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
            <div class="login">
                <?PHP
                does_user_want_mail();
                ?>
            <form method="post" action="/user/profile.php">
                <p>write "yes" or "no" if you want email or none, when someone comment your pic</p>
                <input type="text" name="bool" placeholder="yes" class="input" required>
                <br>
                <br>
                <input class="button" type="submit" name="submit" value="Send">
            </form>
            </div>
        </div>
    </div>
</body>

</html>
