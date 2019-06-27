<?php
session_start();

function path($str) {
	return $_SERVER["DOCUMENT_ROOT"].$str;
}

function valid_request($attend) {
	if ($attend === 'post')
	return ($_SERVER['REQUEST_METHOD'] === 'POST');
	if ($attend === 'get')
	return ($_SERVER['REQUEST_METHOD'] === 'GET');
}

function valid_input($input) {
	if (preg_match('/[<>"\']/', $input))
		return false;
	else
		return true;
}
?>
