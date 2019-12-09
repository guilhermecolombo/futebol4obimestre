<?php
	
	include("conexao.php");
	
	$nome_cidade = $_POST["nome_cidade"];
	$cod_estado = $_POST["cod_estado"];
	$insere = "INSERT INTO cidade (nome_cidade, cod_estado)
						VALUES('$nome_cidade', '$cod_estado')";

	mysqli_query($conexao,$insere)
		or die(mysqli_error($conexao));
	
	echo "1";
	
?>