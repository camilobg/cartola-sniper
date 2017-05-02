<?php
/* Cartrolando FC - http://cartrolandofc.com
* https://github.com/wgenial/cartrolandofc
* Desenvolvido por WGenial - http://wgenial.com.br
* License: MIT <http://opensource.org/licenses/mit-license.php> - see LICENSE file
*/
header("Access-Control-Allow-Origin: *");
header('Content-type: application/json');
/*
if (isset($_GET["api"]) and $_GET["api"] !== "") {
if ($_GET["api"] === "busca-time") {
$url = "https://api.cartolafc.globo.com/times?q=". rawurlencode($_GET["team"]);
} else if ($_GET["api"] === "busca-atletas") {
$url = "https://api.cartolafc.globo.com/time/". $_GET["team_slug"];
} else if ($_GET["api"] === "parciais-atletas") {
$url = "https://api.cartolafc.globo.com/atletas/pontuados";
} else if ($_GET["api"] === "mercado-status") {
$url = "https://api.cartolafc.globo.com/mercado/status";
} else if ($_GET["api"] === "atletas-mercado") {
$url = "https://api.cartolafc.globo.com/atletas/mercado";
}
*/

//$url = './status.txt';


$c = curl_init();
curl_setopt($c, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
curl_setopt($c, CURLOPT_SSL_VERIFYPEER, FALSE);
curl_setopt($c, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($c, CURLOPT_FRESH_CONNECT, TRUE);
curl_setopt($c, CURLOPT_URL, $url);
curl_setopt($c, CURLOPT_FOLLOWLOCATION, 1);

$result = curl_exec($c);

// Check for errors and display the error message
if($errno = curl_errno($c)) {
    $error_message = curl_strerror($errno);
    echo "cURL error ({$errno}):\n {$error_message}";
}

// TRANSFORMA JSON EM ARRAY;
$status_mercado = json_decode($result, TRUE);

//var_dump($status_mercado);
print_r($status_mercado);
curl_close($c);




//}
?>