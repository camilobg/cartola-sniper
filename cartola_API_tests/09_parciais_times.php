<html>
 <head>
  <title>PARCIAIS TIMES</title>
 </head>
 <body>
 
 
 <?php

  include 'get_json_web_page.php';

//--------------------------------------------------------
// 	RETORNA PARCIAIS DE PONTUAÇÃO DOS ATLETAS DA RODADA ATUAL
//	https://api.cartolafc.globo.com/atletas/pontuados

$getterJSON = 'https://api.cartolafc.globo.com/atletas/pontuados';

$parcias_rodada_json = get_json_web_page($getterJSON);
$parcias_rodada_json = $parcias_rodada_json['content'];

//  Adequando o JSON para uma array no PHP
$parcias_rodada = json_decode($parcias_rodada_json, TRUE);

//--------------------------------------------------------


//--------------------------------------------------------
// 	RETORNA TODOS OS ATLETAS
// 	https://api.cartolafc.globo.com/atletas/mercado

$getterJSON = 'https://api.cartolafc.globo.com/atletas/mercado';

$atletas_json = get_json_web_page($getterJSON);
$atletas_json = $atletas_json['content'];

//  Adequando o JSON para uma array no PHP
$atletas = json_decode($atletas_json, TRUE);

//--------------------------------------------------------



//--------------------------------------------------------
// DEFININDO ARRAYS DE DADOS

//ARRAY DE POSIÇÕES
$posicoes = $parcias_rodada['posicoes'];

//ARRAY DAS INFO GERAIS DOS CLUBES
$clubes = $parcias_rodada['clubes'];

//ARRAY DE PARCIAIS DOS ATLETAS DA RODADA
$parciais = $parcias_rodada['atletas'];
//$parciais = $atletas['atletas'];


//ARRAY DE TOTAL DE ATLETAS QUE JÁ JOGARAM
$total_atletas = $parcias_rodada['total_atletas'];


//--------------------------------------------------------
//ORDENA A ESCALAÇÃO POR ORDEM CRESCENTE DE POSIÇÃO_ID
usort($parciais, function($a, $b) {
    return $a['posicao_id'] <=> $b['posicao_id'];
});
//--------------------------------------------------------

//--------------------------------------------------------
//ORDENA OS CLUBES POR ORDEM ALFABÉTICA
usort($clubes, function($a, $b) {
    return $a['nome'] <=> $b['nome'];
});
//--------------------------------------------------------

//--------------------------------------------------------
// REINDEX DA ARRAY
$parciais = array_values($parciais);
//--------------------------------------------------------

//var_dump($parciais);

//--------------------------------------------------------
// MOSTRANDO A ESCALAÇÃO DOS TIMES
echo "<h2> PARCIAIS TIMES RODADA  </h2>";


foreach ($clubes as $clube) 
{
	if($clube[escudos]['30x30'] != NULL){
	
	
		echo "<table border='0' style='width:30%' cellspacing='0' pading='10'>";

		echo "<img src='" . $clube[escudos]['30x30'] ."' style='width:30px;height:30px;'>";
		echo $clube[nome];
		
		echo "<tr align='center'>"; 
		echo "<th style='width:50%'> </th>";		
		echo "<th style='width:0%'>  </th>";
		echo "<th style='width:15%'> </th>";
		echo "</tr>";

		$pontuacao_parcial_time = 0;
		
		//para cada jogador da parcial
		foreach ($parciais as $atleta) {
			
			$pontuacao_parcial_atleta = 0;
			$color_pts = '#000000';	
											
			if ($atleta[clube_id] == $clube[id])
			{
				//$pontuacao_parcial_atleta = $atleta[pontos_num];
				//$pontuacao_parcial_time += $atleta[pontos_num];
				$pontuacao_parcial_atleta = $atleta[pontuacao];
				$pontuacao_parcial_time += $atleta[pontuacao];
				
				if ($pontuacao_parcial_atleta < 0)	$color_pts = '#FF0000';	
				
				echo "<td style='width:50%'>" . $atleta[apelido] . "</td>";		
				echo "<td>" . strtoupper($posicoes[$atleta[posicao_id]][abreviacao]) . "</td>";
				echo "<td> <font color ='" . $color_pts . "'>" . number_format($pontuacao_parcial_atleta, 2, ',', '.') . "</td>";
				echo "</tr>";
				
			}
			
		}
		echo "</table>";
		
		
		// IMPRIME A PARCIAL DO TIME
		echo "<br>";
		echo "<table border='0' style='width:30%'>";
		echo "<tr align='center'>"; 
		//echo "<td> <img src='" . $clube[escudos]['30x30'] ."' style='width:30px;height:30px;'> </td>";
		//echo "<td>" . $clube[nome] . "</td>";
		echo "<td bgcolor='#E0DDD0'> <b>PARCIAL " . number_format($pontuacao_parcial_time, 2, ',', '.') . " </b> </td>";
		echo "</tr>";
		echo "</table>";

		echo "<br>";
	}
}


//--------------------------------------------------------

?>
<br><br><br>

 </body>
</html>