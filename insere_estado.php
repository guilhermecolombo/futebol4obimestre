<?php
	
	include("conexao.php");
	
	$nome_estado = $_POST["nome_estado"];
	$uf = $_POST["uf"];
	$insere = "INSERT INTO estado (nome_estado, uf)
						VALUES('$nome_estado', '$uf')";

	mysqli_query($conexao,$insere)
		or die(mysqli_error($conexao));
	
	echo "1";
	
?>