<?php

include_once "../conexao.php";

try{
	$cod_lote = filter_var($_POST['cod_lote']);
	$cod_transf = filter_var($_POST['cod_transf']);
	$cod_op = filter_var($_POST['cod_op']);
	$cod_predio = filter_var($_POST['cod_predio']);
	/*
	echo "aqui é cod_lote".$cod_lote;
	echo "aqui é cod_transf".$cod_transf;
	echo "aqui é cod_op".$cod_op;
	*/
	$insert = $conectar->prepare("INSERT INTO ordprod(cod_lote,transf_op,cod_predio)
								VALUES(:cod_lote,:cod_transf,:cod_predio)");
	$insert->bindParam(':cod_lote',$cod_lote);
	$insert->bindParam(':cod_transf',$cod_transf);
	$insert->bindParam(':cod_predio',$cod_predio);
	$insert->execute();
	
	//echo '<script>location.reload(history.go(-2));</script>';
	header("location: formlistartransf.php");
	
	
} catch(PDOException $e){
	echo 'Erro: ' . $e->getMessage();
}

