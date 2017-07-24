<!DOCTYPE html>
<html lang="en">
 <head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="description" content="Insert a description here">
	<meta name="keywords" content="Insert keywords here">
	<meta name="author" content="Camilo B Groberio">


  <title>PHP MEU TIME STATUS PARCIAIS</title>

      <!-- Bootstrap -->
    <link href="bootstrap/css/bootstrap.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

<style>
table{
    border: 0px solid black;
	border-collapse: separate;
  	border-spacing: 0 3px;
  	margin-top: -3px;
}


th, td {
    padding: 3px;
	color: white;
    text-shadow: 1px 0px 0px black, 
                 -1px 0px 0px black, 
                 0px 1px 0px black, 
                 0px -1px 0px black;
	
    font-weight: bold;
	font-size: 18px;

}

td.pts{
	background-color: #cdcdcd;
	text-align: center;
	text-shadow: 0px 0px 0px white, 
                 0px 0px 0px white, 
                 0px 0px 0px white, 
                 0px 0px 0px white;
	
    font-weight: bold;
	font-size: 14px;
}

td.time{

	text-shadow: 0px 0px 0px white, 
                 0px 0px 0px white, 
                 0px 0px 0px white, 
                 0px 0px 0px white;
	
	color: black;
    font-weight: bold;
	font-size: 16px;
}



</style>

 </head>
 <body>

     <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="bootstrap/js/bootstrap.min.js"></script>
 
 
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
// status_mercado:3 - MANUTENCAO


//----------------------------------------------------/--------------------------------------------------------


//--------------------------------------------------------/----------------------------------------------------
$AA_SANTA_MONICA = json_decode($time_cartola_json, TRUE);
//ARRAY DOS CLUBES
$time = $AA_SANTA_MONICA['time'];

//--------------------------------------------------------
// MOSTRANDO AS INFO DO TIME DO CARTOLA

echo "<h1> PONTUAÇÃO PARCIAL DA RODADA  </h1>";

echo "<table border='0' style='width:30%' cellspacing='0' pading='0' >";

	echo "<tr>";
		echo "<td class='time' align='center'>";
			echo "<img src='" . $time[url_escudo_png] 	. "' alt='escudo' style='width:90px;height:90px;'> ";
		echo "</td>";

		echo "<td class='time'align='top'>";
			echo $time['nome'] . "</br>";
			echo $time['nome_cartola']. "</br>";
			echo "slug: " . $time['slug'];

		echo "</td>";

	echo "</tr>";
echo "</table>";


//echo "CARTOLETAS: $" . number_format($time['valor_time'], 2, ',', '.'); 
//echo "<img src='" . $time[foto_perfil] 		. "' alt='foto' style='width:50px;height:50px;'> ";
//echo '<br>';
//echo "<hr>";
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
	usort($atletas, function($a, $b) { 
		return $a['posicao_id'] <=> $b['posicao_id'];
		} 
	);
	 
	//ORDENANDO AS PARCIAIS POR ORDEM ALFABETICA
	usort($parciais, function($a, $b) { return $a['apelido'] <=> $b['apelido'];} );
	
	//--------------------------------------------------------
	// REINDEXANDO DA ARRAY DAS PARCIAIS
	$parciais = array_values($parciais);
	//--------------------------------------------------------

	echo "<table border='0' style='width:45%' cellspacing='0' pading='10'>";

	//echo "<tr align='center'>"; 
	echo "<tr>"; 
	echo "<th> </th>";
	echo "<th style='width:30%'> </th>";
	//echo "<th style='width:0%'>  </th>";
	echo "<th style='width:15%'> </th>";
	echo "<th style='width:110%'> </th>";
	echo "</tr>";
	
	$time_pontuacao_parcial = 0;
	
	//para cada jogador escalado
	foreach ($atletas as $atleta) {
	
		$atleta_pontuacao_parcial = 0;
		
		$color_player='#FFFFFF';
		$bgcolor_jogou='#E0E0E0'; 
		$color_pts = '#000000';
		$color_pos = '#FFFFFF';
											
		$atleta_escudo_clube_30 = $clubes[$atleta[clube_id]][escudos]['45x45'];
		$atleta_apelido = $atleta[apelido];
		$atleta_posicao_abrv = strtoupper($posicoes[$atleta[posicao_id]][abreviacao]);

		switch ($atleta[posicao_id]){
			case 1: //goleiro
				$color_pos = '#9966ff';
				break;

			case 2: //lateral
				$color_pos = '#00e355';
				break;	

			case 3: //zagueiro
				$color_pos = '#00e355';
				break;
			
			case 4: //meia
				$color_pos = '#ffdd00';
				break;
			
			case 5: //atacante
				$color_pos = '#fb7ca8';
				break;
			
			case 6://tecnico
				$color_pos = GRAY;
				break;
		}

				
		$atleta_na_array = array_search($atleta[apelido], array_column($parciais, 'apelido'));
		$atleta_parcial = $parciais[$atleta_na_array];
						
		if ($atleta_na_array != NULL  && $atleta_parcial[clube_id] == $atleta[clube_id])
		{		
			$atleta_pontuacao_parcial = number_format($atleta_parcial[pontuacao], 2, ',', '.');
			$time_pontuacao_parcial += $atleta_parcial[pontuacao];
			$bgcolor_jogou='#FFFFFF';	
				
			if ($atleta_pontuacao_parcial < 0)	$color_pts = '#FF0000';
		}
		

		echo "<tr bgcolor='" .$color_pos."'>";	
		echo "<td> <img src='" . $atleta_escudo_clube_30 ."' style='width:30px;height:30px;'> </td>";
		echo "<td style='width:50%'>" . $atleta_apelido . "</td>";		
		//echo "<td>" . $atleta_posicao_abrv . "</td>";
		echo "<td class='pts'> <font color ='" . $color_pts . "'>" . $atleta_pontuacao_parcial . "</td>";


		echo "<td class='pts'>";

			if ($atleta_parcial[scout][PE] != null){
				echo " <font color ='RED'> " . $atleta_parcial[scout][PE] . "PE";
			}

			if ($atleta_parcial[scout][FC] != null){
				echo " <font color ='RED'> " . $atleta_parcial[scout][FC] . "FC";
			}

			if ($atleta_parcial[scout][I] != null){
				echo " <font color ='RED'> " . $atleta_parcial[scout][I] . "I";
			}

			if ($atleta_parcial[scout][CA] != null){
				echo " <font color ='RED'> " . $atleta_parcial[scout][CA] . "CA";
			}

			if ($atleta_parcial[scout][CV] != null){
				echo " <font color ='RED'> " . $atleta_parcial[scout][CV] . "CV";
			}

			if ($atleta_parcial[scout][PP] != null){
				echo " <font color ='RED'> " . $atleta_parcial[scout][PP] . "PP";
			}

			if ($atleta_parcial[scout][GC] != null){
				echo " <font color ='RED'> " . $atleta_parcial[scout][GC] . "GC";
			}

			if ($atleta_parcial[scout][GS] != null){
				echo " <font color ='RED'> " . $atleta_parcial[scout][GS] . "GS";
			}
			
			echo "<br>";

			if ($atleta_parcial[scout][FS] != null){
				echo " <font color ='BLUE'> " . $atleta_parcial[scout][FS] . "FS";
			}

			if ($atleta_parcial[scout][RB] != null){
				echo " <font color ='BLUE'> " . $atleta_parcial[scout][RB] . "RB";
			}

			if ($atleta_parcial[scout][FF] != null){
				echo " <font color ='BLUE'> " . $atleta_parcial[scout][FF] . "FF";
			}

			if ($atleta_parcial[scout][FD] != null){
				echo " <font color ='BLUE'> " . $atleta_parcial[scout][FD] . "FD";
			}

			if ($atleta_parcial[scout][FT] != null){
				echo " <font color ='BLUE'> " . $atleta_parcial[scout][FT] . "FT";
			}

			if ($atleta_parcial[scout][A] != null){
				echo " <font color ='BLUE'> " . $atleta_parcial[scout][A] . "A";
			}

			if ($atleta_parcial[scout][G] != null){
				echo " <font color ='BLUE'> " . $atleta_parcial[scout][G] . "G";
			}

			if ($atleta_parcial[scout][SG] != null){
				echo " <font color ='BLUE'> SG";
			}

			if ($atleta_parcial[scout][DD] != null){
				echo " <font color ='BLUE'> " . $atleta_parcial[scout][DD] . "DD";
			}

			if ($atleta_parcial[scout][DP] != null){
				echo " <font color ='BLUE'> " . $atleta_parcial[scout][DP] . "DP";
			}


			echo "</td>";






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