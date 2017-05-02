<html>
 <head>
  <title>Destaques da Rodada</title>
 </head>
 <body>
 
<?php echo "<p>Destaques da Rodada</p>";

// RETORNA OS ATLETAS MAIS ESCALADOS
https://api.cartolafc.globo.com/mercado/destaques
$destaques_json = '[{"Atleta":{"atleta_id":72605,"nome":"Vitor Hugo Franchescoli de Souza","apelido":"Vitor Hugo","foto":"https://s.glbimg.com/es/sde/f/2016/05/01/e68421691461665280e5183ea53281dd_FORMATO.png","preco_editorial":5},"escalacoes":1694369,"clube":"PAL","escudo_clube":"https://s.glbimg.com/es/sde/f/equipes/2014/04/14/palmeiras_60x60.png","posicao":"Zagueiro"},{"Atleta":{"atleta_id":71227,"nome":"Maicon Pereira Roque","apelido":"Maicon","foto":"https://s.glbimg.com/es/sde/f/2016/05/01/f3000bd2b412a315dad8796d7080a492_FORMATO.png","preco_editorial":7},"escalacoes":1638864,"clube":"SAO","escudo_clube":"https://s.glbimg.com/es/sde/f/equipes/2014/04/14/sao_paulo_60x60.png","posicao":"Zagueiro"},{"Atleta":{"atleta_id":51548,"nome":"Giuliano Victor de Paula","apelido":"Giuliano","foto":"https://s.glbimg.com/es/sde/f/2016/04/30/6abcfcc0e937e32dd475d4322fab30f8_FORMATO.png","preco_editorial":13},"escalacoes":1130431,"clube":"GRE","escudo_clube":"https://s.glbimg.com/es/sde/f/equipes/2014/04/14/gremio_60x60.png","posicao":"Meia"},{"Atleta":{"atleta_id":83257,"nome":"Gabriel Barbosa Almeida","apelido":"Gabriel","foto":"https://s.glbimg.com/es/sde/f/2016/05/01/1483ff1b3cb82fa23bc8625656564b18_FORMATO.png","preco_editorial":16},"escalacoes":1062614,"clube":"SAN","escudo_clube":"https://s.glbimg.com/es/sde/f/equipes/2014/04/14/santos_60x60.png","posicao":"Atacante"},{"Atleta":{"atleta_id":89898,"nome":"Róger Krug Guedes","apelido":"Róger Guedes","foto":"https://s.glbimg.com/es/sde/f/2016/05/01/50ba5f59e410f0d4a635357cb29bcdb8_FORMATO.jpeg","preco_editorial":3},"escalacoes":1058479,"clube":"PAL","escudo_clube":"https://s.glbimg.com/es/sde/f/equipes/2014/04/14/palmeiras_60x60.png","posicao":"Atacante"},{"Atleta":{"atleta_id":62977,"nome":"Paulo Henrique Chagas de Lima","apelido":"Ganso","foto":"https://s.glbimg.com/es/sde/f/2016/05/01/09e893a83d0e8dc68f184b293ac1ff81_FORMATO.png","preco_editorial":17},"escalacoes":1001081,"clube":"SAO","escudo_clube":"https://s.glbimg.com/es/sde/f/equipes/2014/04/14/sao_paulo_60x60.png","posicao":"Meia"},{"Atleta":{"atleta_id":86759,"nome":"Luan Guilherme de Jesus Vieira","apelido":"Luan","foto":"https://s.glbimg.com/es/sde/f/2016/04/30/48dd7ee31224c5846fad2dbe7a73178c_FORMATO.png","preco_editorial":14},"escalacoes":959645,"clube":"GRE","escudo_clube":"https://s.glbimg.com/es/sde/f/equipes/2014/04/14/gremio_60x60.png","posicao":"Atacante"},{"Atleta":{"atleta_id":51683,"nome":"Bruno Rangel Domingues","apelido":"Bruno Rangel","foto":"https://s.glbimg.com/es/sde/f/2016/04/27/3c7ecd662014838c83e615e22a14c643_FORMATO.png","preco_editorial":9},"escalacoes":835217,"clube":"CHA","escudo_clube":"https://s.glbimg.com/es/sde/f/equipes/2015/08/03/Escudo-Chape-165.png","posicao":"Atacante"},{"Atleta":{"atleta_id":70622,"nome":"Paulo Jorge Gomes Bento","apelido":"Paulo Bento","foto":"https://s.glbimg.com/es/sde/f/2016/05/25/4dc07b20682720e6ad26d1d7c7360e4b_FORMATO.png","preco_editorial":2.25},"escalacoes":825701,"clube":"CRU","escudo_clube":"https://s.glbimg.com/es/sde/f/equipes/2015/04/29/cruzeiro_65.png","posicao":"Técnico"},{"Atleta":{"atleta_id":38523,"nome":"Edílson Mendes Guimarães","apelido":"Edílson","foto":"https://s.glbimg.com/es/sde/f/2016/06/06/fff1e2f2c5b5ab7d1955d4863ec54bf3_FORMATO.png","preco_editorial":5},"escalacoes":796971,"clube":"GRE","escudo_clube":"https://s.glbimg.com/es/sde/f/equipes/2014/04/14/gremio_60x60.png","posicao":"Lateral"}]
';

// TRANSFORMA JSON EM ARRAY;
$destaques = json_decode($destaques_json, TRUE);

// IMPRIME ARRAY
echo '<pre>';
print_r( $destaques );
echo '</pre>';

?>
 
 </body>
</html>





