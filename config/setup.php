<?php
$DB_dsn = 'mysql:host=localhost:3307';
$DB_user = 'root';
$DB_password = 'popopo';

try 
{
  $DB_connect = new PDO($DB_dsn, $DB_user, $DB_password);
}

catch (PDOException $error)
{
  echo  'connection Failed l 13 config/database.php\n' . $error->getMessage();  
}

$statement =  $DB_connect->prepare("CREATE DATABASE DB");
$statement->execute();
$row_count = $statement->rowCount();

echo $row_count;


?>
