<!DOCTYPE html>
<html>

<head>
<title>Editar O.F.</title>
<link href="css/estilo.css" rel="stylesheet">
</head>

<body>

<?php
	//echo '<input type="button" value="Voltar" onClick="history.go(-1)"><br><br>';
	echo "<a href='formof.php'><button>Voltar</button></a><br><br>";
	
	include_once "conexao.php";
	
	$id=filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
	//echo "numero pedido".$id;
	echo "Olá!!<br><br> Altere a ORDEM DE FABRICAÇÃO:";
	//QUERY DAS OF
	$sql = $conectar->query("SELECT
A.PEDIDO AS 'PED_ORIGINAL',
A.DATENT AS 'PRAZO_PED',
A.RAZAO AS 'CLIENTE',
CONVERT(varchar(10),A.DATENT,103) AS PRAZO_OF,
B.cod_of AS 'COD_OF'

FROM FAT00001.dbo.pedido AS A
LEFT JOIN pcp_producao.dbo.cad_of AS B ON A.PEDIDO = B.pedido

WHERE
A.pedido = '$id'
");
	$row = $sql->fetch(PDO::FETCH_ASSOC);
	
	//QUERY DOS LOTES
	
	$sql_lote = $conectar->query("SELECT
A.pedido AS 'PEDIDO',
A.cod_of AS 'COD_OF_LOTE',
B.cod_lote AS 'COD_LOTE',
CONVERT(varchar(10),B.prazo_lote,103) as 'PRAZO_LOTE',
REPLACE(CONVERT(VARCHAR,CAST(B.qtde_lote AS NUMERIC(18,2)), 1),'.',',') AS 'QTDE_LOTE',
B.unid AS UNID_LOTE

FROM pcp_producao.dbo.cad_of AS A
LEFT JOIN pcp_producao.dbo.cad_lote AS B ON A.cod_of = B.cod_of

WHERE
A.pedido = '$id'
");

	
?>

<form action="editarof.php" method="post">
<table>
<tr>
<td>Número O.F.:</td>
<td><input type="text" style="font-size: 10pt; height: 16px; width:90px;" name="codigo_of" id="codigo_of"/></td>
</tr>
<tr>
<td>Pedido:</td>
<td><input type="text" readonly="readonly" style="font-size: 10pt; height: 16px; width:90px;" name="pedido" value="<?php echo $row['PED_ORIGINAL'] ?>" id="pedido"/></td>
</tr>
<tr>
<td>Prazo:</td>
<td><input type="text" readonly="readonly" style="font-size: 10pt; height: 16px; width:120px;" value="<?php echo $row['PRAZO_OF'] ?>"/></td>
</tr>
<tr>
<td>Cliente:</td>
<td><input type="text" readonly="readonly" style="font-size: 10pt; height: 16px; width:400px;" value="<?php echo $row['CLIENTE'] ?>"/></td>
</tr>
</table>
<input type="hidden" name="prazo_of" value="<?php echo $row['PRAZO_PED'] ?>" id="prazo_of"/>
<br>
<input type="submit" value="Alterar"><br>
</form>


<?php
echo '<br><br>Abaixo os lotes da O.F.: '.$row['COD_OF'].'<br>';


?>

<form action="cadastrarlote.php" method="post">
<table>
<tr>
<td>Lote:</td>
<td><input type="text" style="font-size: 10pt; height: 16px; width:90px;" name="cod_lote" id="cod_lote"/></td>
<td>Quantidade:</td>
<td><input type="number" style="font-size: 10pt; height: 16px; width:90px;" name="qtde_lote" id="qtde_lote"/></td>
<td>Unidade:</td>
<td><input type="text" style="font-size: 10pt; height: 16px; width:50px;" name="unid_lote" id="unid_lote"/></td>
<td>Prazo:</td>
<td><input type="date" style="font-size: 10pt; height: 16px; width:150px;" name="prazo_lote" id="prazo_lote"/></td>
<td><input type="hidden" name="cod_of" value="<?php echo $row['COD_OF'] ?>" id="cod_of"/>
<input type="hidden" name="pedido" value="<?php echo $row['PED_ORIGINAL'] ?>" id="pedido"/></td>
<td><input type="submit" value="Cadastrar"></td>
</tr>
</table>
</form>
<?php

try{
	
	echo "<table id=tbordprod>
		<tr>
			<td width=3%>O.F.</td>
			<td width=4%>Lote</td>
			<td width=5%>Prazo Lote</td>
			<td width=5%>Quantidade</td>
			<td width=5%>Unidade</td>
		</tr>";
	while
	($linha = $sql_lote->fetch(PDO::FETCH_ASSOC)) {
		echo "<tr>
				<td>$linha[COD_OF_LOTE]</td>
				<td>$linha[COD_LOTE]</td>
				<td>$linha[PRAZO_LOTE]</td>
				<td>$linha[QTDE_LOTE]</td>
				<td>$linha[UNID_LOTE]</td>
			</tr>";
	}
	echo "</table>";
	
	echo $sql_lote->rowCount() . " Registros Exibidos";
}catch(PDOExceprion $e){
	echo $e->getMessasge();
}
?>
</body>

</html>



<?php
/*
Pedido: <select name='pedido'>

OF: <input type="text" name="codigo_of" id="codigo_of" /><br/>
Data: <input type="text" name="data_of" id="data_of"/><br/>

// . $row[DATA_PED] . $row[CLIENTE]
while ($row = $sql->fetch(PDO::FETCH_ASSOC)) { ?>
<option id="pedido_of" name="pedido_of" value="<?php echo $row['PED_ORIGINAL'] ?>"> <?php echo $row['PED_ORIGINAL'] ?></option>


<?php };*/
?>