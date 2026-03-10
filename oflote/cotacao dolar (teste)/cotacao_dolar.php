<?php

      /*
        # Anderson Luiz de Oliveira - 25/02/2017 # 
        Revisado em 16/03 para corrigir um bug na extração do valor da venda.
      */

      if(!$fp=fopen("https://www.infomoney.com.br/mercados/cambio" , "r" )) 
	  {
      	echo "Erro ao abrir a página de cotação" ;
      	exit;
      }

      $conteudo = '';
      while(!feof($fp)) 
	  { 
      	$conteudo .= fgets($fp,1024);
      }
      fclose($fp);

	  $valorCompraHTML = explode('class="numbers">', $conteudo); 
	  $valorCompra = trim(strip_tags($valorCompraHTML[5]));
	  $valorVendaHTML = explode('+', strip_tags($valorCompraHTML[6]));
	  
	  //Estes são os valores HTML para exibir no site.	
	  $valorVendaHTML = explode('-', $valorVendaHTML[0]);
	  $valorVenda  = trim($valorVendaHTML[0]) ;
	  
	  //Estes são os valores numéricos para cálculos.	  
	  $valorCompraCalculavel = str_replace(',','.', $valorCompra);
	  $valorVendaCalculavel  = str_replace(',','.', $valorVenda);
 
 ?> 
 
<html lan="pt-br">
<head>
     <meta charset="utf-8">
     <meta name="viewport" content="width=device-width, user-scalable=yes">
     <link href="https://fonts.googleapis.com/css?family=Simonetta" rel="stylesheet">
	 <title>Exemplo de Script de cotação do dólar</title>     
</head>
<body style="font-family: 'Simonetta', cursive;">
<h1>Exemplo de script de cotação do dólar</h1><hr/>
    <p>Cotação extraída de <a href="https://www.infomoney.com.br/mercados/cambio" title="Extração da cotação do dólar" target="_blank">https://www.infomoney.com.br/mercados/cambio</a><br>
Script revisado em 16/03/2017</p>
<p><strong>Compra:</strong> R$ <?php echo $valorCompra ?> <br/>
<strong>Venda:</strong> R$ <?php echo $valorVenda ?>  </p>
       
       
    <h2>Exemplo de câmbio:</h2>
    <label>Digite o valor em reais:</label>
<input type="text" id="converte" placeholder="1.00" onKeyUp="cambio()" style="width:50px">
    <span id="resultado">0.00</span>    
<script>
		function cambio()
		{
			var valorDolarVenda = <?php echo $valorVendaCalculavel ?>;
			var valorReais	 = document.getElementById('converte').value;
			if (document.getElementById('converte').value == '') valorReais = 0;
			var valorCambio = valorReais * valorDolarVenda;
			document.getElementById('resultado').innerHTML = valorCambio.toFixed(2);
		}
	</script>
    
    <hr/>
    <p>download: <a href="https://invettor.com.br/downloads/inVettor_cotacao_dolar_infomoney.zip" title="Download do Script de Cotação do dólar">https://invettor.com.br/downloads/inVettor_cotacao_dolar_infomoney.zip</a></p>
    <p>Gostou do script? Ele é quase gratuito, custa apenas um <em>like!</em> :)</p>
    
    <div id="fb-root"></div>
<script>(function(d, s, id) {
  		var js, fjs = d.getElementsByTagName(s)[0];
 		if (d.getElementById(id)) return;
  		js = d.createElement(s); js.id = id;
  		js.src = "//connect.facebook.net/pt_BR/sdk.js#xfbml=1&version=v2.8&appId=1736903143236965";
  		fjs.parentNode.insertBefore(js, fjs);
		}(document, 'script', 'facebook-jssdk'));</script>
<div class="fb-like" data-href="https://blog.invettor.com.br/script-cotacao-dolar-infomoney/" data-layout="button_count" data-action="like" data-size="large" data-show-faces="true" data-share="true"></div>
       
</body>
</html>