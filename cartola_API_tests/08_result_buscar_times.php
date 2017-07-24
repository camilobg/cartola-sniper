<html>
 <head>
  <title>Buscar Times</title>
 </head>
 <body>
 
<p>Buscar Times</p>

<!--------------------------------------------------------
//  busca geral de times. Retorna info do time e o slug
// https://api.cartolafc.globo.com/times?q=[nome do time]
//-------------------------------------------------------->



<?php 

include 'get_json_web_page.php';
//echo 'https://api.cartolafc.globo.com/times?q='.$_GET["nomeTime"]; 

$getterJSON = 'https://api.cartolafc.globo.com/times?q='.$_GET["nomeTime"];
echo $getterJSON;
echo '<br><br><br>';


$time_cartola_json = get_json_web_page($getterJSON);


//testa se houve erro no parsing! Vai acusar erro de string mal-formada (JSON_ERROR_SYNTAX)
if ($time_cartola_json['errno'] != 0){

    echo 'Erro!</br>';
	switch (json_last_error()) {
	
        case JSON_ERROR_DEPTH:
            echo ' - profundidade maxima excedida';
        break;
        case JSON_ERROR_STATE_MISMATCH:
            echo ' - state mismatch';
        break;
        case JSON_ERROR_CTRL_CHAR:
            echo ' - Caracter de controle encontrado';
        break;
        case JSON_ERROR_SYNTAX:
            echo ' - Erro de sintaxe! String JSON mal-formada!';
        break;
        case JSON_ERROR_UTF8:
            echo ' - Erro na codificação UTF-8';
        break;
        default:
            echo ' – Erro desconhecido';
        break;
    }

	echo '<pre>';
	print_r($time_cartola_json);
	echo '</pre>';
}
else{
    echo '- Nao houve erro! O parsing foi executado corretamente';
    $time_cartola_json = $time_cartola_json['content'];
}

$busca_times = json_decode($time_cartola_json, TRUE);



// IMPRIME ARRAY
echo '<pre>';
print_r( $busca_times );
echo '</pre>';

?>
 
 </body>
</html>

