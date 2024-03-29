<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/galerie/php/utils_photo.php');
block_if_not_connected();
$data = $_POST['data'];
$filtre = $_POST['filter'];

if (preg_match('/^data:image\/(\w+);base64,/', $data, $type)) {
	$data = substr($data, strpos($data, ',') + 1);
	$type = strtolower($type[1]); // jpg, png, gif
	if (!in_array($type, [ 'jpg', 'jpeg', 'gif', 'png' ])) {
		exit;
	}
	$data = base64_decode($data, true);
	if ($data === false) {
		exit;
	}
} else {
	exit;
}

$name = find_the_right_name(path("/galerie/photo")).".{$type}";
file_put_contents(path('/galerie/photo/').$name, $data);
if (valid_photo(path('/galerie/photo/').$name) && $filtre !== NULL && file_exists(path("/".get_good_path($filtre))))
{
	super_impose(path("/galerie/photo/").$name, path("/".get_good_path($filtre)));
	add_pic_to_user($name);
	echo $name;
}
else
	echo "error";
?>
