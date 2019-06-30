<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/src/utils.php");
#block_all(); pete tout le site 
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once('database.php');
function fetch_bool($collum, $name) {
  global $DB_connect;
  $statement =  $DB_connect->prepare("SELECT ".$collum." FROM db.user WHERE ".$collum." = :name;");
  $statement->execute(['name' => $name]);
  return (($statement->rowCount() > 0)? true : false);
}

?>
