<?php
	
	header ("Content-Type: Application/json");
	
	include("conexao.php");
	
	$id = $_POST["id"];
	
	$sql = "SELECT * FROM jogador WHERE id_jogador = '$id'";
	
	$resultado = mysqli_query($conexao,$sql);
	
	$linha = mysqli_fetch_assoc($resultado);
	
	echo json_encode($linha);
	
?>