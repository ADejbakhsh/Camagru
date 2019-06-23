<?php
session_start();
$data = $_POST['data'];
if (preg_match('/^data:image\/(\w+);base64,/', $data, $type)) {
	$data = substr($data, strpos($data, ',') + 1);
	echo $data;
	$type = strtolower($type[1]); // jpg, png, gif
	if (!in_array($type, [ 'jpg', 'jpeg', 'gif', 'png' ])) {
		echo 'invalid image type';
	}
	$data = base64_decode($data, true);
	if ($data === false) {
		echo 'base64_decode failed';
	}
} else {
	echo 'did not match data URI with image data';
}
file_put_contents("img.{$type}", $data);

imagecreatefromjpeg("img.{$type}");
?>
