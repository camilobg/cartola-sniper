<html>
 <head>
  <title>Status da Rodada</title>
 </head>
 <body>
 
<?php echo "<p>Status da Rodada</p>";
 
// RETORNA O STATUS DA RODADA ATUAL
//https://api.cartolafc.globo.com/mercado/status
$status_rodada_json = '{"rodada_atual":10,"status_mercado":2,"esquema_default_id":4,"cartoleta_inicial":100,"max_ligas_free":2,"max_ligas_pro":5,"max_ligas_matamata_free":5,"max_ligas_matamata_pro":5,"max_ligas_patrocinadas_free":2,"max_ligas_patrocinadas_pro_num":2,"game_over":false,"times_escalados":3610011,"fechamento":{"dia":21,"mes":6,"ano":2016,"hora":19,"minuto":30,"timestamp":1466548200},"mercado_pos_rodada":false}';

// TRANSFORMA JSON EM ARRAY;
$status_rodada = json_decode($status_rodada_json, TRUE);

// IMPRIME ARRAY
echo '<pre>';
print_r( $status_rodada );
echo '</pre>';

?>
 
 </body>
</html>