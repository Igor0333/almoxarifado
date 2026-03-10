<!DOCTYPE html>
<html>

<head>
<title>Cadastro de Produtos</title>
<link href="../css/estilo.css" rel="stylesheet">
</head>

<body>

<?php
	echo "Olá!!<br> Seja bem vindo ao cadastro de Produtos<br><br>";
	echo "<a href='../index.php'><button>Voltar</button></a><br><br>";	



include_once "../conexao.php";

try{
	//EXECUÇÃO DA INSTRUCAO SQL
	$consulta = $conectar->query("SELECT
A.CODIGO AS PROD,
A.GRUPO AS GRUPO,
A.UNID AS UNID,
C.DESCRICAO AS SUBGRUPO,
A.DESCRICAO AS DESCRICAO,
REPLACE(CONVERT(VARCHAR,CAST(A.QUANT AS NUMERIC(18,5)), 1),'.',',') AS 'SALDOCONT',
REPLACE(CONVERT(VARCHAR,CAST(B.SOMAOP AS NUMERIC(18,5)), 1),'.',',') AS 'EMPROCESSO',
REPLACE(CONVERT(VARCHAR,CAST((A.QUANT-B.SOMAOP) AS NUMERIC(18,5)), 1),'.',',') AS 'DISPONIVEL'

FROM
FAT00001.dbo.produto AS A
LEFT JOIN(SELECT OP3.CODIGO_MP,SUM(OP3.QTDETEMP2) AS SOMAOP FROM FAT00001.dbo.CadOp1 AS OP1,FAT00001.dbo.CadOp3 AS OP3
WHERE OP1.CODIGO=OP3.CODIGO_OP AND OP1.STATUS<>'F' GROUP BY OP3.CODIGO_MP) AS B ON A.CODIGO=B.CODIGO_MP
LEFT JOIN(SELECT SB.CODIGO,SB.DESCRICAO FROM FAT00001.dbo.SubGrupo AS SB) AS C ON A.SUBGRUPO=C.CODIGO
WHERE A.GRUPO IN ('01','') AND A.ATIVO='Sim'
GROUP BY A.CODIGO,A.GRUPO,A.UNID,C.DESCRICAO,A.DESCRICAO,A.QUANT,B.SOMAOP
ORDER BY A.GRUPO,C.DESCRICAO,A.CODIGO

		");

	echo "<table id=tbordprod>
		<tr>
			<td width=10%>CODIGO</td>
			<td width=30%>DESCRIÇÃO</td>
			<td width=10%>GRUPO</td>
			<td width=5%>UNID</td>
			<td width=15%>SDO CONTÁBIL</td>
			<td width=15%>EM PROCESSO</td>
			<td width=15%>SDO DISPONÍVEL</td>
		</tr>";
	while
	($linha = $consulta->fetch(PDO::FETCH_ASSOC)) {
		echo "<tr>
				<td >$linha[PROD]</td>
				<td >$linha[DESCRICAO]</td>
				<td >$linha[SUBGRUPO]</td>
				<td >$linha[UNID]</td>
				<td class=tdright width=15%>$linha[SALDOCONT]</td>
				<td class=tdright width=15%>$linha[EMPROCESSO]</td>
				<td class=tdright width=15%>$linha[DISPONIVEL]</td>
				";
	}
	echo "</table>";
	
	echo $consulta->rowCount() . " Registros Exibidos";
}catch(PDOExceprion $e){
	echo $e->getMessasge();
}

?>

</body>

</html>
