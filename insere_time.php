<?php
	
	include("conexao.php");
	
	$nome_time = $_POST["nome_time"];
	$cod_cidade = $_POST["cod_cidade"];
	$insere = "INSERT INTO time ( nome_time, cod_cidade)
						VALUES('$nome_time', '$cod_cidade')";

	mysqli_query($conexao,$insere)
		or die(mysqli_error($conexao));
	
	echo "1";
	
?>