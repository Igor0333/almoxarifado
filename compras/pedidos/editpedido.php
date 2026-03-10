<?php

include_once "../../conexao.php";

try{
	$pedido = filter_var($_POST['pedido']);
	$codfor = filter_var($_POST['codfor']);
	$razforn = filter_var($_POST['razforn']);
	$obs1 = filter_var($_POST['obs1']);
	$obs2 = filter_var($_POST['obs2']);
	$obs3 = filter_var($_POST['obs3']);
	$obs4 = filter_var($_POST['obs4']);
	$obs5 = filter_var($_POST['obs5']);
	$fant = filter_var($_POST['fant']);
	
	$sql = $conectar->query("SELECT
	A.CODFOR,
	A.RAZAO_SOC,
	A.FANT
	FROM
	FIN00001.dbo.cadfor AS A
	WHERE A.CODFOR = '$codfor'
	");
	$linha = $sql->fetch(PDO::FETCH_ASSOC);
	$n_codfor = "$linha[CODFOR]";
	$n_razforn = "$linha[RAZAO_SOC]";
	$n_fant = "$linha[FANT]";

		$update = $conectar->prepare("UPDATE FAT00001.dbo.compra SET
		FORN = :codfor, RAZFORN = :razforn, FANT = :fant,
		OBS1 = :obs1, OBS2 = :obs2, OBS3 = :obs3, OBS4 = :obs4, OBS5 = :obs5
		WHERE PEDIDO = :pedido");
	
		$update->bindParam(':codfor',$n_codfor);
		$update->bindParam(':razforn',$n_razforn);
		$update->bindParam(':fant',$n_fant);
		$update->bindParam(':pedido',$pedido);
		$update->bindParam(':obs1',$obs1);
		$update->bindParam(':obs2',$obs2);
		$update->bindParam(':obs3',$obs3);
		$update->bindParam(':obs4',$obs4);
		$update->bindParam(':obs5',$obs5);
		$update->bindParam(':movto',$movto);
		$update->execute();
		
		header("location: formeditpedido.php?id=$pedido");
} catch(PDOException $e){
	echo 'Erro: ' . $e->getMessage();
}

