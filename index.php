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
	<script>
		var map;
		var imageOnibus = 'sprite.png';
		var imageEstacao = 'estacao.png';
		var markers = [];

		// Inicializa o mapa
		function initializeMap() {
			var lat = -22.921976641965472;
			var lng = -43.46191498778683;

			var mapOptions = {
				center: new google.maps.LatLng(lat, lng),
				streetViewControl: false,
				scrollwheel: false,
				zoomControl: true,
				zoom: 11,
			};

			map = new google.maps.Map(document.getElementById('mapa'), mapOptions);

			// Carrega a posição dos ônibus
			getMarkers();
		}

		// Apaga todos os ônibus do mapa
		function deleteMarkers() {
			for (var i = 0; i < markers.length; i++) {
		    	markers[i].setMap(null);
	    	}
			markers = [];
		}

		// Adiciona um ônibus no mapa e define um conteúdo para a janela que aparece quando clicado em cima
		function addMarker(lat, long, title, icon, windowContent) {
			var infoWindow = new google.maps.InfoWindow(), marker;

			var marker = new google.maps.Marker({
				position: new google.maps.LatLng(lat, long),
				map: map,
				title: title,
				icon: icon
			});

			google.maps.event.addListener(marker, 'click', (function(marker) {
				return function() {
					infoWindow.setContent(windowContent);
					infoWindow.open(map, marker);
				}
			})(marker));

		  markers.push(marker);
		}

    // requisição ajax para pegar a posição dos mapas pela API
		function getMarkers() {
			deleteMarkers();
			
			// Pega as posições dos onibus
			$.ajax({
				url: 'getJson.php',
				type: 'GET',
				data: {alvo: 'onibus'},
				dataType: 'json',
				success: function(json) {
					for (i = 0; i < json.veiculos.length; i++) {
						addMarker(
							json.veiculos[i].latitude, 
							json.veiculos[i].longitude, 
							"Linha: " + json.veiculos[i].linha, 
							imageOnibus, 
							'<div class="content"><h1 class="content-linha">Linha: '+ json.veiculos[i].linha+'</h1><h2 class="content-codigo">Código: '+json.veiculos[i].codigo+'</h2><h3 class="content-velocidade">Velocidade: '+json.veiculos[i].velocidade+' km/h</h3></div>'
						);
					}
				}
			});

			// pega as posições das estações
			$.ajax({
				url: 'getJson.php',
				type: 'GET',
				data: {alvo: 'estacao'},
				dataType: 'json',
				success: function(json) {
					for (i = 0; i < json.length; i++) {
						addMarker(
							json[i].LATITUDE, 
							json[i].LONGITUDE, 
							"Estação: " + json[i].ESTACAO, 
							imageEstacao, 
							'<div class="content"><h1 class="content-linha">Estação: '+ json[i].ESTACAO+'</h1><h2 class="content-codigo">Endereço: '+json[i].LOGRADOURO+'</h2></div>'
						);
					}
				}
			});
		}

		// Inicia o mapa ao carregamento do DOM
		google.maps.event.addDomListener(window, 'load', initializeMap);

		// Atualiza as posições dos ônibus a cada 10 segundos
		setInterval(function() {
			getMarkers();
		}, 10000);
	</script>
	<div id="mapa" style="height: 100vh; width: 100vw; "></div>
</body>
</html>