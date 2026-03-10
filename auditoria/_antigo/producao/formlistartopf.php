<!DOCTYPE html>
<html>

<head>
<title>Lista de Transferências</title>
<link href="../css/estilo.css" rel="stylesheet">
</head>

<body>

<?php
	echo "Olá!!<br> Seja bem vindo a lista de Transferências das O.P. com seus respectivos LOTES<br><br>";
	echo "<a href='formordprod.php'><button>O.P. Aberta</button></a>
			<a href='formordprodf.php'><button>O.P. Fechada</button></a>
			<a href='formlistartransf.php'><button>Transf Aberta</button></a>
			<a href='formlistartopf.php'><button>Consultar Transf</button></a>
			<a href='../index.php'><button>Voltar</button></a><br><br>";
			
//	echo '<input type="button" value="Voltar" onClick="history.go(-1)"><br><br>';

include_once "../conexao.php";

try{
	//EXECUÇÃO DA INSTRUCAO SQL
	$consulta = $conectar->query("SELECT
CONVERT(varchar(10),A.DATATU,103) AS 'DATATRANSF',
A.CODTRANS AS CODTRANS,
A.CODOP AS CODOP,
A.CODCUS AS CCUSTO,
CASE WHEN A.CODTRANS=B.transf_op THEN B.cod_lote ELSE 'Cadastrar' END AS 'CODLOTE',
B.cod_predio AS PREDIO,
A.OBSERVACAO AS OBSERVACAO
FROM
FAT00001.dbo.Transf1 AS A 
LEFT JOIN pcp_producao.dbo.ordprod AS B ON A.CODTRANS=B.transf_op
WHERE B.cod_lote IS NOT NULL
ORDER BY A.DATATU DESC
	");
	
	echo "<table id=tbordzebr>
		<tr>
			<td width=4%>DT TRANSF</td>
			<td width=3%>TRANSF</td>
			<td width=3%>O.P.</td>
			<td width=4%>C CUSTO</td>
			<td width=3%>LOTE</td>
			<td width=3%>PREDIO</td>
			<td width=20%>OBSERVAÇÃO</td>
			
		</tr>";
	while
	($linha = $consulta->fetch(PDO::FETCH_ASSOC)) {
		echo "<tr>
				<td>$linha[DATATRANSF]</td>
				<td>$linha[CODTRANS]</td>
				<td>$linha[CODOP]</td>
				<td>$linha[CCUSTO]</td>
				<td>$linha[CODLOTE]</a></td>
				<td>$linha[PREDIO]</td>
				<td>$linha[OBSERVACAO]</td>
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
