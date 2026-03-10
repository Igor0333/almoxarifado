<?php


try{
//FAZ CONEXAO COM BANCO DE DADOS POSTGREE    
$conn = new PDO('pgsql:host=192.168.10.30;port=5432;dbname=efiscal', 'sageuser','FOLHAmatic&201IOB');

//FAZ CONEXAO COM BANCO DE DADOS SQLSERVER
$conectar = new PDO( "sqlsrv:Database=pcp_producao;server=FOLHAMATIC_RJC\BUSINESSSERVER;ConnectionPooling=0", "rjc_public", "rjc" );

//if($conn) {
//echo "database conectado";
//}
}catch (PDOException $e){
// report error message
echo $e->getMessage();
}


?>