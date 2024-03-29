<?php

if (isset($_SESSION) && $_SESSION !== NULL)
  require_once($_SERVER["DOCUMENT_ROOT"] . "/src/utils.php");
else
  require_once('../src/utils.php');

$DB_dsn = 'mysql:host=localhost:3306';
$DB_user = 'root';
$DB_password = 'test';

try
{
  $DB_connect = new PDO($DB_dsn, $DB_user, $DB_password);
  $DB_connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch (PDOException $e) {
  echo 'Connection failed: ' . $e->getMessage();
}

?>
