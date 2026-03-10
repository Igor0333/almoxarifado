<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Requisições</title>
	<link href="css/estilo.css" rel="stylesheet">
</head>

<body>

<?php
	echo "Olá!!<br> Seja bem vindo ao cadastro de Requisições<br><br>";
	//echo "<a href='formcadastrarproduto.php'><button>Cadastrar Produto Novo</button></a>  ";
	echo "<a href='index.php'><button>Voltar</button></a><br><br>";	



include_once "conexao.php";

try{
	//EXECUÇÃO DA INSTRUCAO SQL
	//$consulta = $conectar->query("SELECT * FROM FAT00001.dbo.produto ");
	$consulta = $conectar->query("SELECT
convert(varchar(10),A.EMISSAO,103) AS 'DATA',
A.DOCUM AS 'REQUISICAO',
A.OBSERV AS 'OBSERVACAO',
A.CCUSTO AS 'CCUSTO'

FROM
FAT00001.dbo.requis1 AS A

WHERE 
A.EMISSAO>='2021-06-01'

ORDER BY A.EMISSAO DESC, A.DOCUM");
	
	echo "<table id=tbordprod>
		<tr>
			<td>DATA</td>
			<td>REQUISIÇÃO</td>
			<td>OBSERVAÇÃO</td>
			<td>CENTRO CUSTO</td>
			<td>PRODUCAO</td>
			<td>ALMOXARIFADO</td>
		</tr>";
	while
	($linha = $consulta->fetch(PDO::FETCH_ASSOC)) {
		echo "<tr>
				<td>$linha[DATA]</td>
				<td>$linha[REQUISICAO]</td>
				<td>$linha[OBSERVACAO]</td>
				<td>$linha[CCUSTO]</td>
				<td><a href='formreqvis.php?id=$linha[REQUISICAO]'>Imprimir</a></a></td>
				<td><a href='formreqalmoxvis.php?id=$linha[REQUISICAO]'>Imprimir</a></a></td>
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
