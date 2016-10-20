var tipo = prompt("Qual informação você deseja visualizar?\n1 - Ônibus\n2 - Estações\n3 - Ambos");
var map;
var imageOnibus = 'sprite.png';
var imageEstacao = 'estacao.png';
var markersOnibus = [];
var markersEstacoes = [];

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
	
	if (tipo == "1" || tipo == "3") {
		getMarkersOnibus();
	}

	if (tipo == "2" || tipo == "3") {
		getMarkersEstacoes();
	}
}

// Apaga todos os ônibus do mapa
function deleteOnibus() {
	for (var i = 0; i < markersOnibus.length; i++) {
    	markersOnibus[i].setMap(null);
	}
	markersOnibus = [];
}

// Apaga todas as estações do mapa
function deleteEstacoes() {
	for (var i = 0; i < markersEstacoes.length; i++) {
    	markersEstacoes[i].setMap(null);
	}
	markersEstacoes = [];
}

// Adiciona um ônibus no mapa e define um conteúdo para a janela que aparece quando clicado em cima
function addOnibus(lat, long, title, icon, windowContent) {
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
	markersOnibus.push(marker);
}

// Adiciona uma estação no mapa e define um conteúdo para a janela que aparece quando clicado em cima
function addEstacao(lat, long, title, icon, windowContent) {
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
	markersEstacoes.push(marker);
}

// requisição ajax para pegar a posição dos mapas pela API
function getMarkersOnibus() {
	deleteOnibus();
	
	// Pega as posições dos onibus
	$.ajax({
		url: 'getJson.php',
		type: 'GET',
		data: {alvo: 'onibus'},
		dataType: 'json',
		success: function(json) {
			for (i = 0; i < json.veiculos.length; i++) {
				addOnibus(
					json.veiculos[i].latitude, 
					json.veiculos[i].longitude, 
					"Linha: " + json.veiculos[i].linha, 
					imageOnibus, 
					'<div class="content"><h1 class="content-linha">Linha: '+ json.veiculos[i].linha+'</h1><h2 class="content-codigo">Código: '+json.veiculos[i].codigo+'</h2><h3 class="content-velocidade">Velocidade: '+json.veiculos[i].velocidade+' km/h</h3></div>'
				);
			}
		}
	});
}

function getMarkersEstacoes() {
	deleteEstacoes();

	// pega as posições das estações
	$.ajax({
		url: 'getJson.php',
		type: 'GET',
		data: {alvo: 'estacao'},
		dataType: 'json',
		success: function(json) {
			for (i = 0; i < json.length; i++) {
				addEstacao(
					json[i].LATITUDE, 
					json[i].LONGITUDE, 
					"Estação: " + json[i].ESTACAO, 
					imageEstacao, 
					'<div class="content"><h1 class="content-linha">Estação '+ json[i].ESTACAO+'</h1><h2 class="content-codigo">Endereço: '+json[i].LOGRADOURO+'</h2></div>'
				);
			}
		}
	});

}

// Inicia o mapa ao carregamento do DOM
google.maps.event.addDomListener(window, 'load', initializeMap);

// Atualiza as informações a cada 10 segundos
setInterval(function() {
	if (tipo == "1" || tipo == "3") {
		getMarkersOnibus();
	}
}, 10000);