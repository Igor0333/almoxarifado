<!DOCTYPE html>
<html>
<head>
<title>Editar Cardex</title>
<link href="css/estilo.css" rel="stylesheet">
</head>
<body>

<?php
	include_once "../../conexao.php";

	$id=filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
	
	
	//QUERY DO CARDEX
	$sql = $conectar->query("SELECT
	A.ID_ALMOX AS ID_ALMOX,
	A.COD_ITEM AS COD_ITEM,
	B.DESCRICAO AS DESCRICAO,
	A.TP_MOVTO AS TP_MOVTO,
	CONVERT(varchar(10),A.DATA,103) as DATA,
	REPLACE(CONVERT(VARCHAR,CAST(A.QTDE AS NUMERIC(18,2)), 1),'.',',') AS QTDE,
	A.LOTE AS LOTE,
	A.OBSERVACAO AS OBSERVACAO
	FROM
	pcp_producao.dbo.almox_movto AS A
	LEFT JOIN FAT00001.dbo.produto AS B ON A.COD_ITEM=B.CODIGO
	WHERE
	A.ID_ALMOX = '$id'
	");
	
	$row = $sql->fetch(PDO::FETCH_ASSOC);
	$codigo = "$row[COD_ITEM]";
	$tp_movimento = "$row[TP_MOVTO]";

	echo "R J C DEFESA E AEROESPACIAL LTDA<br>
	<a href='cardex.php?id=$codigo'><button>Voltar</button></a><br><br>";
	//echo '<input type="button" value="Voltar" onClick="history.go(-1)"><br><br>';
	echo "Altere o lançamento CARDEX:<br><br>";

	echo "<form action='editcardex.php' method='post'>
	<table>
	<tr>
	<td>Código</td>
	<td><input type='text' readonly='readonly' name='cod_item' id='cod_item' style='font-size: 10pt; height: 16px; width:150px;' value='$row[COD_ITEM]'/></td>
	</tr><tr>
	<td>Descrição:</td>
	<td><input type='text' readonly='readonly' style='font-size: 10pt; height: 16px; width:600px;'value='$row[DESCRICAO]'/></td>
	</tr><tr>
	<td>Quantidade:</td>
	<td><input type='text' name='qtde' id='qtde' style='font-size: 10pt; height: 16px; width:150px;' value='$row[QTDE]'/></td>
	</tr>
	<tr>
	<td>Lote:</td>
	<td><input type='text' name='cod_lote' id='cod_lote'  style='font-size: 10pt; height: 16px; width:150px;' value='$row[LOTE]'/></td>
	</tr>
	<tr>
	<td>Observação:</td>
	<td><input type='text'  name='observacao' id='observacao'  style='font-size: 10pt; height: 16px; width:600px;' value='$row[OBSERVACAO]'/></td>
	</tr>
	<tr>
	<td>Movimento:</td><td>";
	if($tp_movimento === 'E'){
		echo "<input type='radio' name='movto' value='E' checked>Entrada<input type='radio' name='movto' value='S'>Saída</td>";
	}else{
		echo "<input type='radio' name='movto' value='E'>Entrada<input type='radio' name='movto' value='S' checked>Saída</td>";
	}
	echo "</tr>
	<tr>
	<td>Alterar ou Excluir?:</td>
	<td><select name='acao' id='acao'>
	<option value='A'>Alterar</option>
	<option value='E'>Excluir</option>
	</select></td></tr>
	</table>
	<input type='hidden' name='id_almox' value='$row[ID_ALMOX]' id='id_almox'/>
	<br>
	<input type='submit' value='Alterar'><br>
	</form>
	";
?>

<br>
</body>
</html>