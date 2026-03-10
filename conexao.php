<?php

try{
	//FAZ CONEXAO COM BANCO DE DADOS SQLSERVER
	$conectar = new PDO( "sqlsrv:Database=pcp_producao;server=192.168.10.31\BUSINESSSERVER;ConnectionPooling=0", "rjc_adm", "Rjc@31522611" );
	//$conn_pg = new PDO("pgsql:host=192.168.10.31;port=5432;dbname=efiscal", "sageuser","FOLHAmatic&201IOB");
	
	//echo 'Conectado com sucesso!!';
}	catch(PDOException $e){
	
	// CASO OCORRA ERRO NA CONEXAO, EXIBE MENSAGEM
	echo 'Falha ao conectar com banco de dados: '.$e->getMessage();
}

