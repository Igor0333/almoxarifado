<?php

include_once "../../conexao.php";

try{
	$cod_item = filter_var($_POST['cod_item']);
	$id_almox = filter_var($_POST['id_almox']);
	$qtde = filter_var($_POST['qtde'], FILTER_SANITIZE_STRING);
	$cod_lote = filter_var($_POST['cod_lote']);
	$observacao = filter_var($_POST['observacao']);
	$movto = filter_var($_POST['movto']);
	$acao = filter_var($_POST['acao']);
	
	$var_qtde = str_replace(',','.', $qtde);

	//QUERY PARA VERIFICACAO DE SALDOS
	$sql_saldo = $conectar->query("SELECT
	A.COD_ITEM AS ITEM,
	B.DESCRICAO AS DESCRICAO,
	((CASE WHEN C.S1TOTAL IS NULL THEN 0 ELSE C.S1TOTAL END)-(CASE WHEN D.S2TOTAL IS NULL THEN 0 ELSE D.S2TOTAL END)) AS SALDO
	FROM
	pcp_producao.dbo.almox_movto AS A	
	LEFT JOIN FAT00001.dbo.produto AS B ON A.COD_ITEM=B.CODIGO	
	LEFT JOIN (SELECT S1.COD_ITEM AS S1ITEM, SUM(S1.QTDE) AS S1TOTAL FROM pcp_producao.dbo.almox_movto S1 WHERE S1.TP_MOVTO='E' AND S1.COD_ITEM='$cod_item' GROUP BY S1.COD_ITEM) AS C ON A.COD_ITEM=C.S1ITEM	
	LEFT JOIN (SELECT S2.COD_ITEM AS S2ITEM, SUM(S2.QTDE) AS S2TOTAL FROM pcp_producao.dbo.almox_movto S2 WHERE S2.TP_MOVTO='S' AND	S2.COD_ITEM='$cod_item'
	GROUP BY S2.COD_ITEM) AS D ON A.COD_ITEM=D.S2ITEM	
	WHERE
	A.COD_ITEM='$cod_item'
	GROUP BY A.COD_ITEM,B.DESCRICAO,C.S1TOTAL,D.S2TOTAL
	");
	$row_sql_saldo = $sql_saldo->fetch(PDO::FETCH_ASSOC);	
	$saldo_item = $row_sql_saldo['SALDO'];

	//QUERY PARA BUSCAR DADOS DO LANÇAMENTO
	$sql_lancto = $conectar->query("SELECT A.TP_MOVTO AS TP_MOVTO, A.QTDE AS SQL_QTDE FROM pcp_producao.dbo.almox_movto AS A WHERE ID_ALMOX = '$id_almox'");
	$row_sql_lancto = $sql_lancto->fetch(PDO::FETCH_ASSOC);	
	$row_movto = $row_sql_lancto['TP_MOVTO'];
	$row_qtde_lancto = $row_sql_lancto['SQL_QTDE'];

	if($acao === 'A' && $movto === 'E'){
		$saldo_final = $saldo_item - $row_qtde_lancto + $var_qtde;
	}
	elseif($acao === 'A' && $movto === 'S'){
		$saldo_final = $saldo_item + $row_qtde_lancto - $var_qtde;
	}
	elseif($acao === 'E' && $row_movto === 'E'){
		$saldo_final = $saldo_item - $row_qtde_lancto;
	}
	else{
		$saldo_final = $saldo_item + $row_qtde_lancto;
	}

	//echo "Saldo Final: ".$saldo_final . "<br>";

	if ($acao === 'A' && $saldo_final >= 0){
/*		echo "R J C DEFESA E AEROESPACIAL LTDA<br><br>
		O lançamento pode ser ALTERADO, pois o saldo final é maior que ZERO<br><br>";
		echo "Saldo final após lançamento: ". $saldo_final;*/

		$update = $conectar->prepare("UPDATE pcp_producao.dbo.almox_movto SET QTDE = '$var_qtde',	LOTE = :cod_lote, OBSERVACAO = :observacao, TP_MOVTO = :movto WHERE ID_ALMOX = '$id_almox'");
	
		$update->bindParam(':cod_lote',$cod_lote);
		$update->bindParam(':observacao',$observacao);
		$update->bindParam(':movto',$movto);
		$update->execute();
		
		header("location: cardex.php?id=$cod_item");
	}elseif ($acao === 'E' && $saldo_final >= 0){
/*		echo "R J C DEFESA E AEROESPACIAL LTDA<br><br>
		O lançamento pode ser EXCLUIDO, pois o saldo final é maior que ZERO<br><br>";
		echo "Saldo final após lançamento: ". $saldo_final; */

		$conectar->query("DELETE FROM pcp_producao.dbo.almox_movto WHERE ID_ALMOX = '$id_almox'");		
		header("location: cardex.php?id=$cod_item");		
	}else {
		echo "R J C DEFESA E AEROESPACIAL LTDA<br><br>
		Saldo após Lançamento ".$saldo_final;
		echo "<br><br>Saldo negativo não permitido, por favor, verifique o lançamento / saldo em estoque <br><br>";
		echo "<a href='cardex.php?id=$cod_item'><button>Voltar</button></a><br><br>";		
	}
} catch(PDOException $e){
	echo 'Erro: ' . $e->getMessage();
}

