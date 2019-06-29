<?php
session_start();
require_once($_SERVER["DOCUMENT_ROOT"]."/src/utils.php");
require_once(path("/requet_db/requet_utile.php"));
$dir_filter = path('/galerie/filter');

function find_the_right_name($path) {
	if (!file_exists($path))
		mkdir($path, 0755);
	$data = get_all_photo($path);
	$data = array_reverse($data);
	if (isset($data[0]) && $data[0] !== NULL)
	{
		preg_match('/\d+/', $data[0], $match);
		return "img".strval(intval($match[0]) + 1);
	}
	else
		return "img0";
}

function get_all_photo($path) {
	if (!file_exists($path))
		return ;
	$data = scandir($path);
	unset($data[0]);
	unset($data[1]);
	natcasesort($data);
	return array_values($data);
}

function photo_exist($img) {
	return(file_exists(path("/galerie/photo/$img")));
}

function valid_photo($img) {
	$type = mime_content_type(path("/galerie/photo/$img"));
	if (preg_match('/(jpeg|png|jpg)/', $type, $match))
		return true;
	else
		return false;
}

function get_scroll_photo($nb) {
	$array  = fetch_all_pic($nb);
	
}

function get_all_com($name_img) {
	return [];
}

function put_comment($img, $input) {
	return array("user" => "george", "body" => $input);
}

function get_filters() {
	global $dir_filter;
	if (!file_exists($dir_filter))
		return ;
	$data = scandir($dir_filter);
	unset($data[0]);
	unset($data[1]);
	return array_values($data);
}

function get_good_image($src) {
	preg_match ('/\..{3,4}$/', $src, $match);
	if ($match[0] !== NULL) {
		if (strpos($match[0], 'jpg') || strpos($match[0],'jpeg'))
			return imagecreatefromjpeg($src);
		else if (strpos($match[0], 'png'))
			return	imagecreatefrompng($src);
	}
}

function get_good_path($filtre) {
	return substr($filtre, strpos($filtre,  'galerie'));
}

function super_impose($src, $filter)
{
	$image_1 = get_good_image($src);
	$image_filter = get_good_image($filter);
	list($width, $height) = getimagesize($src);
	list($width_small, $height_small) = getimagesize($filter);
	$marge_right = ($width/2)-($width_small/2);
	$marge_bottom = ($height/2)-($height_small/2);
	$sx = imagesx($image_filter);
	$sy = imagesy($image_filter);
	imagealphablending($image_1, true);
	imagesavealpha($image_1, true);
	imagecopy($image_1, $image_filter,  imagesx($image_1) - $sx - $marge_right, imagesy($image_1) - $sy - $marge_bottom, 0, 0, $width_small, $height_small);
	imagejpeg($image_1, $src);
}

function get_image_name($url)
{
	preg_match("/photo\/\K.*/", $url, $match);
	return ($match[0]);
}
?>
