<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require ('database.php');

function fetch_user($id) {
}

var_dump($DB_connect);

function fetch_username($user_login) {

  global $DB_connect;
  $statement =  $DB_connect->prepare("SELECT login FROM db.user WHERE login = :user_login;");

  $statement->execute(['user_login' => $user_login]);
  var_dump($statement->fetch());
}

?>
