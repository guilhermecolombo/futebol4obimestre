<?php

	$user = "root";
	$senha = "usbw";
	$banco = "projeto";
	$server = "localhost";
	
	$conexao = mysqli_connect($server, $user, $senha, $banco);
	
	mysqli_set_charset($conexao,"utf8");
?>