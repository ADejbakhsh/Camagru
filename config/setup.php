<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require 'database.php';


$statement =  $DB_connect->prepare("DROP DATABASE IF EXISTS db;");
$statement->execute();
$statement =  $DB_connect->prepare("CREATE DATABASE db;");
$statement->execute();

$statement =  $DB_connect->prepare("CREATE TABLE db.user
  (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    login VARCHAR(255) CHARACTER SET utf8,
    email VARCHAR(255) CHARACTER SET utf8,
    password VARCHAR(255) CHARACTER SET utf8,
    token VARCHAR(255) CHARACTER SET utf8
  );");
$statement->execute();

?>
