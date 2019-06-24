<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/galerie/php/utils_photo.php');
$data = $_POST['data'];
$filtre = $_POST['nb_filtre'];


if (preg_match('/^data:image\/(\w+);base64,/', $data, $type)) {
	$data = substr($data, strpos($data, ',') + 1);
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
$name = find_the_right_name().".{$type}";
file_put_contents(path('/galerie/photo/').$name, $data);
echo $name;
?>
