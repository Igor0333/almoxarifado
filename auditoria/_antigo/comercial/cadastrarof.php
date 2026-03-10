<?php

include_once "../conexao.php";

try{
	$pedido = filter_var($_POST['pedido']);
	$cod_of = filter_var($_POST['codigo_of']);
	$prazo_of = filter_var($_POST['prazo_of']);
		
	$insert = $conectar->prepare("INSERT INTO cad_of(pedido,cod_of,prazo_of)
								VALUES(:pedido,:cod_of,:prazo_of)");
	$insert->bindParam(':pedido',$pedido);
	$insert->bindParam(':cod_of',$cod_of);
	$insert->bindParam(':prazo_of',$prazo_of);
	$insert->execute();
	
	header("location: formof.php");
	
} catch(PDOException $e){
	echo 'Erro: ' . $e->getMessage();
}

