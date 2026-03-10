<?php

include_once "../../../conexao.php";

try{
	$acao = filter_var($_POST['acao']);
	$cod_of = filter_var($_POST['cod_of']);
	$prazo_lote = filter_var($_POST['prazo_lote']);
	$cod_lote = filter_var($_POST['cod_lote']);
	$qtde_lote = filter_var($_POST['qtde_lote']);
	$unid_lote = filter_var($_POST['unid_lote']);
	
	if ($acao == 'E'){		
		echo $acao;
		$conectar->query("DELETE FROM pcp_producao.dbo.cad_lote WHERE cod_lote = '$cod_lote'");
		
		header("location: formcadastrarlote.php?id=$cod_of");
	
	}else {
		
	$insert = $conectar->prepare("UPDATE pcp_producao.dbo.cad_lote 
								SET prazo_lote = :prazo_lote, cod_lote = :cod_lote, qtde_lote = :qtde_lote,unid = :unid_lote
								WHERE cod_lote = '$cod_lote' ");

	$insert->bindParam(':cod_of',$cod_of);
	$insert->bindParam(':prazo_lote',$prazo_lote);
	$insert->bindParam(':cod_lote',$cod_lote);
	$insert->bindParam(':qtde_lote',$qtde_lote);
	$insert->bindParam(':unid_lote',$unid_lote);
	$insert->execute();
	
	header("location: formcadastrarlote.php?id=$cod_of");
	}
	
} catch(PDOException $e){
	echo 'Erro: ' . $e->getMessage();
}

