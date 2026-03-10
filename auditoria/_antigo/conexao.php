<?php

try{
	//FAZ CONEXAO COM BANCO DE DADOS SQLSERVER
	$conectar = new PDO( "sqlsrv:Database=pcp_producao;server=FOLHAMATIC_RJC\BUSINESSSERVER;ConnectionPooling=0", "rjc_adm", "Rjc@31522611" );
	//$conectar = new PDO("mysql:host=localhost;port=3306;dbname=u824580866_rjc;", "u824580866_rjc", "Hcbr@2021");
	
	//echo 'Conectado com sucesso!!';
}	catch(PDOException $e){
	
	// CASO OCORRA ERRO NA CONEXAO, EXIBE MENSAGEM
	echo 'Falha ao conectar com banco de dados: '.$e->getMessage();
}

