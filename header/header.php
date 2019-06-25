<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/src/utils.php");

function header_custom($title) {
	echo "<!DOCTYPE html>";
	echo "<html>";
	echo "<head>";
	echo "<title>".$title."</title>";
	echo "<link rel='stylesheet' href='css/header.css'>";
	echo "</head>";
	echo "<body>";
	echo "<div class='header'>";
	echo "<a href='index.php' class='logo'>Camagrue</a>";
	echo "<div class='header-right'>";
	echo "<a class='active' href='index.php' title='Home' >Home</a>";
	if (!isset($_SESSION['user']))
	{
		echo "<a href=\"../../../user/login_page.php\" title=\"Login\" >Login</a>";
		echo  "<a href='/user/register_page.php' title='Register' >Register</a>";
	}
	else
	{
		echo  "<a href=\"../../../user/Deconexion.php\" title=\"Deconexion\" >Deconexion</a>";
	}
	if ($_SESSION['permission'] == "admin")
		echo "<a href=".path("/admin/admin_page.php")." title='admin'>Admin</a>";
	echo " </div>";
	echo "</div>";
}
?>
