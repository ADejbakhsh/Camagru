<?php
#block_unconnect
require_once($_SERVER['DOCUMENT_ROOT'].'/galerie/php/utils_photo.php');


$photo = get_filters();

echo json_encode($photo);
?>
