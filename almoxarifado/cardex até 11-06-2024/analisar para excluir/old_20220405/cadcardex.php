<?php

include_once "conexao.php";

$movto_valid = filter_var($_POST['movto']);
$qtde_valid = (int)filter_var($_POST['qtde']);
$saldo_item_valid = (int)filter_var($_POST['saldo_item']);
$cod_item_valid = filter_var($_POST['cod_item']);

$soma = $saldo_item_valid - $qtde_valid;

if (filter_var($_POST['movto']) == 'S' && $soma < 0){
	echo "Sado após Lançamento ".$soma;
	echo "<br><br>SALDO INSUFICIENTE!!! <br><br>Saldo negativo não permitido, por favor, verifique o saldo em estoque <br><br>";
	echo "<a href='cardex.php?id=$cod_item_valid'><button>Voltar</button></a><br><br>";

}else {
	echo "Irá executar";
	
try{
	
	$movto = filter_var($_POST['movto']);
	$data = filter_var($_POST['data']);
	$qtde = filter_var($_POST['qtde'], FILTER_SANITIZE_STRING);
	$cod_lote = filter_var($_POST['cod_lote']);
	$observacao = filter_var($_POST['observacao']);
	$cod_item = filter_var($_POST['cod_item']);
	$saldo_item = filter_var($_POST['saldo_item']);
	
	$result = str_replace(',','.', $qtde);
	
	$insert = $conectar->prepare("INSERT INTO almox_movto(TP_MOVTO,DATA,QTDE,LOTE,OBSERVACAO,COD_ITEM)
								VALUES(:movto,:data,'$result',:cod_lote,:observacao,:cod_item)");
	
	$insert->bindParam(':movto',$movto);
	$insert->bindParam(':data',$data);
	//$insert->bindParam(':qtde',$qtde);
	$insert->bindParam(':cod_lote',$cod_lote);
	$insert->bindParam(':observacao',$observacao);
	$insert->bindParam(':cod_item',$cod_item);
	$insert->bindParam(':saldo_item',$saldo_item);
	$insert->execute();
	
	header("location: cardex.php?id=$cod_item");
	
} catch(PDOException $e){
	echo 'Erro: ' . $e->getMessage();
}

}
