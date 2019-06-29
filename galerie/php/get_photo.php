<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/galerie/php/utils_photo.php');

$photo = "";

if (isset($_POST['scroll']) && $_POST['scroll'] !== NULL && !is_nan($_POST['scroll']))
{
	$photo = get_scroll_photo(intval($_POST['scroll']));
	if (count($photo) === 0)
	$photo = "done";
}
else
{
	if (check_if_connected())
	$photo = fetch_all_pic_of_user();
	else
	$photo = "error";
}

echo json_encode($photo);
?>
