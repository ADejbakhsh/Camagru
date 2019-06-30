<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/galerie/php/utils_photo.php');


if (check_if_connected()) {
	if (valid_request('get'))
		echo is_liked($_GET['src']);
	else if (valid_request('post')) {
		if (is_liked($_POST['img']) === 'true') {
			unlike($_POST['img']);
			echo "false";
		} else {
			like($_POST['img']);
			echo "true";
		}
	}
}
