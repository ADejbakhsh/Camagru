<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/galerie/php/utils_photo.php');
require_once(path('/header/layout.php'));
if (!(photo_exist($_GET['img']) && valid_photo($_GET['img'])))
	header("Location: /");

layout('photo');
echo "<div id='main'><img src='/galerie/photo/".$_GET['img']."'></div>";
echo var_dump($_SERVER);
?>

			<script src="/galerie/photo.js"></script>
	</body>
</html>
