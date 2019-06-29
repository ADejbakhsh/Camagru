<?php
#block unconnect and not good user
require_once($_SERVER['DOCUMENT_ROOT'].'/galerie/php/utils_photo.php');
block_if_not_connected();
$src = $_POST['src'];
echo $_POST['src'];
if ($src === NULL || $src === "")
{
	echo "error";
	exit;
}

$src = path("/".get_good_path($src));
if (!(file_exists($src) && img_belong_to_user($src)))
{
	echo "error";
	exit;
}
unlink($src);

echo "done";
?>
