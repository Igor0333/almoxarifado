<!DOCTYPE html>
<html>
<head>
<title>Cotação Dolar</title>
<link href="css/estilo.css" rel="stylesheet">
</head>
<body>

<?php


$id_data = '09-13-2022'

$ch = curl_init("https://olinda.bcb.gov.br/olinda/servico/PTAX/versao/v1/odata/CotacaoDolarDia(dataCotacao=@dataCotacao)?@dataCotacao='08-13-2022'&format=json");

curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$res_curl = curl_exec($ch);
if(curl_error($ch)) {
    echo curl_error($ch);
} else {
 $resultado = json_decode($res_curl, true);
 $valores = $resultado["value"][0];
 //Agora será possível recuperar a informação da cotação do dólar:
 echo $valores["cotacaoCompra"];
 echo ('
 ');
 echo $valores["cotacaoVenda"];
 echo ('
');
 echo $valores["dataHoraCotacao"];
}
curl_close($ch);

?>

</body>

</html>
