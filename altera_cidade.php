<?php
	
	include("conexao.php");
	
	$id = $_POST["id"];
	$nome_cidade = $_POST["nome_cidade"];
	$cod_estado = $_POST["cod_estado"];
	
	$alteracao = "UPDATE cidade SET 
				nome_cidade = '$nome_cidade',
				cod_estado = '$cod_estado'
				WHERE id_cidade = '$id'";

	mysqli_query($conexao,$alteracao)
		or die(mysqli_error($conexao));
	
	echo "1";
	
?>