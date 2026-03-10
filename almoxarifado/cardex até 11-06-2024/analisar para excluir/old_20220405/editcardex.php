<?php

include_once "conexao.php";
/*
$hoje = date('d/m/Y');


$movto_valid = filter_var($_POST['movto']);
$qtde_valid = (int)filter_var($_POST['qtde']);
$saldo_item_valid = (int)filter_var($_POST['saldo_item']);
$cod_item_valid = filter_var($_POST['cod_item']);

if (filter_var($_POST['movto']) != $hoje){
	echo "Sado após Lançamento ".$soma;
	echo "<br><br>SALDO INSUFICIENTE!!! <br><br>Saldo negativo não permitido, por favor, verifique o saldo em estoque <br><br>";
	echo "<a href='cardex.php?id=$cod_item_valid'><button>Voltar</button></a><br><br>";

}else {
	echo "Irá executar";
	*/
try{
	$cod_item = filter_var($_POST['cod_item']);
	$id_almox = filter_var($_POST['id_almox']);
	$qtde = filter_var($_POST['qtde'], FILTER_SANITIZE_STRING);
	$cod_lote = filter_var($_POST['cod_lote']);
	$observacao = filter_var($_POST['observacao']);
	$movto = filter_var($_POST['movto']);
	
	//echo $qtde;
	//echo "<br>";
	
	$result = str_replace(',','.', $qtde);
	//echo $result;
	
	$update = $conectar->prepare("UPDATE pcp_producao.dbo.almox_movto SET QTDE = '$result',	LOTE = :cod_lote, OBSERVACAO = :observacao, TP_MOVTO = :movto WHERE ID_ALMOX = '$id_almox'");
	
	//$update->bindParam(':qtde',$qtde);
	$update->bindParam(':cod_lote',$cod_lote);
	$update->bindParam(':observacao',$observacao);
	$update->bindParam(':movto',$movto);
	$update->execute();
	
	header("location: cardex.php?id=$cod_item");
	
	
} catch(PDOException $e){
	echo 'Erro: ' . $e->getMessage();
}
/*

	$id = filter_var($_POST['pedido'], FILTER_SANITIZE_NUMBER_INT);
	$cod_of = filter_var($_POST['codigo_of']);
	$prazo_of = filter_var($_POST['prazo_of']);
	
	$update = $conectar->prepare("UPDATE pcp_producao.dbo.cad_of SET cod_of = :cod_of, prazo_of = :prazo_of WHERE pedido = '$id'");
								
	$update->bindParam(':cod_of',$cod_of);
	$update->bindParam(':prazo_of',$prazo_of);
	$update->execute(); */