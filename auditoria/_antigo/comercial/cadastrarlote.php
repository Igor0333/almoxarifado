<?php

include_once "../conexao.php";

try{
	$pedido = filter_var($_POST['pedido']);
	$cod_of = filter_var($_POST['cod_of']);
	$prazo_lote = filter_var($_POST['prazo_lote']);
	$cod_lote = filter_var($_POST['cod_lote']);
	$qtde_lote = filter_var($_POST['qtde_lote']);
	$unid_lote = filter_var($_POST['unid_lote']);
		
	$insert = $conectar->prepare("INSERT INTO cad_lote(cod_of,prazo_lote,cod_lote,qtde_lote,unid)
								VALUES(:cod_of,:prazo_lote,:cod_lote,:qtde_lote,:unid_lote)");
	$insert->bindParam(':cod_of',$cod_of);
	$insert->bindParam(':prazo_lote',$prazo_lote);
	$insert->bindParam(':cod_lote',$cod_lote);
	$insert->bindParam(':qtde_lote',$qtde_lote);
	$insert->bindParam(':unid_lote',$unid_lote);
	$insert->execute();
	
	header("location: formeditarof.php?id=$pedido");
	
} catch(PDOException $e){
	echo 'Erro: ' . $e->getMessage();
}

