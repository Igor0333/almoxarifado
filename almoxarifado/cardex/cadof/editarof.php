<?php

include_once "../../../conexao.php";

try{
	$acao = filter_var($_POST['acao']);
	$id = filter_var($_POST['codigo_of']);	
	$prazo_of = filter_var($_POST['prazo_of']);
	$obs_of = filter_var($_POST['obs_of']);
	$qtdeof = filter_var($_POST['qtde_of']);
	
	//echo $id."<br>"; echo $prazo_of;

	if ($acao == 'E'){		
		$conectar->query("DELETE FROM pcp_producao.dbo.cad_of WHERE cod_of = '$id'");
		
		header("location: index.php");
	
	}else {
	$update = $conectar->prepare("UPDATE pcp_producao.dbo.cad_of SET prazo_of = :prazo_of, observ1 = :obs_of, qtde_of = :qtdeof WHERE cod_of = '$id'");
	
	$update->bindParam(':prazo_of',$prazo_of);
	$update->bindParam(':obs_of',$obs_of);
	$update->bindParam(':qtdeof',$qtdeof);
	$update->execute();

	header("location: formcadastrarlote.php?id=$id");	
	}

} catch(PDOException $e){
	echo 'Erro: ' . $e->getMessage();
}
?>
