<?php
session_start();
require_once('../header/layout.php');
layout("my gallerie");
?>
		<video id="video"></video>
		<button id="startbutton">Prendre une photo</button>
		<canvas id="canvas"></canvas>
    <img id="photo" alt="The screen capture will appear in this box.">


		<script charset="utf-8" src="galerie/galerie.js"></script>	
	</body>
</html>
