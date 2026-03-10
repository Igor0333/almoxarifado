<!DOCTYPE html>
<html>

<head>
<title>Ordem de Produção Fechada</title>
<link href="../css/estilo.css" rel="stylesheet">
</head>

<body>

<?php
	echo "Olá!!<br> Seja bem vindo ao cadastro de Ordem de Produção<br><br>";
	echo "<a href='formordprod.php'><button>O.P. Aberta</button></a>
			<a href='formordprodf.php'><button>O.P. Fechada</button></a>
			<a href='formlistartransf.php'><button>Transf Aberta</button></a>
			<a href='formlistartopf.php'><button>Consultar Transf</button></a>
			<a href='../index.php'><button>Voltar</button></a><br><br>";	

include_once "../conexao.php";

try{
	//EXECUÇÃO DA INSTRUCAO SQL
	$consulta = $conectar->query("SELECT
CONVERT(VARCHAR(10),A.DATA,103) AS 'DATA',
A.CODIGO AS 'CODIGO',
A.STATUS AS 'STATUS',
(A.OBSERVACAO+' '+A.OBSERVACAO2) AS 'OBSERVACAO',
REPLACE(CONVERT(VARCHAR,CAST(SUM(B.QTDE) AS NUMERIC(18,2)), 1),'.',',') AS 'QTDE',
C.sit_sgq AS 'SITUACAO',
CONVERT(VARCHAR(10),C.dt_conferencia,103) AS 'DATASGQ',
C.obs_sgq AS 'OBSSGQ'
FROM
FAT00001.dbo.CadOP1 AS A LEFT JOIN pcp_producao.dbo.sgqstatus AS C ON A.CODIGO=C.cod_op,FAT00001.dbo.CadOP2 AS B
WHERE
A.CODIGO=B.CODIGO
AND A.STATUS='F'
AND A.DATA >= DATEADD(DAY, -720, GETDATE()) 
GROUP BY A.DATA,A.CODIGO,A.STATUS,A.OBSERVACAO,A.OBSERVACAO2,C.sit_sgq,C.dt_conferencia,C.obs_sgq
ORDER BY A.DATA DESC,A.CODIGO DESC
");
	
	echo "<table id=tbordzebr>
		<tr>
			<td>Data</td>
			<td>O.P.</td>
			<td>Observação</td>
			<td>Status</td>
			<td>Imprimir</td>
			<td>Transferência</td>
			<td>Quantidade</td>
			<td>Editar</td>
			<td>Sit. SGQ</td>
			<td>Data SGQ</td>
			<td>Obs. SGQ</td>
		</tr>";
	while
	($linha = $consulta->fetch(PDO::FETCH_ASSOC)) {
		echo "<tr>
				<td>$linha[DATA]</td>
				<td>$linha[CODIGO]</td>
				<td>$linha[OBSERVACAO]</td>
				<td>$linha[STATUS]</td>
				<td><a href='formordprodvis.php?id=$linha[CODIGO]'>Imprimir</a></td>
				<td><a href='formoptransf.php?id=$linha[CODIGO]'>Consultar</a></td>
				<td align=right>$linha[QTDE]</td>
				
				<td>Editar</td>
				<!-- <td><a href='formcadsgq.php?id=$linha[CODIGO]'>Editar</a></td> -->
				
				<td>$linha[SITUACAO]</td>
				<td>$linha[DATASGQ]</td>
				<td>$linha[OBSSGQ]</td>
				
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
