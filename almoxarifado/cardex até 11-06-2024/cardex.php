<!DOCTYPE html>
<html>
<head>
<title>Cardex</title>
<link href="css/estilo.css" rel="stylesheet">
</head>
<body>

<?php
	$id=filter_var($_GET['id'], FILTER_SANITIZE_STRING);
	$hoje = date('d/m/Y');
	
	echo "SISTEMA DO ALMOXARIFADO - R J C DEFESA AEROESPACIAL LTDA<br><br>";
	echo "<a href='index.php'><button>Voltar</button></a><br><br>";
	
	include_once "../../conexao.php";
	
	$sql_saldo = $conectar->query("SELECT
	A.COD_ITEM AS ITEM,
	B.DESCRICAO AS DESCRICAO,
	REPLACE(CONVERT(VARCHAR,CAST(((CASE WHEN C.S1TOTAL IS NULL THEN 0 ELSE C.S1TOTAL END)-(CASE WHEN D.S2TOTAL IS NULL THEN 0 ELSE D.S2TOTAL END)) AS NUMERIC(18,2)), 1),'.',',') AS SALDO,
	((CASE WHEN C.S1TOTAL IS NULL THEN 0 ELSE C.S1TOTAL END)-(CASE WHEN D.S2TOTAL IS NULL THEN 0 ELSE D.S2TOTAL END)) AS SALDO2,
	E.DESCRICAO AS TIPINV,
	B.ESTMIN AS ESTMIN
	FROM
	pcp_producao.dbo.almox_movto AS A
	LEFT JOIN FAT00001.dbo.produto AS B ON A.COD_ITEM = B.CODIGO
	LEFT JOIN FAT00001.dbo.TipoInv AS E ON B.TIPINV = E.CODIGO
	LEFT JOIN (SELECT S1.COD_ITEM AS S1ITEM, SUM(S1.QTDE) AS S1TOTAL FROM pcp_producao.dbo.almox_movto S1 WHERE S1.TP_MOVTO='E' AND S1.COD_ITEM='$id' GROUP BY S1.COD_ITEM) AS C ON A.COD_ITEM=C.S1ITEM
	LEFT JOIN (SELECT S2.COD_ITEM AS S2ITEM, SUM(S2.QTDE) AS S2TOTAL FROM pcp_producao.dbo.almox_movto S2 WHERE S2.TP_MOVTO='S' AND S2.COD_ITEM='$id' GROUP BY S2.COD_ITEM) AS D ON A.COD_ITEM=D.S2ITEM
	WHERE
	A.COD_ITEM='$id'
	GROUP BY A.COD_ITEM,B.DESCRICAO,C.S1TOTAL,D.S2TOTAL,E.DESCRICAO,B.ESTMIN
	");

	$linha1 = $sql_saldo->fetch(PDO::FETCH_ASSOC);
	$saldo_item = "$linha1[SALDO]";
	$saldo_item2 = number_format($linha1['SALDO2'],2,',', '.');
	$est_min = number_format($linha1['ESTMIN'],2,',', '.');
	
	if("$linha1[SALDO2]" <= "$linha1[ESTMIN]"){
		$corfundo = 'red';
	}else{
		$corfundo = '#fff78c';
	}
	//$corfundo = "#fff78c";
	//echo $saldo_item."TESTE<br><br>";

	echo "CARTÃO CARDEX DO ITEM:<br>
		<table id=tbordzebr>
		<tr>
			<td width='150px'>CÓDIGO</td>
			<td width='440px'>DESCRIÇÃO</td>
			<td width='130px'>SALDO</td>
			<td width='130px'>EST. MÍNIMO</td>
			<td width='200px'>INVENTARIO</td>
		</tr>
		<tr>
			<td><a href='movtofiscal.php?id=$linha1[ITEM]'>$linha1[ITEM]</a></td>
			<td>$linha1[DESCRICAO]</td>
			<td align=right>$saldo_item2</td>
			<td align=right bgcolor=$corfundo>$est_min</td>
			<td bgcolor=$corfundo>$linha1[TIPINV]</td>
		</tr>
		</table>
		";

//echo "<br><br>Temos".$saldo_item."itens em estoque<br><br>";


	echo "<br><br>Cadastrar o movimento do item:";
	//echo $hoje;
	
?>
	<form action="cadcardex.php" method="post">
	<table>
	<tr>
	<td>Data:</td>
	<td><input type="text" readonly="readonly" style="font-size: 10pt; height: 16px; width:70px;" name="data" value="<?php echo $hoje; ?>" id="data"/></td>
	<td>Qtde:</td>
	<td><input type="text" style="font-size: 10pt; height: 16px; width:90px;" name="qtde" id="qtde"/></td>
	<td>Lote:</td>
	<td><input type="text" style="font-size: 10pt; height: 16px; width:90px;" name="cod_lote" id="cod_lote"/></td>
	<td>Obs:</td>
	<td><input type="text" style="font-size: 10pt; height: 16px; width:300px;" name="observacao" id="observacao"/></td>
	<td>Movto:</td>
	<td><input type="radio" name="movto" value="E">Entrada<input type="radio" name="movto" value="S" checked>Saída</td>
	</tr>
	<input type="hidden" name="cod_item" value="<?php echo $id; ?>" id="cod_item"/>
	<input type="hidden" name="saldo_item" value="<?php echo $saldo_item; ?>" id="saldo_item"/>
	</table><br>
	<input type="submit" value="Cadastrar">
	</form><br>
<?php
	$sql = $conectar->query("SELECT
	A.ID_ALMOX AS ID_ALMOX,
	A.TP_MOVTO AS TP_MOVTO,
	CONVERT(varchar(10),A.DATA,103) as 'DATA',
	--REPLACE(CONVERT(VARCHAR,CAST(A.QTDE AS NUMERIC(18,2)), 1),'.',',') AS 'QTDE',
	A.QTDE AS QTDE,
	A.LOTE AS LOTE,
	A.OBSERVACAO AS OBSERVACAO
	FROM
	pcp_producao.dbo.almox_movto AS A
	LEFT JOIN FAT00001.dbo.produto AS B ON A.COD_ITEM=B.CODIGO
	WHERE
	A.COD_ITEM = '$id'
	ORDER BY ID_ALMOX DESC, A.DATA
");

try{
	
	echo "<table id=tbordzebr>
		<tr>
			<td>DATA</td>
			<td>MOVTO</td>
			<td>QTDE</td>
			<td>OBSERVAÇÃO</td>
			<td>LOTE</td>
			<td>ALTERAR</td>
		</tr>";
	while
	($linha = $sql->fetch(PDO::FETCH_ASSOC)) {
		$qtde = number_format($linha['QTDE'],2,',', '.');
		echo "<tr>
				<td>$linha[DATA]</td>
				<td>$linha[TP_MOVTO]</td>
				<td align=right>$qtde</td>
				<td>$linha[OBSERVACAO]</td>
				<td>$linha[LOTE]</td>
				<td>";
				if("$linha[DATA]" == $hoje){
					echo "
					<a href='formeditcardex.php?id=$linha[ID_ALMOX]'>Alterar</a>
					";
					}
				else{}
			echo "</td>
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