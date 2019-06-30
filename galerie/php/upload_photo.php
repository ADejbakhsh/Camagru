<?php
#block unconnect
require_once($_SERVER['DOCUMENT_ROOT']."/galerie/php/utils_photo.php");
$file = $_POST['file'];

if (preg_match('/^data:image\/(\w+);base64,/', $file, $type)) {
	$file = substr($file, strpos($file, ',') + 1);
	$type = strtolower($type[1]);
	if (!in_array($type, [ 'jpg', 'jpeg', 'gif', 'png' ])) {
		exit;
	}
	$file = base64_decode($file, true);
	if  ($file === false) {
		exit;
	}
} else {
	exit;
}
$name = find_the_right_name(path("/galerie/tmp")).".{$type}";
file_put_contents(path('/galerie/tmp/').$name, $file);
if (valid_photo(path('/galerie/tmp/').$name))
	echo $name;
else
{
	unlink(path('/galerie/tmp/').$name);
	echo "error";
}
?>
