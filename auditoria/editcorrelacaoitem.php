<?php

include_once "../conexao.php";

try{
	//RECEBE DADOS DO FORMULARIO
	$cod_item = filter_var($_POST['cod_item']);
	$new_item = filter_var($_POST['new_item']);
	$cod_forn = filter_var($_POST['cod_forn']);
	$pro_for = filter_var($_POST['prod_for']);

	

		$update = $conectar->prepare("UPDATE FAT00001.dbo.MatFor SET CODPRODINTERNO = :new_item WHERE CODIGO = :cod_item AND CODFOR = :cod_forn AND CODPRODINTERNO = :pro_for");
	
		$update->bindParam(':cod_item',$cod_item);
		$update->bindParam(':new_item',$new_item);
		$update->bindParam(':cod_forn',$cod_forn);
		$update->bindParam(':pro_for',$pro_for);
		$update->execute();
		

		//echo "exibe: $cod_item, exibe: $new_item, exibe: $cod_forn, exibe: $pro_for";

		header("location: correlacaoitem.php?pesquisa=$cod_forn&descr=$cod_item");

} catch(PDOException $e){
	echo 'Erro: ' . $e->getMessage();
}

