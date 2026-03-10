<?php

include_once "../../conexao.php";

try{
		$nota = filter_var($_GET['nota']);
		$num_op = filter_var($_GET['num_op']);
		$item = filter_var($_GET['item']);
		$prod = filter_var($_GET['prod']);
		$qtde = filter_var($_GET['qtde']);
		$dt_ini = filter_var($_GET['dt_ini']);
		$dt_fim = filter_var($_GET['dt_fim']);
		
	//FUNCAO CADASTRAR
	$insert = $conectar->prepare("INSERT INTO vinc_nf_op(num_nf,num_op,item_nf,codproduto_op,qtde_op)
								VALUES(:nota,:num_op,:item,:prod,:qtde)");
	$insert->bindParam(':nota',$nota);
	$insert->bindParam(':num_op',$num_op);
	$insert->bindParam(':item',$item);
	$insert->bindParam(':prod',$prod);
	$insert->bindParam(':qtde',$qtde);
	$insert->execute();
	
	header("location: nfxmovto.php?dt_ini=$dt_ini&dt_fim=$dt_fim");

}catch(PDOException $e){
	echo 'Erro: ' . $e->getMessage();
}

