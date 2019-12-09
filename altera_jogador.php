<?php
	
	include("conexao.php");
	
	$id = $_POST["id"];
	$nome_jogador = $_POST["nome_jogador"];
	$email = $_POST["email"];
	$sexo = $_POST["sexo"];
	$data_nascimento = $_POST["data_nascimento"];
	$posicao = $_POST["posicao"];
	$cod_cidade = $_POST["cod_cidade"];
	$cod_time = $_POST["cod_time"];
	
	$alteracao = "UPDATE time SET 
				nome_jogador = '$nome_jogador',
				email = '$email',
				sexo = '$sexo',
				data_nascimento = '$data_nascimento',
				posicao = '$posicao',
				cod_cidade = '$cod_cidade',
				cod_time = '$cod_time'
				WHERE id_jogador = '$id'";

	mysqli_query($conexao,$alteracao)
		or die(mysqli_error($conexao));
	
	echo "1";
	
?>