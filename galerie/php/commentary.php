<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/galerie/php/utils_photo.php');

if (check_if_connected())
if (!(valid_request('post') && $_POST['img'] !== NULL && photo_exist($_POST['img']) && valid_photo($_POST['img'])))
{
	echo json_encode("error");
	exit;
}
if (isset($_POST['input']) && $_POST['input'] !== NULL && valid_input($_POST['input']))
{
	#block unconnect
	add_comment($_POST['img'], $_POST['input']);
	$comms = put_comment($_SESSION['login'], $_POST['input']);
	echo json_encode($comms);
}
else if (!isset($_POST['input']))
{
	$comms = get_all_com($_POST['img']);
	echo json_encode($comms);
}
?>
