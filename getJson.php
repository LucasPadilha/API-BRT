<?php 
  include_once('autoload.php');
  if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    header('Content-Type: text/json');
  	if ($_GET['alvo'] == 'onibus') {
	    $parser = new API\UrlParser("http://webapibrt.rio.rj.gov.br/api/v1/brt");
	    echo $parser->createCurl()->getWebpage();
  	} elseif ($_GET['alvo'] == 'estacao') {
	    $parser = new API\UrlParser("http://dadosabertos.rio.rj.gov.br/brt/api/v1/rest/EstacoesTransoeste.cfm?token=7A32FDD1-CF97-4B1D-4BEE71037BAAEAF2&pretty=false&filter=");
	    echo $parser->createCurl()->getWebpage();
  	}
  }
?>