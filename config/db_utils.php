<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/src/utils.php");
block_all();
error_reporting(E_ALL);
ini_set('display_errors', 1);

require ('database.php');

function fetch_bool($collum, $name) {
  global $DB_connect;
  $statement =  $DB_connect->prepare("SELECT ".$collum." FROM db.user WHERE login = :name;");
  $statement->execute(['name' => $name]);
  return (($statement->rowCount() > 0)? true : false);
}

?>
