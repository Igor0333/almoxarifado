<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Movimento</title>
	<link href="../css/estilo.css" rel="stylesheet">
</head>
<body>

<?php
	//echo "<a href="index.php"><button>Voltar</button></a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp<br><a href="index.php"><button>Voltar</button></a>";
	
	$hoje = date('d/m/Y');
	if(isset($_POST['id'])){
		$id=filter_var($_POST['id']);
	}else{
		$id = filter_var($_GET['id'], FILTER_SANITIZE_STRING);
	}
	
	//$id = "EC145719";
	
	if(isset($_POST['dt_ini'])){
		$id_dtini=filter_var($_POST['dt_ini']);
		}else {
			$id_dtini=$hoje;
		}
	
		if(isset($_POST['dt_fim'])){
			$id_dtfim=filter_var($_POST['dt_fim']);
			}else {
				$id_dtfim=$hoje;
			}
	
	echo "<b>R J C DEFESA E AEROESPACIAL LTDA</b><br>";
	echo "<a href='cardex.php?id=$id'><button>Voltar</button></a><br>";
	echo "<center><b>Movimentação do Estoque</b></center><br><br>";
	echo '<b>Data emissão: </b>' . $hoje;
	echo "<br><br>";

	echo "
	<form action='movtofiscal.php' method='POST'>
	<table>
	<tr>
	<td><label>Data Inicial: </label></td>
	<td><input type='date' style='font-size: 10pt; height: 16px; width:150px;' name='dt_ini'/></td>
	<td><label>Data Final: </label></td>
	<td><input type='date' style='font-size: 10pt; height: 16px; width:150px;' name='dt_fim'/></td>
	<input type='hidden' name='id' value='$id'>
	<td><input type='submit' value='Buscar'></td>
	<td></td>
	</tr>
	</table>
	</form>";
	
	echo "Período de lançamentos: " .date('d/m/Y', strtotime($id_dtini))." a ".date('d/m/Y', strtotime($id_dtfim))."<br><br>";
	
	
	include_once "../../conexao.php";

try{
	$consulta = $conectar->query("SELECT
	convert(varchar(10),A.DATA,103) AS 'EMISSAO',
	A.NOTA AS NOTA,
	A.RAZAO AS RAZAO,
	A.OBSSAI AS OBSSAI,
	A.PROD AS CODIGO,
	A.QUANT AS QTDE,
	A.DESCRICAO AS DESCRICAO
	FROM FAT00001.dbo.movto AS A
	WHERE
	A.DATA >= '$id_dtini' AND A.DATA <= '$id_dtfim'
	AND A.PROD='{$id}'
	ORDER BY A.DATA
	");
echo "<table id=tbordprod>
<tr>
	<td>DATA</td>
	<td>NOTA</td>
	<td>RAZÃO SOCIAL</td>
	<td>OBSERVAÇÃO</td>
	<td>CODIGO</td>
	<td>QUANTIDADE</td>
	<td>DESCRICAO</td>
</tr>";

	while
	($linha = $consulta->fetch(PDO::FETCH_ASSOC)) {
		$qtde = number_format($linha['QTDE'],2,',', '.');
echo "<tr>
		<td>$linha[EMISSAO]</td>
		<td>$linha[NOTA]</td>
		<td>$linha[RAZAO]</td>
		<td>$linha[OBSSAI]</td>
		<td>$linha[CODIGO]</td>
		<td align=right>$qtde</td>
		<td>$linha[DESCRICAO]</td>
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
