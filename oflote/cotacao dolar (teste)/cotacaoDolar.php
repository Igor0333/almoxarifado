<?php
/*
  cotacaoDolar.php - script usado para extrair a cota��o atual do d�lar junto ao
  banco central do governo federal

  Autor: F�bio Berbert de Paula <fabio@vivaolinux.com.br>
  http://www.vivaolinux.com.br
*/

// o fopen tamb�m funciona para arquivos da rede, uau !
if(!$fp=fopen("http://www4.bcb.gov.br/pec/taxas/batch/taxas.asp?id=txdolar&id=txdolar" ,"r" )) {
    echo "Erro ao abrir a página de cotação" ;
    exit ;
}
  
$conteudo = '';
while(!feof($fp)) { // leia o conteúdo da página
   $conteudo .= fgets($fp,1024);
}
fclose($fp);

/*
  Na expressão regular abaixo pego os dois números que tem o seguinte formato:
  9,9999 (ex.: 2,8182)
  O primeiro número é a taxa de compra e o segunda, taxa de venda
*/
//eregi("([0-9],[0-9]{4}).*([0-9],[0-9]{4})",$conteudo,$saida);
//list($lixo,$taxaCompra,$taxaVenda) = $saida;

preg_match("/([0-9],[0-9]{2,}).*([0-9],[0-9]{2,})/", $conteudo, $saida);
$taxaCompra = $saida[1];
$taxaVenda = $saida[2];
echo "
<h3>Cota&ccedil;&atilde;o atual do d&oacute;lar</h3>
Taxa de compra: <b>$taxaCompra</b><br>
Taxa de venda : <b>$taxaVenda</b><br>
</pre>
";
?> 

