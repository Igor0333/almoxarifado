<!DOCTYPE html>
<html>

<head>
<title>Registrar SGQ</title>
<link href="css/estilo.css" rel="stylesheet">
</head>

<body>

<?php
	$id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
	echo "Olá!!<br> Cadastre o Status SGQ<br><br>";
	echo "<a href='formordprodf.php'><button>Voltar</button><p></a>";

?>

<form action="cadastrarsgq.php" method="post">

O.P.: <input type="text" id="cod_op" name="cod_op" value="<?php echo"$id"; ?>" readonly="readonly" /><p>

Status:<br>
		<input type="radio" id="conferido" name="sit_sgq" value="CORRECAO"><label for="1">Correção</label><br>
		<input type="radio" id="conferido" name="sit_sgq" value="CONFERIDO"><label for="2">Conferido</label><p>

Observação: <textarea name="obs_sgq" id="obs_sgq" rows="1" cols="100"></textarea><p>

<br>
<button type="submit">Cadastrar</button>

</form>


</body>
</html>