<!DOCTYPE html>
<html>

<head>
<title>Ordem de Fabricação em Aberto</title>
<link href="css/estilo.css" rel="stylesheet">
</head>

<body>

<?php
	echo "Olá!!<br> Seja bem vindo ao cadastro de PEDIDOS e ORDEM DE FABRICAÇÃO<br><br>";
	echo "<a href='formof.php'><button>Em Processo</button></a>
			<a href='formof.php'><button>Fechado</button></a>
			<a href='index.php'><button>Voltar</button></a><br><br>";
//	echo '<input type="button" value="Voltar" onClick="history.go(-1)"><br><br>';

include_once "conexao.php";

try{
	//EXECUÇÃO DA INSTRUCAO SQL
	$consulta = $conectar->query("SELECT
	A.PEDIDO AS 'PEDIDO',
	CONVERT(varchar(10),A.DATA,103) AS 'EMISSAO',
	A.RAZAO AS 'CLIENTE',
	A.OBS_PED+' '+A.OBS2_PED+' '+A.OBS3_PED+' '+A.OBS4_PED+' '+A.OBS5_PED+' '+A.OBS6_PED AS OBS_PEDIDO,
	A.OBS7_PED+' '+A.OBS8_PED AS 'OBS_PCP',
	B.cod_of as 'NRO_OF',
	C.QTDE_LOTE AS QT_LOTE,
	CONVERT(varchar(10),B.prazo_of,103) AS 'PRAZO_OF'

	FROM
	FAT00001.dbo.pedido AS A
	LEFT JOIN pcp_producao.dbo.cad_of AS B ON A.PEDIDO=B.pedido
	LEFT JOIN (	SELECT LT.cod_of AS CODOF,COUNT(LT.cod_lote) AS QTDE_LOTE FROM pcp_producao.dbo.cad_lote AS LT GROUP BY LT.cod_of,LT.cod_of) AS C ON B.cod_of=C.CODOF

	WHERE
	A.DATA>'2017-01-01'
	--A.FECHADO!='F'

	ORDER BY
	B.cod_of,A.PEDIDO
	");
	
	echo "<table id=tbordprod>
		<tr>
			<td width=3%>Pedido</td>
			<td width=4%>Dt. Pedido</td>
			<td width=15%>Razão</td>
			<td width=20%>Observação Comercial</td>
			<td width=20%>Observação para PCP</td>
			<td width=3%>O.F.</td>
			<td width=3%>Lotes</td>
			<td width=4%>Prazo</td>
		</tr>";
	while
	($linha = $consulta->fetch(PDO::FETCH_ASSOC)) {
		echo "<tr>
				<td><a href='formcadastrarof.php?id=$linha[PEDIDO]'>$linha[PEDIDO]</a></td>
				<td>$linha[EMISSAO]</td>
				<td>$linha[CLIENTE]</td>
				<td>$linha[OBS_PEDIDO]</td>
				<td>$linha[OBS_PCP]</td>
				<td><a href='formeditarof.php?id=$linha[PEDIDO]'>$linha[NRO_OF]</a></td>
				<td>$linha[QT_LOTE]</td>
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
