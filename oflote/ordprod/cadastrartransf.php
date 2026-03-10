<?php

include_once "../../conexao.php";

try{
	$acao = filter_var($_POST['acao']);
	$cod_lote = filter_var($_POST['cod_lote']);
	$cod_transf = filter_var($_POST['cod_transf']);
	$cod_op = filter_var($_POST['cod_op']);
	$cod_predio = filter_var($_POST['cod_predio']);
	
	if ($acao == 'A'){
	//FUNCAO ALTERAR
	$update = $conectar->prepare("UPDATE pcp_producao.dbo.ordprod SET cod_lote = :cod_lote, cod_predio = :cod_predio WHERE transf_op = '$cod_transf'");
	$update->bindParam(':cod_lote',$cod_lote);
	$update->bindParam(':cod_predio',$cod_predio);
	$update->execute();
	header("location: index.php");

	}elseif($acao == 'E'){
	//FUNCAO EXCLUIR
	$conectar->query("DELETE FROM pcp_producao.dbo.ordprod WHERE transf_op = '$cod_transf'");
		
	header("location: index.php");
	}else{
		//FUNCAO CADASTRAR
	$insert = $conectar->prepare("INSERT INTO ordprod(cod_lote,transf_op,cod_predio)
								VALUES(:cod_lote,:cod_transf,:cod_predio)");
	$insert->bindParam(':cod_lote',$cod_lote);
	$insert->bindParam(':cod_transf',$cod_transf);
	$insert->bindParam(':cod_predio',$cod_predio);
	$insert->execute();
	
	header("location: index.php");
	}

} catch(PDOException $e){
	echo 'Erro: ' . $e->getMessage();
}

