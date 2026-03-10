<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Movimento</title>
	<link href="../css/estilo.css" rel="stylesheet">
</head>

<body>

<?php
	//echo "<a href="index.php"><button>Voltar</button></a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp<br><a href="index.php"><button>Voltar</button></a>";
	
	$hoje = date('d/m/Y');
	echo "<b>R J C DEFESA E AEROESPACIAL LTDA</b><br><br>";
	echo "<center><b>Movimentação do estoque</b></center><br><br>";
	echo '<b>Data emissão: </b>' . $hoje;
	echo "<br><br>";

include_once "../conexao.php";

//$id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
//echo $id;

try{
	//EXECUÇÃO DA INSTRUCAO SQL
	$id = filter_var($_GET['id'], FILTER_SANITIZE_STRING);

	$consulta = $conectar->query("SELECT
	convert(varchar(10),A.DATA,103) AS 'EMISSAO',
	A.NOTA AS NOTA,
	A.RAZAO AS RAZAO,
	A.OBSSAI AS OBSSAI,
	A.PROD AS CODIGO,
	REPLACE(CONVERT(VARCHAR,CAST(A.QUANT AS NUMERIC(18,5)), 1),'.',',') AS QTDE,
	A.DESCRICAO AS DESCRICAO
	FROM FAT00001.dbo.movto AS A
	WHERE
	A.DATA >= DATEADD(MM, DATEDIFF(mm,0,GETDATE()) -3, 0)
	AND A.PROD='{$id}'
	ORDER BY A.DATA
	");
echo "<table id=tbordprod>
<tr>
	<td>DATA</td>
	<td>NOTA</td>
	<td>RAZÃO SOCIAL</td>
	<td>OBSERVAÇÃO</td>
	<td>CODIGO</td>
	<td>QUANTIDADE</td>
	<td>DESCRICAO</td>
</tr>";

	while
	($linha = $consulta->fetch(PDO::FETCH_ASSOC)) {
echo "<tr>
		<td>$linha[EMISSAO]</td>
		<td>$linha[NOTA]</td>
		<td>$linha[RAZAO]</td>
		<td>$linha[OBSSAI]</td>
		<td>$linha[CODIGO]</td>
		<td>$linha[QTDE]</td>
		<td>$linha[DESCRICAO]</td>
	</tr>";
}
echo "</table>";

echo $consulta->rowCount() . " Registros Exibidos";
}catch(PDOExceprion $e){
echo $e->getMessasge();
}
		
//<td><a href='formeditproduto.php?id=$linha[id]'>Editar</a> - <a href='excluirproduto.php?id=$linha[id]'>Excluir</a></td>

?>

</body>

</html>
