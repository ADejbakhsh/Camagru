<?php
#block unconnect
require_once($_SERVER['DOCUMENT_ROOT'].'/galerie/php/utils_photo.php');
$file = $_POST['tmp'];
$filtre = $_POST['filter'];

 if ($file === NULL || $filtre === NULL || $file === "" || $filtre === "")
{
echo "error";	
	exit;
}

$file = path("/".get_good_path($file));
$filtre = path("/".get_good_path($filtre));

if (!file_exists($file) || !file_exists($filtre))
{
echo "error";	
	exit;
}

$name = find_the_right_name(path("/galerie/photo")).".jpeg";

rename($file , path('/galerie/photo/').$name);

super_impose(path("/galerie/photo/").$name, $filtre);

echo $name;
?>
