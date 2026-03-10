<!DOCTYPE html>
<html>

<head>
<title>Relatórios</title>
<link href="css/estilo.css" rel="stylesheet">
</head>

<body>

<?php
	
	include_once "conexao.php";
	
	if(isset($_POST['pesquisa'])){
	$id=filter_var($_POST['pesquisa']);
	}else {
		$id='VAZIO';
	}

	echo "SISTEMA DO ALMOXARIFADO - R J C DEFESA AEROESPACIAL LTDA &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp
	<a href='index.php'><button>Cardex</button></a><br><br>
	Localize o Lote desejado:<br>";
?>

<form action="relatorios.php" method="POST">
<table>
<tr>
<td><label>Pesquisar: </label></td>
<td><input type="text" style="font-size: 10pt; height: 16px; width:300px;" name="pesquisa" placeholder="Digite Lote"/></td>
<td><input type="submit" value="Buscar"></td>
<td></td>
</tr>
</table>
</form>

<?php
	//QUERY PESQUISA DE PRODUTOS
	$sql = $conectar->query("
	SELECT
A.LOTE AS LOTE,
CONVERT(varchar(10),A.DATA,103) as DATA,
A.COD_ITEM AS CODIGO,
B.DESCRICAO AS DESCRICAO,
B.UNID AS UNIDADE,
REPLACE(CONVERT(VARCHAR,CAST(A.QTDE AS NUMERIC(18,2)), 1),'.',',') AS QTDE,
REPLACE(CONVERT(VARCHAR,CAST(B.PREMED AS NUMERIC(18,2)), 1),'.',',') AS CUNIT,
REPLACE(CONVERT(VARCHAR,CAST(A.QTDE*B.PREMED AS NUMERIC(18,2)), 1),'.',',') AS CITEM,
A.OBSERVACAO AS OBSERVACAO,
A.TP_MOVTO AS TIPO
FROM
pcp_producao.dbo.almox_movto AS A
LEFT JOIN FAT00001.dbo.produto AS B ON A.COD_ITEM=B.CODIGO
WHERE LOTE LIKE '%$id%'
ORDER BY A.DATA
	");
	

echo "<br><br>RELAÇÃO DO ITENS DO LOTE:<br>";

try{
	
	echo "<table id=tbordprod>
		<tr>
			<td>LOTE</td>
			<td>DATA</td>
			<td>CÓDIGO</td>
			<td>DESCRIÇÃO</td>
			<td>UN</td>
			<td>QTDE</td>
			<td>C. UNIT</td>
			<td>C. ITEM</td>
			<td>OBSERVAÇÃO</td>
			<td>E/S</td>
		</tr>";
	while
	($linha = $sql->fetch(PDO::FETCH_ASSOC)) {
		echo "<tr>
				<td>$linha[LOTE]</td>
				<td>$linha[DATA]</td>
				<td>$linha[CODIGO]</td>
				<td>$linha[DESCRICAO]</td>
				<td>$linha[UNIDADE]</td>
				<td align='right'>$linha[QTDE]</td>
				<td align='right'>$linha[CUNIT]</td>
				<td align='right'>$linha[CITEM]</td>
				<td>$linha[OBSERVACAO]</td>
				<td>$linha[TIPO]</td>
			</tr>";
	}
	echo "</table>";
	
	echo $sql->rowCount() . " Registros Exibidos";
}catch(PDOExceprion $e){
	echo $e->getMessasge();
}

?>
</body>

</html>