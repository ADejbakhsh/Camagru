<?php
#block unconnect
require_once($_SERVER['DOCUMENT_ROOT'].'/galerie/php/utils_photo.php');


#if $_GET just return if you like or not the photo (true/false)

if (valid_request('get'))
	echo "true";
else if (valid_request('post'))
	echo "false";
?>
