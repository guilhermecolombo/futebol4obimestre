<?php
	
	include("conexao.php");
	
	$id = $_POST["id"];
	$nome_estado = $_POST["nome_estado"];
	$uf = $_POST["uf"];
	
	$alteracao = "UPDATE estado SET 
				nome_estado = '$nome_estado',
				uf = '$uf'
				WHERE id_estado = '$id'";

	mysqli_query($conexao,$alteracao)
		or die(mysqli_error($conexao));
	
	echo "1";
	
?>