<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/galerie/php/utils_photo.php');

if (!(valid_request('post') && $_POST['img'] !== NULL && photo_exist($_POST['img']) && valid_photo($_POST['img'])))
{
	echo json_encode("error");
	exit;
}
if ($_POST['input'] !== NULL && valid_input($_POST['input']))
{
	$comms = put_comment($_POST['img'], $_POST['input']);
	echo json_encode($comms);
}
else if ($_POST['input'] === NULL)
{
	$comms = get_all_com($_POST['img']);
	echo json_encode($comms);
}
?>
