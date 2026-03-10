<!DOCTYPE html>
<html>

<head>
<title>Cadastrar O.F.</title>
<link href="../css/estilo.css" rel="stylesheet">
</head>

<body>

<?php
	echo "Olá!!<br> Cadastre ou altere a ORDEM DE FABRICAÇÃO<br>
	** verifique se existe lote cadastrado, só é possível alterar se não houver nenhum lote vinculado **
	<br><br><br>";
	echo '<input type="button" value="Voltar" onClick="history.go(-1)"><br><br>';
	
	include_once "../conexao.php";
	
	$id=filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
	//echo "numero pedido".$id;
	
	$sql = $conectar->query("SELECT
A.PEDIDO AS 'PED_ORIGINAL',
A.DATENT AS 'PRAZO_PED',
A.RAZAO AS 'CLIENTE',
CONVERT(varchar(10),A.DATENT,103) AS PRAZO_OF

FROM FAT00001.dbo.pedido AS A
LEFT JOIN pcp_producao.dbo.cad_of AS B ON A.PEDIDO = B.pedido

WHERE
A.pedido = '$id'
");
	$row = $sql->fetch(PDO::FETCH_ASSOC);
	
?>


<form action="cadastrarof.php" method="post">
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
<input type="submit" value="Cadastrar/Alterar"><br>
</form>

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