<?php
session_start();
require_once($_SERVER["DOCUMENT_ROOT"]."/src/utils.php");
$dir_photo = path('/galerie/photo');

function find_the_right_name() {
	global $dir_photo;
	if (!file_exists($dir_photo))
		return ;
	$data = scandir($dir_photo);
	return "img".strval(count($data) - 2);
}

function get_all_photo() {
	global $dir_photo;
	if (!file_exists($dir_photo))
		return ;
	$data = scandir($dir_photo);
	unset($data[0]);
	unset($data[1]);
	return $data;
}


?>
