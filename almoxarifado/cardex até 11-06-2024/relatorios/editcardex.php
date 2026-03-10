<?php

include_once "../../../conexao.php";

try{	
	$id_almox = filter_var($_POST['id_almox']);
	$cod_lote = filter_var($_POST['cod_lote']);
	$observacao = filter_var($_POST['observacao']);
		
	$update = $conectar->prepare("UPDATE pcp_producao.dbo.almox_movto SET LOTE = :cod_lote, OBSERVACAO = :observacao WHERE ID_ALMOX = '$id_almox'");
	
	//$update->bindParam(':qtde',$qtde);
	$update->bindParam(':cod_lote',$cod_lote);
	$update->bindParam(':observacao',$observacao);
	$update->execute();
	
	header("location: index.php");
	
	
} catch(PDOException $e){
	echo 'Erro: ' . $e->getMessage();
}
