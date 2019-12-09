<?php
	
	include("conexao.php");
	
	$id = $_POST["id"];
	$nome_time = $_POST["nome_time"];
	$cod_cidade = $_POST["cod_cidade"];
	
	$alteracao = "UPDATE time SET 
				nome_time = '$nome_time',
				cod_cidade = '$cod_cidade'
				WHERE id_time = '$id'";

	mysqli_query($conexao,$alteracao)
		or die(mysqli_error($conexao));
	
	echo "1";
	
?>