<!DOCTYPE html>
<html>

<head>
<title>Ordem de Produção Aberta</title>
<link href="css/estilo.css" rel="stylesheet">
</head>

<body>

<?php
	echo "Olá!!<br> Seja bem vindo ao cadastro de Ordem de Produção<br><br>";
	echo "<a href='formordprod.php'><button>O.P. Aberta</button></a>
	<a href='formordprodf.php'><button>O.P. Fechada</button></a>
	<a href='index.php'><button>Voltar</button></a><br><br>";	

include_once "conexao.php";

try{
	//EXECUÇÃO DA INSTRUCAO SQL
	$consulta = $conectar->query("SELECT
CONVERT(VARCHAR(10),A.DATA,103) AS 'DATA',
A.CODIGO AS 'CODIGO',
CASE WHEN A.STATUS = '' THEN 'A' ELSE 'P' END AS 'STATUS',
(A.OBSERVACAO+' '+A.OBSERVACAO2) AS 'OBSERVACAO',
REPLACE(CONVERT(VARCHAR,CAST(SUM(B.QTDE) AS NUMERIC(18,2)), 1),'.',',') AS 'QTDE',
REPLACE(CONVERT(VARCHAR,CAST(SUM(B.QTDBAIX) AS NUMERIC(18,2)), 1),'.',',') AS 'QTDBAIX'

FROM
FAT00001.dbo.CadOP1 AS A,FAT00001.dbo.CadOP2 AS B

WHERE
A.CODIGO=B.CODIGO
AND A.STATUS<>'F'

GROUP BY A.DATA,A.CODIGO,A.STATUS,A.OBSERVACAO,A.OBSERVACAO2
ORDER BY A.DATA DESC,A.CODIGO DESC");
	
	echo "<table id=tbordprod>
		<tr>
			<td>Data</td>
			<td>O.P.</td>
			<td>Observação</td>
			<td>Status</td>
			<td>Imprimir</td>
			<td>Transf OP</td>
			<td>Qt. na OP</td>
			<td>Baixada</td>
		</tr>";
	while
	($linha = $consulta->fetch(PDO::FETCH_ASSOC)) {
		echo "<tr>
				<td>$linha[DATA]</td>
				<td>$linha[CODIGO]</td>
				<td>$linha[OBSERVACAO]</td>
				<td><a href='formopstatus.php?id=$linha[CODIGO]'>$linha[STATUS]</a></td>
				<td><a href='formordprodvis.php?id=$linha[CODIGO]'>Imprimir</a></td>
				<td><a href='formoptransf.php?id=$linha[CODIGO]'>Consultar</a></td>
				<td align=right>$linha[QTDE]</td>
				<td align=right>$linha[QTDBAIX]</td>
			</tr>";
	}
	echo "</table>";
	
	echo $consulta->rowCount() . " Registros Exibidos";
}catch(PDOExceprion $e){
	echo $e->getMessasge();
}
?>

</body>

</html>
