<?php
session_start();
require_once('../header/layout.php');
layout("my gallerie");
?>

 <link rel="stylesheet" type="text/css" href="css/galerie.css" />

	<div id="main">	
		<div class="video">	
			<video id="video"></video>
		</div>	
		<div id='sidebar'>
		</div>
		<button id="startbutton">Prendre une photo</button>
		<canvas style="display: none" id="canvas"></canvas>
	</div>
		<script charset="utf-8" src="galerie/galerie.js"></script>	
	</body>
</html>
