<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/galerie/php/utils_photo.php');
require_once(path('/header/layout.php'));
if (!(photo_exist($_GET['img']) && valid_photo(path('/galerie/photo/').$_GET['img'])))
	header("Location: /");

layout('photo');
echo "<div id='main'><img id='big' src='/galerie/photo/".$_GET['img']."'><div id='like'></div></div>";
?>

<link rel="stylesheet" type="text/css" href="/css/photo.css">
<div style="height: 80px"></div>

			<script src="/galerie/photo.js"></script>
	</body>
</html>
