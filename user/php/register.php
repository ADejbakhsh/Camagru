<?php
require ("./login_utils.php");
user_connect("michel","rm -rf ~/Library/Containers/com.docker.docker
rm -rf ~/.docker
rm -rf ~/goinfre/docker ~/goinfre/agent
mkdir -p ~/goinfre/docker ~/goinfre/agent
ln -s ~/goinfre/agent ~/Library/Containers/com.docker.docker
ln -s ~/goinfre/docker ~/.docker");

if (isset($_POST['submit']) && $_POST['submit'] === "Register")
{
  $error = error_register($_POST['login'], $_POST['email'], $_POST['pass'], $_POST['pass_bis']);
  if (isset ($error['0']))
  {
    echo "error";
    die();
    #print all error
  }
  else
  {
    user_creation($_POST['login'], $_POST['email'], $_POST['pass']);
  }
}
  /*
  $login
    = mysqli_real_escape_string($mysqli,
      $_POST['login']);
  $passwd = hash ('whirlpool',
    mysqli_real_escape_string($mysqli,
    $_POST['passwd']));

  if ($_POST['passwd'] ===
    $_POST['re-passwd'] &&
    ft_exist($login, $users) ===
    FALSE) {
    $query = "INSERT INTO
      Users (login, passwd,
        permission) VALUES
        ('".$login."',
        '".$passwd."',
        'pigeon')";
    echo ("<p>login
      and passwd
      :".$login.",
      ".$passwd."</p>");
    if
      ($mysqli->query($query)
      === FALSE) {
      echo
        ("Error
        trying to
        create user
        : " . $mysqli->error."\n");
      exit
        ();
    }
    $query
      = "INSERT
      INTO
      Carts
      (login)
      VALUES
      ('".$login."')";
    if
      ($mysqli->query($query)
      ===
      FALSE)
    {
      echo
        ("Error
        trying
        to
        create
        cart
        for
          user
          : " . $mysqli->error."\n");
      exit
        ();
    }
    $_SESSION['user']
      = $_POST['login'];
    $_SESSION['permission']
      = 'pigeon';
    $_SESSION['cart']
      = $_POST['login'];
    header('Location:
      index.php');
  }
  else
  {
    $_SESSION['login_failure']
      = TRUE;
    header('Location:
      register_page.php');
  }
  mysqli_close($mysqli);
}*/
?>
