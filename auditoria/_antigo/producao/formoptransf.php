<!DOCTYPE html>
<html>

<head>
<title>Status O.P. em aberta</title>
<link href="../css/estilo.css" rel="stylesheet">
</head>

<body>


<?php
	echo "Olá!!<br> Seja bem vindo ao relatório de Transferências da O.P.<br><br>";
	//echo '<input type="button" value="Voltar" onClick="history.go(-1)"><br><br>';
	echo "<a href='formordprod.php'><button>Voltar</button></a><br><br>";

include_once "../conexao.php";


try{
	//EXECUÇÃO DA INSTRUCAO SQL
	$id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

	$consulta = $conectar->query("SELECT
CONVERT(VARCHAR(10),A.DATA,103) AS DATA,
A.CODTRANS AS TRANSF,
A.CODPROD AS CODIGO,
A.DESCRICAO AS DESCR,
REPLACE(CONVERT(varchar,CAST(A.QTDE AS NUMERIC(18,2)), 1),'.',',') AS QTDE,
B.OBSERVACAO AS OBS,
B.CODCUS AS CODCUS,
CASE WHEN C.cod_lote<>'' THEN C.cod_lote ELSE 'Incluir' END AS COD_LOTE

FROM
FAT00001.dbo.Transf2 AS A,
FAT00001.dbo.Transf1 AS B
LEFT OUTER JOIN
pcp_producao.dbo.ordprod AS C ON C.transf_op=B.CODTRANS
LEFT OUTER JOIN
pcp_producao.dbo.cad_lote AS D ON C.cod_lote=D.cod_lote

WHERE
A.CODTRANS=B.CODTRANS AND A.CODOP='{$id}'

ORDER BY A.DATA");
	echo "Ordem de Produção No:  ".$id;
	echo "<table id=tbordzebr>
		<tr>
			<td width=5%>Data</td>
			<td width=5%>No Transf</td>
			<td width=6%>Código</td>
			<td width=30%>Descrição Produto</td>
			<td width=5%>Quantidade</td>
			<td width=30%>Observação</td>
			<td width=6%>C. Custo</td>
			<td width=6%>Lote</td>
		</tr>";
	while
	($linha = $consulta->fetch(PDO::FETCH_ASSOC)) {
		echo "<tr>
				<td>$linha[DATA]</td>
				<td>$linha[TRANSF]</td>
				<td>$linha[CODIGO]</td>
				<td>$linha[DESCR]</td>
				<td align=right>$linha[QTDE]</td>
				<td>$linha[OBS]</td>
				<td>$linha[CODCUS]</td>
				<td><a href='formcadastrartransf.php?id=$linha[TRANSF]'>$linha[COD_LOTE]</a></td>
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
