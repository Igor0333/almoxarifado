<?php

include_once "conexao.php";

try{
	$id = filter_var($_POST['pedido'], FILTER_SANITIZE_NUMBER_INT);
	$cod_of = filter_var($_POST['codigo_of']);
	$prazo_of = filter_var($_POST['prazo_of']);
	
	$update = $conectar->prepare("UPDATE pcp_producao.dbo.cad_of SET cod_of = :cod_of, prazo_of = :prazo_of WHERE pedido = '$id'");
								
	$update->bindParam(':cod_of',$cod_of);
	$update->bindParam(':prazo_of',$prazo_of);
	$update->execute();
	
	header("location: formof.php");
	
} catch(PDOException $e){
	echo 'Erro: ' . $e->getMessage();
}

