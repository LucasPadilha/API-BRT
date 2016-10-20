<?php ini_set('display_errors', '1'); error_reporting(E_ALL); ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Localização dos ônibus do Rio de Janeiro em tempo real</title>
	<style>
		.content {
			padding: 0;
			margin: 0 auto;
			display: block;
			color: #333131;
			position: relative;
			width: 200px;
		}

		.content-linha {
			margin: 0;
			text-transform: uppercase;
			font-size: 1.25em;
		}

		.content-codigo {
			font-size: 1.25em;
			margin: 0;
		}

		.content-velocidade {
			font-size: 1.25em;
			margin: 0;
		}

	</style>
</head>
<body style="margin:0; padding:0;">
	<script src="jquery.min.js"></script>
	<script src="http://maps.googleapis.com/maps/api/js?key=AIzaSyAG-VzjvI8lmLhz3LGiQ9t-Xa5DPJEHF_Y"></script>
	<script src="api.js"></script>
	<div id="mapa" style="height: 100vh; width: 100vw; "></div>
</body>
</html>