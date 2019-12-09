<?php
	include("conexao.php");
	
	$id = $_POST["id"];

	$remover = "DELETE FROM cidade WHERE id_cidade ='$id'";

	mysqli_query($conexao,$remover)
			or die("0");
	echo "1";
?>