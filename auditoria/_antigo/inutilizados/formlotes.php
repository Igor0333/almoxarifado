<!DOCTYPE html>
<html>

<head>
<title>Consulta Lotes</title>
<link href="css/estilo.css" rel="stylesheet">
</head>

<body>

<?php
	echo "Olá!!<br> Seja bem vindo ao cadastro de LOTES<br><br>";
	echo "<a href='index.php'><button>Voltar</button></a>
			<a href='formlotes.php'><button>Listar Lotes</button></a>
			<a href='formlistartransf.php'><button>Listar Transf</button></a><br><br>";
//	echo '<input type="button" value="Voltar" onClick="history.go(-1)"><br><br>';

include_once "conexao.php";

try{
	//EXECUÇÃO DA INSTRUCAO SQL
	$consulta = $conectar->query("
	SELECT
	CONVERT(varchar(10),C.DATA,103)AS EMISSAO,
	A.pedido AS PEDIDO,
	A.cod_of AS COD_OF,
	B.cod_lote AS COD_LOTE,
	B.unid AS UNID_LOTE,
	REPLACE(CONVERT(VARCHAR,CAST(B.qtde_lote AS NUMERIC(18,2)), 1),'.',',') AS 'QTDE_LOTE',
	CONVERT(varchar(10),A.prazo_of,103) AS PRAZO_OF,
	CASE WHEN COUNT(E.cod_lote) IS NULL THEN '0' ELSE COUNT(E.cod_lote) END AS QT_TRANSF
--	,COUNT(B.cod_lote) AS QT_TRANSF

	FROM
	pcp_producao.dbo.cad_of AS A
	LEFT JOIN pcp_producao.dbo.cad_lote AS B ON A.cod_of=B.cod_of
	LEFT JOIN FAT00001.dbo.pedido AS C ON C.PEDIDO=A.pedido
	LEFT JOIN (SELECT * FROM  pcp_producao.dbo.ordprod AS D) AS E ON B.cod_lote=E.cod_lote
	
	WHERE
	C.DATA>'2000-01-01'
	--AND A.cod_of='5003'
	
	GROUP BY
	C.DATA,A.pedido,A.cod_of,B.cod_lote,B.unid,B.qtde_lote,A.prazo_of
	
	ORDER BY
	A.cod_of,B.cod_lote
	");

/*	SELECT
	CONVERT(varchar(10),C.DATA,103)AS EMISSAO,
	A.pedido AS PEDIDO,
	A.cod_of AS COD_OF,
	B.cod_lote AS COD_LOTE,
	B.unid AS UNID_LOTE,
	REPLACE(CONVERT(VARCHAR,CAST(B.qtde_lote AS NUMERIC(18,2)), 1),'.',',') AS 'QTDE_LOTE',
	CONVERT(varchar(10),A.prazo_of,103) AS PRAZO_OF

	FROM
	pcp_producao.dbo.cad_of AS A
	LEFT JOIN pcp_producao.dbo.cad_lote AS B ON A.cod_of=B.cod_of
	LEFT JOIN FAT00001.dbo.pedido AS C ON C.PEDIDO=A.pedido
	
	WHERE
	C.DATA>'2000-01-01'
	ORDER BY
	A.cod_of,B.cod_lote
	*/
	
	echo "<table id=tbordprod>
		<tr>
			<td width=4%>EMISSAO</td>
			<td width=3%>O.F.</td>
			<td width=5%>LOTE</td>
			<td width=8%>QTDE LOTE</td>
			<td width=8%>No TRANSF</td>
			<td width=3%>UNIDADE</td>
			<td width=4%>PRAZO O.F.</td>
		</tr>";
	while
	($linha = $consulta->fetch(PDO::FETCH_ASSOC)) {
		echo "<tr>
				
				<td>$linha[EMISSAO]</td>
				<td>$linha[COD_OF]</td>
				<td><a href='formvisualizarof.php?id=$linha[COD_LOTE]'>$linha[COD_LOTE]</a></td>
				<td align=right>$linha[QTDE_LOTE]</td>
				<td align=right>$linha[QT_TRANSF]</td>
				<td>$linha[UNID_LOTE]</td>
				<td>$linha[PRAZO_OF]</td>
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
