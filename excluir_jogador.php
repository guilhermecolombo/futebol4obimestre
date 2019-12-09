<?php
	include("conexao.php");
	
	$id = $_POST["id"];

	$remover = "DELETE FROM jogador WHERE id_jogador ='$id'";

	mysqli_query($conexao,$remover)
			or die("0");
	echo "1";
?>