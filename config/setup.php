<?php
if ( !isset($_GET['password']) || $_GET['password'] !== "abc2019")
    exit();
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once($_SERVER['DOCUMENT_ROOT'].'/config/database.php');

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
    token VARCHAR(255) CHARACTER SET utf8,
    validated_account TINYINT,
    want_mail  VARCHAR(255) DEFAULT 'yes'

  );");
$statement->execute();

$statement =  $DB_connect->prepare("CREATE TABLE db.img
  (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) CHARACTER SET utf8,
    user_id INT NOT NULL
  );");
$statement->execute();

$statement =  $DB_connect->prepare("CREATE TABLE db.like
  (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    img_id INT NOT NULL,
    user_id INT NOT NULL
  );");
$statement->execute();

$statement =  $DB_connect->prepare("CREATE TABLE db.commentary
  (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    img_id INT NOT NULL,
    body LONGTEXT CHARACTER SET utf8,
    user_id INT NOT NULL
  );");
$statement->execute();


?>
