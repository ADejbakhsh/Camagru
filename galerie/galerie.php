<?php
#block if unconnect
require_once($_SERVER['DOCUMENT_ROOT'].'/header/layout.php');
layout("my atelier photo");
?>

 <link rel="stylesheet" type="text/css" href="/css/mount.css" />

	<div id="main">
		<div class="video">
			<img id="active_filter" src="" />
			<video id="video"></video>
		</div>
		<div id='filter'>
		</div>
		<div id='sidebar'>
		</div>
		<div class='startbutton'>
		</div>
		<canvas style="display: none" id="canvas"></canvas>
	</div>
		<script charset="utf-8" src="/galerie/galerie.js"></script>	
	</body>
</html>
