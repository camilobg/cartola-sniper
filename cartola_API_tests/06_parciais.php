<!DOCTYPE html>
<html lang="en">
 <head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="description" content="Insert a description here">
	<meta name="keywords" content="Insert keywords here">
	<meta name="author" content="Camilo B Groberio">

  <title>Parciais dos Jogadores da Rodada</title>

        <!-- Bootstrap -->
    <link href="bootstrap/css/bootstrap.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->


<style>
table, th, td {
    border: 1px solid black;
    border-collapse: collapse;
}
th, td {
    padding: 5px;
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
echo "<h2> PONTUAÇÃO PARCIAL DOS JOGADORES DA RODADA  </h2>";


//--------------------------------------------------------
//ORDENA AS PARCIAIS POR ORDEM DECRESCENTE DE PONTUAÇÃO
usort($parciais_atleta, function($a, $b) {
    return $a['pontuacao'] <= $b['pontuacao'];
});
//--------------------------------------------------------


echo "<table style='width:50%'>";

	echo "<tr align='center'>"; 
	echo "<td> <b>TIME</b> 		</td>";
	echo "<td> <b>ATLETA</b> 	</td>";		
	echo "<td> <b>POS</b>  		</td>";
	echo "<td> <b>PTS</b>  		</td>";
	echo "<td style='width:40%'> <b>SCOUT</b>  	</td>";
	echo "</tr>";

	foreach ($parciais_atleta as $parcial_atleta) 
	{
		if ($parcial_atleta[clube_id] != 0)
		{
			echo "<tr  align='center'>"; 
			echo "<td> <img src='" . $clubes[$parcial_atleta[clube_id]][escudos]['45x45'] ."' style='width:30px;height:30px;'> </td>";
			echo "<td>" . $parcial_atleta[apelido] . "</td>";		
			echo "<td>" . strtoupper($posicoes[$parcial_atleta[posicao_id]][abreviacao]) . "</td>";

			$atleta_pontuacao_parcial = $parcial_atleta[pontuacao];

			$color_pts = '#000000';
			if ($atleta_pontuacao_parcial < 0)	$color_pts = '#FF0000';

			echo "<td> <font color ='" . $color_pts . "'>" . number_format($atleta_pontuacao_parcial, 2, ',', '.'). "</td>";
			
			
			echo "<td>";

			if ($parcial_atleta[scout][PE] != null){
				echo " PE:" . $parcial_atleta[scout][PE];
			}

			if ($parcial_atleta[scout][FC] != null){
				echo " FC:" . $parcial_atleta[scout][FC];
			}

			if ($parcial_atleta[scout][I] != null){
				echo " I:" . $parcial_atleta[scout][I];
			}

			if ($parcial_atleta[scout][CA] != null){
				echo " CA:" . $parcial_atleta[scout][CA];
			}

			if ($parcial_atleta[scout][CV] != null){
				echo " CV:" . $parcial_atleta[scout][CV];
			}

			if ($parcial_atleta[scout][PP] != null){
				echo " PP:" . $parcial_atleta[scout][PP];
			}

			if ($parcial_atleta[scout][GC] != null){
				echo " GC:" . $parcial_atleta[scout][GC];
			}

			if ($parcial_atleta[scout][GS] != null){
				echo " GS:" . $parcial_atleta[scout][GS];
			}
			
			echo "<br>";

			if ($parcial_atleta[scout][FS] != null){
				echo " FS:" . $parcial_atleta[scout][FS];
			}

			if ($parcial_atleta[scout][RB] != null){
				echo " RB:" . $parcial_atleta[scout][RB];
			}

			if ($parcial_atleta[scout][FF] != null){
				echo " FF:" . $parcial_atleta[scout][FF];
			}

			if ($parcial_atleta[scout][FD] != null){
				echo " FD:" . $parcial_atleta[scout][FD];
			}

			if ($parcial_atleta[scout][FT] != null){
				echo " FT:" . $parcial_atleta[scout][FT];
			}

			if ($parcial_atleta[scout][A] != null){
				echo " A:" . $parcial_atleta[scout][A];
			}

			if ($parcial_atleta[scout][G] != null){
				echo " G:" . $parcial_atleta[scout][G];
			}

			if ($parcial_atleta[scout][SG] != null){
				echo " SG"; //. $parcial_atleta[scout][SG];
			}

			if ($parcial_atleta[scout][DD] != null){
				echo " DD:" . $parcial_atleta[scout][DD];
			}

			if ($parcial_atleta[scout][DP] != null){
				echo " DP:" . $parcial_atleta[scout][DP];
			}


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





