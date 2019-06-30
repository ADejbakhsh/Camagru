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

function block_all()
{
	if ($_SERVER !== NULL)
		exit;
}

function block_if_connected()
{
	if (check_if_connected())
	{
		header('Location: /index.php');
		exit;
	}
}

function block_if_not_connected()
{
	if (!check_if_connected())
	{
		header('Location: /index.php');
		exit;
	}
}

function check_if_connected()
{  
	if (isset($_SESSION['login']) && $_SESSION['login'] != NULL)
		return(true);
	return(false);
}


?>
