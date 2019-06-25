<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/galerie/php/utils_photo.php');
$src = $_POST['src'];

if ($src === NULL || $src === "")
{
	echo "error";
	exit;
}

$src = path("/".get_good_path($src));
if (!file_exists($src))
{
	echo "error";
	exit;
}

unlink($src);


echo "done";
?>
