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
//echo 'https://api.cartolafc.globo.com/times?q='.$_GET["nomeTime"]; 

$getterJSON = 'https://api.cartolafc.globo.com/times?q='.$_GET["nomeTime"];
echo $getterJSON;
echo '<br><br><br>';

//$busca_times_json = file_get_contents('https://api.cartolafc.globo.com/times?q=a a santa monica');
//$busca_times_json = '[{"time_id":1031627,"nome":"A A Santa Monica","nome_cartola":"@camilobg","slug":"a-a-santa-monica","facebook_id":10152370829821303,"url_escudo_png":"https://s2.glbimg.com/Pspg-j-ukLUlpwC64989n-ArVDs=/https://s3.glbimg.com/v1/AUTH_58d78b787ec34892b5aaa0c7a146155f/svg_v3/escudo/38/51/09/003598103820160623175109","url_escudo_svg":"https://s3.glbimg.com/v1/AUTH_58d78b787ec34892b5aaa0c7a146155f/svg_v3/escudo/38/51/09/003598103820160623175109","foto_perfil":"https://graph.facebook.com/v2.2/10152370829821303/picture?width=100\u0026height=100","assinante":false},{"time_id":3754288,"nome":"Atletico Santa Mônica","nome_cartola":"Tiago Leite","slug":"atletico-santa-monica","facebook_id":null,"url_escudo_png":"https://s2.glbimg.com/rmBOEh7y-Eu4Z8e4iDeEaDa8tvI=/https://s3.glbimg.com/v1/AUTH_58d78b787ec34892b5aaa0c7a146155f/svg/escudo/002863081220160514130552","url_escudo_svg":"https://s3.glbimg.com/v1/AUTH_58d78b787ec34892b5aaa0c7a146155f/svg/escudo/002863081220160514130552","foto_perfil":"","assinante":false},{"time_id":5498095,"nome":"fc atletico santa monica","nome_cartola":"Deivison  Marques","slug":"fc-atletico-santa-monica","facebook_id":null,"url_escudo_png":"https://s2.glbimg.com/ZnDPiSqXYCuUhfQ8gdz7JWNzn3w=/https://s3.glbimg.com/v1/AUTH_58d78b787ec34892b5aaa0c7a146155f/svg_v2/escudo/007080353320160603205332","url_escudo_svg":"https://s3.glbimg.com/v1/AUTH_58d78b787ec34892b5aaa0c7a146155f/svg_v2/escudo/007080353320160603205332","foto_perfil":"","assinante":false},{"time_id":4431797,"nome":"Atlético Santa Mônica F.C","nome_cartola":"Fernando Lima","slug":"atletico-santa-monica-f-c","facebook_id":null,"url_escudo_png":"https://s2.glbimg.com/JftkNB6qsC9el5d65Qwk8yuRLx8=/https://s3.glbimg.com/v1/AUTH_58d78b787ec34892b5aaa0c7a146155f/svg_v2/escudo/006934047020160526115210","url_escudo_svg":"https://s3.glbimg.com/v1/AUTH_58d78b787ec34892b5aaa0c7a146155f/svg_v2/escudo/006934047020160526115210","foto_perfil":"https://cartolafc.globo.com/static/img/placeholder_perfil.png","assinante":false},{"time_id":3247448,"nome":"Atletico Santa Mônica FC","nome_cartola":"Diogo ribas","slug":"atletico-santa-monica-fc","facebook_id":null,"url_escudo_png":"https://s2.glbimg.com/hQfjZp8bfpX7pa9DOSnsiBe9nEc=/https://s3.glbimg.com/v1/AUTH_58d78b787ec34892b5aaa0c7a146155f/svg_v2/escudo/006803354220160603143624","url_escudo_svg":"https://s3.glbimg.com/v1/AUTH_58d78b787ec34892b5aaa0c7a146155f/svg_v2/escudo/006803354220160603143624","foto_perfil":"https://cartolafc.globo.com/static/img/placeholder_perfil.png","assinante":false},{"time_id":3883127,"nome":"A.A.D.F Las Cocotinhas  De Santa Mônica","nome_cartola":"Marcos torquato","slug":"a-a-d-f-las-cocotinhas-de-santa-monica","facebook_id":null,"url_escudo_png":"https://s2.glbimg.com/q3iSh24BWoTfhmGz3K_Eb-7KG7I=/https://s3.glbimg.com/v1/AUTH_58d78b787ec34892b5aaa0c7a146155f/svg/escudo/006848629820160515114832","url_escudo_svg":"https://s3.glbimg.com/v1/AUTH_58d78b787ec34892b5aaa0c7a146155f/svg/escudo/006848629820160515114832","foto_perfil":"","assinante":false}]';

//---------------------------------------------------------------------------------------------
// make sure to replace vimeouser with your vimeo username
$vimeorequest = 'https://api.cartolafc.globo.com/times?q=a a santa monica';
$vimeoci = curl_init($vimeorequest);
curl_setopt($vimeoci,CURLOPT_RETURNTRANSFER, TRUE);
$jsondoc = curl_exec($vimeoci);
curl_close($vimeoci);

// parameter 'true' is necessary for output as PHP array
$video = json_decode($jsondoc,true);
//---------------------------------------------------------------------------------------------



// TRANSFORMA JSON EM ARRAY;
//$busca_times = json_decode($busca_times_json, TRUE);


//testa se houve erro no parsing! Vai acusar erro de string mal-formada (JSON_ERROR_SYNTAX)
if (json_last_error() == 0) {
    echo '- Nao houve erro! O parsing foi perfeito';
}	
else {			
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
}



// IMPRIME ARRAY
echo '<pre>';
//print_r( $busca_times );
print_r( $video );

echo '</pre>';

?>
 
 </body>
</html>

