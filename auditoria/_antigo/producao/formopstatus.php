<!DOCTYPE html>
<html>

<head>
<title>Status O.P. em aberta</title>
<link href="../css/estilo.css" rel="stylesheet">
</head>

<body>


<?php
	echo "Olá!!<br> Seja bem vindo ao relatório de Itens da O.P. em Aberto com saldo disponível da Matéria Prima<br><br>";
	//echo "<a href='formcadastrarproduto.php'><button>Cadastrar Produto Novo</button></a>  ";
	echo "<a href='formordprod.php'><button>Voltar</button></a><br><br>";


include_once "../conexao.php";


try{
	//EXECUÇÃO DA INSTRUCAO SQL
	$id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

	$consulta = $conectar->query("SELECT
	B.CODIGO AS NROP,
	B.ITEM AS ITEM,
	B.UNID AS UNIDADE,
	B.CODPROD AS CODPRODFINAL,
	B.DESCRICAO AS DESCPRODFINAL,
	REPLACE(CONVERT(varchar,CAST(B.QTDE AS NUMERIC(18,2)), 1),'.',',') AS QTDEPRODFINAL
	FROM
	FAT00001.dbo.CadOP1 AS A,
	FAT00001.dbo.CadOp2 AS B
	WHERE
	A.CODIGO=B.CODIGO
	AND A.CODIGO = '{$id}'");
	
	echo "<table id=tbordprod>
		<tr>
			<td width=5%>No. OP</td>
			<td width=5%>Item</td>
			<td width=5%>Unid</td>
			<td width=10%>Código PF</td>
			<td width=40%>Produto Final</td>
			<td width=10%>Quantidade</td>
		</tr>";
	while
	($linha = $consulta->fetch(PDO::FETCH_ASSOC)) {
		echo "<tr>
				<td>$linha[NROP]</td>
				<td>$linha[ITEM]</td>
				<td>$linha[UNIDADE]</td>
				<td>$linha[CODPRODFINAL]</td>
				<td>$linha[DESCPRODFINAL]</td>
				<td align=right>$linha[QTDEPRODFINAL]</td>
			</tr>";
	}
	echo "</table>";
	
	
	echo $consulta->rowCount() . " Registros Exibidos";
}catch(PDOExceprion $e){
	echo $e->getMessasge();
}




//RELACAO DE MATERIA PRIMA
try{
	//RECEBE O NUMERO DA OP DO FUMULARIO
	$id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

	//EXECUÇÃO DA INSTRUCAO SQL
	$relmp = $conectar->query("SELECT
	B.ITEM AS ITEMMP,
	B.CODIGO_MP AS CODIGOMP,
	B.DESCRICAO_MP AS DESCRICAOMP,
	B.UNID AS UNIDMP,
	REPLACE(CONVERT(varchar,CAST(B.QTDETEMP2 AS NUMERIC(18,5)), 1),'.',',') AS QTDEUTILIZ,
	REPLACE(CONVERT(varchar,CAST(C.QUANT AS NUMERIC(18,5)), 1),'.',',') AS SALDO
	FROM
	FAT00001.dbo.CadOp2 AS A,
	FAT00001.dbo.CadOp3 AS B,
	FAT00001.dbo.produto AS C,
	FAT00001.dbo.CadOP1 AS D
	WHERE
	A.CODIGO=B.CODIGO_OP
	AND B.CODIGO_MP=C.CODIGO
	AND A.CODIGO=D.CODIGO
	AND A.CODIGO='{$id}'
	AND A.STATUS<>'F'
	
	ORDER BY A.CODIGO, B.CODIGO_PR, B.CODIGO_MP
		");
	echo "<br>";
	
	//CABECALHO DA TABELA COMPONENTES E MATERIA PRIMA EMPREGADA
	echo "<table width='100%' id=tbordprod>
		<tr>
			<td width=5%><b>Item</b></td>
			<td width=20%><b>Cod Mat Prima</b></td>
			<td width=50%><b>Descrição M.P.</b></td>
			<td width=5%><b>Unid</b></td>
			<td width=10% align=right><b>Qtde Utiliz</b></td>
			<td width=10% align=right><b>Saldo Contab.</b></td>
		</tr>";
	
	//RELACAO DE ITENS E MATERIA PRIMA EMPREGADA
	while
	($linha = $relmp->fetch(PDO::FETCH_ASSOC)) {
			
		echo "<tr>
				<td>$linha[ITEMMP]</td>
				<td>$linha[CODIGOMP]</td>
				<td>$linha[DESCRICAOMP]</td>
				<td>$linha[UNIDMP]</td>
				<td align=right>$linha[QTDEUTILIZ]</td>
				<td align=right>$linha[SALDO]</td>
			</tr>";
	}
	echo "</table>";
	
	//CONTAGEM DE LINHAS OU ITENS EMPREGADOS
	echo "Total de itens: " . $relmp->rowCount();

}catch(PDOExceprion $e){
	echo $e->getMessasge();
}




?>

</body>

</html>
