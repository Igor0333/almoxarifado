<?php

include_once "../../conexao.php";

try{

	if(isset($_GET['regcusto'])){$regcusto = filter_var($_GET['regcusto']);}else{$regcusto = NULL;}
	//if(isset($_GET['acao'])){$acao = filter_var($_GET['acao']);}else{$acao = NULL;}
		$acao = filter_var($_GET['acao']);
		$busca = filter_var($_GET['busca']);
		$doc_id = filter_var($_GET['doc_id']);
		$dt_ini = filter_var($_GET['dt_ini']);
		$dt_fim = filter_var($_GET['dt_fim']);
		$rotina = filter_var($_GET['rotina']);
		$cod_lote = filter_var($_GET['cod_lote']);
		$item = filter_var($_GET['item']);
		$prod = filter_var($_GET['prod']);
		$vlr_unit = filter_var($_GET['vlr_unit']);
		$qtde = filter_var($_GET['qtde']);
		if ($rotina == "REQ"){
			$vlr_tot = $vlr_unit * $qtde * -1;
		}else{
			$vlr_tot = $vlr_unit * $qtde;
		}

	if ($acao == 'A'){
	//FUNCAO ALTERAR

	$update = $conectar->prepare("UPDATE pcp_producao.dbo.reglote SET cod_lote = :cod_lote, valuni = :vlr_unit, valtot = :vlr_tot WHERE doc_id = '$doc_id' AND codproduto = '$prod' AND item = '$item'");
	$update->bindParam(':cod_lote',$cod_lote);
	$update->bindParam(':vlr_unit',$vlr_unit);
	$update->bindParam(':vlr_tot',$vlr_tot);	
	$update->execute();
	
	header("location: vincularlote.php?dt_ini=$dt_ini&dt_fim=$dt_fim&rotina=$rotina&busca=$busca");

	}elseif($acao == 'E'){
	//FUNCAO EXCLUIR
	$conectar->query("DELETE FROM pcp_producao.dbo.reglote WHERE doc_id = '$doc_id' AND codproduto = '$prod' AND item = '$item' ");
	//echo "Registros a serem excluídos: / $doc_id / $prod /";
	header("location: vincularlote.php?dt_ini=$dt_ini&dt_fim=$dt_fim&rotina=$rotina&busca=$busca");
	
	}else{
		//FUNCAO CADASTRAR
	$insert = $conectar->prepare("INSERT INTO reglote(cod_lote,doc_id,regcusto,codproduto,valuni,valtot,item)
								VALUES(:cod_lote,:doc_id,:regcusto,:prod,:vlr_unit,:vlr_tot,:item)");
	$insert->bindParam(':cod_lote',$cod_lote);
	$insert->bindParam(':doc_id',$doc_id);
	$insert->bindParam(':regcusto',$regcusto);
	$insert->bindParam(':prod',$prod);
	$insert->bindParam(':item',$item);
	$insert->bindParam(':vlr_unit',$vlr_unit);
	$insert->bindParam(':vlr_tot',$vlr_tot);	
	$insert->execute();
	
	header("location: vincularlote.php?dt_ini=$dt_ini&dt_fim=$dt_fim&rotina=$rotina&busca=$busca");
	}

} catch(PDOException $e){
	echo 'Erro: ' . $e->getMessage();
}

