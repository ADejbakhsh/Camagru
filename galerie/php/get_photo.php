<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/galerie/php/utils_photo.php');

$photo = "";

if ($_POST['scroll'] !== NULL && !is_nan($_POST['scroll']))
	$photo = get_scroll_photo(intval($_POST['scroll']));
else
	$photo = get_all_photo(path("/galerie/photo"));

echo json_encode($photo);
?>
