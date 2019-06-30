<?php
#block unconnect and not good user
require_once($_SERVER['DOCUMENT_ROOT'].'/galerie/php/utils_photo.php');
block_if_not_connected();
$src = $_POST['src'];
if ($src === NULL || $src === "")
{
	echo "error";
	exit;
}
$tmp =  get_image_name($src);
$src = path("/".get_good_path($src));
if (!(file_exists($src) && img_belong_to_user($tmp)))
{
	echo "error";
	exit;
}
del_pic_of_user($tmp);
unlink($src);

echo "done";
?>
