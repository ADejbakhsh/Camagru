<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/galerie/php/utils_photo.php');


$photo = get_all_photo();

echo json_encode($photo);
?>
