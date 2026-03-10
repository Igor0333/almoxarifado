<!DOCTYPE html>
<html>

<head>
<title>Almoxarifado</title>
<link href="css/estilo.css" rel="stylesheet">
</head>

<body>

<?php
	
	include_once "conexao.php";
	
	if(isset($_POST['pesquisa'])){
	$id=filter_var($_POST['pesquisa']);
	}else {
		$id='';
	}

	echo "SISTEMA DO ALMOXARIFADO - R J C DEFESA AEROESPACIAL LTDA &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp
	<a href='relatorios.php'><button>Relatórios</button></a><br><br>
	Localize o item desejado:<br>";
?>

<form action="index.php" method="POST">
<table>
<tr>
<td><label>Pesquisar: </label></td>
<td><input type="text" style="font-size: 10pt; height: 16px; width:300px;" name="pesquisa" placeholder="Digite código ou descrição do item"/></td>
<td><input type="submit" value="Buscar"></td>
<td></td>
</tr>
</table>
</form>

<?php
	//QUERY PESQUISA DE PRODUTOS
	$sql = $conectar->query("
SELECT
TOP 200
A.CODIGO AS CODIGO,
A.DESCRICAO AS DESCRICAO,
A.UNID AS UNIDADE,
REPLACE(CONVERT(VARCHAR,CAST(((CASE WHEN C.S1TOTAL IS NULL THEN 0 ELSE C.S1TOTAL END) -(CASE WHEN D.S2TOTAL IS NULL THEN 0 ELSE D.S2TOTAL END)) AS NUMERIC(18,2)), 1),'.',',') AS SALDO
FROM
FAT00001.dbo.produto AS A

LEFT JOIN (SELECT S1.COD_ITEM AS S1ITEM, SUM(S1.QTDE) AS S1TOTAL
FROM pcp_producao.dbo.almox_movto S1 
WHERE S1.TP_MOVTO='E'
-- AND S1.COD_ITEM='$id'
GROUP BY S1.COD_ITEM) AS C ON A.CODIGO=C.S1ITEM

LEFT JOIN (SELECT S2.COD_ITEM AS S2ITEM, SUM(S2.QTDE) AS S2TOTAL
FROM pcp_producao.dbo.almox_movto S2 
WHERE S2.TP_MOVTO='S' 
--AND S2.COD_ITEM='$id'
GROUP BY S2.COD_ITEM) AS D ON A.CODIGO=D.S2ITEM


WHERE CODIGO LIKE '%$id%' OR DESCRICAO LIKE '%$id%'
	
ORDER BY SALDO DESC,A.CODIGO ASC
	");
	
	/*
	$sql = $conectar->query("SELECT TOP 30
	CODIGO AS CODIGO,
	DESCRICAO AS DESCRICAO
	FROM
	FAT00001.dbo.produto
	
	WHERE CODIGO LIKE '%$id%' OR DESCRICAO LIKE '%$id%'
	ORDER BY CODIGO
	");*/


echo "<br><br>RELAÇÃO DE ITENS PESQUISADOS<br>";

try{
	
	echo "<table id=tbordprod>
		<tr>
			<td>CÓDIGO</td>
			<td>DESCRIÇÃO</td>
			<td>UNID</td>
			<td>SALDO</td>
			<td>CARDEX</td>
		</tr>";
	while
	($linha = $sql->fetch(PDO::FETCH_ASSOC)) {
		echo "<tr>
				<td>$linha[CODIGO]</td>
				<td>$linha[DESCRICAO]</td>
				<td>$linha[UNIDADE]</td>
				<td align='right'>$linha[SALDO]</td>
				<td><a href='cardex.php?id=$linha[CODIGO]'>Acessar</a></td>
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