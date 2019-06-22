<?php

include 'database.php';

try 
{
  $DB_connect = new PDO($DB_dsn, $DB_user, $DB_password);

  $statement =  $DB_connect->prepare("DROP DATABASE IF EXIST db");
  $statement->execute();
  
  $statement =  $DB_connect->prepare("CREATE DATABASE db");
  $statement->execute();

  $statement =  $DB_connect->prepare("CREATE TABLE db.user
    (
    login VARCHAR(20) CHARACTER SET utf8,
    email VARCHAR(20) CHARACTER SET utf8,
    password VARCHAR(255) CHARACTER SET utf8,
    token VARCHAR(255) CHARACTER SET utf8
    );");
  $statement->execute();
}

catch (PDOException $error)
{
  echo  'connection Failed l 13 config/database.php\n' . $error->getMessage();  
}









?>
