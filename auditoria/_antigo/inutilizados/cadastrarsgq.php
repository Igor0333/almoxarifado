<?php

include_once "conexao.php";
try{
	$cod_op = filter_var($_POST['cod_op']);
	$sit_sgq = filter_var($_POST['sit_sgq']);
	$hoje = date('d/m/Y');
	$obs_sgq = filter_var($_POST['obs_sgq']);
	$consulta = $conectar->query("SELECT
cod_op AS ordprod
FROM pcp_producao.dbo.sgqstatus
WHERE cod_op='{$cod_op}'
");

while
	($exibe = $consulta->fetch(PDO::FETCH_ASSOC)) {	
if ($exibe[ordprod] == $cod_op){
	
	echo 'EXISTE OP '.$exibe[ordprod];
}	
 else {
	echo 'NAO EXISTE OP';
/*	$insert = $conectar->prepare("INSERT INTO pcp_producao.dbo.sgqstatus(cod_op,sit_sgq,dt_conferencia,obs_sgq)
								VALUES(:cod_op,:sit_sgq,:hoje,:obs_sgq)");
	$insert->bindParam(':cod_op',$cod_op);
	$insert->bindParam(':sit_sgq',$sit_sgq);
	$insert->bindParam(':hoje',$hoje);
	$insert->bindParam(':obs_sgq',$obs_sgq);
	$insert->execute();
	
	header("location: formordprodf.php"); */
}
	}	
	
	
} catch(PDOException $e){
	echo 'Erro: ' . $e->getMessage();
}


?>