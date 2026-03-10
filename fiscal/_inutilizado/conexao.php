<?php


try{

    //FAZ CONEXAO COM BANCO DE DADOS POSTGREE
    $conn = new PDO('pgsql:host=192.168.10.30;port=5432;dbname=efiscal', 'sageuser','FOLHAmatic&201IOB');    
   
    //if($conn) {
    //echo "database conectado";
    //}
    }catch (PDOException $e){
    // report error message
    echo $e->getMessage();
    }

?>