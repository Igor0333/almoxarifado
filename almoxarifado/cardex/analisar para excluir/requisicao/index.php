<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Requisições</title>
	<link href="../css/estilo.css" rel="stylesheet">
</head>

<body>

<?php
	echo "Olá!!<br> Seja bem vindo ao cadastro de Requisições &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp
	<a href='listasaldo.php'><button>Relatórios</button></a>&nbsp &nbsp &nbsp";
	echo "<a href='confnota.php'><button>Conf N.F.</button></a>&nbsp &nbsp &nbsp";
	echo "<a href='../index.php'><button>Voltar</button></a><br><br>";	



include_once "../conexao.php";


if(isset($_POST['dt_ini'])){
	$id_dtini=filter_var($_POST['dt_ini']);
	}else {
		$id_dtini='';
	}

	if(isset($_POST['dt_fim'])){
		$id_dtfim=filter_var($_POST['dt_fim']);
		}else {
			$id_dtfim='';
		}

?>

<form action="index.php" method="POST">
<table>
<tr>
<td><label>Data Inicial: </label></td>
<td><input type="date" style="font-size: 10pt; height: 16px; width:150px;" name="dt_ini"/></td>
<td><label>Data Final: </label></td>
<td><input type="date" style="font-size: 10pt; height: 16px; width:150px;" name="dt_fim"/></td>
<td><input type="submit" value="Buscar"></td>
<td></td>
</tr>
</table>
</form>
<br><br>

<?php

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
A.EMISSAO >= '$id_dtini' AND A.EMISSAO <= '$id_dtfim'
ORDER BY A.EMISSAO DESC, A.DOCUM");
	
	echo "<table id=tbordprod>
		<tr>
			<td>DATA</td>
			<td>REQUISIÇÃO</td>
			<td>OBSERVAÇÃO</td>
			<td>CENTRO CUSTO</td>
			<td>ALMOXARIFADO</td>
		</tr>";
	while
	($linha = $consulta->fetch(PDO::FETCH_ASSOC)) {
		echo "<tr>
				<td>$linha[DATA]</td>
				<td>$linha[REQUISICAO]</td>
				<td>$linha[OBSERVACAO]</td>
				<td>$linha[CCUSTO]</td>
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
