<html>
 <head>
  <title>Parciais da Rodada</title>
 </head>
 <body>
 
<?php 

 include 'get_json_web_page.php';

// RETORNA PARCIAIS DE PONTUAÇÃO DOS ATLETAS DA RODADA ATUAL
//https://api.cartolafc.globo.com/atletas/pontuados

$parciais_rodada_json = get_json_web_page('https://api.cartolafc.globo.com/atletas/pontuados');
$parciais_rodada_json = $parciais_rodada_json['content'];


// TRANSFORMA JSON EM ARRAY;
$parciais_rodada = json_decode($parciais_rodada_json, TRUE);

// DESMENBRA INFORMAÇÕES EM ARRAYS
$parciais_atleta = $parciais_rodada[atletas];
$clubes = $parciais_rodada[clubes];
$posicoes = $parciais_rodada[posicoes];


// IMPRIME ARRAY
//	echo '<pre>';
//	print_r( $parcias_rodada );
//	echo '</pre>';



// MOSTRANDO PONTUAÇÃO DOS ATLETAS
echo "<h2> PONTUAÇÃO PARCIAL DA RODADA  </h2>";


//--------------------------------------------------------
//ORDENA AS PARCIAIS POR ORDEM DECRESCENTE DE PONTUAÇÃO
usort($parciais_atleta, function($a, $b) {
    return $a['pontuacao'] <= $b['pontuacao'];
});
//--------------------------------------------------------


echo "<table border='1' style='width:40%'>";

	echo "<tr align='center'>"; 
	echo "<td> <b>TIME</b> </td>";
	echo "<td style='width:80%'> <b>ATLETA</b>  </td>";		
	echo "<td> <b>POSIÇÃO</b>  </td>";
	echo "<td> <b>PONTUAÇÃO</b>  </td>";
	echo "<td> <b>SCOUT</b>  </td>";
	echo "</tr>";

	foreach ($parciais_atleta as $parcial_atleta) 
	{
		if ($parcial_atleta[clube_id] != 0)
		{
			echo "<tr align='center'>"; 
			echo "<td> <img src='" . $clubes[$parcial_atleta[clube_id]][escudos]['30x30'] ."' style='width:30px;height:30px;'> </td>";
			echo "<td style='width:60%'>" . $parcial_atleta[apelido] . "</td>";		
			echo "<td>" . $posicoes[$parcial_atleta[posicao_id]][abreviacao] . "</td>";
			echo "<td>" . $parcial_atleta[pontuacao] . "</td>";
			
			echo "<td>";
			echo "FT:" . $parcial_atleta[scout][FT] . " PE:" . $parcial_atleta[scout][PE];
			echo "</td>";

			echo "</tr>";		
		}
	}
echo "</table>";

echo "<hr>";
//--------------------------------------------------------



?>
 
 </body>
</html>





