<?php 
  include_once('autoload.php');
  if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    header('Content-Type: text/json');
    
    $parser = new API\UrlParser("http://webapibrt.rio.rj.gov.br/api/v1/brt");
    echo $parser->createCurl()->getWebpage();
  }
?>