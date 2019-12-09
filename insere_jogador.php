<?php
	
	include("conexao.php");
	
	$nome_jogador = $_POST["nome_jogador"];
	$email = $_POST["email"];
	$sexo = $_POST["sexo"];
	$data_nascimento = $_POST["data_nascimento"];
	$posicao = $_POST["posicao"];
	$cod_cidade = $_POST["cod_cidade"];
	$cod_time = $_POST["cod_time"];
	$insere = "INSERT INTO jogador (nome_jogador, email, sexo, data_nascimento, posicao, cod_cidade, cod_time)
						VALUES('$nome_jogador', '$email','$sexo','$data_nascimento','$posicao','$cod_cidade','$cod_time')";

	mysqli_query($conexao,$insere)
		or die(mysqli_error($conexao));
	
	echo "1";
	
?>