<html>
 <head>
  <title>PHP MEU TIME STATUS PARCIAIS</title>
 </head>
 <body>
 
 
 <?php 

 include 'get_json_web_page.php';
 
//----------------------------------------------------/------------------------------------------------------
//	BASES JSON
//----------------------------------------------------/------------------------------------------------------
 
//----------------------------------------------------
//  https://api.cartolafc.globo.com/time/[slug do time] 
//  retorna informações de um time específico: usar o slug do time.
//  https://api.cartolafc.globo.com/time/slug/grubberio-calcio

$time_cartola_json = get_json_web_page('https://api.cartolafc.globo.com/time/slug/grubberio-calcio');
	
if ($time_cartola_json['errno'] != 0){
	echo '<pre>';
	print_r($time_cartola_json);
	echo '</pre>';
}
else{

    $time_cartola_json = $time_cartola_json['content'];
}


//--------------------------------------------------------
// 	RETORNA PARCIAIS DE PONTUAÇÃO DOS ATLETAS DA RODADA ATUAL
//	https://api.cartolafc.globo.com/atletas/pontuados

$parciais_rodada_json = get_json_web_page('https://api.cartolafc.globo.com/atletas/pontuados');

if ($parciais_rodada_json['errno'] != 0){
	echo '<pre>';
	print_r($parciais_rodada_json);
	echo '</pre>';
}
else{
    $parciais_rodada_json = $parciais_rodada_json['content'];
}


//--------------------------------------------------------
// RETORNA O STATUS DA RODADA ATUAL
//https://api.cartolafc.globo.com/mercado/status
$mercado_status_json = get_json_web_page('https://api.cartolafc.globo.com/mercado/status');

if ($mercado_status_json['errno'] != 0){
	echo '<pre>';
	print_r($mercado_status_json);
	echo '</pre>';
}
else{
    $mercado_status_json = $mercado_status_json['content'];
}

//--------------------------------------------------------
// status_mercado:1 - ABERTO
// status_mercado:2 - FECHADO
// status_mercado:3 - 
// status_mercado:3 - MANUTENCAO


//----------------------------------------------------/--------------------------------------------------------


//--------------------------------------------------------/----------------------------------------------------
$AA_SANTA_MONICA = json_decode($time_cartola_json, TRUE);
//ARRAY DOS CLUBES
$time = $AA_SANTA_MONICA['time'];

//--------------------------------------------------------
// MOSTRANDO AS INFO DO TIME DO CARTOLA
echo "<h2>" . $time['nome'] . "</h2>";

echo  "NOME DO TIME:" . $time['nome'];
echo '<br>';
echo "NOME DO CARTOLA:" . $time['nome_cartola'];
echo '<br>';
echo "CARTOLETAS: $" . number_format($AA_SANTA_MONICA['valor_time'], 2, ',', '.'); 
echo '<br><br>';
echo "<img src='" . $time[url_escudo_png] 	. "' alt='escudo' style='width:50px;height:50px;'> ";
echo "<img src='" . $time[foto_perfil] 		. "' alt='foto' style='width:50px;height:50px;'> ";
echo '<br>';
echo "<hr>";
//--------------------------------------------------------/----------------------------------------------------


//----------------------------------------------------/--------------------------------------------------------
// MAIN
// QUANDO MERCADO = 1 -- USAR FUNCAO POS RODADA
// QUANDO MERCADO = 2 -- USAR FUNCAO RODADA
//----------------------------------------------------/---------------------------------------------------------

parciais_time_rodada ($time_cartola_json, $parciais_rodada_json);

//parciais_time_pos_rodada($time_cartola_json);

//----------------------------------------------------/--------------------------------------------------------



/*--------------------------------------------------------/----------------------------------------------------
FUNÇÃO: PARCIAIS_TIME_RODADA

PARAMETROS:

--- $time_json ---
Objeto JSON obtido através da consulta abaixo
retorna informações de um time específico: usar o slug do time
https://api.cartolafc.globo.com/time/[slug do time] 
-- https://api.cartolafc.globo.com/time/grubberio-calcio

--- $parciais_rodada_json ---
Objeto JSON obtido através da consulta abaixo
retorna as parciais de todos os jogadores na rodada em andamento
https://api.cartolafc.globo.com/atletas/pontuados

//--------------------------------------------------------/----------------------------------------------------*/
function parciais_time_rodada ($time_cartola_json, $parciais_rodada_json)
{
	//--------------------------------------------------------
	//	TRANSFORMANDO JSONs EM ARRAYS
	//--------------------------------------------------------
	$time_cartola = json_decode($time_cartola_json, TRUE);
	$parciais_rodada = json_decode($parciais_rodada_json, TRUE);
	
	//--------------------------------------------------------
	//	DESMEMBRANDO INFORMAÇÕES DAS ARRAYS
	//--------------------------------------------------------
	//ARRAY DOS CLUBES
	$clubes = $time_cartola[clubes];
	
	//ARRAY DE POSIÇÕES
	$posicoes = $time_cartola[posicoes];

	//ARRAY DAS INFO GERAIS DO TIME DO CARTOLA
	$time = $time_cartola['time'];

	//ARRAY DE ATLETAS ESCALADOS DO TIME
	$atletas = $time_cartola[atletas];

	//ARRAY DE PARCIAIS DOS ATLETAS DA RODADA
	$parciais = $parciais_rodada[atletas];
	
	//--------------------------------------------------------
	//ORDENANDO A ESCALAÇÃO POR ORDEM CRESCENTE DE POSIÇÃO_ID
	usort($atletas, function($a, $b) { return $a['posicao_id'] <=> $b['posicao_id'];} );
	 
	//ORDENANDO AS PARCIAIS POR ORDEM ALFABETICA
	usort($parciais, function($a, $b) { return $a['apelido'] <=> $b['apelido'];} );
	
	//--------------------------------------------------------
	// REINDEXANDO DA ARRAY DAS PARCIAIS
	$parciais = array_values($parciais);
	//--------------------------------------------------------

	echo "<h2> PONTUAÇÃO PARCIAL DA RODADA  </h2>";

	echo "<table border='0' style='width:30%' cellspacing='0' pading='10'>";

	echo "<tr align='center'>"; 
	echo "<th> </th>";
	echo "<th style='width:50%'> </th>";		
	echo "<th style='width:0%'>  </th>";
	echo "<th style='width:15%'> </th>";
	echo "</tr>";
	
	$time_pontuacao_parcial = 0;
	
	//para cada jogador escalado
	foreach ($atletas as $atleta) {
	
		$atleta_pontuacao_parcial = 0;
		
		$bgcolor_jogou='#E0E0E0'; 
		$color_pts = '#000000';
											
		$atleta_escudo_clube_30 = $clubes[$atleta[clube_id]][escudos]['30x30'];
		$atleta_apelido = $atleta[apelido];
		$atleta_posicao_abrv = strtoupper($posicoes[$atleta[posicao_id]][abreviacao]);										
				
		$atleta_na_array = array_search($atleta[apelido], array_column($parciais, 'apelido'));
		$atleta_parcial = $parciais[$atleta_na_array];
						
		if ($atleta_na_array != NULL  && $atleta_parcial[clube_id] == $atleta[clube_id])
		{		
			$atleta_pontuacao_parcial = number_format($atleta_parcial[pontuacao], 2, ',', '.');
			$time_pontuacao_parcial += $atleta_parcial[pontuacao];
			$bgcolor_jogou='#FFFFFF';	
				
			if ($atleta_pontuacao_parcial < 0)	$color_pts = '#FF0000';
		}
		
		echo "<tr align='center' bgcolor='" .$bgcolor_jogou."'>";	
		echo "<td> <img src='" . $atleta_escudo_clube_30 ."' style='width:30px;height:30px;'> </td>";
		echo "<td style='width:50%'>" . $atleta_apelido . "</td>";		
		echo "<td>" . $atleta_posicao_abrv . "</td>";
		echo "<td> <font color ='" . $color_pts . "'>" . $atleta_pontuacao_parcial . "</td>";
		echo "</tr>";
	}
	
	echo "</table>";
	
	// IMPRIME A PARCIAL DO TIME
	echo "<br>";
	echo "<table border='0' style='width:30%'>";
	echo "<tr align='center'>"; 
	echo "<td bgcolor='#E0DDD0'> <b>PARCIAL " . number_format($time_pontuacao_parcial, 2, ',', '.') . " </b> </td>";
	echo "</tr>";
	echo "</table>";
	echo "<br> <hr>";
}
//--------------------------------------------------------/----------------------------------------------------


/*--------------------------------------------------------/----------------------------------------------------
FUNÇÃO: PARCIAIS_TIME_POS_RODADA

PARAMETROS:

--- $time_json ---
Objeto JSON obtido através da consulta abaixo
retorna informações de um time específico: usar o slug do time
https://api.cartolafc.globo.com/time/[slug do time] 
-- https://api.cartolafc.globo.com/time/a-a-santa-monica

//--------------------------------------------------------/----------------------------------------------------*/
function parciais_time_pos_rodada ($time_cartola_json)
{
	//--------------------------------------------------------
	//	TRANSFORMANDO JSONs EM ARRAYS
	//--------------------------------------------------------
	$time_cartola = json_decode($time_cartola_json, TRUE);
	
	//--------------------------------------------------------
	//	DESMEMBRANDO INFORMAÇÕES DAS ARRAYS
	//--------------------------------------------------------
	//ARRAY DOS CLUBES
	$clubes = $time_cartola[clubes];
	
	//ARRAY DE POSIÇÕES
	$posicoes = $time_cartola[posicoes];

	//ARRAY DAS INFO GERAIS DO TIME DO CARTOLA
	$time = $time_cartola['time'];

	//ARRAY DE ATLETAS ESCALADOS DO TIME
	$atletas = $time_cartola[atletas];
	
	//--------------------------------------------------------
	//ORDENANDO A ESCALAÇÃO POR ORDEM CRESCENTE DE POSIÇÃO_ID
	usort($atletas, function($a, $b) { return $a['posicao_id'] <=> $b['posicao_id'];} );
	
	
	echo "<h2> ESCALAÇÃO - FIM DA RODADA  </h2>";

	echo "<table border='0' style='width:30%' cellspacing='0' pading='10'>";

	echo "<tr align='center'>"; 
	echo "<th> </th>";
	echo "<th style='width:50%'> </th>";		
	echo "<th style='width:0%'>  </th>";
	echo "<th style='width:15%'> </th>";
	echo "</tr>";

	$time_pontuacao_parcial = 0;
	
	//para cada jogador escalado
	foreach ($atletas as $atleta) {
		
		$pontuacao_parcial_alteta = 0;
		$color_pts = '#000000';
		
		$atleta_escudo_clube_30 = $clubes[$atleta[clube_id]][escudos]['30x30'];
		$atleta_apelido = $atleta[apelido];
		$atleta_posicao_abrv = strtoupper($posicoes[$atleta[posicao_id]][abreviacao]);
		$atleta_pontuacao_parcial = number_format($atleta[pontos_num], 2, ',', '.');
		$time_pontuacao_parcial += $atleta[pontos_num];
			
		if ($atleta_pontuacao_parcial < 0)	$color_pts = '#FF0000';
			
			
		echo "<tr align='center' bgcolor='" .$bgcolor_jogou."'>";	
		echo "<td> <img src='" . $atleta_escudo_clube_30 ."' style='width:30px;height:30px;'> </td>";
		echo "<td style='width:50%'>" . $atleta_apelido . "</td>";		
		echo "<td>" . $atleta_posicao_abrv . "</td>";
		echo "<td> <font color ='" . $color_pts . "'>" . $atleta_pontuacao_parcial . "</td>";
		echo "</tr>";
	}
	echo "</table>";
		
	// IMPRIME A PARCIAL DO TIME
	echo "<br>";
	echo "<table border='0' style='width:30%'>";
	echo "<tr align='center'>"; 
	echo "<td bgcolor='#E0DDD0'> <b>PARCIAL " . number_format($time_pontuacao_parcial, 2, ',', '.') . " </b> </td>";
	echo "</tr>";
	echo "</table>";
	echo "<br> <hr>";
}
//--------------------------------------------------------/----------------------------------------------------



?>
<br><br><br>

 </body>
</html>