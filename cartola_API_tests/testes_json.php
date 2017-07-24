<html>
 <head>
  <title>PHP JSON</title>
 </head>
 <body>
 
<?php 
function get_json_web_page( $url )
{
    $options = array(
        CURLOPT_RETURNTRANSFER => true,         // return web page
        CURLOPT_HEADER         => false,        // don't return headers
        CURLOPT_FOLLOWLOCATION => true,         // follow redirects
        CURLOPT_ENCODING       => "",           // handle all encodings
        CURLOPT_USERAGENT      => "spiderman",  // who am i
        CURLOPT_AUTOREFERER    => true,         // set referer on redirect
        CURLOPT_CONNECTTIMEOUT => 120,          // timeout on connect
        CURLOPT_TIMEOUT        => 120,          // timeout on response
        CURLOPT_MAXREDIRS      => 10,           // stop after 10 redirects
        CURLOPT_SSL_VERIFYPEER => false         // Disabled SSL Cert checks
    );

    $ch      = curl_init( $url );
    curl_setopt_array( $ch, $options );

    $content = curl_exec( $ch );
    $err     = curl_errno( $ch );
    $errmsg  = curl_error( $ch );
    $json_get_result  = curl_getinfo( $ch );
    curl_close( $ch );


    $json_get_result['errno']   = $err;
    $json_get_result['errmsg']  = $errmsg;
    $json_get_result['content'] = $content;

    return $json_get_result;
}
?>

<?php echo "<p>lets start! </p>"; 

 $result = get_json_web_page('https://api.cartolafc.globo.com/mercado/status');

if ($result['errno'] != 0){

        echo '<pre>';
        print_r($result);
        echo '</pre>';
}
else{
    $status_rodada_json = $result['content'];

    // TRANSFORMA JSON EM ARRAY;
    $status_rodada = json_decode($status_rodada_json, TRUE);

    // IMPRIME ARRAY
    echo '<pre>';
    print_r($status_rodada);
    echo '</pre>';
}

 ?>

 
 </body>
</html>